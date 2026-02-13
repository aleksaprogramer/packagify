<?php

// ROUTER CONFIG
if (isset($_GET['router'])) {
    $router = $_GET['router'];

    switch ($router) {
        case 'register':
            require_once '././modules/register.php';
            break;
        
        case 'login':
            require_once '././modules/login.php';
            break;
        
        case 'otp':
            require_once '././modules/otp.php';
            break;

        case 'homepage':
            require_once '././modules/homepage.php';
            break;

        case 'profile':
            require_once '././modules/profile.php';
            break;

        case 'make-new-package':
            require_once '././modules/make-new-package.php';
            break;

        case 'admin-page':
            require_once '././modules/admin-page.php';
            break;

        default:
            require_once '././modules/404.php';
    }

} else {
    require_once '././modules/404.php';
}