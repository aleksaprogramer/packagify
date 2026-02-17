<?php
require_once './classes/Package.php';
require_once './classes/User.php';

$package = new Package();
$packages = $package->get_all_packages();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_destroy();
    header("Location: " . $env->base_url . "?router=login");
    exit();
}

?>

<div class="homepage">
    <nav>
        <h2>Homepage</h2>
        <ul>
            <li><a href="<?php echo $env->base_url . "?router=homepage"; ?>">Homepage</a></li>

            <?php if (!isset($_SESSION['user_id'])): ?>
                <li><a href="<?php echo $env->base_url . "?router=login"; ?>">Login</a></li>
            <?php endif; ?>

            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="<?php echo $env->base_url . "?router=profile"; ?>">Profile</a></li>
            <?php endif; ?>

            <?php if (isset($_SESSION['user_id'])): ?>
                <li>
                    <form method="POST">
                        <button type="submit">Logout</button>
                    </form>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="packages-container">
        <?php foreach ($packages as $package): ?>
            <p>Author: <?php
                
            $user = new User();
            $data = $user->get_user_data($package['user_id']);
            echo $data['username'];

            ?></p>
            <a href="<?php echo $env->base_url . "?router=package&id=" . $package['id'] ?>">Package Name: <?php echo $package['package_name']; ?></a>
        <?php endforeach; ?>
    </div>
</div>