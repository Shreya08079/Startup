# Startup Connect Frontend

The frontend application for the Startup-Corporate Connection Platform, built with PHP.

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL 5.7 or higher
- Apache/Nginx web server
- mod_rewrite enabled (for Apache)

## Installation

1. Clone the repository:
```bash
git clone [repository-url]
cd startup-connect/frontend
```

2. Install dependencies:
```bash
composer install
```

3. Create a copy of the configuration file:
```bash
cp config/config.example.php config/config.php
```

4. Update the configuration file with your database and application settings:
```php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'startup_connect');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');

// Application configuration
define('APP_URL', 'http://localhost:8000');
define('APP_ENV', 'development');
```

5. Set up the web server:

For Apache, create a virtual host:
```apache
<VirtualHost *:80>
    ServerName localhost
    DocumentRoot /path/to/startup-connect/frontend/public
    
    <Directory /path/to/startup-connect/frontend/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

For Nginx, create a server block:
```nginx
server {
    listen 80;
    server_name localhost;
    root /path/to/startup-connect/frontend/public;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

6. Set proper permissions:
```bash
chmod -R 755 .
chmod -R 777 public/uploads
chmod -R 777 cache
```

7. Create the database and import the schema:
```bash
mysql -u root -p < ../backend/database/schema.sql
```

## Development

1. Start the development server:
```bash
php -S localhost:8000 -t public
```

2. Run tests:
```bash
composer test
```

3. Check code style:
```bash
composer cs-check
```

4. Fix code style issues:
```bash
composer cs-fix
```

5. Run static analysis:
```bash
composer phpstan
```

## Project Structure

```
frontend/
├── public/          # Publicly accessible files
│   ├── index.php    # Front controller
│   ├── assets/      # CSS, JS, images
│   └── uploads/     # User uploads
├── src/             # PHP source files
│   ├── Core/        # Core classes
│   ├── Controllers/ # Controllers
│   ├── Models/      # Models
│   └── Services/    # Services
├── templates/       # PHP templates
├── config/          # Configuration files
├── tests/           # Test files
└── vendor/          # Composer dependencies
```

## Features

- User authentication (login, registration, password reset)
- Company profiles for startups and corporates
- Opportunity posting and management
- Messaging system
- Connection management
- Review system
- Notification system

## Security

- CSRF protection
- XSS prevention
- SQL injection prevention
- Password hashing
- Input validation
- Secure session handling
- File upload security

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details. 