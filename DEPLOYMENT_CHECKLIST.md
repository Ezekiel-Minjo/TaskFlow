# TaskFlow Deployment Checklist

## 🚀 Quick Deploy Guide

### Pre-deployment Requirements
- [ ] PHP 8.2+ with required extensions (mbstring, openssl, pdo, tokenizer, xml)
- [ ] MySQL/MariaDB database server
- [ ] Node.js 18+ and NPM (for asset building)
- [ ] Web server (Apache/Nginx) with URL rewriting enabled

### Step 1: File Upload
- [ ] Upload all project files to server
- [ ] Ensure proper directory structure is maintained
- [ ] Upload the `database.sql` file

### Step 2: Database Setup
```sql
-- Create database
CREATE DATABASE task_flow;

-- Import the database
mysql -u username -p task_flow < database.sql
```

### Step 3: Environment Configuration
- [ ] Copy `.env.example` to `.env`
- [ ] Configure database credentials:
  ```env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=task_flow
  DB_USERNAME=your_username
  DB_PASSWORD=your_password
  ```
- [ ] Set application URL:
  ```env
  APP_URL=https://yourdomain.com
  APP_ENV=production
  APP_DEBUG=false
  ```

### Step 4: Email Configuration (Optional but Recommended)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="TaskFlow"
```

### Step 5: Permissions (Linux/cPanel)
```bash
# Set proper permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod -R 644 .env
```

### Step 6: Web Server Configuration

#### Apache (.htaccess - usually automatic)
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php [QSA,L]
```

#### Nginx
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

### Step 7: Security Checklist
- [ ] Generate application key: `php artisan key:generate`
- [ ] Remove `.env.example` from production
- [ ] Ensure `storage/` and `bootstrap/cache/` are writable
- [ ] Point domain to `public/` directory
- [ ] Enable HTTPS (SSL certificate)

### Step 8: Testing
- [ ] Access admin login: admin@example.com / password
- [ ] Access user login: user@example.com / password
- [ ] Test user management features
- [ ] Test task creation and assignment
- [ ] Test email notifications (if configured)
- [ ] Test responsive design on mobile devices

## 🎯 Default Login Credentials

**Administrator Account:**
- Email: `admin@example.com`
- Password: `password`

**Regular User Account:**
- Email: `user@example.com`
- Password: `password`

⚠️ **Important**: Change default passwords immediately after deployment!

## 🔧 Troubleshooting

### Common Issues:

1. **500 Internal Server Error**
   - Check file permissions (755 for directories, 644 for files)
   - Verify `.env` configuration
   - Check error logs

2. **Database Connection Error**
   - Verify database credentials in `.env`
   - Ensure database exists and is accessible
   - Check MySQL service is running

3. **Email Not Sending**
   - Verify SMTP settings in `.env`
   - Check firewall settings for SMTP ports
   - Test with a simple SMTP tool first

4. **CSS/JS Not Loading**
   - Ensure `public/build/` directory exists with compiled assets
   - Check web server configuration for static file serving
   - Verify file permissions

## 📱 Mobile Responsiveness Verified
- ✅ Desktop (1920x1080+)
- ✅ Tablet (768x1024)
- ✅ Mobile (375x667)
- ✅ Large Mobile (414x896)

## 🌟 Features Ready for Production
- ✅ Role-based authentication
- ✅ User management (CRUD)
- ✅ Task management with deadlines
- ✅ Email notifications
- ✅ Responsive design
- ✅ Security best practices
- ✅ Professional UI/UX

## 📞 Support Information
For deployment assistance:
- Email: cmogore@cytonn.com or eamondi@cytonn.com
- Include server environment details and error logs if needed

---

**TaskFlow is ready for production deployment!** 🚀