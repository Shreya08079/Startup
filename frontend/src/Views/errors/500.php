<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - Something Went Wrong</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .error-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #e74c3c;
            margin-top: 0;
        }
        .error-message {
            color: #666;
            margin-bottom: 20px;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 3px;
        }
        .back-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>Oops! Something Went Wrong</h1>
        <div class="error-message">
            <p>We apologize, but an error occurred while processing your request.</p>
            <?php if (isset($error) && APP_DEBUG): ?>
                <p><strong>Error:</strong> <?php echo htmlspecialchars($error['message']); ?></p>
                <p><strong>File:</strong> <?php echo htmlspecialchars($error['file']); ?></p>
                <p><strong>Line:</strong> <?php echo htmlspecialchars($error['line']); ?></p>
            <?php endif; ?>
        </div>
        <a href="/" class="back-button">Back to Home</a>
    </div>
</body>
</html> 