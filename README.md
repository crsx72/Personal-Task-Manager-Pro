Personal Task Manager Pro

A fully-featured task management web application built using PHP (MVC), MySQL, and PDO.
Users can register, log in, and manage their tasks with categories, priorities, due dates, reports, and more.

##  Features

- User Registration & Authentication
- Category Management (per user)
- Task CRUD
- Task Status: `todo`, `in_progress`, `done`
- Task Search (by keyword + filters)
- Reports:
- Task count by status
- Overdue tasks
- Task summary by category
- Sorting by priority, due date, and status
- Secure:
- Passwords hashed
- All inputs validated
- SQL-safe with PDO prepared statements

## Setup Instructions

### Requirements

- PHP 7.4+ or 8.x
- MySQL
- Apache (XAMPP)
- PhpMyAdmin

### Installation

1. Download and install XAMPP.
2. Start Apache and MySQL in XAMPP Control Panel
3. Clone this repository
```bash
git clone https://github.com/crsx72/personal_task_manager_pro.git
```
4. Move project folder to C:\xampp\htdocs
5. Create the Database:
Go to http://localhost/phpmyadmin New->SQL and Run the provided SQL schema (see below)
```bash
CREATE DATABASE task_manager_pro;
USE task_manager_pro;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE,
  password VARCHAR(255),
  email VARCHAR(100) UNIQUE,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  name VARCHAR(50),
  UNIQUE(user_id, name),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  category_id INT NULL,
  title VARCHAR(100),
  description TEXT,
  priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
  due_date DATETIME NULL,
  status ENUM('todo', 'in_progress', 'done') DEFAULT 'todo',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  completed_at DATETIME NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

```

6. Configure Database in config.php if needed:
```bash
$host = 'localhost';
$db = 'task_manager_pro';
$user = 'root';
$pass = '';
```

7. Visit the app in your browser: http://localhost/personal_task_manager_pro/public/

## Project Structure
```bash
personal_task_manager_pro/
├── public/ # Web root
├── models/ # Database models
├── controllers/ # Business logic and routing
├── views/ # HTML templates with minimal PHP
├── config.php # Central DB config
└── README.md
```
## Usage
### Authentication
- Register: Create an account.
- Login: Sign in.
- Logout: Ends the session.
### Task Management
- Add a task: Use "Add Task" to enter title, description, category, priority, and due date.
- Add a category: Use "Add Category" to see category list and use "Add Category" in category list menu to add category.
- Edit a task: Click "Edit" to update task details.
- Change status: Mark as Todo, In Progress, or Done.
- Delete a task: Use "Delete" with confirmation.
- Sort: Sort according to Priority, Due Date or Status.
- Search Tasks: Search tasks according to Keyword, Priority, Due Date or Status.
- View Report: See Status Summary, Overdue Tasks and Category Summary.

Author
Onur Keskin

GitHub: @crsx72

License

This project is open source and free to use under the MIT License.