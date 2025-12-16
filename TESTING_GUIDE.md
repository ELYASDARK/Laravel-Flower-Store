# Comprehensive Testing Guide - Flower Store

This guide provides detailed test cases for all features of the Flower Store application.

## Prerequisites

Before testing, ensure:
```bash
# 1. Install dependencies
composer install
npm install

# 2. Set up environment
cp .env.example .env
php artisan key:generate

# 3. Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flower_store
DB_USERNAME=your_username
DB_PASSWORD=your_password

# 4. Run migrations and seeders
php artisan migrate:fresh --seed

# 5. Create storage symlink
php artisan storage:link

# 6. Build assets
npm run build

# 7. Start server
php artisan serve
```

Access the application at: `http://localhost:8000`

---

## 1. ✅ User Registration and Login

### Test User Registration

**Steps:**
1. Navigate to `/register`
2. Fill in the registration form:
   - Name: `Test Customer`
   - Email: `customer@test.com`
   - Password: `password`
   - Confirm Password: `password`
3. Click "Register"

**Expected Results:**
- ✅ User is registered and automatically logged in
- ✅ Redirected to home page
- ✅ Success message displayed
- ✅ User name appears in navigation
- ✅ "Logout" button visible

**Test Validation:**
1. Try to register with existing email → Should show error
2. Try to register with short password → Should show error
3. Try to register with mismatched passwords → Should show error
4. Try to register without required fields → Should show errors

**Database Verification:**
```sql
SELECT * FROM users WHERE email = 'customer@test.com';
-- Should show user with role = 'customer'
```

---

### Test User Login

**Steps:**
1. Logout if logged in
2. Navigate to `/login`
3. Enter credentials:
   - Email: `customer@test.com`
   - Password: `password`
4. Click "Login"

**Expected Results:**
- ✅ User is logged in
- ✅ Redirected to home page
- ✅ User name in navigation
- ✅ Cart icon visible

**Test Validation:**
1. Try invalid email → Should show error
2. Try wrong password → Should show error
3. Try empty fields → Should show errors

**Test Admin Login:**
- Email: `admin@flowerstore.com`
- Password: `password`
- Should see admin navigation menu

---

## 2. ✅ Guest Browsing

### Test Guest Can View

**Steps (as guest - not logged in):**
1. Visit home page `/`
2. Browse product grid
3. Click on a product
4. View product details

**Expected Results:**
- ✅ Products are visible
- ✅ Search and filters work
- ✅ Product details page loads
- ✅ Can see price, description, image
- ✅ "Add to Cart" button visible but...

### Test Guest Cannot Purchase

**Steps:**
1. On product details page, try to add to cart
2. Click "Add to Cart" button

**Expected Results:**
- ✅ Redirected to login page
- ✅ Message: "Please login to continue"
- ✅ After login, can proceed with purchase

---

## 3. ✅ Product Search and Filters

### Test Search Functionality

**Steps:**
1. On home page, enter search term: `Rose`
2. Click "Search"
3. Verify results

**Expected Results:**
- ✅ Only products with "Rose" in name/description shown
- ✅ Works for both English and Kurdish names
- ✅ Product count displayed correctly
- ✅ "Clear Filters" button appears

**Test Cases:**
| Search Term | Expected Results |
|-------------|------------------|
| `Rose` | Shows roses |
| `Birthday` | Shows birthday flowers |
| `گوڵ` (Kurdish) | Shows flowers with Kurdish name |
| `xyz123` | Shows "No products found" empty state |

### Test Category Filter

**Steps:**
1. Select category from dropdown: `Wedding`
2. Click "Search"

**Expected Results:**
- ✅ Only wedding category products shown
- ✅ Category name displayed in product cards
- ✅ Clear filters works

### Test Sort Options

**Test Each Sort:**
| Sort Option | Expected Result |
|-------------|-----------------|
| Latest | Newest products first |
| Price: Low to High | $10, $20, $30... |
| Price: High to Low | $50, $40, $30... |
| Name: A-Z | Alphabetical order |
| Name: Z-A | Reverse alphabetical |

### Test Combined Filters

**Steps:**
1. Search: `Rose`
2. Category: `Wedding`
3. Sort: `Price: Low to High`

**Expected Results:**
- ✅ All filters applied simultaneously
- ✅ Results are accurate
- ✅ Clear filters removes all

---

## 4. ✅ Shopping Cart and Checkout

### Test Add to Cart

**Prerequisites:** Login as customer

