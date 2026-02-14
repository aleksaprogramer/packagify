<?php
require_once './classes/Package.php';

// Checking user
if (!is_logged()) {
    header("Location: " . $env->base_url . "?router=login");
    exit();
}

// Handling errors
$max_size = 25 * 1024 * 1024; // 25MB
$allowed_types = "zip";

$file_error = false;
$package_name_error = false;
$documentation_error = false;

// Handling upload
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // File handling
    $target_dir = "uploads/";
    $target_file = $target_dir . $_FILES['uploaded-file']['name'];
    $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $package_name = htmlspecialchars(trim($_POST['package-name']));
    $documentation = htmlspecialchars(trim($_POST['documentation']));

    if ($_FILES['uploaded-file']['name'] === "") {
        $file_error = 'Please upload file';

    } else if ($file_extension !== $allowed_types) {
        $file_error = "File can be only be type of '.zip'";

    } else if ($_FILES['uploaded-file']['size'] > $max_size) {
        $file_error = 'The file should have less than 25MB';

    } else if ($package_name === '') {
        $package_name_error = 'Please enter package name';

    } else if (strlen($package_name) < 3) {
        $package_name_error = 'Package name should have at least 3 characters';

    } else if (strlen($package_name) > 25) {
        $package_name_error = 'Package name cannot have more than 25 characters';

    } else if ($documentation === '') {
        $documentation_error = 'Please enter documentation';

    } else if (strlen($documentation) > 4000) {
        $documentation_error = 'You reached the documentation characters limit';

    } else {
        $filename = bin2hex(random_bytes(4)) . "." . $file_extension;
        $filepath = $target_dir . $filename;

        // $_FILES['uploaded-file']['name']

        if (move_uploaded_file($_FILES['uploaded-file']['tmp_name'], $filepath)) {
            $new_package = new Package();
            $package = $new_package->make_new_package($_SESSION['user_id'], $package_name, $filename, $documentation, $filepath);

            if ($package) {
                header("Location: " . $env->base_url . "?router=homepage");
                exit();

            } else {
                header("Location: " . $env->base_url . "?router=make-new-package");
                exit();
            }

        } else {
            header("Location: " . $env->base_url . "?router=make-new-package");
            exit();
        }
    }
}

?>

<div class="make-new-package">
    <h2>New Package</h2>

    <ul>
        <li><a href="<?php echo $env->base_url . "?router=homepage"; ?>">Back to homepage</a></li>
        <li><a href="<?php echo $env->base_url . "?router=profile"; ?>">Profile</a></li>
        <li><a href="<?php echo $env->base_url . "?router=make-new-package"; ?>">Make new package</a></li>
    </ul>

    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="uploaded-file">
        <input type="text" placeholder="Package name*" name="package-name">
        <input type="text" placeholder="Documentation*" name="documentation">
        <button type="submit">Create</button>
    </form>
</div>