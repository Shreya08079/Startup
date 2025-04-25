<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Startup Connect'; ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="nav">
                <a href="/" class="nav-logo">Startup Connect</a>
                <div class="nav-links">
                    <a href="/" class="nav-link">Home</a>
                    <a href="/about" class="nav-link">About</a>
                    <a href="/register" class="nav-link">Register</a>
                    <a href="/login" class="nav-link">Login</a>
                </div>
            </nav>
        </div>
    </header>

    <main class="container">
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="flash-message <?php echo $_SESSION['flash']['type']; ?>">
                <?php echo $_SESSION['flash']['message']; ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <?php echo $content ?? ''; ?>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-links">
                    <a href="/" class="footer-link">Home</a>
                    <a href="/about" class="footer-link">About</a>
                    <a href="/contact" class="footer-link">Contact</a>
                </div>
                <p>&copy; <?php echo date('Y'); ?> Startup Connect. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="/assets/js/main.js"></script>
</body>
</html> 