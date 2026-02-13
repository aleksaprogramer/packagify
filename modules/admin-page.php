<?php
require_once './classes/User.php';

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
var_dump($users);



?>

<div class="admin-page">
    <h2>Admin Page</h2>
</div>