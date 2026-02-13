<?php
require_once './classes/User.php';

// Checking user
if (!is_logged()) {
    header("Location: " . $env->base_url . "?router=login");
    exit();

} else {
    $user = new User();
    $logged_user = $user->get_user_data($_SESSION['user_id']);
}

?>

<div class="profile">
    <h2>Profile</h2>
    <a href="<?php echo $env->base_url . "?router=homepage"; ?>">Back to homepage</a>

    <div class="profile-content">
        <h3>Username: <?php echo $logged_user['username'] ?></h3>
        <h3>Email: <?php echo $logged_user['email'] ?></h3>
    </div>
</div>