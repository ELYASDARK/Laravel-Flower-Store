# Flower Online Store - Installation Guide

## Overview
This is a complete Laravel 12 e-commerce application for selling flowers with dual-language support (English & Kurdish) and RTL support.

## Features
✅ Dual-language support (English & Kurdish with RTL)
✅ Admin panel for product and order management
✅ Customer portal with cart and checkout
✅ Guest browsing with authentication required for purchases
✅ Beautiful Tailwind CSS UI
✅ Strict PHP 8.3+ typing and Laravel 12 best practices

## Requirements
- PHP 8.3 or higher
- Composer
- MySQL 5.7+ or MariaDB 10.3+
- Node.js 18+ and NPM

## Installation Steps

### 1. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 2. Environment Configuration

```bash
# Copy the environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Database Configuration

Edit `.env` file and configure your database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flower_store
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Create Database

```bash
# Create the database
mysql -u root -p -e "CREATE DATABASE flower_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 5. Run Migrations and Seeders

```bash
# Run migrations
php artisan migrate

# Seed the database with dummy data
php artisan db:seed
```

### 6. Build Frontend Assets

```bash
# Development build
npm run dev

# Or for production build
npm run build
```

### 7. Create Storage Symlink

```bash
php artisan storage:link
```

### 8. Set Permissions (Linux/Mac)

```bash
chmod -R 775 storage bootstrap/cache
```

### 9. Start Development Server

```bash
php artisan serve
```

Visit: http://localhost:8000

## Default Credentials

### Admin Account
- **Email:** admin@flowerstore.com
- **Password:** password

### Customer Account
- **Email:** customer@flowerstore.com
- **Password:** password

## Database Structure

### Users Table
- `id`, `name`, `email`, `password`, `role` (admin/customer)

### Categories Table
- `id`, `name_en`, `name_ku`, `slug`

### Products Table
- `id`, `category_id`, `name_en`, `name_ku`, `description_en`, `description_ku`
- `price`, `image_path`, `stock`, `is_active`

### Orders Table
- `id`, `user_id`, `total_price`, `status`, `shipping_address`, `phone`, `notes`

### Order Items Table
- `id`, `order_id`, `product_id`, `quantity`, `price`

### Cart Items Table
- `id`, `user_id`, `product_id`, `quantity`

## Seeded Data

The application comes with:
- **1 Admin user** (admin@flowerstore.com)
- **1 Customer user** (customer@flowerstore.com)
- **5 Categories** (Wedding, Birthday, Funeral, Anniversary, Congratulations)
- **10 Products** (Various flower arrangements with English & Kurdish names/descriptions)

## Language Support

### Switching Languages
Use the language switcher in the top navigation:
- **EN** - English (LTR)
- **KU** - Kurdish (RTL)

### Adding New Translations
Edit these files:
- `lang/en/messages.php` - English translations
- `lang/ku/messages.php` - Kurdish translations

## Key Features

### Public Features (Guest Access)
- Browse all products
- Search and filter products
- View product details
- See categories
- Cannot add to cart without login

### Customer Features
- All guest features
- Add products to cart
- Update cart quantities
- Complete checkout
- View order history
- View order details

### Admin Features
- Dashboard with statistics
- Product CRUD operations (with dual-language inputs)
- Upload product images
- Manage product stock and status
- View all orders
- Update order status
- Filter orders by status

## Routing Structure

### Public Routes
- `GET /` - Home page with products
- `GET /products/{product}` - Product details
- `GET /language/{locale}` - Switch language

### Authenticated Customer Routes
- `GET /cart` - Shopping cart
- `POST /cart/add/{product}` - Add to cart
- `GET /checkout` - Checkout page
- `POST /checkout` - Process checkout
- `GET /my-orders` - Order history
- `GET /my-orders/{order}` - Order details

### Admin Routes (Prefix: /admin)
- `GET /admin/dashboard` - Admin dashboard
- Resource routes for products (index, create, store, edit, update, destroy)
- `GET /admin/orders` - List all orders
- `GET /admin/orders/{order}` - View order details
- `PATCH /admin/orders/{order}/status` - Update order status

## File Structure Highlights

```
app/
├── Enums/              # UserRole, OrderStatus, Language enums
├── Http/
│   ├── Controllers/
│   │   ├── Admin/      # Admin controllers
│   │   ├── Auth/       # Authentication controllers
│   │   └── Public/     # Public-facing controllers
│   ├── Middleware/     # SetLocale, AdminMiddleware
│   └── Requests/       # Form request validation classes
└── Models/             # Eloquent models with relationships

database/
├── migrations/         # Database schema migrations
└── seeders/           # Database seeders

resources/
├── css/               # Tailwind CSS
├── js/                # JavaScript files
└── views/
    ├── admin/         # Admin panel views
    ├── auth/          # Login/Register views
    ├── layouts/       # Base layout with RTL support
    └── public/        # Public-facing views

lang/
├── en/                # English translations
└── ku/                # Kurdish translations
```

## Code Quality Standards

This project follows strict Laravel and PHP best practices:
- ✅ PHP 8.3+ features (Enums, typed properties, readonly classes)
- ✅ `declare(strict_types=1)` in all files
- ✅ Comprehensive type hints and return types
- ✅ FormRequest validation
- ✅ Eloquent relationships
- ✅ Resource controllers
- ✅ Middleware for authentication and authorization
- ✅ kebab-case for files
- ✅ PascalCase for classes
- ✅ camelCase for methods
- ✅ snake_case for variables and database columns

## Troubleshooting

### Issue: 500 Error on Homepage
**Solution:** Make sure migrations are run and database is properly configured.

```bash
php artisan migrate:fresh --seed
```

### Issue: Images Not Showing
**Solution:** Create storage symlink and ensure public/images/products directory exists.

```bash
php artisan storage:link
mkdir -p public/images/products
```

### Issue: Language Not Switching
**Solution:** Clear config cache.

```bash
php artisan config:clear
php artisan cache:clear
```

### Issue: Styles Not Loading
**Solution:** Rebuild assets.

```bash
npm run build
```

## Production Deployment

### 1. Optimize Application

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

### 2. Set Environment to Production

```env
APP_ENV=production
APP_DEBUG=false
```

### 3. Configure Web Server

Set document root to `/public` directory.

### Apache (.htaccess already included)

### Nginx Configuration Example

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/flower-store/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## Support & Documentation

For Laravel documentation: https://laravel.com/docs/12.x
For Tailwind CSS: https://tailwindcss.com/docs

## License

This project is open-sourced software licensed under the MIT license.


