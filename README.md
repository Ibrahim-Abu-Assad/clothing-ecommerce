# 🛍️ Clothing E-commerce Platform

A modern, full-stack clothing e-commerce web application built with Laravel, Vue.js, Inertia.js, Tailwind CSS, and MySQL.

## 🚀 Features

- User registration & authentication
- Product browsing with advanced filters (brand, category, size, color, price, etc.)
- Search functionality
- Shopping cart
- Checkout and order placement
- Order history
- Admin product management (coming soon)
- Responsive design for all devices

## 🛠️ Tech Stack

- **Backend**: Laravel 12.x (PHP 8.3)
- **Frontend**: Vue.js 3, Inertia.js
- **Styling**: Tailwind CSS
- **Database**: MySQL
- **Session**: PHP Session (or Laravel default)
- **Package Management**: Composer, NPM

## 📸 Screenshots

> _You can add some screenshots later here using markdown or direct image links._

## 📦 Installation

```bash
git clone https://github.com/Ibrahim-Abu-Assad/clothing-ecommerce.git
cd clothing-ecommerce

# Install PHP dependencies
composer install

# Install JS dependencies
npm install && npm run dev

# Copy .env and configure
cp .env.example .env
php artisan key:generate

# Set up DB and run migrations
php artisan migrate --seed

# Serve the project
php artisan serve

