# E-Commerce Shopping Management System

## Project Overview
This is a fully functional **PHP + MySQL E-Commerce system** with:

- User registration, login, password reset
- Product listing, categories, brands
- Product detail pages with images, description, reviews
- Cart, Wishlist, Save-for-Later
- Checkout with address, coupon, total
- Order history and tracking
- Admin panel with:
  - Dashboard (sales, orders, top products, low-stock)
  - CRUD: Products, Categories, Brands
  - Orders management
  - Users management (roles, block/unblock)
  - Coupons & Banners
  - Reviews moderation
  - Vendors management

## Project Structure

ecommerce_project/
├── assets/
│ ├── css/style.css
│ ├── js/main.js
│ └── images/
├── includes/
│ ├── db.php
│ ├── header.php
│ ├── footer.php
│ └── mail.php
├── admin/
│ ├── dashboard.php
│ ├── products.php
│ ├── categories.php
│ ├── brands.php
│ ├── orders.php
│ ├── users.php
│ ├── coupons.php
│ ├── banners.php
│ ├── reviews.php
│ └── vendors.php
├── cart.php
├── checkout.php
├── index.php
├── login.php
├── logout.php
├── product_detail.php
├── register.php
├── wishlist.php
├── save_for_later.php
├── account.php
└── README.md

## Installation Steps

1. **Install XAMPP/WAMP/LAMP** (PHP + MySQL) on your machine.
2. **Copy the `ecommerce_project` folder** into your server root:
   - XAMPP: `C:\xampp\htdocs\`
   - WAMP: `C:\wamp64\www\`
3. **Create MySQL Database**:
   - Name it: `ecommerce_db`
   - Import `database.sql` (contains tables: users, products, categories, brands, orders, order_items, cart, wishlist, save_for_later, reviews, coupons, banners, vendors)
4. **Update database connection**:
   - Open `includes/db.php`
   - Update credentials: `host`, `username`, `password`, `database`
5. **Add Images**:
   - Place product and banner images in `assets/images/`
6. **Run Project**:
   - Open browser: `http://localhost/ecommerce_project/index.php`
7. **Admin Panel**:
   - Access: `http://localhost/ecommerce_project/admin/dashboard.php`
   - Default Admin User: (create manually in `users` table)
     ```sql
     INSERT INTO users(name,email,password,role,status) VALUES('Admin','admin@example.com',MD5('password'),'admin','active');
     ```
8. **Features**:
   - Fully responsive grid
   - Hover effects
   - Role-based access (Admin, Manager, Support, Customer)
   - Multi-vendor support ready
   - Coupon and promotional banner integration
   - Product reviews moderation

## Notes
- Ensure PHP `file_uploads` is enabled in `php.ini` for banners and product images
- Session must be enabled for cart/wishlist functionality
- You can extend payment gateway integration (Stripe/Razorpay/PayPal) in `checkout.php`

## Optional Enhancements
- Multi-language (i18n) support in `/lang/`
- Email notifications for orders, password reset, promotions
- Recommendations and personalized offers

✅ DESCRIPTION

RKS Store – Online Shopping Management System is a web-based e-commerce application designed to provide a smooth, convenient, and secure online shopping experience. The system allows customers to browse products, add items to the cart, place orders, make secure payments, and track their purchases. It also includes a powerful Admin Panel that enables administrators to manage products, categories, brands, users, and orders efficiently.

The project is developed using HTML, CSS, JavaScript, PHP, and MySQL, following a structured software development methodology. The system focuses on usability, security, performance, and reliability—making it suitable for both small businesses and academic purposes.

RKS Store replicates essential features found in modern e-commerce platforms like Flipkart and Amazon, while keeping the interface simple and user-friendly.

⭐ KEY FEATURES
1. User Authentication & Account Management

  - Secure user registration and login

  - Password encryption and validation

  - Profile management (name, email, address, phone, etc.)

  - View order history and track orders

2. Product Catalog & Browsing

  - Clean and categorized product listing

  - Filter by brand, category, and price

  - Product details with images, description, and reviews

  - Search functionality for quick product discovery

3. Shopping Cart System

  - Add/remove products from the cart

  - Update item quantity

  - Automatic cart total calculation

  - Proceed to checkout with selected items

4. Wishlist & Save-for-Later

  - Save products to wishlist

  - Move items between wishlist, cart, and saved list

5. Checkout & Order Processing

  - Secure order placement

  - Delivery address submission

  - Payment gateway ready (Stripe/PayPal/Razorpay integration possible)

  - Automatic order ID and tracking number generation

