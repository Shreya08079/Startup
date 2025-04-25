# Startup-Corporate Connection Platform

A modern platform designed to bridge the gap between innovative startups and established corporations, facilitating meaningful partnerships and collaborations.

## Features

### For Startups
- Create and manage detailed company profiles
- Showcase products, services, and innovations
- Connect with relevant corporate partners
- Track partnership opportunities
- Messaging system for direct communication

### For Corporates
- Browse and discover innovative startups
- Filter startups by industry, technology, and stage
- Create partnership opportunities
- Direct messaging with startups
- Track and manage startup relationships

## Tech Stack

### Frontend
- PHP 8.1+
- Bootstrap 5
- jQuery
- AJAX for dynamic content
- Modern PHP templating

### Backend
- Laravel 10
- MySQL
- Redis for caching
- REST API

## Getting Started

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL
- Apache/Nginx web server

### Installation

1. Clone the repository
```bash
git clone [repository-url]
cd startup-corporate-platform
```

2. Backend Setup
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

3. Frontend Setup
```bash
cd frontend
composer install
cp config.example.php config.php
# Configure your web server to point to the frontend/public directory
```

## License

This project is licensed under the MIT License - see the LICENSE file for details. 