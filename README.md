# Positfy - Backend API

## Overview
Positfy is a backend API built with Laravel that allows users to manage posts and comments with authentication using Laravel Sanctum.

## Features
- User authentication (Register, Login, Logout)
- Manage posts (Create, Read, List)
- Manage comments (Create, Read, List)
- Token-based authentication with Laravel Sanctum

## Technologies Used
- **Backend:** Laravel (PHP, MySQL, Sanctum for authentication)

## Setup Instructions

### Prerequisites
Before you begin, ensure you have the following installed on your system:
- **PHP** (8.0 or later)
- **Composer**
- **MySQL** (or any database supported by Laravel)
- **Laravel** (optional, but recommended)

### Installation Steps

1. **Clone the repository:**
   ```sh
   git clone https://github.com/Ezz24Mohamed/positfy.git
   cd positfy
   ```

2. **Install dependencies:**
   ```sh
   composer install
   ```

3. **Set up environment variables:**
   ```sh
   cp .env.example .env
   ```
   Open `.env` and update the database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```

4. **Generate application key:**
   ```sh
   php artisan key:generate
   ```

5. **Run migrations and seed the database:**
   ```sh
   php artisan migrate --seed
   ```

6. **Start the Laravel development server:**
   ```sh
   php artisan serve
   ```
   The server will run at:  
   **http://127.0.0.1:8000**

7. **Set up Laravel Sanctum for authentication:**
   ```sh
   composer require laravel/sanctum
   php artisan vendor:publish --provider="Laravel\\Sanctum\\SanctumServiceProvider"
   php artisan migrate
   ```

8. **Testing the API:**  
   You can test the API using:
   - [Postman](https://www.postman.com/)
   - `curl` commands in the terminal
   - Frontend application consuming the API

## API Endpoints

### Authentication
| Method | Endpoint        | Description            | Authentication Required |
|--------|---------------|------------------------|-------------------------|
| POST   | `/api/register` | Register a new user    | No                      |
| POST   | `/api/login`    | Login an existing user | No                      |
| POST   | `/api/logout`   | Logout the user        | Yes (Bearer Token)      |

#### Request Body - Register
```json
{
    "name": "John Doe",
    "email": "johndoe@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

#### Response - Register
```json
{
    "message": "User registered successfully",
    "token": "generated_token_here"
}
```

#### Request Body - Login
```json
{
    "email": "johndoe@example.com",
    "password": "password123"
}
```

#### Response - Login
```json
{
    "message": "Login successful",
    "token": "generated_token_here"
}
```

---

### Posts
| Method | Endpoint      | Description                  | Authentication Required |
|--------|-------------|------------------------------|-------------------------|
| GET    | `/api/posts` | Fetch all posts              | No                      |
| POST   | `/api/posts` | Create a new post            | Yes (Bearer Token)      |
| GET    | `/api/posts/{id}` | Get a specific post by ID | No                      |

#### Request Body - Create Post
```json
{
    "title": "My First Post",
    "content": "This is the content of my post."
}
```

#### Response - Create Post
```json
{
    "message": "Post created successfully",
    "post": {
        "id": 1,
        "title": "My First Post",
        "content": "This is the content of my post."
    }
}
```

---

### Comments
| Method | Endpoint                               | Description                          | Authentication Required |
|--------|--------------------------------------|--------------------------------------|-------------------------|
| GET    | `/api/posts/{post_id}/comments`      | Fetch comments for a specific post  | No                      |
| POST   | `/api/posts/{post_id}/comments`      | Add a comment to a specific post    | Yes (Bearer Token)      |

#### Request Body - Add Comment
```json
{
    "content": "This is a comment on the post."
}
```

#### Response - Add Comment
```json
{
    "message": "Comment added successfully",
    "comment": {
        "id": 1,
        "content": "This is a comment on the post."
    }
}
```

## License
This project is open-source and available under the MIT License.

## Author
[Ezzeldin Mohamed Mohamed](https://github.com/Ezz24Mohamed)

---
This README file provides full documentation of your project, from installation to API usage. 🚀
