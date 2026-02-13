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
    var_dump($_FILES['uploaded-file']['name']);

    // File handling
    $target_dir = "uploads/";
    $target_file = $target_dir . $_FILES['uploaded-file']['name'];
    $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($_FILES['uploaded-file']['name'] === "") {
        $file_error = 'Please upload file';

    } else if ($file_extension !== $allowed_types) {
        $file_error = "File can be only be type of '.zip'";

    } else if ($_FILES['uploaded-file']['size'] > $max_size) {
        $file_error = 'The file should have less than 25MB';

    }
}

?>

<div class="make-new-package">
    <h2>New Package</h2>

    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="uploaded-file">
        <input type="text" placeholder="Package name*" name="package-name">
        <input type="text" placeholder="Documentation*" name="documentation">
        <button type="submit">Create</button>
    </form>
</div>