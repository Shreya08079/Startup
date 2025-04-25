<?php
require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = apiRequest('login', 'POST', [
        'email' => $_POST['email'],
        'password' => $_POST['password']
    ]);
    
    if ($response['status'] === 200) {
        $_SESSION['user'] = $response['data']['user'];
        $_SESSION['access_token'] = $response['data']['access_token'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = $response['data']['message'] ?? 'Login failed. Please try again.';
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card mt-5">
                <div class="card-header">
                    <h4>Login</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>