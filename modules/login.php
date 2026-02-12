<?php
require_once './classes/User.php';

?>

<div class="login">
    <h2>Login</h2>

    <form method="POST">
        <input type="hidden" name="csrf-token">
        <input type="email" placeholder="Email" name="email">
        <input type="password" placeholder="Password" name="password">
        <button type="submit">Login</button>
    </form>
</div>