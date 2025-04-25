<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
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
        <section class="about-page">
            <div class="container py-5">
                <h1 class="mb-4">About Startup Connect</h1>
                <div class="row">
                    <div class="col-lg-8">
                        <p class="lead">Startup Connect is a platform designed to bridge the gap between innovative startups, experienced investors, and knowledgeable mentors.</p>
                        
                        <h2 class="mt-5 mb-3">Our Mission</h2>
                        <p>We believe in the power of connections to transform great ideas into successful businesses. Our mission is to create meaningful relationships between entrepreneurs, investors, and mentors to foster innovation and drive business growth.</p>
                        
                        <h2 class="mt-5 mb-3">What We Offer</h2>
                        <div class="row mt-4">
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h3 class="card-title h5">For Startups</h3>
                                        <p class="card-text">Access to funding opportunities, mentorship, and resources to help your startup grow.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h3 class="card-title h5">For Investors</h3>
                                        <p class="card-text">Discover promising startups and investment opportunities in various sectors.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title h5">Get Started Today</h3>
                                <p class="card-text">Join our community and start connecting with the right people to grow your business.</p>
                                <a href="/register" class="btn btn-primary">Register Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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