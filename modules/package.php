<?php
require_once './classes/Package.php';
require_once './classes/User.php';

if (!isset($_GET['id'])) {
    header("Location: " . $env->base_url . "?router=homepage");
    exit();
}

$package_id = $_GET['id'];

$package = new Package();
$current_package = $package->get_package_data($package_id);

$user = new User();
$author = $user->get_user_data($current_package['user_id']);

if (!$current_package) {
    header("Location: " . $env->base_url . "?router=homepage");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $filename = $current_package['filename'];
    $filepath = $current_package['filepath'];

    if (file_exists($filepath)) {
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Expires: 0');
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");

        readfile($filepath);
        exit();
    }
}

?>

<div class="package">
    <h2>Package</h2>
    <h3>Package Name: <?php echo $current_package['package_name']; ?></h3>
    <h4>Author: <?php echo $author['username']; ?></h4>
    
    <form method="POST">
        <button type="submit">Download Package</button>
    </form>

    <h4>Documentation: </h4>
    <p><?php echo $current_package['documentation']; ?></p>
</div>