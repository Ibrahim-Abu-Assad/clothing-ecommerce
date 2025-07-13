🛍️ Clothing E-commerce Platform
A modern, full-stack clothing e-commerce web application built using Laravel, Vue.js, Inertia.js, Tailwind CSS, and MySQL.

📌 Project Overview
This platform allows users to browse, filter, search, and purchase clothing products online. It provides full functionality from product discovery to checkout, all within a responsive and user-friendly Single Page Application (SPA).

🚀 Features
👕 Product Browsing
Advanced filtering by:

Brand

Color

Size

Category

Price Range

Starting Letter of Name

Server-side filtering using a single optimized query

Sorting alphabetically (A→Z / Z→A)

Live search with debounce

Pagination using Laravel’s native paginate()

📄 Product Details
Multiple product images

Description, price, available sizes & colors

Stock availability

Add to cart with selected variant

🛒 Shopping Cart
Add / update / remove items

Cart stored in ((session))

((Dynamic quantity updates))

Cart summary with subtotal & total

🔐 Authentication
Laravel Breeze (Vue + Inertia stack)

Users can:

Register / Log in

Add to cart

Place orders

View order history

🧾 Checkout & Orders
Only authenticated users can place orders

Inventory updates after successful checkout

Orders saved to database

Order history page for users

////////////////////

🧱 Tech Stack
Layer	    |  Technology
Backend	    |   Laravel 12 (PHP 8.3)
Frontend  	|   Vue.js 3 (via Inertia)
SPA	        |   Inertia.js
UI	        |   Tailwind CSS
Database   	|   MySQL
Auth   	    |   Laravel Breeze
Build   	|   Vite
Session	    |   PHP Session (default)

📦 Example Filter Query (Laravel Controller)
this the code : 
[[
public function index(Request $request)
{
    $products = Product::query()
        ->when($request->brand, fn ($q) => $q->where('brand', $request->brand))
        ->when($request->color, fn ($q) => $q->where('color', $request->color))
        ->when($request->size, fn ($q) => $q->where('size', $request->size))
        ->when($request->category, fn ($q) => $q->where('category', $request->category))
        ->when($request->letter, fn ($q) => $q->where('name', 'LIKE', $request->letter . '%'))
        ->when($request->min_price && $request->max_price, fn ($q) =>
            $q->whereBetween('price', [$request->min_price, $request->max_price]))
        ->when($request->search, fn ($q) =>
            $q->where('name', 'LIKE', '%' . $request->search . '%'))
        ->when($request->sort === 'az', fn ($q) => $q->orderBy('name'))
        ->when($request->sort === 'za', fn ($q) => $q->orderByDesc('name'))
        ->paginate(12)
        ->withQueryString();

    return Inertia::render('Products/Index', [
        'products' => $products,
        'filters' => $request->only([
            'brand', 'color', 'size', 'category',
            'letter', 'search', 'sort', 'min_price', 'max_price'
        ]),
    ]);
}
]]

📁 Folder Structure (Main)
markdown
Copy
Edit
- app/
- resources/
  - js/
    - Pages/
      - Products/Index.vue
      - Cart.vue
      - Checkout.vue
  - views/
- routes/
  - web.php
- database/
  - migrations/
- public/

🧑‍💻 Author
Ibrahim Abu-Assad
GitHub Profile » Ibrahim-Abu-Assad

📸 Screenshots (I will add later)

Product listing with filters

Cart page

Checkout page

Order history page

