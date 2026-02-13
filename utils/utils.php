<?php

function is_logged () {

    if (isset($_SESSION['user_id'])) {
        return true;

    } else {
        return false;
    }
}

function is_admin () {
    global $db;
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT is_admin FROM users WHERE id = ?;";
    $run = $db->prepare($sql);
    $run->bind_param("s", $user_id);
    $run->execute();
    $result = $run->get_result();
    $user = $result->fetch_assoc();

    if ((int)$user['is_admin'] === 1) {
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