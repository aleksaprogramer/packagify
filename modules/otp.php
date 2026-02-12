<?php

// Checking user
if (!is_logged()) {
    header("Location: " . $env->base_url . "?router=login");
    exit();
}

// Checking for verifiyed OTP
if ($_SESSION['otp_verified']) {
    header("Location: " . $env->base_url . "?router=homepage");
    exit();
}

// OTP logic
if (!isset($_SESSION['otp_code']) || !isset($_SESSION['otp_code_expire'])) {
    $_SESSION['otp_code'] = random_int(100000, 999999);
    $_SESSION['otp_code_expire'] = time() + 60; // 60 seconds
}

$sql = "SELECT email FROM users WHERE id = ?;";

$run = $db->prepare($sql);
$run->bind_param("s", $_SESSION['user_id']);
$run->execute();
$results = $run->get_result();

$user = $results->fetch_assoc();

send_mail($user['email'], 'OTP Verification Code', $_SESSION['otp_code']);

// Handling errors
$otp_code_error = false;

// Handling POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $otp_code = htmlspecialchars(trim($_POST['otp-code']));

    if (!isset($_SESSION['otp_code'])) {
        header("Location: " . $env->base_url . "?router=otp");
        exit();

    } else if (time() > $_SESSION['otp_code_expire']) {
        unset($_SESSION['otp_code']);
        unset($_SESSION['otp_code_expire']);
        header("Location: " . $env->base_url . "?router=otp");
        exit();

    } else if ((int)$_SESSION['otp_code'] !== (int)$otp_code) {
        header("Location: " . $env->base_url . "?router=otp");
        exit();

    } else if ($otp_code === '') {
        $otp_code_error = 'Please enter recieved OTP code';

    } else if (strlen($otp_code) < 6) {
        $otp_code_error = 'OTP code must contains 6 digits';

    } else if (strlen($otp_code) > 6) {
        $otp_code_error = 'OTP code must contains 6 digits';

    } else if (!is_numeric($otp_code)) {
        $otp_code_error = 'Only numbers are allowed';

    } else {
        unset($_SESSION['otp_code']);
        unset($_SESSION['otp_code_expire']);
        $_SESSION['otp_verified'] = true;
        header("Location: " . $env->base_url . "?router=homepage");
        exit();
    }
}

?>

<div class="otp">
    <h2>OTP Verification</h2>

    <form method="POST">
        <input type="text" placeholder="OTP code" name="otp-code" maxlength="6">
        <button type="submit">Verify</button>
    </form>
</div>