**Steps:**
1. Go to product details page
2. Select quantity: `2`
3. Click "Add to Cart"

**Expected Results:**
- ✅ Success message: "Product added to cart"
- ✅ Cart badge shows item count
- ✅ Redirected to cart page

**Test Stock Validation:**
1. Try to add more than available stock
2. Should show error: "Not enough stock"

### Test Cart Management

**Steps:**
1. Navigate to `/cart`
2. View cart items

**Expected Results:**
- ✅ Product image, name, price displayed
- ✅ Quantity controls work (+/-)
- ✅ Subtotal calculated correctly
- ✅ Total displayed at bottom
- ✅ Remove button works
- ✅ Cart updates in real-time

**Test Update Quantity:**
1. Click "+" to increase quantity
2. Click "-" to decrease quantity
3. Verify totals update

**Test Remove Item:**
1. Click "Remove" button
2. Item disappears from cart
3. Totals recalculated
4. If empty, show empty cart state

### Test Checkout Process

**Steps:**
1. In cart, click "Proceed to Checkout"
2. Fill checkout form:
   - Shipping Address: `123 Main St, City, Country`
   - Phone: `+964 770 123 4567`
   - Notes: `Please deliver before 5 PM`
3. Click "Place Order"

**Expected Results:**
- ✅ Order created successfully
- ✅ Success message displayed
- ✅ Redirected to order confirmation/history
- ✅ Cart is cleared
- ✅ Stock reduced in database

**Test Validation:**
1. Try to checkout with empty cart → Should show error
2. Try without shipping address → Should show error
3. Verify required fields

**Database Verification:**
```sql
-- Check order created
SELECT * FROM orders WHERE user_id = [your_user_id] ORDER BY created_at DESC LIMIT 1;

-- Check order items
SELECT * FROM order_items WHERE order_id = [order_id];

-- Check stock reduced
SELECT stock FROM products WHERE id = [product_id];

-- Check cart cleared
SELECT * FROM cart_items WHERE user_id = [your_user_id];
```

---

## 5. ✅ Order History

### Test View Orders

**Steps:**
1. Login as customer
2. Navigate to "My Orders"

**Expected Results:**
- ✅ List of all user's orders displayed
- ✅ Order ID, date, status, total shown
- ✅ Status badges colored correctly
- ✅ "View Details" button for each order

### Test Order Details

**Steps:**
1. Click "View Details" on an order

**Expected Results:**
- ✅ Customer information displayed
- ✅ Shipping address shown
- ✅ All order items listed with quantities
- ✅ Subtotals calculated correctly
- ✅ Total amount displayed
- ✅ Order status visible

---

## 6. ✅ Admin Product CRUD

**Prerequisites:** Login as admin (`admin@flowerstore.com` / `password`)

### Test Product List

**Steps:**
1. Navigate to "Admin Panel" → "Products"

**Expected Results:**
- ✅ Table with all products
- ✅ Shows: Image, English name, Kurdish name, category, price, stock, status
- ✅ Edit and Delete buttons for each product
- ✅ Pagination works
- ✅ "Add Product" button visible

### Test Create Product

**Steps:**
1. Click "Add Product"
2. Fill form:
   - Name (English): `Premium Red Roses`
   - Name (Kurdish): `گوڵی سوور`
   - Description (EN): `Beautiful red roses for special occasions`
   - Description (KU): `گوڵی سووری جوان بۆ بۆنە تایبەتەکان`
   - Category: Select `Wedding`
   - Price: `45.00`
   - Stock: `50`
   - Image: Upload flower image
   - Active: Check
3. Click "Create Product"

**Expected Results:**
- ✅ Product created successfully
- ✅ Success message displayed
- ✅ Redirected to products list
- ✅ New product appears in list
- ✅ Image uploaded and displayed

**Test Validation:**
1. Try to submit without required fields → Should show errors
2. Try to upload non-image file → Should show error
3. Try to upload file > 5MB → Should show error
4. Try negative price → Should show error
5. Try negative stock → Should show error

### Test Edit Product

**Steps:**
1. Click "Edit" on a product
2. Modify fields:
   - Change price to `50.00`
   - Change stock to `30`
   - Upload new image
3. Click "Update Product"

**Expected Results:**
- ✅ Product updated successfully
- ✅ Success message displayed
- ✅ Changes reflected in product list
- ✅ Old image deleted, new image displayed

### Test Delete Product

**Steps:**
1. Click "Delete" on a product
2. Confirm deletion

