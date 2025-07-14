# TaskFlow - Task Management System

A modern, responsive task management system built with Laravel 12, Vue.js 3, and Inertia.js. This application provides comprehensive task assignment, tracking, and management capabilities with role-based access control.

## 🎯 Features

### Admin Features
- **User Management**: Add, edit, and delete users with role assignments
- **Task Management**: Create, assign, edit, and delete tasks with deadlines
- **Dashboard**: Overview of system statistics and quick actions
- **Email Notifications**: Automatic email notifications when tasks are assigned
- **Role-based Access Control**: Secure admin-only access to management features

### User Features  
- **Task Dashboard**: View all assigned tasks with status indicators
- **Status Updates**: Update task status (Pending, In Progress, Completed)
- **Progress Tracking**: Visual progress bars and task statistics
- **Deadline Alerts**: Clear indication of overdue tasks
- **Email Notifications**: Receive notifications when new tasks are assigned

## 🛠 Tech Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Vue.js 3 with Inertia.js
- **Styling**: Tailwind CSS
- **Database**: MySQL/MariaDB
- **Authentication**: Laravel Breeze
- **Email**: Laravel Mail with customizable templates

## 📋 Requirements

- PHP 8.2 or higher
- Composer
- Node.js 18+ and NPM
- MySQL 8.0+ or MariaDB 10.4+
- Web server (Apache/Nginx)

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd taskflow
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

### 4. Database Setup
Edit `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_flow
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Import the provided database:
```bash
# Create database
mysql -u root -p -e "CREATE DATABASE task_flow"

# Import the SQL dump
mysql -u root -p task_flow < database.sql
```

### 5. Email Configuration (Optional)
Configure email settings in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 6. Build Assets
```bash
# Development build
npm run dev

# Production build
npm run build
```

### 7. Set Permissions (Linux/Mac)
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## 🎮 Usage

### Default Login Credentials

**Administrator:**
- Email: `admin@example.com`
- Password: `password`

**Regular User:**
- Email: `user@example.com`  
- Password: `password`

### Starting the Application

```bash
# Start Laravel development server
php artisan serve

# In another terminal, start Vite dev server
npm run dev
```

Visit `http://localhost:8000` in your browser.

## 📊 Database Schema

### Users Table
- `id` - Primary key
- `name` - User's full name
- `email` - Unique email address
- `password` - Hashed password
- `role` - Enum: 'admin' or 'user'
- `created_at`, `updated_at` - Timestamps

### Tasks Table
- `id` - Primary key
- `title` - Task title
- `description` - Task description (optional)
- `user_id` - Foreign key to users table
- `status` - Enum: 'Pending', 'In Progress', 'Completed'
- `deadline` - Task deadline date
- `created_at`, `updated_at` - Timestamps

## 🔐 Security Features

- **Role-based Access Control**: Admin middleware protects administrative routes
- **CSRF Protection**: All forms include CSRF tokens
- **Password Hashing**: Bcrypt encryption for passwords
- **Email Verification**: Optional email verification support
- **Input Validation**: Comprehensive server-side validation

## 📧 Email Notifications

The system sends HTML email notifications when:
- New tasks are assigned to users
- Email templates are professionally designed and responsive
- Includes task details, deadlines, and direct links to the task dashboard

## 🎨 UI/UX Features

- **Responsive Design**: Works seamlessly on desktop, tablet, and mobile
- **Modern Interface**: Clean, professional design with Tailwind CSS
- **Interactive Elements**: Real-time status updates without page refresh
- **Visual Indicators**: Color-coded status badges and progress bars
- **Intuitive Navigation**: Role-based navigation menus

## 🛠 Development

### Project Structure
```
app/
├── Http/Controllers/     # Controllers for user and task management
├── Models/              # Eloquent models (User, Task)
├── Mail/               # Email notification classes
└── Http/Middleware/    # Custom middleware (AdminMiddleware)

resources/
├── js/
│   ├── Pages/          # Vue.js page components
│   │   ├── Admin/      # Admin-specific pages
│   │   └── User/       # User-specific pages
│   └── Layouts/        # Layout components
└── views/
    └── emails/         # Email templates

routes/
└── web.php            # Application routes
```

### Key Routes

**Admin Routes** (requires admin role):
- `/admin/dashboard` - Admin dashboard
- `/admin/users` - User management
- `/admin/tasks` - Task management

**User Routes** (authenticated users):
- `/dashboard` - User dashboard
- `/user/tasks` - User task list

## 🚀 Deployment

### Production Environment

1. **Server Requirements**: PHP 8.2+, MySQL, Nginx/Apache
2. **Environment Setup**: Configure `.env` for production
3. **Database Migration**: Import `database.sql`
4. **Asset Building**: Run `npm run build`
5. **Permissions**: Set proper file permissions
6. **Queue Workers**: Set up queue workers for email processing (optional)

### Hosting Recommendations

- **Shared Hosting**: cPanel with PHP 8.2+ support
- **VPS/Cloud**: DigitalOcean, AWS, Linode
- **Managed Laravel**: Laravel Vapor, Forge + server

## 🔧 Configuration

### Email Settings
For Gmail SMTP:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

### Queue Configuration (Optional)
For better email performance:
```env
QUEUE_CONNECTION=database
```

Then run: `php artisan queue:work`

## 📞 Support

For technical questions or issues:
- **Email**: cmogore@cytonn.com or eamondi@cytonn.com
- **Documentation**: This README file
- **Code Comments**: Inline documentation throughout the codebase

## 🏆 Features Implemented

✅ **Core Requirements**:
- Admin user management (CRUD operations)
- Task assignment with deadlines
- Task status tracking (Pending, In Progress, Completed)
- User task dashboard with status updates
- Email notifications for task assignments

✅ **Technical Requirements**:
- Laravel framework (no CMS)
- Vue.js frontend
- Object-Oriented Programming
- MySQL database with SQL dump provided
- Professional UI with responsive design

✅ **Bonus Features**:
- Modern, mobile-responsive design
- Real-time status updates
- Visual progress indicators
- Role-based navigation
- Professional email templates
- Comprehensive error handling

## 📄 License

This project is developed for the Cytonn Software Engineering Internship challenge.

---

**TaskFlow** - Streamlining team productivity through efficient task management.
