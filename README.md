﻿# 📚 Student Management System

A web-based Student Management System built with **Laravel 11**, **Filament Admin**, and **MySQL**.  
Designed to manage students, professors, courses, class sections, academic results, clubs, and timetables efficiently.

---

## 🚀 Features

- 🔐 Authentication & Authorization (Role-Based Access Control with Spatie Permissions)
- 📋 Full CRUD operations for:
  - Students
  - Professors
  - Courses
  - Departments
  - Study Levels
  - Class Sections
  - Clubs
  - Timetables
- 📈 Custom Admin Dashboard with real-time statistics
- 🧾 Export student academic results as **PDF** (DOMPDF integrated)
- 📂 Image/File uploads for student profiles
- 🔥 Trend charts and color-coded indicators
- 🎯 Responsive Admin Panel (Filament UI)

---

## 🛠️ Technologies Used

- **Laravel 11** (Backend Framework)
- **Filament Admin** (Admin Panel & UI)
- **Spatie Laravel-Permission** (Roles and Permissions)
- **Laravel DomPDF** (PDF Export)
- **MySQL** (Database)
- **TailwindCSS** (UI Styling via Filament)

---

## 🏗️ Database Structure

- `departments`
- `study_levels`
- `professors`
- `courses`
- `class_sections`
- `students`
- `academic_results`
- `clubs`
- `club_student`
- `timetables`

✅ All tables have proper **foreign keys** and **relationships**.

---

## ⚙️ Installation

1. **Clone the repository:**

```bash
git clone https://github.com/SalahEddine-Ghannouch/Filament-School-Management.git
cd to-the-repo
```
2. **Install dependencies:**

```bash
composer install
npm install && npm run build
```

3. **Copy .env and configure database:**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Set up your database (.env):**

```bash
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

5. **Run migrations and seeders:**

```bash
php artisan migrate --seed
```

6. **Serve the project:**

```bash
php artisan serve
```

7. **Access Admin Panel:**

```bash
Visit /your-domain/admin
```

## 🔥 Author

Developed by **SalahEddine Ghannouch**
🔗 [LinkedIn](https://www.linkedin.com/in/salah-eddine-ghannouch/) | [GitHub](https://github.com/SalahEddine-Ghannouch)
