<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Startup Connect</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="nav">
                <a href="/" class="nav-logo">Startup Connect</a>
                <div class="nav-links">
                    <a href="/" class="nav-link">Home</a>
                    <a href="/about.php" class="nav-link">About</a>
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="/dashboard.php" class="nav-link">Dashboard</a>
                        <a href="/logout.php" class="nav-link">Logout</a>
                    <?php else: ?>
                        <a href="/register.php" class="nav-link">Register</a>
                        <a href="/login.php" class="nav-link">Login</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="container">
            <div class="flash-message <?php echo $_SESSION['flash']['type']; ?>">
                <?php echo $_SESSION['flash']['message']; ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        </div>
    <?php endif; ?>

    <main>
</body>
</html>
