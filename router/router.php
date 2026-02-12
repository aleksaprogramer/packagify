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

        default:
            exit('404. Page not found');
    }

} else {
    exit('404. Page not found');
}