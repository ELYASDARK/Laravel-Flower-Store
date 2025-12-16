# Flower Online Store - Feature Documentation

## Complete Feature List

### 🌍 Internationalization (i18n)

#### Dual Language Support
- **English (en)** - Left-to-Right (LTR)
- **Kurdish (ku)** - Right-to-Left (RTL)

#### Implementation Details
- Language switcher in navigation bar
- Session-based language preference storage
- Automatic RTL layout when Kurdish is selected
- All text content available in both languages
- Database stores both English and Kurdish content for products and categories

#### Files
- `lang/en/messages.php` - English translations
- `lang/ku/messages.php` - Kurdish translations
- `app/Http/Middleware/SetLocale.php` - Language middleware
- `app/Enums/Language.php` - Language enum with helper methods

---

### 👤 User Management & Authentication

#### User Roles
1. **Admin** - Full access to admin panel
2. **Customer** - Can purchase products
3. **Guest** - Can browse but not purchase

#### Authentication Features
- User registration with email verification ready
- Login with "Remember Me" option
- Logout functionality
- Password hashing with bcrypt
- Rate limiting on login attempts
- Automatic redirect based on role (Admin → Dashboard, Customer → Home)

#### Authorization
- Middleware-based role checking
- Admin-only routes protected
- Cart and checkout require authentication
- FormRequest-level authorization

---

### 🛒 Shopping & E-commerce

#### Product Browsing (Public)
- Grid layout of products with images
- Category filtering
- Search functionality (searches both EN and KU fields)
- Price sorting (Low to High, High to Low)
- Name sorting (A-Z, Z-A)
- Latest products sorting
- Product detail pages with:
  - Large product image
  - Name and description (in selected language)
  - Price display
  - Stock availability
  - Category information
  - Related products section

#### Shopping Cart (Authenticated)
- Add products to cart with quantity selection
- View cart with:
  - Product images and details
  - Quantity adjustment
  - Remove items
  - Real-time subtotal calculation
- Stock validation before adding
- Persistent cart items (database-backed)

#### Checkout Process
- Shipping information form:
  - Shipping address (required)
  - Phone number (required)
  - Order notes (optional)
- Order summary display
- Total price calculation
- Stock validation before checkout
- Automatic stock reduction on order placement

#### Order Management (Customer)
- Order history page
- Order details view with:
  - Order status with color-coded badges
  - Shipping information
  - Items list with images
  - Price breakdown
  - Order date and number

---

### 🔧 Admin Panel

#### Dashboard
- **Statistics Cards:**
  - Total Orders count
  - Total Sales (completed orders)
  - Pending Orders count
  - Total Products count
- Recent orders table (last 10)
- Quick action buttons:
  - Add Product
  - Manage Orders

#### Product Management
**List View:**
- Paginated product table
- Product image thumbnails
- Both English and Kurdish names displayed
- Category information
- Price display
- Stock levels
- Active/Inactive status badges
- Edit and Delete actions

**Create Product:**
- Dual-language input fields:
  - Name (English & Kurdish)
  - Description (English & Kurdish)
- Single-language fields:
  - Category selection
  - Price (decimal)
  - Stock quantity (integer)
  - Image upload
  - Active checkbox
- Image upload with validation (jpeg, png, jpg, webp, max 2MB)
- Auto-generated random image names

**Edit Product:**
- Same form as create
- Pre-filled with existing data
- Image preview shown
- Option to upload new image (old image deleted)
- Can toggle active status

**Delete Product:**
- Confirmation dialog
- Cascade delete (removes related cart/order items)
- Deletes associated image file

#### Order Management
**List View:**
- Paginated orders table
- Filter by status (All, Pending, Processing, Completed, Cancelled)
- Customer information (name, email)
- Order date and time
- Total price
- Status badges (color-coded)
- View details action

**Order Details:**
- Full order information
- Customer details
- Shipping information
- List of items with:
  - Product images
  - Product names
  - Quantities
  - Prices and subtotals
- Total price breakdown
- Status update form with dropdown

---

### 🗃️ Database Architecture

#### Tables & Relationships

**users**
- Basic auth fields
- Role enum (admin, customer)
- hasMany: orders, cart_items

**categories**
- Dual-language names
- Slug for URL-friendly references
- hasMany: products

**products**
- Dual-language names and descriptions
- Price (decimal)
- Stock (integer)
- Image path
- Active status (boolean)
- belongsTo: category
- hasMany: order_items, cart_items

**orders**
- Order total
- Status enum (pending, processing, completed, cancelled)
- Shipping details
- Phone and notes
- belongsTo: user
- hasMany: order_items

