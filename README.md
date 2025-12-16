# 🌸 Flower Online Store

A complete, production-ready Laravel 12 e-commerce application for selling flowers with **dual-language support** (English & Kurdish) featuring **RTL support**, comprehensive admin panel, and beautiful Tailwind CSS UI.

![Laravel](https://img.shields.io/badge/Laravel-12.x-red)
![PHP](https://img.shields.io/badge/PHP-8.3+-blue)
![Tailwind CSS](https://img.shields.io/badge/TailwindCSS-3.4-38bdf8)
![License](https://img.shields.io/badge/License-MIT-green)

## ✨ Features

### 🌍 Internationalization
- **Dual Language Support**: English (LTR) and Kurdish (RTL)
- Dynamic language switcher in navigation
- Session-based language preference
- Automatic RTL layout for Kurdish
- All content translated (UI, products, categories)

### 👥 User Management
- **Three User Types**: Admin, Customer, and Guest
- Secure authentication with Laravel Breeze-style implementation
- Role-based access control
- Guest browsing (no purchase without login)

### 🛒 E-commerce Features
- Product catalog with categories
- Advanced search (both languages)
- Filter & sort (price, name)
- Shopping cart management
- Complete checkout process
- Order history and tracking

### 🎨 Admin Panel
- Dashboard with statistics
- Product CRUD (dual-language inputs)
- Image upload for products
- Order management
- Status updates
- Category management

### 💻 Technical Excellence
- **PHP 8.3+** with strict typing
- **Enums** for type safety (UserRole, OrderStatus, Language)
- **SQLite/MySQL** - Database agnostic (fully compatible with both)
- **FormRequests** for validation
- **Eloquent** relationships and scopes
- **Middleware** for localization and authorization
- **Tailwind CSS** for modern, responsive UI
- Clean, maintainable code following Laravel best practices

## 📸 Screenshots

*(Add your screenshots here after deployment)*

## 🚀 Quick Start

### Prerequisites
- PHP 8.3 or higher
- Composer
- **SQLite** (included) or MySQL 5.7+ / MariaDB 10.3+
- Node.js 18+ and NPM

### Installation

```bash
# 1. Clone or download the project
cd flower-store

# 2. Install PHP dependencies
composer install

# 3. Install Node.js dependencies
npm install

# 4. Configure environment
cp .env.example .env
php artisan key:generate

# 5. Configure database (SQLite - Already configured by default!)
# Using SQLite (no additional setup needed):
# DB_CONNECTION=sqlite
# DB_DATABASE=database/database.sqlite

# OR for MySQL:
# DB_CONNECTION=mysql
# DB_DATABASE=flower_store
# DB_USERNAME=root
# DB_PASSWORD=your_password
# mysql -u root -p -e "CREATE DATABASE flower_store"

# 6. Run migrations and seed data
php artisan migrate:fresh --seed

# 8. Build frontend assets
npm run dev

# 9. Start the server
php artisan serve
```

Visit: **http://localhost:8000**

### Default Credentials

**Admin Account:**
- Email: `admin@flowerstore.com`
- Password: `password`

**Customer Account:**
- Email: `customer@flowerstore.com`
- Password: `password`

## 📚 Documentation

- **[INSTALLATION.md](INSTALLATION.md)** - Detailed installation guide with troubleshooting
- **[FEATURES.md](FEATURES.md)** - Complete feature documentation
- **[.cursorrules](.cursorrules)** - Development standards and conventions

## 🗂️ Project Structure

```
app/
├── Enums/                  # UserRole, OrderStatus, Language
├── Http/
│   ├── Controllers/
│   │   ├── Admin/         # Product & Order management
│   │   ├── Auth/          # Login & Registration
│   │   └── Public/        # Storefront
│   ├── Middleware/        # Localization, Authorization
│   └── Requests/          # Form validation
└── Models/                # Eloquent models

database/
├── migrations/            # Database schema
└── seeders/              # Demo data (5 categories, 10 products)

resources/
├── css/                  # Tailwind CSS
├── views/
│   ├── admin/           # Admin panel views
│   ├── auth/            # Login/Register
│   ├── public/          # Storefront
│   └── layouts/         # Base layout with RTL

lang/
├── en/                   # English translations
└── ku/                   # Kurdish translations (with RTL)
```

## 🎯 Key Features Detail

### Public Features (Guest)
✅ Browse all products  
✅ Search functionality  
✅ Filter by category  
✅ Sort by price/name  
✅ View product details  
✅ Multi-language support  

### Customer Features
✅ All guest features  
✅ Add to cart  
✅ Update cart quantities  
✅ Complete checkout  
✅ View order history  
✅ Order details  

### Admin Features
✅ Dashboard with stats  
✅ Product CRUD (dual-language)  
✅ Image upload  
✅ Stock management  
✅ Order management  
✅ Status updates  

## 🗃️ Database Schema

**Users**: id, name, email, password, role (admin|customer)  
**Categories**: id, name_en, name_ku, slug  
**Products**: id, category_id, name_en, name_ku, desc_en, desc_ku, price, image_path, stock, is_active  
**Orders**: id, user_id, total_price, status, shipping_address, phone, notes  
**Order Items**: id, order_id, product_id, quantity, price  
**Cart Items**: id, user_id, product_id, quantity  

## 🌐 Routes Overview

### Public Routes
```
GET  /                          # Home page
GET  /products/{product}        # Product details
GET  /language/{locale}         # Switch language
```

### Authenticated Routes
```
GET   /cart                     # Shopping cart
POST  /cart/add/{product}       # Add to cart
GET   /checkout                 # Checkout
POST  /checkout                 # Process order
GET   /my-orders                # Order history
```

### Admin Routes (`/admin/*`)
```
GET   /admin/dashboard          # Admin dashboard
Resource: /admin/products       # Product CRUD
GET   /admin/orders             # List orders
PATCH /admin/orders/{id}/status # Update order status
```

## 🛠️ Technology Stack

- **Backend**: Laravel 12, PHP 8.3+
- **Frontend**: Blade Templates, Tailwind CSS 3.4
- **Database**: MySQL/MariaDB
- **Build Tools**: Vite
- **Authentication**: Custom Laravel Breeze-style

## 🎨 Code Quality

This project follows **strict Laravel and PHP best practices**:

- ✅ `declare(strict_types=1)` in all files
- ✅ Comprehensive type hints and return types
- ✅ PHP 8.3+ features (Enums, readonly properties)
- ✅ FormRequest validation
- ✅ Eloquent relationships and scopes
- ✅ Resource controllers
- ✅ Middleware architecture
- ✅ Clean code principles

**Naming Conventions:**
- `kebab-case` for files
- `PascalCase` for classes
- `camelCase` for methods
- `snake_case` for variables/properties/columns

## 📦 Seeded Data

The application includes:
- **2 Users**: 1 Admin, 1 Customer
- **5 Categories**: Wedding, Birthday, Funeral, Anniversary, Congratulations
- **10 Products**: Various flower arrangements with dual-language content

## 🌟 Highlights

- **Production-Ready**: Complete e-commerce flow from browsing to checkout
- **Bilingual**: Full English/Kurdish support with RTL
- **Type-Safe**: Strict PHP 8.3+ typing throughout
- **Beautiful UI**: Modern, responsive Tailwind design
- **Clean Architecture**: Follows Laravel best practices
- **Well-Documented**: Comprehensive inline documentation

## 🔒 Security

- Password hashing (bcrypt)
- CSRF protection
- SQL injection prevention (Eloquent ORM)
- XSS protection (Blade auto-escaping)
- Rate limiting on authentication
- File upload validation
- Authorization at multiple levels

## 🚢 Deployment

See **[INSTALLATION.md](INSTALLATION.md)** for production deployment instructions including:
- Environment optimization
- Asset compilation
- Cache configuration
- Web server setup (Apache/Nginx)

## 📈 Future Enhancements

Potential additions:
- Payment gateway integration (Stripe, PayPal)
- Email notifications
- Product reviews & ratings
- Wishlist functionality
- Discount codes
- Advanced analytics
- REST API
- Real-time order tracking

## 🤝 Contributing

This is a complete educational project. Feel free to:
- Fork the repository
- Use it as a learning resource
- Build upon it for your own projects
- Adapt it for different businesses

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 👨‍💻 Author

Created as a complete Laravel 12 e-commerce demonstration following enterprise-level coding standards.

## 🙏 Acknowledgments

- Laravel Framework
- Tailwind CSS
- All open-source contributors

---

**Note**: This is a fully functional e-commerce application ready for learning, portfolio projects, or as a foundation for a real flower shop business. All features are implemented and tested according to Laravel 12 standards with PHP 8.3+ best practices.

For detailed setup and feature documentation, see:
- 📘 [INSTALLATION.md](INSTALLATION.md)
- 📗 [FEATURES.md](FEATURES.md)