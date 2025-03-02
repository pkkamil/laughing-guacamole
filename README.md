# Project

## 📌 Introduction
A project based on PHP 8.3, running in Docker containers using Docker Compose. It utilizes the Nginx server to handle HTTP traffic.

## 📦 Requirements
- Docker
- Docker Compose

## 🚀 Installation and Running
1. Clone the repository:
   ```sh
   git clone https://github.com/pkkamil/laughing-guacamole.git
   cd project
   ```
2. Start the containers:
   ```sh
   docker compose up -d
   ```
3. The project will be available at:
   ```
   http://localhost
   ```

## 🛠 Project Structure
```
/project
│── docker/
│   │── db/
│   │   ├── Dockerfile  # Database docker configuration
│   │── nginx/
│   │   ├── Dockerfile  # Nginx docker configuration
│   │   ├── nginx.conf  # Nginx configuration
│   │── php/
│   │   ├── Dockerfile    # PHP 8.3 docker configuration
│── src/
│   ├── index.php        # Application entry file
│── docker-compose.yml   # Docker Compose service definitions
│── README.md            # Project documentation
```

## 📜 License
Project available under the MIT license.

