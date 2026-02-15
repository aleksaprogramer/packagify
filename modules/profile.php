<?php
require_once './classes/User.php';
require_once './classes/Package.php';

// Checking user
if (!is_logged()) {
    header("Location: " . $env->base_url . "?router=login");
    exit();
}

$user = new User();
$logged_user = $user->get_user_data($_SESSION['user_id']);

$package = new Package();
$packages_by_user = $package->get_packages_by_user_id($_SESSION['user_id']);

?>

<div class="profile">
    <h2>Profile</h2>

    <ul>
        <li><a href="<?php echo $env->base_url . "?router=homepage"; ?>">Back to homepage</a></li>
        <li><a href="<?php echo $env->base_url . "?router=profile"; ?>">Profile</a></li>
        <li><a href="<?php echo $env->base_url . "?router=edit-profile"; ?>">Edit profile</a></li>
        <li><a href="<?php echo $env->base_url . "?router=make-new-package"; ?>">Make new package</a></li>
    </ul>

    <div class="profile-content">
        <h3>Username: <?php echo $logged_user['username'] ?></h3>
        <h3>Email: <?php echo $logged_user['email'] ?></h3>
    </div>

    <br>

    <div class="user-packages">
        <h2>Packages</h2>

        <?php foreach ($packages_by_user as $package): ?>
            <h3>Package name: <?php echo $package['package_name']; ?></h3>
            <h3>Created at: <?php echo $package['created_at']; ?></h3>
            <p><a href="<?php echo $env->base_url . "?router=edit-package&id=" . $package['id']; ?>">Edit Package</a></p>
        <?php endforeach; ?>
    </div>
</div>