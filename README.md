# 🎓 EduFlow

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
  <img src="https://img.shields.io/badge/Livewire-4e56a6?style=for-the-badge&logo=livewire&logoColor=white" alt="Livewire" />
  <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS" />
  <img src="https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
</p>

EduFlow is a modern, premium, and comprehensive **Multi-School Management System** built with Laravel, Livewire, and Tailwind CSS. It is designed to bridge the gap between administrators, teachers, students, and parents with an intuitive and seamless user experience.

---

## ✨ Key Features

- **📊 Multi-School & Multi-Role Support**: Super Admin, Admin, Teacher, Student, and Parent roles.
- **💳 Online Payments**: Integrated Stripe payment gateway for tuition and fee collection.
- **🏫 Classroom Management**: Track attendance, absences, and generate detailed disciplinary records.
- **📚 E-Learning Module**: Distribute study materials, PDF resources, and assign homework dynamically.
- **💬 Internal Messaging**: Real-time messaging system to foster communication between staff and students.
- **🎨 Premium UI/UX**: Built with Glassmorphism aesthetics, modern typography (Inter/Plus Jakarta Sans), and smooth transitions.
- **📈 Dynamic Dashboards**: Role-specific dashboards featuring weather widgets, class analytics, and interactive charts.

---

## 🛠️ Tech Stack

- **Backend**: Laravel 10.x, PHP 8.1+
- **Frontend**: Livewire 3.x, Tailwind CSS, Alpine.js
- **Database**: MySQL

---

## 🚀 Installation Guide

Follow these steps to get EduFlow up and running on your local environment.

### 1. Clone the repository
```bash
git clone https://github.com/TAGNE-JULIO/eduflow.git
cd eduflow
```

### 2. Install Dependencies
```bash
composer install
npm install
npm run build
```

### 3. Environment Setup
Duplicate the `.env.example` file and rename it to `.env`. Configure your database credentials inside.
```bash
cp .env.example .env
```

### 4. Initialize EduFlow
EduFlow comes with a convenient artisan command that handles the database migrations, seeding, and linking storage automatically:
```bash
php artisan eduflow:init
```
*Note: During initialization, you will be prompted to select your environment. Select `local` to automatically seed the database with the default credentials.*

### 5. Start the Server
```bash
php artisan serve
```

---

## 🔐 Default Login Credentials

If you seeded the database during the `eduflow:init` process, you can log in using the following default accounts. All passwords are set to `password`.

| Role | Email | Password |
|---|---|---|
| **Super Admin** | `super@admin.com` | `password` |
| **Admin** | `admin@admin.com` | `password` |
| **Teacher** | `teacher@teacher.com` | `password` |
| **Student** | `student@student.com` | `password` |
| **Parent** | `parent@parent.com` | `password` |

---

## 📄 License
EduFlow is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).