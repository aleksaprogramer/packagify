<?php
require_once './classes/Package.php';

// Checking user
if (!is_logged()) {
    header("Location: " . $env->base_url . "?router=login");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: " . $env->base_url . "?router=homepage");
    exit();
}

$package_id = $_GET['id'];

$package = new Package();
$current_package = $package->get_package_data($package_id);

if ($current_package['user_id'] !== $_SESSION['user_id']) {
    header("Location: " . $env->base_url . "?router=homepage");
    exit();
}

// Handling package deletion
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $deleted_package = $package->delete_package($package_id);

    if ($deleted_package) {
        header("Location: " . $env->base_url . "?router=profile");
        exit();

    } else {
        header("Location: " . $env->base_url . "?router=delete-package");
        exit();
    }
}

?>

<div class="delete-package">
    <h2>Delete Package</h2>

    <form method="POST">
        <h3>Are you sure you want to delete this package?</h3>
        <button type="submit">Delete account</button>
    </form>
</div>