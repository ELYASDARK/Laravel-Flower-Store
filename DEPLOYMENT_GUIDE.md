# Flower Store - Deployment Guide

## 📋 Prerequisites

- **PHP 8.3+** (with extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML)
- **Composer 2.x**
- **Node.js 18+ and NPM**
- **MySQL 8.0+** or **MariaDB 10.3+**
- **Web Server** (Apache/Nginx) or Laravel's built-in server

---

## 🚀 Quick Start (Development)

### 1. Clone/Download the Project

```bash
cd /path/to/your/projects
# If from Git:
git clone <repository-url> flower-store
# Or extract the ZIP file
cd flower-store
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
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

Edit `.env` file:

```env
APP_NAME="Flower Store"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flower_store
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### 5. Create Database

```bash
# MySQL/MariaDB
mysql -u root -p
CREATE DATABASE flower_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 6. Run Migrations and Seeders

```bash
# Create tables and seed data
php artisan migrate:fresh --seed
```

This creates:
- Admin user: `admin@flowerstore.com` / `password`
- Customer user: `customer@flowerstore.com` / `password`
- 5 categories (Wedding, Birthday, Funeral, Anniversary, Congratulations)
- 10 sample products

### 7. Create Storage Symbolic Link

```bash
# Linux/Mac
php artisan storage:link
chmod -R 775 storage bootstrap/cache

# Windows (run as Administrator)
php artisan storage:link
```

Or use the provided scripts:
- Windows: `setup-storage.bat`
- Linux/Mac: `./setup-storage.sh`

### 8. Build Frontend Assets

```bash
# Development build
npm run dev

# Or for production
npm run build
```

### 9. Start Development Server

```bash
php artisan serve
```

Access the application at: **http://localhost:8000**

---

## 🎯 Default Credentials

### Admin Account
- **Email:** `admin@flowerstore.com`
- **Password:** `password`
- **Access:** Full admin panel (Dashboard, Products, Categories, Orders)

### Customer Account
- **Email:** `customer@flowerstore.com`
- **Password:** `password`
- **Access:** Shopping, cart, checkout, order history

---

## 🔧 Production Deployment

### 1. Server Requirements

**Recommended Stack:**
- **PHP 8.3+** with required extensions
- **MySQL 8.0+** or **MariaDB 10.3+**
- **Nginx** or **Apache** with mod_rewrite
- **Redis** (optional, for caching/sessions)
- **SSL Certificate** (Let's Encrypt recommended)

### 2. Clone and Setup

```bash
cd /var/www
git clone <repository-url> flower-store
cd flower-store
```

### 3. Install Dependencies (Production)

```bash
# Install PHP dependencies (no dev)
composer install --no-dev --optimize-autoloader

# Install and build frontend assets
npm install
npm run build
```

### 4. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` for production:

```env
APP_NAME="Flower Store"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourstore.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flower_store_prod
DB_USERNAME=secure_username
DB_PASSWORD=secure_strong_password

# Session driver (file, database, redis)
SESSION_DRIVER=database

# Cache driver (file, database, redis)
CACHE_DRIVER=redis

# Queue driver (sync, database, redis)
QUEUE_CONNECTION=redis

# Redis (if using)
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 5. Database Setup

```bash
# Create production database
mysql -u root -p
CREATE DATABASE flower_store_prod CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;

# Run migrations
php artisan migrate --force

# Seed initial data
php artisan db:seed --force
```

### 6. Set Permissions

```bash
# Set ownership
chown -R www-data:www-data /var/www/flower-store

# Set permissions
chmod -R 755 /var/www/flower-store
chmod -R 775 /var/www/flower-store/storage
chmod -R 775 /var/www/flower-store/bootstrap/cache

# Create storage link
php artisan storage:link
```

### 7. Optimize for Production

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize
```

### 8. Web Server Configuration

#### Nginx Configuration

Create `/etc/nginx/sites-available/flower-store`:

```nginx
server {
    listen 80;
    server_name yourstore.com www.yourstore.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name yourstore.com www.yourstore.com;
    root /var/www/flower-store/public;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/yourstore.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourstore.com/privkey.pem;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
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

Enable the site:
```bash
ln -s /etc/nginx/sites-available/flower-store /etc/nginx/sites-enabled/
nginx -t
systemctl reload nginx
```

#### Apache Configuration

Create `/etc/apache2/sites-available/flower-store.conf`:

```apache
<VirtualHost *:80>
    ServerName yourstore.com
    ServerAlias www.yourstore.com
    Redirect permanent / https://yourstore.com/
</VirtualHost>

<VirtualHost *:443>
    ServerName yourstore.com
    ServerAlias www.yourstore.com
    
    DocumentRoot /var/www/flower-store/public
    
    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/yourstore.com/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/yourstore.com/privkey.pem
    
    <Directory /var/www/flower-store/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/flower-store-error.log
    CustomLog ${APACHE_LOG_DIR}/flower-store-access.log combined