**Expected Results:**
- ✅ Confirmation prompt appears
- ✅ Product deleted from database
- ✅ Success message displayed
- ✅ Product removed from list
- ✅ Product image deleted from storage

---

## 7. ✅ Admin Category CRUD

### Test Category List

**Steps:**
1. Navigate to "Categories"

**Expected Results:**
- ✅ Table with all categories
- ✅ Shows: English name, Kurdish name, slug, product count
- ✅ Edit and Delete buttons
- ✅ "Add Category" button visible

### Test Create Category

**Steps:**
1. Click "Add Category"
2. Fill form:
   - Name (English): `Graduation`
   - Name (Kurdish): `خوێندن`
   - Slug: Auto-generated as `graduation`
3. Click "Create Category"

**Expected Results:**
- ✅ Category created successfully
- ✅ Slug auto-generated from English name
- ✅ Appears in category list

**Test Validation:**
1. Try duplicate slug → Should show error
2. Try invalid slug format → Should show error
3. Try empty required fields → Should show errors

### Test Edit Category

**Steps:**
1. Click "Edit" on a category
2. Modify fields
3. Click "Update Category"

**Expected Results:**
- ✅ Category updated successfully
- ✅ Changes reflected in list

### Test Delete Category

**Steps:**
1. Try to delete category with products

**Expected Results:**
- ✅ Error message: "Cannot delete category with products"
- ✅ Delete button disabled if has products

**Steps:**
2. Delete category with no products

**Expected Results:**
- ✅ Category deleted successfully

---

## 8. ✅ Admin Order Management

### Test Order List

**Steps:**
1. Navigate to "Orders"

**Expected Results:**
- ✅ Table with all orders
- ✅ Shows: Order ID, customer name, total, status, date
- ✅ Status badges colored:
  - Pending: Yellow
  - Processing: Blue
  - Completed: Green
  - Cancelled: Red
- ✅ "View" button for each order

### Test Order Details

**Steps:**
1. Click "View" on an order

**Expected Results:**
- ✅ Customer details displayed
- ✅ Shipping address shown
- ✅ All order items listed
- ✅ Total amount calculated
- ✅ Current status displayed
- ✅ Status update dropdown available

### Test Update Order Status

**Steps:**
1. On order details page
2. Select new status: `Processing`
3. Click "Update Status"

**Expected Results:**
- ✅ Status updated successfully
- ✅ Success message displayed
- ✅ New status reflected in order list
- ✅ Badge color changes accordingly

**Test All Status Transitions:**
| From | To | Expected |
|------|----|---------| 
| Pending | Processing | ✅ Works |
| Processing | Completed | ✅ Works |
| Processing | Cancelled | ✅ Works |
| Completed | Any | ✅ Should work |

---

## 9. ✅ Language Switching and RTL

### Test English (LTR)

**Steps:**
1. Click "EN" language button
2. Browse all pages

**Expected Results:**
- ✅ All text in English
- ✅ Left-to-right layout
- ✅ Navigation left-aligned
- ✅ Text left-aligned
- ✅ Icons on correct side

### Test Kurdish (RTL)

**Steps:**
1. Click "KU" language button
2. Browse all pages

**Expected Results:**
- ✅ All text in Kurdish
- ✅ Right-to-left layout
- ✅ Navigation right-aligned
- ✅ Text right-aligned
- ✅ Icons mirrored (arrows point left)
- ✅ Form inputs right-aligned
- ✅ Breadcrumbs reversed
- ✅ Product cards mirrored

**Pages to Test:**
- [ ] Home page
- [ ] Product details
- [ ] Cart
- [ ] Checkout
- [ ] Order history
- [ ] Admin dashboard
- [ ] Product management
- [ ] Category management
- [ ] Order management

**RTL Elements to Verify:**
- [ ] Navigation menu
- [ ] Product grid
- [ ] Forms
- [ ] Buttons
- [ ] Alerts
- [ ] Tables
- [ ] Breadcrumbs
- [ ] Pagination

### Test Language Persistence

**Steps:**
1. Switch to Kurdish
2. Navigate to different pages
3. Close browser
4. Reopen

**Expected Results:**
- ✅ Language persists across pages
- ✅ Language persists in session

---

## 10. ✅ Image Upload and Display

### Test Product Image Upload

**Steps:**
1. Admin → Add Product
2. Upload image (JPEG, PNG, GIF, WebP)

