<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_destroy();
    header("Location: " . $env->base_url . "?router=login");
    exit();
}

?>

<div class="homepage">
    <nav>
        <h2>Homepage</h2>
        <ul>
            <li><a href="<?php echo $env->base_url . "?router=homepage"; ?>">Homepage</a></li>

            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="<?php echo $env->base_url . "?router=profile"; ?>">Profile</a></li>
            <?php endif; ?>

            <?php if (isset($_SESSION['user_id'])): ?>
                <li>
                    <form method="POST">
                        <button type="submit">Logout</button>
                    </form>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>