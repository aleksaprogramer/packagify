<?php
require_once './classes/User.php';
require_once './classes/Package.php';

// Checking user
if (!is_logged()) {
    header("Location: " . $env->base_url . "?router=login"); // 401 unauthorized
    exit();
}

// Checking admin
if (!is_admin()) {
    header("Location: " . $env->base_url . "?router=homepage");
    exit();
}

$user = new User();
$users = $user->get_all_users();

$package = new Package();
$packages = $package->get_all_packages();

?>

<div class="admin-page">
    <h2>Admin Page</h2>

    <a href="<?php echo $env->base_url . "?router=homepage"; ?>">Back to homepage</a>

    <ul>
        <li><a href="#">Users</a></li>
        <li><a href="#">Packages</a></li>
    </ul>

    <div class="users">
        <h3>Users</h3>

        <?php foreach ($users as $user): ?>
            <div class="user">
                <p>Username: <?php echo $user['username']; ?></p>
                <p>Email: <?php echo $user['email']; ?></p>
                <p>Admin: <?php echo $user['is_admin'] ? 'Yes' : 'No'; ?></p>
                <p>Created at: <?php echo $user['created_at']; ?></p>
            </div>
        <?php endforeach; ?>

    </div>

    <div class="packages">
        <h3>Packages</h3>

        <?php foreach ($packages as $package): ?>
            <div class="package">
                <p>Author: <?php
                
                $sql = "SELECT username FROM users WHERE id = ?";
                $run = $db->prepare($sql);
                $run->bind_param("s", $package['user_id']);
                $run->execute();
                $results = $run->get_result();
                $user = $results->fetch_assoc();
                echo $user['username'];


                ?></p>
                <p>Package name: <?php echo $package['package_name']; ?></p>
                <p>Created at: <?php echo $package['created_at']; ?></p>
            </div>
        <?php endforeach; ?>

    </div>
</div>