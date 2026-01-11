# AllFreshFoods - Multi-Vendor Grocery Store Platform

A Laravel-based multi-vendor e-commerce platform that enables customers to shop from multiple grocery vendors in one place, while allowing vendors to manage their products and orders independently.

## Project Description

AllFreshFoods is a comprehensive multi-vendor grocery marketplace built with Laravel 11. The platform facilitates seamless transactions between customers and multiple food vendors, featuring role-based access control, real-time inventory management, and an intuitive order processing system.

### Key Features

- **Multi-Vendor Support**: Multiple vendors can sell products on a single platform
- **Role-Based Access Control**: Three distinct user roles (Admin, Vendor, Customer)
- **Product Management**: Full CRUD operations with image uploads and categorization
- **Shopping Cart**: Session-based cart with quantity management and stock validation
- **Order Management**: Multi-vendor order splitting with vendor-specific order items
- **Email Notifications**: Automated order confirmation emails
- **Authentication**: Laravel Breeze with role-specific registration
- **Responsive UI**: Tailwind CSS for modern, mobile-friendly design

## User Roles

### 1. Admin
- Manage all products across all vendors
- Manage product categories
- View all orders system-wide
- Access admin dashboard with comprehensive statistics

### 2. Vendor
- Manage only their own products
- View and update order items for their products
- Track sales and revenue
- Access vendor-specific dashboard

### 3. Customer
- Browse products from all vendors
- Add products to cart with quantity selection
- Place orders
- View order history and track order status

## Technology Stack

- **Framework**: Laravel 11
- **PHP**: 8.2+
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Breeze
- **File Storage**: Laravel Storage (local/public disk)
- **Email**: Laravel Mail with Markdown templates
- **Queue**: Database queue driver

## Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL 5.7+ or PostgreSQL
- Node.js & NPM
- Git

## Installation Steps

### 1. Clone the Repository

```bash
git clone <repository-url>
cd allfreshfoods
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database

Edit `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=allfreshfoods
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Configure Email (Optional)

For email notifications, configure your mail settings in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@allfreshfoods.com"
MAIL_FROM_NAME="AllFreshFoods"
```

For testing, you can use:
```env
MAIL_MAILER=log
```

### 6. Configure Application URL

```env
APP_URL=http://localhost:8000
```

### 7. Run Migrations

```bash
php artisan migrate
```

### 8. Create Storage Link

```bash
php artisan storage:link
```

### 9. Seed Database

```bash
php artisan db:seed
```

This will create:
- 1 Admin user
- 5 Vendors with associated user accounts
- 10 Product categories
- 50 Products distributed across vendors
- Sample orders with order items

### 10. Build Frontend Assets

```bash
npm run build

# Or for development with hot reload
npm run dev
```

### 11. Start the Application

```bash
php artisan serve
```

Visit: `http://localhost:8000`

### 12. Start Queue Worker (Optional)

For email notifications to work asynchronously:

```bash
php artisan queue:work
```

## Test Credentials

After seeding, you can log in with:

### Admin Account
- **Email**: admin@allfreshfoods.com
- **Password**: password

### Vendor Accounts
- **Email**: vendor1@allfreshfoods.com to vendor5@allfreshfoods.com
- **Password**: password

### Customer Account
- **Email**: customer@allfreshfoods.com
- **Password**: password

## Project Structure

```
app/
├── Enums/
│   └── UserRole.php           # User role enumeration
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   │   └── RegisterController.php
│   │   ├── CartController.php
│   │   ├── CategoryController.php
│   │   ├── DashboardController.php
│   │   ├── OrderController.php
│   │   ├── OrderItemController.php
│   │   ├── ProductController.php
│   │   └── VendorDashboardController.php
│   ├── Requests/
│   │   ├── StoreCategoryRequest.php
│   │   ├── UpdateCategoryRequest.php
│   │   ├── StoreProductRequest.php
│   │   └── UpdateProductRequest.php
│   └── Middleware/
│       └── CheckRole.php
├── Mail/
│   └── OrderPlacedMail.php
├── Models/
│   ├── Category.php
│   ├── Order.php
│   ├── OrderItem.php
│   ├── Product.php
│   ├── User.php
│   └── Vendor.php
├── Policies/
│   ├── CategoryPolicy.php
│   ├── ProductPolicy.php
│   ├── OrderPolicy.php
│   └── OrderItemPolicy.php
└── Services/
    ├── CartService.php
    ├── CategoryService.php
    ├── OrderService.php
    └── ProductService.php

resources/
├── views/
│   ├── admin/
│   │   ├── dashboard.blade.php
│   │   ├── categories/
│   │   ├── products/
│   │   └── orders/
│   ├── vendor/
│   │   ├── dashboard.blade.php
│   │   ├── products/
│   │   └── orders/
│   ├── auth/
│   │   ├── register-customer.blade.php
│   │   └── register-vendor.blade.php
│   ├── cart/
│   │   └── index.blade.php
│   ├── orders/
│   │   └── show.blade.php
│   ├── products/
│   │   └── index.blade.php
│   ├── emails/
│   │   └── order-placed.blade.php
│   ├── layouts/
│   │   ├── app.blade.php
│   │   ├── admin.blade.php
│   │   ├── vendor.blade.php
│   │   └── navigation.blade.php
│   └── welcome.blade.php
```