**Expected Results:**
- ✅ Image uploads successfully
- ✅ Image resized to max 1200x1200px
- ✅ File size reduced (optimization)
- ✅ Image displayed in product list
- ✅ Image displayed on product details page
- ✅ Image displayed in cart
- ✅ Image displayed in order history

**Test Image Validation:**
| Test Case | Expected Result |
|-----------|-----------------|
| Upload JPEG | ✅ Success |
| Upload PNG | ✅ Success |
| Upload GIF | ✅ Success |
| Upload WebP | ✅ Success |
| Upload PDF | ❌ Error: Invalid type |
| Upload > 5MB | ❌ Error: File too large |
| No image | ✅ Shows placeholder |

### Test Image Update

**Steps:**
1. Edit product with existing image
2. Upload new image

**Expected Results:**
- ✅ Old image deleted from storage
- ✅ New image uploaded
- ✅ New image displayed

### Test Image Deletion

**Steps:**
1. Delete product with image

**Expected Results:**
- ✅ Product deleted
- ✅ Image deleted from storage

### Test Placeholder

**Steps:**
1. Create product without image

**Expected Results:**
- ✅ Placeholder SVG displayed
- ✅ Placeholder shows on all views

---

## 11. ✅ Validation Testing

### Product Form Validation

**Test Create Product:**
| Field | Test | Expected Error |
|-------|------|----------------|
| name_en | Empty | "The name (English) field is required." |
| name_ku | Empty | "The name (Kurdish) field is required." |
| description_en | Empty | "The description (English) field is required." |
| price | Empty | "The price field is required." |
| price | Negative | "The price must be at least 0." |
| price | Text | "The price must be a number." |
| stock | Empty | "The stock field is required." |
| stock | Negative | "The stock must be at least 0." |
| category_id | Empty | "The category field is required." |
| category_id | Invalid | "The selected category is invalid." |
| image | Wrong type | "The image must be a file of type: jpeg, png..." |
| image | Too large | "The image must not be greater than 5120 kilobytes." |

### Category Form Validation

**Test Create Category:**
| Field | Test | Expected Error |
|-------|------|----------------|
| name_en | Empty | "The name (English) field is required." |
| name_ku | Empty | "The name (Kurdish) field is required." |
| slug | Empty | "The slug field is required." |
| slug | Duplicate | "The slug has already been taken." |
| slug | Invalid format | "Slug must contain only lowercase letters..." |
| slug | With spaces | "Slug must contain only lowercase letters..." |
| slug | With uppercase | "Slug must contain only lowercase letters..." |

### Checkout Form Validation

**Test Checkout:**
| Field | Test | Expected Error |
|-------|------|----------------|
| shipping_address | Empty | "The shipping address field is required." |
| phone | Too long | "The phone must not be greater than 20 characters." |

### Cart Validation

**Test Add to Cart:**
| Test | Expected Error |
|------|----------------|
| Quantity empty | "The quantity field is required." |
| Quantity < 1 | "The quantity must be at least 1." |
| Quantity > stock | "Not enough stock available." |
| Product out of stock | "Product is out of stock." |

### Authentication Validation

**Test Registration:**
| Field | Test | Expected Error |
|-------|------|----------------|
| name | Empty | "The name field is required." |
| email | Empty | "The email field is required." |
| email | Invalid format | "The email must be a valid email address." |
| email | Duplicate | "The email has already been taken." |
| password | Empty | "The password field is required." |
| password | < 8 chars | "The password must be at least 8 characters." |
| password | No match | "The password confirmation does not match." |

**Test Login:**
| Field | Test | Expected Error |
|-------|------|----------------|
| email | Empty | "The email field is required." |
| email | Wrong format | "The email must be a valid email address." |
| password | Empty | "The password field is required." |
| credentials | Wrong | "These credentials do not match our records." |

---

## 12. ✅ Browser Testing

### Browsers to Test

**Desktop:**
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)

**Mobile:**
- [ ] Chrome Mobile (Android)
- [ ] Safari Mobile (iOS)
- [ ] Samsung Internet

### Test Cases per Browser

For each browser, verify:
1. ✅ Layout renders correctly
2. ✅ All CSS styles apply
3. ✅ JavaScript works (Alpine.js)
4. ✅ Forms submit correctly
5. ✅ Images load and display
6. ✅ Animations work smoothly
7. ✅ Navigation functions properly
8. ✅ Mobile responsive design works

### Screen Sizes to Test

