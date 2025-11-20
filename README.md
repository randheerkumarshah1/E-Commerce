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
