<?php
require_once './classes/User.php';

// Checking user
if (!is_logged()) {
    header("Location: " . $env->base_url . "?router=login");
    exit();
}

$user = new User();

// Handling account deletion
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $deleted_user = $user->delete_user($_SESSION['user_id']);

    if ($deleted_user) {
        session_destroy();
        header("Location: " . $env->base_url . "?router=login");
        exit();

    } else {
        header("Location: " . $env->base_url . "?router=delete-profile");
        exit();
    }
}

?>

<div class="delete-profile">
    <h2>Delete Profile</h2>

    <form method="POST">
        <h3>Are you sure you want to delete the account?</h3>
        <button type="submit">Delete account</button>
    </form>
</div>