| Size | Width | Device | Test |
|------|-------|--------|------|
| Mobile S | 320px | iPhone SE | [ ] |
| Mobile M | 375px | iPhone 12 | [ ] |
| Mobile L | 414px | iPhone 12 Pro Max | [ ] |
| Tablet | 768px | iPad | [ ] |
| Laptop | 1024px | iPad Pro | [ ] |
| Desktop | 1440px | Desktop | [ ] |
| Large | 1920px | Large Desktop | [ ] |

---

## 13. ✅ Feature Completeness Check

### Per README.md Requirements

#### Core Features

- [x] **Bilingual Support (EN/KU)**
  - [x] All UI text translatable
  - [x] RTL layout for Kurdish
  - [x] Language switcher

- [x] **User Authentication**
  - [x] Registration
  - [x] Login
  - [x] Role-based access (Admin/Customer)

- [x] **Guest Features**
  - [x] Browse products
  - [x] Search products
  - [x] Filter by category
  - [x] Sort products
  - [x] View product details
  - [x] Cannot purchase without login

- [x] **Customer Features**
  - [x] All guest features
  - [x] Add to cart
  - [x] View cart
  - [x] Update cart quantities
  - [x] Remove from cart
  - [x] Checkout
  - [x] Place orders
  - [x] View order history
  - [x] View order details

- [x] **Admin Features**
  - [x] Dashboard with statistics
  - [x] Product CRUD (Create, Read, Update, Delete)
  - [x] Category CRUD
  - [x] Order management
  - [x] Update order status
  - [x] View all orders

#### Technical Requirements

- [x] **Laravel 12**
- [x] **PHP 8.3+ features**
- [x] **Strict typing**
- [x] **Tailwind CSS**
- [x] **MySQL database**
- [x] **Laravel Breeze authentication**
- [x] **Form Requests for validation**
- [x] **Eloquent models with relationships**
- [x] **Localization middleware**
- [x] **Image upload with optimization**
- [x] **Responsive design**
- [x] **RTL support**

---

## 🐛 Bug Tracking

### Found Bugs

| # | Description | Severity | Status | Fix |
|---|-------------|----------|--------|-----|
| 1 | | | | |
| 2 | | | | |
| 3 | | | | |

---

## ✅ Final Checklist

### Functionality
- [ ] All pages load without errors
- [ ] All forms submit correctly
- [ ] All validations work
- [ ] All CRUD operations work
- [ ] Authentication works
- [ ] Authorization works (role-based)
- [ ] File uploads work
- [ ] Images display correctly
- [ ] Pagination works
- [ ] Search works
- [ ] Filters work
- [ ] Sorting works

### User Experience
- [ ] Loading states shown
- [ ] Success messages displayed
- [ ] Error messages displayed
- [ ] Forms show validation errors
- [ ] Empty states shown
- [ ] Breadcrumbs work
- [ ] Navigation intuitive
- [ ] Responsive on all devices

### Localization
- [ ] English translations complete
- [ ] Kurdish translations complete
- [ ] Language switcher works
- [ ] RTL layout works perfectly
- [ ] No untranslated text

### Performance
- [ ] Pages load quickly
- [ ] Images optimized
- [ ] No console errors
- [ ] No PHP errors
- [ ] Database queries optimized

### Security
- [ ] Authentication required for protected routes
- [ ] Admin routes protected
- [ ] CSRF protection enabled
- [ ] SQL injection prevented (Eloquent)
- [ ] XSS protection (Blade escaping)
- [ ] File upload validation

---

## 📊 Test Summary Report

**Date:** __________  
**Tested By:** __________  
**Version:** __________  

### Results

| Category | Total Tests | Passed | Failed | Notes |
|----------|-------------|--------|--------|-------|
| Authentication | | | | |
| Guest Browsing | | | | |
| Product Search | | | | |
| Shopping Cart | | | | |
| Checkout | | | | |
| Order Management | | | | |
| Admin Products | | | | |
| Admin Categories | | | | |
| Admin Orders | | | | |
| Language/RTL | | | | |
| Image Upload | | | | |
| Validation | | | | |
| Browser Compatibility | | | | |

### Overall Status

- **Pass Rate:** _____%
- **Critical Issues:** ____
- **Minor Issues:** ____
- **Recommendations:** __________

---

## 🚀 Production Readiness

- [ ] All tests passed
- [ ] All bugs fixed
- [ ] Performance acceptable
- [ ] Security verified
- [ ] Documentation complete
- [ ] Deployment guide ready
- [ ] Backup strategy in place

**Ready for Production:** ☐ Yes ☐ No

---

**Last Updated:** [Date]  
**Flower Store v1.0**

