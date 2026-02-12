<?php
require_once './classes/User.php';

// CSRF token
if (!isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token_expire'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    $_SESSION['csrf_token_expire'] = time() + 600; // 10 minutes
}

// Handling errors
$email_error = false;
$password_error = false;

// Handling POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $csrf_token = htmlspecialchars(trim($_POST['csrf-token']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    if (!isset($_SESSION['csrf_token']) || !isset($_POST['csrf-token'])) {
        header("Location: " . $env->base_url . "?router=login");
        exit();

    } else if (time() > (int)$_SESSION['csrf_token_expire']) {
        unset($_SESSION['csrf_token']);
        unset($_SESSION['csrf_token_expire']);
        header("Location: " . $env->base_url . "?router=login");
        exit();

    } else if (!hash_equals($_SESSION['csrf_token'], $csrf_token)) {
        header("Location: " . $env->base_url . "?router=login");
        exit();

    } else if ($email === '') {
        $email_error = 'Please enter email';

    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = 'Please enter email in a valid format';

    } else if (!str_contains($email, "@")) {
        $email_error = 'Please enter email in a valid format';

    } else if ($password === '') {
        $password_error = 'Please enter password';

    } else {

        $user = new User();

        $logged_user = $user->login($email, $password);

        if (!$logged_user) {
            $email_error = 'Entered data is not correct';

        } else {
            unset($_SESSION['csrf-token']);
            unset($_SESSION['csrf-token-expire']);
            header("Location: " . $env->base_url . "?router=otp");
            exit();
        }
    }
}

?>

<div class="login">
    <h2>Login</h2>

    <form method="POST">
        <input type="hidden" name="csrf-token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="email" placeholder="Email" name="email">
        <input type="password" placeholder="Password" name="password">
        <button type="submit">Login</button>
    </form>
</div>