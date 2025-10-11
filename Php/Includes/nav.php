<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$base_url = "/SSM/";
?>
 
<link rel="stylesheet" href="/SSM/Asset/Css/navFoot.css">

<nav class="navbar">
    <!-- Logo -->
    <a href="<?php echo $base_url; ?>index.php" class="logo">SSM</a>

    <!-- Search bar -->
    <form action="<?php echo $base_url; ?>Php/Product/search.php" method="GET" class="search-form">
        <input type="text" name="q" placeholder="Search products..." required>
        <button type="submit">🔍</button>
    </form>

    <!-- Right side links -->
    <div class="nav-links">
        <?php if(isset($_SESSION['user_id'])): ?>
            <span class="welcome-text">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a href="<?php echo $base_url; ?>Php/Auth/logout.php" class="nav-link btn-logout">Logout</a>
        <?php else: ?>
            <a href="<?php echo $base_url; ?>Php/Auth/register.php" class="nav-link btn-signup">Sign Up</a>
            <a href="<?php echo $base_url; ?>Php/Auth/login.php" class="nav-link btn-login">Login</a>
        <?php endif; ?>
    </div>
</nav>
