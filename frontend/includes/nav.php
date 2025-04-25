<nav class="nav">
    <a href="/" class="nav-logo">Startup Connect</a>
    <div class="nav-links">
        <a href="/" class="nav-link">Home</a>
        <a href="/about" class="nav-link">About</a>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="/dashboard" class="nav-link">Dashboard</a>
            <a href="/logout" class="nav-link">Logout</a>
        <?php else: ?>
            <a href="/register" class="nav-link">Register</a>
            <a href="/login" class="nav-link">Login</a>
        <?php endif; ?>
    </div>
</nav>
