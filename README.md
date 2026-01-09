# 🎓 Laravel Role-Based School Management System

![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8.4x-blue)
![MySQL](https://img.shields.io/badge/Database-MySQL-orange)
![Spatie](https://img.shields.io/badge/Spatie-Roles%20%26%20Permissions-green)

> A **role-based multi-user Laravel application** built using **Spatie Role & Permission**, focusing on **CRUD operations**, **user access control**, and **school management logic**.

---

## 📌 Project Overview

This project is a **role-based web application** developed in **Laravel**, where multiple types of users interact with the system based on their assigned roles and permissions.

The system is designed around **school management**, where:

* **Admins manage data**
* **Students can only view data**
* **Super Admin controls everything**

Only the **User model** is used, and all access is handled using **roles and permissions**.

---

## 👥 User Roles Implemented

The application supports multiple user roles such as:

* 👑 **Super Admin** – Full access (users, roles, permissions, data)
* 🛠 **Admin** – Manage schools, subjects, and student data
* 🏫 **School Admin** – Subject-wise and school-wise data handling
* 🎓 **Student** – View-only access
* 👨‍💻 **Developer** – System-level access (for maintenance/testing)

Roles are managed using **Spatie Laravel Permission** library.

---

## 🔐 Authentication & Authorization

* Laravel built-in authentication
* Role-based authorization using **Spatie Role & Permission**
* Middleware-based route protection
* Permission checks for each CRUD operation

Example:

* Students ❌ cannot insert/update/delete
* Admins ✅ can insert and update
* Super Admin ✅ full control

---

## 🗄 Database Design

The database was designed **step-by-step**, starting with:

1. User table (default Laravel)
2. Role & permission tables (Spatie)
3. School-related tables
4. Subject-wise data tables

### Focus Areas:

* Relational database structure
* Foreign keys & constraints
* Clean and scalable schema

---

## ⚙️ Features Implemented

### ✅ CRUD Operations

* Create, Read, Update, Delete operations
* Role-restricted CRUD logic
* Form validation and error handling

### ✅ Role-Based Logic

* Students can **only view details**
* Admins can **insert and manage data**
* Super Admin can **manage users, roles & permissions**

### ✅ School & Subject Management

* Admin can add school details
* Subject-wise information handling
* Data shown dynamically based on role

---

## 🧩 Libraries & Packages Used

* **Laravel Framework**
* **Spatie Laravel Permission** (Role & Permission Management)
* Laravel UI / Breeze (Authentication)
* Eloquent ORM
* Blade Templating Engine

---

## 🛠 Tech Stack

| Technology | Usage                        |
| ---------- | ---------------------------- |
| Laravel    | Backend Framework            |
| PHP 8+     | Programming Language         |
| MySQL      | Database                     |
| Blade      | Frontend Templates           |
| Spatie     | Role & Permission Management |

---

## 🚀 Installation Steps

```bash
# Clone the repository
git clone <repository-url>

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Run migrations
php artisan migrate

# Seed roles and permissions
php artisan db:seed

# Run the application
php artisan serve
```

---

## 🧪 Learning Outcomes

Through this project, the following concepts were practiced:

* Laravel MVC architecture
* Role & permission based access control
* CRUD operations with real logic
* Database design and relations
* Middleware and route protection
* Clean and scalable backend logic

---

## 📸 Screenshots (Optional)

> Add screenshots of:

* Login page
* Admin dashboard
* Student view page
* Role management screen

---

## 👨‍💻 Developer

**Name:** Vinay Chavada
**Role:** Laravel Developer
**Focus:** Backend Logic, Role Management, CRUD Operations

---

## 📄 License

This project is for **learning and demonstration purposes**.

---

⭐ *If you like this project, feel free to give it a star!*