**order_items**
- Quantity
- Price snapshot (preserves price at time of order)
- belongsTo: order, product

**cart_items**
- Quantity
- Unique constraint on (user_id, product_id)
- belongsTo: user, product

---

### 🎨 UI/UX Features

#### Design
- Modern, clean Tailwind CSS design
- Responsive layout (mobile, tablet, desktop)
- Beautiful color scheme (Pink primary, Purple accents)
- Card-based design pattern
- Shadow and hover effects

#### Navigation
- Fixed top navigation bar
- Logo and site name
- Contextual menu items based on auth status and role
- Language switcher (EN/KU buttons)
- Authentication buttons (Login/Register or Logout)

#### Alerts & Notifications
- Success messages (green)
- Error messages (red)
- Session flash messages
- Form validation errors inline

#### Forms
- Clean, accessible form design
- Proper labels and validation
- Error messages below fields
- Required field indicators
- Tailwind Forms plugin integration

---

### 🔒 Security Features

#### Authentication & Authorization
- Hashed passwords (bcrypt)
- CSRF protection on all forms
- Rate limiting on login
- Session regeneration on login
- Authorization at FormRequest level
- Middleware-based route protection

#### Input Validation
- FormRequest validation classes
- Strict typing throughout
- SQL injection prevention (Eloquent ORM)
- XSS protection (Blade auto-escaping)

#### File Upload Security
- MIME type validation
- File size limits (2MB)
- Random filename generation
- Storage outside web root option

---

### 📊 Data Seeding

#### Included Seed Data
**Users:**
- 1 Admin (admin@flowerstore.com / password)
- 1 Customer (customer@flowerstore.com / password)

**Categories:**
- Wedding (ئاهەنگی زەماوەند)
- Birthday (لەدایکبوون)
- Funeral (چوارەمین)
- Anniversary (ساڵڕۆژ)
- Congratulations (پیرۆزبایی)

**Products:**
- 10 flower products across all categories
- Each with English & Kurdish names/descriptions
- Realistic pricing ($29.99 - $69.99)
- Stock quantities (10-40 units)
- All products active

---

### 🚀 Performance Features

#### Query Optimization
- Eager loading relationships (with, load)
- Pagination on all list views
- Indexed foreign keys
- Efficient database queries

#### Caching Ready
- Config caching support
- Route caching support
- View caching support

#### Asset Optimization
- Vite for modern asset bundling
- CSS purging via Tailwind
- Production build optimization

---

### 🎯 Code Quality

#### PHP Standards
- PHP 8.3+ features (Enums, typed properties)
- `declare(strict_types=1)` on all files
- Comprehensive type hints
- Return type declarations
- PHPDoc blocks for IDE support

#### Laravel Best Practices
- FormRequest validation
- Resource controllers
- Eloquent relationships
- Query scopes
- Accessors for computed properties
- Middleware for cross-cutting concerns
- Service Container usage

#### File Naming Conventions
- kebab-case for files
- PascalCase for classes
- camelCase for methods
- snake_case for variables, properties, columns

---

### 📱 Responsive Design

#### Breakpoints
- Mobile (< 640px)
- Tablet (640px - 1024px)
- Desktop (> 1024px)

#### Mobile Features
- Hamburger menu (can be extended)
- Touch-friendly buttons
- Readable text sizes
- Properly sized form inputs
- Grid layouts adapt to screen size

---

## API-Ready Architecture

While this version focuses on web views, the architecture supports easy API addition:
- Clean controller logic
- FormRequest validation
- Resource models
- JSON-ready responses

---

## Extensibility

The application is built with extension in mind:

### Easy to Add:
- Payment gateway integration
- Email notifications
- Product reviews
- Wishlists
- Discount codes/coupons
- Inventory management
- Advanced filtering
- Product variants
- Multiple images per product
- CSV export/import
- Analytics dashboard
- Customer profiles

### Already Structured For:
- Additional user roles
- More languages
- API endpoints
- Real-time updates (Laravel Echo)
- Queue jobs
- Event broadcasting

---

## Summary

This Flower Online Store is a **production-ready** e-commerce application featuring:

✅ Complete shopping flow (browse → cart → checkout → orders)
✅ Full admin panel (products, orders, dashboard)
✅ Dual-language support with RTL
✅ Role-based access control
✅ Beautiful, responsive UI
✅ Strict typing and code quality
✅ Seeded demo data
✅ Comprehensive documentation

Perfect for learning, portfolio projects, or as a foundation for a real flower shop business!


