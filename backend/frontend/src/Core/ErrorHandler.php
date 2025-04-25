<?php
namespace App\Core;

class ErrorHandler
{
    public static function handleError($errno, $errstr, $errfile, $errline)
    {
        if (!(error_reporting() & $errno)) {
            return false;
        }

        $error = [
            'type' => $errno,
            'message' => $errstr,
            'file' => $errfile,
            'line' => $errline
        ];

        self::logError($error);
        self::displayError($error);

        return true;
    }

    public static function handleException($exception)
    {
        $error = [
            'type' => get_class($exception),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString()
        ];

        self::logError($error);
        self::displayError($error);
    }

    private static function logError($error)
    {
        $logMessage = date('Y-m-d H:i:s') . " - Error: {$error['message']} in {$error['file']} on line {$error['line']}\n";
        error_log($logMessage, 3, ROOT_DIR . '/logs/error.log');
    }

    private static function displayError($error)
    {
        if (php_sapi_name() === 'cli') {
            echo "Error: {$error['message']}\n";
            echo "File: {$error['file']}\n";
            echo "Line: {$error['line']}\n";
        } else {
            http_response_code(500);
            include ROOT_DIR . '/src/Views/errors/500.php';
        }
    }
} 