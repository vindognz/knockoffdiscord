<?php

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