</VirtualHost>
```

Enable the site:
```bash
a2ensite flower-store
a2enmod rewrite ssl
apache2ctl configtest
systemctl reload apache2
```

### 9. SSL Certificate (Let's Encrypt)

```bash
# Install Certbot
apt-get install certbot python3-certbot-nginx

# Obtain certificate
certbot --nginx -d yourstore.com -d www.yourstore.com

# Auto-renewal
certbot renew --dry-run
```

### 10. Setup Cron Jobs (Optional)

For scheduled tasks, add to crontab:

```bash
crontab -e -u www-data
```

Add:
```
* * * * * cd /var/www/flower-store && php artisan schedule:run >> /dev/null 2>&1
```

### 11. Setup Queue Worker (Optional)

Create systemd service `/etc/systemd/system/flower-store-worker.service`:

```ini
[Unit]
Description=Flower Store Queue Worker
After=network.target

[Service]
User=www-data
Group=www-data
Restart=always
ExecStart=/usr/bin/php /var/www/flower-store/artisan queue:work --sleep=3 --tries=3

[Install]
WantedBy=multi-user.target
```

Enable and start:
```bash
systemctl enable flower-store-worker
systemctl start flower-store-worker
```

---

## 🔒 Security Checklist

- [x] Set `APP_DEBUG=false` in production
- [x] Use strong database passwords
- [x] Enable HTTPS/SSL
- [x] Set proper file permissions (775 for storage, 644 for files)
- [x] Keep `.env` file secure and out of version control
- [x] Enable CSRF protection (enabled by default)
- [x] Validate all user inputs (Form Requests in place)
- [x] Sanitize file uploads (validation in place)
- [x] Use prepared statements (Eloquent does this)
- [x] Implement rate limiting on sensitive routes
- [x] Regular backups of database
- [x] Keep Laravel and dependencies updated

---

## 📊 Performance Optimization

### 1. Enable Caching

```bash
# Cache everything
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Clear cache when deploying updates:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 2. Use Redis

Install Redis:
```bash
apt-get install redis-server
pecl install redis
```

Update `.env`:
```env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### 3. Enable OPcache

Edit `php.ini`:
```ini
opcache.enable=1
opcache.memory_consumption=256
opcache.max_accelerated_files=20000
opcache.validate_timestamps=0
```

### 4. Database Optimization

```sql
-- Add indexes (already in migrations)
-- Regular maintenance
OPTIMIZE TABLE products;
OPTIMIZE TABLE orders;
OPTIMIZE TABLE cart_items;
```

---

## 🔄 Maintenance

### Regular Updates

```bash
# Pull latest code
git pull origin main

# Update dependencies
composer install --no-dev --optimize-autoloader
npm install
npm run build

# Run migrations (if any)
php artisan migrate --force

# Clear and cache
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart services
systemctl restart php8.3-fpm
systemctl reload nginx
```

### Backup Strategy

**Database Backup:**
```bash
# Daily backup script
mysqldump -u username -p flower_store_prod > backup_$(date +%Y%m%d).sql
```

**File Backup:**
```bash
# Backup uploads
tar -czf storage_backup_$(date +%Y%m%d).tar.gz storage/app/public
```

**Automated Backup (Cron):**
```bash
# Add to crontab
0 2 * * * /path/to/backup-script.sh
```

---

## 🐛 Troubleshooting

### Issue: 500 Internal Server Error

**Solution:**
```bash
# Check logs
tail -f storage/logs/laravel.log

# Check permissions
chmod -R 775 storage bootstrap/cache

# Clear cache
php artisan cache:clear
php artisan config:clear
```

### Issue: Images not displaying

**Solution:**
```bash
# Check storage link
ls -la public/storage

# Recreate if needed
rm public/storage
php artisan storage:link

# Check permissions
chmod -R 775 storage/app/public
```

### Issue: Database connection error

**Solution:**
```bash
# Verify database exists
mysql -u username -p
SHOW DATABASES;

# Check .env credentials
# Test connection
php artisan tinker
DB::connection()->getPdo();
```

### Issue: npm run build fails

**Solution:**
```bash
# Clear node modules
rm -rf node_modules package-lock.json
npm cache clean --force
npm install
npm run build
```

---

## 📞 Support

For issues or questions:
1. Check `storage/logs/laravel.log`
2. Review `.env` configuration
3. Verify file permissions
4. Check web server error logs
5. Consult Laravel documentation: https://laravel.com/docs

---

## 🎉 Success!

Your Flower Store is now deployed and ready to accept orders!

**Next Steps:**
1. Change default admin password
2. Configure email settings (for order notifications)
3. Set up SSL certificate
4. Configure backups
5. Test all functionality
6. Add your products and categories
7. Launch! 🚀

---

**Version:** 1.0.0  
**Last Updated:** December 2025


