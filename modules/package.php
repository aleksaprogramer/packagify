<?php
require_once './classes/Package.php';
require_once './classes/User.php';

if (!isset($_GET['id'])) {
    header("Location: " . $env->base_url . "?router=homepage");
    exit();
}

$package_id = $_GET['id'];

$package = new Package();
$data = $package->get_package_data($package_id);

$user = new User();
$author = $user->get_user_data($data['user_id']);

if (!$data) {
    header("Location: " . $env->base_url . "?router=homepage");
    exit();
}

?>

<div class="package">
    <h2>Package</h2>
    <h3>Package Name: <?php echo $data['package_name']; ?></h3>
    <h4>Author: <?php echo $author['username']; ?></h4>
    <h4>Documentation: </h4>
    <p><?php echo $data['documentation']; ?></p>
</div>