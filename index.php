<!-- php that runs when startup -->
<?php

session_start();
require_once "functions.php";

if (isset($_POST["login"])) { // checks if you loaded the page by pressing the submit button

    // gets username from the input and sanitizes it
    $username = "";
    if (isset($_POST["username"])) {
        $username = preg_replace("/[^a-zA-Z0-9]/", "", $_POST["username"]);
    }

    // gets password from the input and sanitizes it
    $password = "";
    if (isset($_POST["password"])) {
        $password = preg_replace("/[^a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)]/", "", $_POST["password"]);
    }

    // checks if both the username and password are not blank
    if ($username != "" && $password != "") {
        // attempts to do database stuffs
        try {
            // initializes the PDO - thing that talks to the db and executes queries
            $pdo = new PDO('sqlite:../db/discordknockoff.sqlite');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // gets the password that corresponds to the inputted username
            $stmt = $pdo->prepare("SELECT password, salt FROM users WHERE username = :username");
            $stmt->execute([':username' => $username]);

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $dbPassword = $data[0]['password'];
            $dbSalt = $data[0]['salt'];

            // if the correct password in the db is the same as the inputted one:
            if ($dbPassword == hash('sha256', $dbSalt.$password)) {
                // successful login!
                $_SESSION['loggedIn'] = true;
                $_SESSION['username'] = $username;

                header('location: '.'/login');
            } else {
                // unsuccessful login.
                ?> <script>alert("Invalid username or password")</script> <?php
            }
        } catch (PDOException $e) { // catches any errors within the database manipulation
            echo "Error: " . $e->getMessage(); // and echos them to the screen
        }
    }
}

if (isset($_POST["register"])) {
    $username = "";
    if (isset($_POST["username"])) {
        $username = preg_replace("/[^a-zA-Z0-9]/", "", $_POST["username"]);
    }

    $password = "";
    if (isset($_POST["password"])) {
        $password = preg_replace("/[^a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)]/", "", $_POST["password"]);
    }

    $email = "";
    if (isset($_POST["email"])) {
        $email = preg_replace("/[^a-z0-9\-\_\.\@]/", "", $_POST["email"]);
    }

    if ($username && $password && $email) {
        try {
            $pdo = new PDO('sqlite:../db/discordknockoff.sqlite');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $salt = substr(base64_encode(random_bytes(8)), 0, 8);

            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, salt) VALUES (:username, :email, :password, :salt)");
            $stmt->execute([':username' => $username, ':email' => $email, ':password' => hash('sha256', ($salt.$password)), ':salt' => $salt]);

        } catch (PDOException $e) { // catches any errors within the database manipulation
            echo "Error: " . $e->getMessage(); // and echos them to the screen
        }
    }
}

if (isset($_POST["logout"])) {
    $_SESSION["loggedIn"] = false;
    header('location: '.'/login');
}
?>

<!-- actual website (pretty self explanatory) -->

<html>
    <head>
        <title>Knockoff Discord</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>

        <?php
            session_start();

            $request_uri = trim($_SERVER['REQUEST_URI'], '/');

            if ($request_uri == 'login') {
                if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
                    appScreen($_SESSION['username']);
                } else {
                    loginScreen($username);
                }
            } elseif ($request_uri == 'register') {
                registerScreen($username, $email);
            }
        ?>

    </body>
</html>