<?php
require_once './classes/User.php';

if (isset($_SESSION['user_id'])) {
    $user = new User();
    $logged_user = $user->get_user_data($_SESSION['user_id']);
}

?>

<div class="homepage">
    <nav>
        <h2>Homepage</h2>
        <ul>
            <li><a href="#">Homepage</a></li>
            <?php if (isset($_SESSION['user_id'])): ?><li><a href="#">Profile</a></li><?php endif; ?>
        </ul>
    </nav>

    <div id="homepage"></div>

    <div id="profile">
        <p>Username: <?php echo $logged_user['username']; ?></p>
        <p>Email: <?php echo $logged_user['email']; ?></p>
    </div>
</div>