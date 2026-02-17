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

if (!$current_package) {
    header("Location: " . $env->base_url . "?router=profile");
    exit();
}

// Handling errors
$documentation_error = false;

// Handling updating package
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $documentation = htmlspecialchars(trim($_POST['documentation']));

    if (strlen($documentation) > 0 && strlen($documentation) < 3) {
        $documentation_error = 'Documentation must have at least 3 characters';

    } else if (strlen($documentation) > 0 && strlen($documentation) > 4000) {
        $documentation_error = 'Documentation cannot have more than 15 characters';

    } else {

        if ($documentation === '') {
            $documentation = $current_package['documentation'];
        }

        $updated_package = $package->update_package($package_id, $documentation);

        if ($updated_package) {
            header("Location: " . $env->base_url . "?router=profile");
            exit();

        } else {
            header("Location: " . $env->base_url . "?router=edit-profile");
            exit();
        }
    }
}

?>

<div class="edit-package">
    <h2>Edit Package</h2>

    <a href="<?php echo $env->base_url . "?router=profile"; ?>">Back to profile</a>
    <br><br>

    <form method="POST">
        <input type="text" placeholder="Documentation" name="documentation">
        <?php if ($documentation_error): ?>
            <p><?php echo $documentation_error; ?></p>
        <?php endif; ?>

        <button type="submit">Update Package</button>
    </form>

    <br><br>

    <a href="<?php echo $env->base_url . "?router=delete-package&id=" . $package_id; ?>">Delete package</a>
</div>