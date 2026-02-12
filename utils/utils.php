<?php

function is_logged () {

    if (isset($_SESSION['user_id'])) {
        return true;

    } else {
        return false;
    }
}

function send_mail ($email, $subject, $message) {
    echo "<hr>";
    echo "From: verification.packagify@gmail.com" . "<br>";
    echo "To: " . $email . "<br>";
    echo "Subject: " . $subject . "<br>";
    echo "Message: " . $message . "<br>";
    echo "<hr>";
}