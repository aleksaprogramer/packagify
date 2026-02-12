<?php
require_once './classes/User.php';

// CSRF token
if (!isset($_SESSION['csrf-token']) || !isset($_SESSION['csrf-token-expire'])) {
    $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
    $_SESSION['csrf-token-expire'] = time() + 600;
}

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