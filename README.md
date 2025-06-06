# PHP E-commerce Store

This is a modern e-commerce store built with plain PHP 8.3, MariaDB, and Nginx using Docker. It is a complete solution featuring product catalog, user authentication, shopping cart, contact form, admin panel, and more – all without any frameworks.

## 🚀 Features

- 🛍️ Product Catalog with individual product pages
- 🛒 Session-based Shopping Cart
- 🔐 User Authentication (Login, Register, Password Reset)
- 🧑‍💼 Admin Panel for managing products and settings
- 📬 Contact Form
- 🧾 Activity Logging
- 🧹 CLI Command to clean expired auth tokens
- 🐳 Dockerized Environment (PHP, Nginx, MariaDB)

## 📁 Project Structure
```text
├── app
│   ├── Commands # CLI commands (e.g., cleanup_tokens)
│   ├── DB.php # Database connection manager
│   ├── Database
│   │   ├── Migrations # Database schema migrations
│   │   ├── Seeders # Default data seeders
│   │   ├── DatabaseSeeder.php # Seeder runner
│   │   └── Migrate.php # Migration runner
│   ├── Http
│   │   ├── Controllers # Base controllers
│   │   ├── Middlewares # Custom middlewares
│   │   ├── Modules # Feature-based logic (Auth, Cart, Products, etc.)
│   │   └── Requests & Resources
│   ├── Interfaces # Repository interfaces
│   ├── Models # Database models
│   ├── Repositories # Data access layers
│   └── Router.php # Application router
├── config.php # Application config
├── docker # Docker environment setup
│   ├── mariadb
│   ├── nginx
│   └── php
├── docker-compose.yaml # Docker orchestration file
├── index.php # Front controller
├── public # Public assets (CSS, JS, images, views)
└── vendor # Dependencies (such as autoload.php)
```

## 🪧 Digram ERD
![alt text](image.png)

## ⚙️ Getting Started

### Prerequisites

- Docker & Docker Compose installed

### Installation

```bash
# Clone the repository
git clone https://github.com/pkkamil/laughing-guacamole.git
cd laughing-guacamole

# Build and run containers
docker-compose up --build -d

# Enter the PHP container
docker exec -it laughing-guacamole-php-1 sh 

# Run migrations and seeders
php app/Database/Migrate.php #In case you want to refresh the database add --fresh flag
php app/Database/DatabaseSeeder.php
```
## 🧪 Testing
Currently, there are no automated tests. Manual testing can be done through the web UI or Postman.

## 🧼 CLI Commands
```bash
php app/Commands/cleanup_tokens.php
```
This command cleans up expired authentication tokens from the database.

## ✅ TODO
- Add CSRF protection for forms
- Implement validation for all user inputs (backend)
- Add product image uploader with cropping
- Add pagination to product listing
- Add activity logging for user actions
- Implement search and filter functionality
- Improve UI styling and responsiveness
- Write unit and integration tests
- Add multi-language support
- Enable password reset via email
- Add order history & confirmation system
- Optimize SQL queries and database indexes
- Add rate limiting for login attempts
- Setup CI/CD pipeline for automated deployment
- Create detailed API documentation (Postman collection)

## 📝 License
This project is open-source and free to use under the MIT License.