# 🛍️ Clothing E-commerce Platform

A modern, full-stack clothing e-commerce web application built using Laravel, Vue.js, Inertia.js, Tailwind CSS, and MySQL.

---

## 📌 Project Overview

This platform allows users to browse, filter, search, and purchase clothing products online. It provides full functionality from product discovery to checkout, all within a responsive and user-friendly Single Page Application (SPA).

---

## 🚀 Features

### 👕 Product Browse
* **Advanced filtering by:**
    * Brand
    * Color
    * Size
    * Category
    * Price Range
    * Starting Letter of Name
* Server-side filtering using a single optimized query
* Sorting alphabetically (A→Z / Z→A)
* Live search with debounce
* Pagination using Laravel’s native `paginate()`

### 📄 Product Details
* Multiple product images
* Description, price, available sizes & colors
* Stock availability
* Add to cart with selected variant

### 🛒 Shopping Cart
* Add / update / remove items
* Cart stored in session
* Dynamic quantity updates
* Cart summary with subtotal & total

### 🔐 Authentication
* Laravel Breeze (Vue + Inertia stack)
* **Users can:**
    * Register / Log in
    * Add to cart
    * Place orders
    * View order history

### 🧾 Checkout & Orders
* Only authenticated users can place orders
* Inventory updates after successful checkout
* Orders saved to database
* Order history page for users

---

## 🧱 Tech Stack

| Layer    | Technology               |
| :------- | :----------------------- |
| Backend  | Laravel 12 (PHP 8.3)     |
| Frontend | Vue.js 3 (via Inertia)   |
| SPA      | Inertia.js               |
| UI       | Tailwind CSS             |
| Database | MySQL                    |
| Auth     | Laravel Breeze           |
| Build    | Vite                     |
| Session  | PHP Session (default)    |

---

## 🚀 Getting Started

### Prerequisites

Before running the project, make sure you have the following software installed on your machine:

* **PHP** (version 8.3 or higher)
* **Composer**
* **Node.js and NPM** (or Yarn)
* **MySQL Database Server**
* **Git**

---

### Installation and Setup

1.  **Clone the Repository:**
    ```bash
    git clone https://github.com/Ibrahim-Abu-Assad/clothing-ecommerce.git
    cd clothing-ecommerce
    ```

2.  **Copy the Environment File:**
    ```bash
    cp .env.example .env
    ```

3.  **Install PHP Dependencies:**
    ```bash
    composer install
    ```

4.  **Generate Application Key:**
    ```bash
    php artisan key:generate
    ```

5.  **Install Frontend Packages:**
    ```bash
    npm install
    ```
    
6.  **Configure Database:**
    Open the `.env` file and update your database connection details:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=clothing_ecommerce # the database name
    DB_USERNAME=root
    DB_PASSWORD=''       # (empty for root without password)
    ```
    Make sure to replace `your_username` and `your_password` with your actual MySQL credentials. You should create the database (`clothing_ecommerce`) manually in your MySQL server if it doesn't exist.

    Before running migrations, make sure you have already created a MySQL database named `clothing_ecommerce`.

7.  **Run Migrations and Seeders :**
    ```bash
    php artisan migrate --seed
    ```
    
8.  **Build Frontend Assets with Vite:**
    ```bash
    npm run dev
    ```
    *(For production, you would use `npm run build` or `yarn build`.)*

9.  **Start the Development Server:**
    ```bash
    php artisan serve
    ```

### Access the Application

Open your web browser and navigate to:

http://127.0.0.1:8000

---

## 👤 Author

**Ibrahim Abu-Assad**  
[GitHub Profile](https://github.com/Ibrahim-Abu-Assad)



