<?php

function mainScreen() {
?>
    <header>
        <nav>
            <a href="/login">Login</a>
            <a href="/register">Register</a>
        </nav>
    </header>
<?php
}

function loginScreen($username) {
?>
    <section id="login">
        <p>Login:</p>
        <form method="post" action="/">
            <input type="text" name="username" value="<?=$username?>" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <input type="submit" name="login" value="Login">
        </form>
    </section>
<?php
}

function registerScreen($username, $email) {
?>
    <section id="register">
        <p>Register:</p>
        <form method="post" action="/" id="register">
            <input type="email" name="email" value="<?=$email?>" placeholder="Email">
            <input type="text" name="username" value="<?=$username?>" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <input type="submit" name="register" value="Register">
        </form>
    </section>
<?php
}

function appScreen($username) {
?>
    <section id="app">
        <p>App Screen:</p>
        <p>Welcome <?=$username?></p>
        <p>idk what else to put here</p>
        <form method="post" action="/">
            <input type="submit" name="logout" value="Log out">
        </form>
    </section>
<?php
}
?>