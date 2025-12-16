# 🚀 Quick Start Guide

Get the Flower Online Store running in 5 minutes!

## Prerequisites Check

Before starting, ensure you have:
- ✅ PHP 8.3+ installed (`php -v`)
- ✅ Composer installed (`composer -V`)
- ✅ MySQL/MariaDB installed and running
- ✅ Node.js 18+ and NPM installed (`node -v && npm -v`)

## Step-by-Step Setup

### 1️⃣ Install Dependencies (2 minutes)

```bash
# Install PHP packages
composer install

# Install Node.js packages
npm install
```

### 2️⃣ Configure Environment (1 minute)

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

**Edit `.env` file** and set your database credentials:
```env
DB_DATABASE=flower_store
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

### 3️⃣ Setup Database (1 minute)

```bash
# Create the database
mysql -u root -p -e "CREATE DATABASE flower_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Run migrations and seed data
php artisan migrate --seed
```

### 4️⃣ Build Frontend & Start Server (1 minute)

```bash
# In Terminal 1: Build assets
npm run dev

# In Terminal 2: Start Laravel server
php artisan serve
```

### 5️⃣ Access the Application

🌐 Open: **http://localhost:8000**

---

## 🎯 Test Accounts

### Admin Access
```
Email: admin@flowerstore.com
Password: password
```
**What to test:**
- Dashboard with statistics
- Product management (Create/Edit/Delete)
- Order management
- Status updates

### Customer Access
```
Email: customer@flowerstore.com
Password: password
```
**What to test:**
- Browse products
- Add to cart
- Checkout process
- View orders

### Guest Access
```
No login required
```
**What to test:**
- Browse products
- Search functionality
- Filter & sort
- Language switcher
- Try adding to cart (should redirect to login)

---

## 🧪 Quick Feature Tests

### Test 1: Language Switching ✅
1. Visit homepage
2. Click **KU** button (top right)
3. Verify layout flips to RTL
4. Verify text changes to Kurdish
5. Click **EN** to switch back

### Test 2: Product Browsing ✅
1. On homepage, view product grid
2. Use search box to find "Rose"
3. Filter by category "Wedding"
4. Sort by "Price: Low to High"
5. Click a product to view details

### Test 3: Shopping Cart Flow ✅
1. Login as customer
2. Go to a product page
3. Select quantity
4. Click "Add to Cart"
5. View cart
6. Update quantity
7. Proceed to checkout
8. Fill shipping information
9. Place order
10. View order in "My Orders"

### Test 4: Admin Panel ✅
1. Login as admin
2. View dashboard statistics
3. Go to "Manage Products"
4. Click "Add Product"
5. Fill both English & Kurdish fields
6. Upload image (optional)
7. Save product
8. Edit the product
9. Go to "Manage Orders"
10. View order details
11. Update order status

---

## 🔍 Troubleshooting

### Issue: "500 Internal Server Error"
**Fix:**
```bash
php artisan config:clear
php artisan cache:clear
php artisan migrate:fresh --seed
```

### Issue: "Database connection failed"
**Fix:**
1. Check MySQL is running: `mysql -u root -p`
2. Verify `.env` database credentials
3. Ensure database exists: `SHOW DATABASES;`

### Issue: "Styles not loading"
**Fix:**
```bash
npm run build
# Or keep dev server running:
npm run dev
```

### Issue: "Permission denied"
**Fix (Linux/Mac):**
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Issue: "Images not showing"
**Fix:**
```bash
php artisan storage:link
mkdir -p public/images/products
chmod -R 775 public/images
```

---

## 📱 Mobile Testing

1. Find your local IP: `ipconfig` (Windows) or `ifconfig` (Mac/Linux)
2. Update `.env`: `APP_URL=http://192.168.1.xxx:8000`
3. Restart server: `php artisan serve --host=0.0.0.0`
4. Access from phone: `http://192.168.1.xxx:8000`

---

## 🎨 Customization Quick Tips

### Change Brand Colors
Edit `tailwind.config.js`:
```javascript
theme: {
  extend: {
    colors: {
      primary: '#your-color',
      secondary: '#your-color',
    }
  }
}
```

### Add More Languages
1. Create `lang/ar/messages.php` (example)
2. Add to `app/Enums/language.php`:
```php
case ARABIC = 'ar';
```
3. Update middleware to support new language

### Add More Categories
In database seeder or via admin panel:
```php
Category::create([
    'name_en' => 'Get Well Soon',
    'name_ku' => 'خێرا چاکبەوە',
    'slug' => 'get-well-soon',
]);
```

---

## 📊 What's Included

After setup, you'll have:

✅ **2 Users**
  - 1 Admin (admin@flowerstore.com)
  - 1 Customer (customer@flowerstore.com)

✅ **5 Categories**
  - Wedding, Birthday, Funeral, Anniversary, Congratulations

✅ **10 Products**
  - Various flower arrangements ($29.99 - $69.99)
  - English & Kurdish names/descriptions
  - Stock quantities ready

✅ **Features Ready**
  - Dual-language (EN/KU with RTL)
  - Shopping cart
  - Checkout
  - Order management
  - Admin panel
  - Product CRUD

---

## 🎓 Next Steps

1. ✅ Complete the quick setup above
2. 📖 Read [FEATURES.md](FEATURES.md) for detailed features
3. 🔧 Read [INSTALLATION.md](INSTALLATION.md) for deployment
4. 💻 Start customizing for your needs!

---

## 🆘 Need Help?

- Check [INSTALLATION.md](INSTALLATION.md) for detailed instructions
- Review [FEATURES.md](FEATURES.md) for feature documentation
- Read [PROJECT_SUMMARY.md](PROJECT_SUMMARY.md) for technical details

---

**Total Setup Time: ~5 minutes**

Enjoy your Flower Online Store! 🌸


