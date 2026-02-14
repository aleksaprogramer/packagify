<?php
require_once './classes/User.php';

// Checking user
if (!is_logged()) {
    header("Location: " . $env->base_url . "?router=login");
    exit();
}

$user = new User();
$current_user = $user->get_user_data($_SESSION['user_id']);

// Handling errors
$username_error = false;
$email_error = false;

// Handling updating user
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));

    if (strlen($username) > 0 && strlen($username) < 3) {
        $username_error = 'Username must have at least 3 characters';

    } else if (strlen($username) > 0 && strlen($username) > 15) {
        $username_error = 'Username cannot have more than 15 characters';

    } else if (strlen($email) > 0 && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = 'Please enter email in a valid format';    

    } else if (strlen($email) > 0 && !str_contains($email, '@')) {
        $email_error = 'Please enter email in a valid format';

    } else {

        if ($username === '') {
            $username = $current_user['username'];
        }

        if ($email === '') {
            $email = $current_user['email'];
        }

        $updated_user = $user->update_user($_SESSION['user_id'], $username, $email);

        if ($updated_user) {
            header("Location: " . $env->base_url . "?router=profile");
            exit();

        } else {
            header("Location: " . $env->base_url . "?router=edit-profile");
            exit();
        }
    }
}

?>

<div class="edit-profile">
    <h2>Edit Profile</h2>

    <a href="<?php echo $env->base_url . "?router=profile"; ?>">Back to profile</a>

    <br><br>

    <form method="POST">
        <input type="text" placeholder="Username" name="username">
        <?php if ($username_error): ?>
            <p><?php echo $username_error; ?></p>
        <?php endif; ?>

        <input type="email" placeholder="Email" name="email">
        <?php if ($email_error): ?>
            <p><?php echo $email_error; ?></p>
        <?php endif; ?>

        <button type="submit">Update</button>
    </form>

    <br><br>

    <a href="<?php echo $env->base_url . "?router=delete-profile"; ?>">Delete profile</a>
</div>