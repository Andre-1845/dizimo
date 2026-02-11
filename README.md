# Dízimo Project

🌍 Read this README in Portuguese: [README.pt-BR.md](README.pt-BR.md)

**Dízimo Project** is a web-based system designed to manage members, donations, and financial transparency for religious institutions.

The application focuses on organization, security, and clear financial reporting, following real-world development best practices.

---

## 🎯 Project Purpose

- Centralize donation records (tithes and offerings)
- Allow members to track their own contributions
- Provide financial transparency through consolidated reports
- Support administrators in managing income and expenses efficiently

---

## 🧩 Features

### 👤 Members

- Member registration
- Personal donation history
- Monthly tithe goal definition
- Access to transparency dashboard

### 🛡️ Administration

- User and member management
- Role-based access control
- Donation, income, and expense registration
- Financial reports by period (month, year, custom range)
- Comparison between expected and actual tithes

### 📊 Transparency

- Consolidated financial dashboards
- Member-accessible reports for accountability

---

## 🛠️ Technologies Used

- **PHP 8+**
- **Laravel 12**
- **MySQL**
- **Blade Templates**
- **Tailwind CSS**
- **Git & GitHub**

---

## 🧱 Architecture and Organization

- MVC (Model–View–Controller) architecture
- Clear separation between:
  - Administrative panel
  - Member area
  - Public area
- Dedicated Service classes for business logic
- Database migrations and seeders
- Role-based authorization system

---

## 🔐 Access Control

The system uses role-based permissions to ensure data security:

- Administrator
- Member / User
- Treasurer, Assistant, and Secretary roles with specific permissions

---

## 🚀 Development and Deployment Workflow

This project follows a professional Git branching strategy:

- `localdev` → development branch
- `main` → production branch

Workflow:

1. Development on `localdev`
2. Commit and push to GitHub
3. Merge into `main`
4. Deploy to production environment

---

## ⚙️ Local Installation

```bash
git clone https://github.com/Andre-1845/dizimo.git
cd dizimo
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