6. Order Tracking

  - Customers can track order status using tracking ID

  - Admin updates order status from panel

  - Real-time visibility for customers

7. Admin Panel (Back-Office System)

  - Admin login with access control

  - Dashboard with analytics:

  - Total sales

  - Total orders

  - Top-selling products

  - Low-stock alerts

- Complete CRUD operations for:

  - Products

  - Categories

  - Brands

  - Users

  - Orders
  
  - Coupons

  - Banners

8. Database Management (MySQL)

  - Centralized database

  - Proper relational design with keys

  - Tables include: users, products, orders, categories, brands, reviews, wishlist, cart, etc.

9. Responsive UI

  - Fully responsive layout using HTML, CSS, and Bootstrap

  - Works smoothly on mobile, tablet, and desktop

10. Security Features

  - SQL injection protection

  - Encrypted passwords

  - Session-based authentication

  - Admin-only access to backend

11. Additional Modules

  - Product review system

  - Email notification support (optional)

  - Multi-vendor support ready

  - Dynamic banners and offers

  - Coupons and discount management


12. ## Rks Store - Online E-Commerce Website Demo Image Reffrencess How To Work Website :-
 1. Screenshoot :- Home Page
    <img width="1919" height="1078" alt="Screenshot 2025-09-29 230255" src="https://github.com/user-attachments/assets/149a05ea-a28e-4328-9d62-4d069aa63f3f" />
    <img width="1920" height="1080" alt="Screenshot 2025-09-29 233935" src="https://github.com/user-attachments/assets/07b7bba4-b142-465e-ad88-f04a2b93bfff" />
    <img width="1920" height="1080" alt="Screenshot 2025-09-29 234216" src="https://github.com/user-attachments/assets/18a2bea9-762e-4145-89ec-6e1d35f5cf26" />


 2. Screenshoot :- Login Page
    <img width="1920" height="1080" alt="Screenshot 2025-09-30 074334" src="https://github.com/user-attachments/assets/36b2f517-dab3-4c3c-976f-7de73502b61a" />

 2. Screenshoot :- Register Page
    <img width="1920" height="1080" alt="Screenshot 2025-09-30 074535" src="https://github.com/user-attachments/assets/1527f1e9-0793-49ca-a104-f213f62ce42e" />

 3. Screenshoot :- Admin Dashboard
    <img width="1920" height="1080" alt="Screenshot 2025-09-30 074831" src="https://github.com/user-attachments/assets/cbc8ee49-44c8-4ac4-98ee-2bd5e8b3527c" />

 4. Screenshoot :- Products Page
    <img width="1920" height="1080" alt="Screenshot 2025-09-30 073751" src="https://github.com/user-attachments/assets/98f824e2-8616-4699-85c0-ee8fea8c4386" />

 5. Screenshoot :- Manage Order Page
    <img width="1920" height="1080" alt="Screenshot 2025-09-30 080344" src="https://github.com/user-attachments/assets/6135a736-bc2f-4bbc-b519-2e5144a9f7a8" />

  6. Screenshoot :- Wishlisted Page
    <img width="1920" height="1080" alt="Screenshot 2025-09-30 081859" src="https://github.com/user-attachments/assets/36edd596-4d1b-4289-8485-4ccba3b68722" />

  7. Screenshoot :- Manage Brands Page
    <img width="1920" height="1080" alt="Screenshot 2025-09-30 080805" src="https://github.com/user-attachments/assets/4c1f6c20-9444-4e39-b768-782e4d115a5b" />

  8.Screenshoot :- Manage Categeory Page
    <img width="1920" height="1080" alt="Screenshot 2025-09-30 080709" src="https://github.com/user-attachments/assets/3f9c2fd7-1a5f-476f-9730-dafeb9652d68" />

  9. Screenshoot :- My Cart Page
    <img width="1920" height="1080" alt="Screenshot 2025-09-30 081936" src="https://github.com/user-attachments/assets/2e360de4-1f14-4999-8c73-1c4c325b4013" />

  10. Screenshoot :- My Account Page
    <img width="1920" height="1080" alt="Screenshot 2025-09-30 082318" src="https://github.com/user-attachments/assets/d01628c1-2e5b-40a3-8116-35bcb51a5ba4" />

  11.Screenshoot :- Checkout page
    <img width="1920" height="1080" alt="Screenshot 2025-09-30 082610" src="https://github.com/user-attachments/assets/aa0317c4-3ea9-4413-a05f-97ade7e9ba9d" />

  Screenshoot :- Admin Dashboard
  


    

    

    



