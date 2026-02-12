<?php
require_once './classes/User.php';

// CRSF token
if (!isset($_SESSION['csrf-token']) || !isset($_SESSION['csrf-token-expire'])) {
    $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
    $_SESSION['csrf-token-expire'] = time() + 600; // 10 minutes
}

// Handling errors
$username_error = false;
$email_error = false;
$password_error = false;
$password_confirm_error = false;

// Handling POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $csrf_token = htmlspecialchars(trim($_POST['csrf-token']));
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $password_confirm = htmlspecialchars(trim($_POST['password-confirm']));

    if (!isset($_SESSION['csrf-token']) || !isset($_POST['csrf-token'])) {
        header("Location: " . $env->base_url . "?router=register");
        exit();

    } else if (time() >= (int)$_SESSION['csrf-token-expire']) {
        unset($_SESSION['csrf-token']);
        unset($_SESSION['csrf-token-expire']);
        header("Location: " . $env->base_url . "?router=register");
        exit();

    } else if (!hash_equals($_SESSION['csrf-token'], $csrf_token)) {
        header("Location: " . $env->base_url . "?router=register");
        exit();

    } else if ($username === '') {
        $username_error = 'Please enter the username';

    } else if (strlen($username) < 3) {
        $username_error = 'Username must have at least 3 characters';

    } else if (strlen($username) > 15) {
        $username_error = 'Username cannot have more than 15 characters';

    } else if ($email === '') {
        $email_error = 'Please enter the email';

    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = 'Please enter email in a valid format';    

    } else if (!str_contains($email, '@')) {
        $email_error = 'Please enter email in a valid format';

    } else if ($password === '') {
        $password_error = 'Please enter password';

    } else if (strlen($password) < 8) {
        $password_error = 'Password should have more than 8 characters';

    } else if (strlen($password) > 25) {
        $password_error = 'Password cannot have more than 25 characters';

    } else if ($password !== $password_confirm) {
        $password_confirm_error = 'Passwords must match';

    } else {
        $new_user = new User();
        $user = $new_user->register($username, $email, $password);
        echo 'user';

        if ($user) {
            unset($_SESSION['csrf-token']);
            unset($_SESSION['csrf-token-expire']);
            header("Location: " . $env->base_url . "?router=otp");
            exit();
        }
    }
}

?>

<div class="register">
    <h2>Register</h2>

    <form method="POST">
        <input type="hidden" name="csrf-token" value="<?php echo $_SESSION['csrf-token'] ?>">
        <input type="text" placeholder="Username" name="username">
        <?php if ($username_error): ?>
            <p><?php echo $username_error; ?></p>
        <?php endif; ?>

        <input type="email" placeholder="Email" name="email">
        <?php if ($email_error): ?>
            <p><?php echo $email_error; ?></p>
        <?php endif; ?>

        <input type="password" placeholder="Password" name="password">
        <?php if ($password_error): ?>
            <p><?php echo $password_error; ?></p>
        <?php endif; ?>

        <input type="password" placeholder="Confirm Password" name="password-confirm">
        <?php if ($password_confirm_error): ?>
            <p><?php echo $password_confirm_error; ?></p>
        <?php endif; ?>

        <button type="submit">Register</button>
    </form>
</div>