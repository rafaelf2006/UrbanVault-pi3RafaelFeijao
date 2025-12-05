<?php
session_start();
?>

<header>
    <nav>
        <a href="index.php">Home</a>

        <?php if (!isset($_SESSION['user'])): ?>
            <!-- Ícone de login -->
            <a href="login.php">
                <img src="login-icon.png" alt="Login" style="width:30px;">
            </a>
        <?php else: ?>
            <!-- Ícone de logout -->
            <a href="logout.php">
                <img src="logout-icon.png" alt="Logout" style="width:30px;">
            </a>
        <?php endif; ?>
    </nav>
</header>