## Key Features Implementation

### 1. Multi-Vendor Product Catalog
- Products belong to specific vendors
- Categories for product organization
- Image upload support
- Stock management with validation

### 2. Shopping Cart System
- Session-based cart storage
- Quantity selection and editing
- Stock validation
- Multi-vendor cart support

### 3. Order Management
- Orders split into vendor-specific order items
- Each order item tracked separately
- Status updates per vendor
- Order synchronization based on item statuses

### 4. Authorization & Policies
- Gate-based middleware for route protection
- Policy-based authorization for resource access
- Vendors can only manage their own products
- Admins have full system access

### 5. Email Notifications
- Order confirmation emails
- Markdown-based templates
- Queued for performance
- Order details and tracking

## Database Schema

### Users
- id, name, email, password, role (enum), vendor_id

### Vendors
- id, name, timestamps

### Categories
- id, name, timestamps

### Products
- id, vendor_id, category_id, name, description, price, stock, image_path, timestamps

### Orders
- id, user_id, total_amount, status, timestamps

### Order Items
- id, order_id, product_id, vendor_id, quantity, price, status, timestamps

## API Routes

### Public Routes
- `GET /` - Welcome page
- `GET /products` - Public product catalog
- `GET /register/customer` - Customer registration
- `GET /register/vendor` - Vendor registration

### Authenticated Routes
- `GET /dashboard` - Role-based dashboard redirect
- `GET /cart` - View shopping cart
- `POST /cart/{product}` - Add to cart
- `PUT /cart/{product}` - Update cart quantity
- `DELETE /cart/{product}` - Remove from cart
- `POST /orders` - Checkout and create order
- `GET /orders/{order}` - View order details

### Admin Routes (Prefix: /admin)
- `GET /dashboard` - Admin dashboard
- Resource routes for categories
- Resource routes for products
- `GET /orders` - All orders

### Vendor Routes (Prefix: /vendor)
- `GET /dashboard` - Vendor dashboard
- Resource routes for products (vendor's only)
- `GET /orders` - Vendor's order items
- `PUT /order/item/{orderItem}` - Update order item status

## Testing

Run the test suite:

```bash
php artisan test
```

Key test files:
- `tests/Feature/ProductAuthorizationTest.php`
- `tests/Feature/VendorOrderTest.php`
- `tests/Feature/Auth/RegistrationTest.php`

## Development Notes

### Queue Configuration

For development, you can use sync driver:
```env
QUEUE_CONNECTION=sync
```

For production, use database or Redis:
```env
QUEUE_CONNECTION=database
```

Then run:
```bash
php artisan queue:table
php artisan migrate
php artisan queue:work
```

### Storage

Product images are stored in `storage/app/public/products/`. Make sure to run:
```bash
php artisan storage:link
```

## Troubleshooting

### Images Not Showing
- Ensure `php artisan storage:link` has been run
- Check `APP_URL` is set correctly in `.env`
- Verify storage permissions: `chmod -R 775 storage`

### Queue Jobs Not Processing
- Check `QUEUE_CONNECTION` in `.env`
- Run `php artisan queue:work` in a separate terminal
- Check failed jobs: `php artisan queue:failed`

### Authorization Errors
- Clear config cache: `php artisan config:clear`
- Check user roles are properly assigned
- Verify policies are registered in `AppServiceProvider`

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is open-sourced software licensed under the MIT license.

## Support

For issues and questions, please open an issue in the GitHub repository.

## Acknowledgments

- Built with Laravel 12
- UI components from Laravel Breeze
- Styled with Tailwind CSS
- Icons from Heroicons
