<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once __DIR__ . '/includes/auth.php';
require_once 'includes/header.php';
?>

<div class="hero-section">
    <h1>Connecting Startups with Corporates</h1>
    <div class="cta-buttons">
        <a href="register.php" class="btn btn-primary">Join as Startup</a>
        <a href="register.php" class="btn btn-secondary">Join as Corporate</a>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>