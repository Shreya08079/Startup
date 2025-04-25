<?php
namespace App\Core;

class ApiClient
{
    private $baseUrl;
    private $token;

    public function __construct()
    {
        $this->baseUrl = API_URL;
        $this->token = $_SESSION['api_token'] ?? null;
    }

    public function setToken($token)
    {
        $this->token = $token;
        $_SESSION['api_token'] = $token;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function request($method, $endpoint, $data = null)
    {
        $url = $this->baseUrl . $endpoint;
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Origin: ' . APP_URL
        ];

        if ($this->token) {
            $headers[] = 'Authorization: Bearer ' . $this->token;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        // Log the request
        error_log("API Request: $method $url");
        if ($data) {
            error_log("Request Data: " . json_encode($data));
        }

        switch ($method) {
            case 'GET':
                if ($data) {
                    $url .= '?' . http_build_query($data);
                    curl_setopt($ch, CURLOPT_URL, $url);
                }
                break;
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                if ($data) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                if ($data) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        // Log the response
        error_log("API Response Code: $httpCode");
        error_log("API Response: $response");

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            error_log("Curl Error: " . $error);
            curl_close($ch);
            throw new \Exception('API request failed: ' . $error);
        }

        curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300) {
            $decodedResponse = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON response from API');
            }
            return $decodedResponse;
        }

        // Try to parse error response
        $errorResponse = json_decode($response, true);
        $errorMessage = isset($errorResponse['message']) ? $errorResponse['message'] : 'Unknown error';
        throw new \Exception('API request failed: ' . $errorMessage);
    }

    public function get($endpoint, $data = null)
    {
        return $this->request('GET', $endpoint, $data);
    }

    public function post($endpoint, $data = null)
    {
        return $this->request('POST', $endpoint, $data);
    }

    public function put($endpoint, $data = null)
    {
        return $this->request('PUT', $endpoint, $data);
    }

    public function delete($endpoint)
    {
        return $this->request('DELETE', $endpoint);
    }
} 