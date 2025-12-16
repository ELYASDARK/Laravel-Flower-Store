# SQLite Configuration Guide for Flower Store

## ✅ Current Status: **Fully SQLite Compatible**

Your Flower Store application is now fully configured to work with SQLite!

---

## 🔧 Changes Made for SQLite Compatibility

### **1. Database Configuration (`config/database.php`)**

✅ Added SQLite connection with:
- Default connection set to `sqlite`
- Database path: `database/database.sqlite`
- Foreign key constraints enabled

### **2. Migration Files Fixed**

✅ **Replaced ENUM columns** (not supported in SQLite):

**Users Table:**
- `enum('role')` → `string('role')` 
- Values: `'admin'` or `'customer'`

**Orders Table:**
- `enum('status')` → `string('status')`
- Values: `'pending'`, `'processing'`, `'completed'`, `'cancelled'`

**Note:** Validation is handled by PHP Enums (`UserRole`, `OrderStatus`) so data integrity is maintained!

### **3. Database File**

✅ `database/database.sqlite` created and seeded with initial data

---

## 📋 SQLite vs MySQL Differences

### **What Works the Same:**
- ✅ Foreign key constraints
- ✅ Indexes
- ✅ Transactions
- ✅ All CRUD operations
- ✅ Relationships (belongsTo, hasMany, etc.)
- ✅ Query builder and Eloquent ORM
- ✅ Migrations and seeders

### **SQLite Limitations (Already Handled):**
- ❌ No native ENUM type → **Fixed:** Using strings with PHP enum validation
- ❌ Limited ALTER TABLE support → **N/A:** Using `migrate:fresh` for development
- ⚠️ No concurrent writes → **OK:** Perfect for development/small apps

---

## 🚀 Environment Configuration

Your `.env` should have:

```env
DB_CONNECTION=sqlite
DB_DATABASE=C:\Develop\Laravel\database\database.sqlite
# OR relative path:
# DB_DATABASE=database/database.sqlite

# These are ignored for SQLite:
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_USERNAME=root
# DB_PASSWORD=
```

---

## 📊 Verify Database

### **Check Tables:**
```bash
php artisan db:show
```

### **Check Table Structure:**
```bash
php artisan db:table users
php artisan db:table products
```

### **Run Tinker:**
```bash
php artisan tinker

# Test queries:
User::count();
Product::with('category')->get();
Order::where('status', 'pending')->count();
```

---

## 🔄 Reset Database (Development)

```bash
# Drop all tables and re-run migrations with seeds:
php artisan migrate:fresh --seed

# Just run migrations (no seeds):
php artisan migrate:fresh
```

---

## 💾 Backup & Restore

### **Backup:**
```bash
# Windows PowerShell:
Copy-Item database\database.sqlite database\database.backup.sqlite

# Or manually copy the file
```

### **Restore:**
```bash
# Windows PowerShell:
Copy-Item database\database.backup.sqlite database\database.sqlite
```

---

## 🔍 SQLite Browser Tools

### **Recommended Tools:**

1. **DB Browser for SQLite** (Free, Cross-platform)
   - Download: https://sqlitebrowser.org/
   - Open `database/database.sqlite` to view/edit data visually

2. **TablePlus** (Free tier available)
   - Download: https://tableplus.com/
   - Professional database client with SQLite support

3. **VS Code Extensions:**
   - "SQLite" by alexcvzz
   - "SQLite Viewer" by Florian Klampfer

---

## ⚠️ Important SQLite Considerations

### **✅ Good For:**
- Development and testing
- Small to medium applications
- Single-user applications
- Embedded applications
- Prototyping

### **❌ Consider MySQL/PostgreSQL For:**
- High-traffic production apps
- Multiple concurrent writers
- Complex stored procedures
- Full-text search (advanced)
- Replication needs

---

## 🐛 Common SQLite Issues & Solutions

### **Issue: "Database is locked"**
**Cause:** Another process has the database open
**Solution:** 
```bash
# Close DB browser tools
# Or increase timeout:
# In config/database.php:
'sqlite' => [
    'busy_timeout' => 5000, // 5 seconds
]
```

### **Issue: "No such table"**
**Cause:** Migrations not run
**Solution:**
```bash
php artisan migrate:fresh --seed
```

### **Issue: "SQLSTATE[23000]: Integrity constraint violation"**
**Cause:** Foreign key constraint violation
**Solution:**
```bash
# Ensure foreign_key_constraints is enabled in config:
'foreign_key_constraints' => true,
```

---

## 🔄 Switching to MySQL Later

If you need to switch to MySQL in production:

1. **Update `.env`:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flower_store
DB_USERNAME=root
DB_PASSWORD=
```

2. **Create MySQL database:**
```sql
CREATE DATABASE flower_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

3. **Run migrations:**
```bash
php artisan migrate:fresh --seed
```

4. **No code changes needed!** Laravel's ORM handles the differences automatically.

---

## 📈 Performance Tips for SQLite

### **1. Enable WAL Mode (Write-Ahead Logging):**
```php
// In config/database.php:
'sqlite' => [
    'driver' => 'sqlite',
    'database' => database_path('database.sqlite'),
    'foreign_key_constraints' => true,
    'journal_mode' => 'WAL', // Add this
],
```

### **2. Use Transactions for Bulk Operations:**
```php
DB::transaction(function () {
    // Multiple inserts/updates here
});
```

### **3. Index Important Columns:**
Your migrations already include proper indexes on foreign keys!

---

## ✅ Verification Checklist

- [x] SQLite database file exists (`database/database.sqlite`)
- [x] All migrations run successfully
- [x] Database seeded with test data (2 users, 5 categories, 10 products)
- [x] Foreign key constraints enabled
- [x] No ENUM columns (replaced with strings)
- [x] PHP Enums handle validation (`UserRole`, `OrderStatus`)
- [x] Application server running and accessible

---

## 🎯 Your SQLite Database Contains:

✅ **Users (2):**
- admin@flowerstore.com (Admin)
- customer@flowerstore.com (Customer)

✅ **Categories (5):**
- Wedding, Birthday, Sympathy, Anniversary, Love & Romance

✅ **Products (10):**
- Various flower products with bilingual names
- Prices ranging from 15,000 to 80,000 IQD
- Stock levels and images

✅ **Tables Ready:**
- users, categories, products, orders, order_items, cart_items
- password_reset_tokens, sessions, migrations

---

## 🚀 Next Steps

1. ✅ Database is ready and working
2. ✅ Server is running at http://127.0.0.1:8000
3. 🎯 Test the application thoroughly
4. 📝 Review the TESTING_GUIDE.md for comprehensive test cases

**Your SQLite-powered Flower Store is ready! 🌸✨**

