# Kedai - SaaS E-commerce Platform

> **Build your online store with ease.** A multi-tenant SaaS platform designed for students, non-tech individuals, startups, and SMEs.

---

## 🎯 What We're Building

**Kedai** is a comprehensive SaaS platform that enables users to:
- Create professional landing pages with drag-and-drop builders
- Launch fully-functional e-commerce stores
- Manage products, orders, and customers
- Accept payments through multiple Malaysian gateways
- Scale from free trials to enterprise-level plans

### Target Users
- 🎓 Students starting their first online business
- 💼 Non-technical entrepreneurs
- 🚀 Startups needing quick market entry
- 🏢 SMEs looking for affordable e-commerce solutions

---

## ✨ Key Features

### For Platform Administrators
- **Super Admin Dashboard** - Complete system control and configuration
- **Admin Management** - Role-based access control with granular permissions
- **Subscription Management** - Flexible plan creation and pricing
- **Analytics** - Geographical tracking and user demographics
- **Multi-Language** - English, Malay, Indonesian, Mandarin, Hindi

### For Sellers (Subscribers)
- **Subdomain & Custom Domains** - Branded online presence
- **Landing Page Builder** - Drag-and-drop website creation
- **E-commerce Store** - Product catalog with inventory management
- **Order Management** - Track orders from new to completed
- **Payment Integration** - Toyyibpay, Billplz, Chip-In, PayPal, SenangPay
- **Email/Telegram Notifications** - Real-time order alerts
- **Custom Branding** - Logo, colors, and theme customization

### For Buyers
- **Guest Checkout** - No registration required
- **Order Tracking** - Track purchases by order number
- **Registered Accounts** - Order history and profile management
- **Email Notifications** - Order confirmations and updates

---

## 🛠️ Technology Stack

### Backend
- **Framework**: Laravel 11.x
- **Database**: MySQL/MariaDB
- **Multi-Tenancy**: Stancl Tenancy
- **Authentication**: Spatie Laravel Permission
- **Activity Logging**: Spatie Activity Log
- **Image Processing**: Intervention Image

### Frontend (Planned)
- **UI Framework**: Vue.js / Tailwind CSS
- **Page Builder**: GrapesJS
- **Charts**: Chart.js
- **Notifications**: Vue Toastification

### Hosting
- **Development**: Herd (Local Windows)
- **Production**: StackCP.com (Unlimited Storage)

---

## 📦 Installation

### Prerequisites
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js & NPM

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd kedai
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database** (Edit `.env`)
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=kedai
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

6. **Start development server**
   ```bash
   php artisan serve
   # or use Herd for local development
   ```

---

## 🗄️ Database Setup

The platform uses **11 custom tables** plus **6 Spatie Permission tables**:

### Core Tables
- `system_settings` - System-wide configuration
- `tenants` - Seller/company information
- `tenant_settings` - Per-tenant customization
- `subscription_plans` - Plan definitions (6 plans seeded)
- `plan_features` - Flexible feature management
- `products` - Product catalog
- `orders` - Order management
- `order_items` - Order line items
- `payments` - Payment transactions
- `pages` - Landing page builder
- `users` - All user types (modified)

**See**: [Database Schema Documentation](Documentation/DATABASE_SCHEMA.md)

---

## 🔐 Default Credentials

### Super Admin
```
Email: superadmin@kedai.test
Password: password
```

### Roles & Permissions
- **SuperAdmin**: Full system access (all 8 permissions)
- **Admin**: Limited management (manage-sellers, view-analytics)
- **Seller**: Store management (manage-products, manage-orders, manage-pages)
- **Buyer**: Customer role (no special permissions)

---

## 💰 Subscription Plans

### Website Hosting
| Plan | Price | Features |
|------|-------|----------|
| **Free** | RM 0/month | 1 landing page, subdomain, 1-month trial |
| **Starter** | RM 19/month | 1 landing page, subdomain |
| **Professional** | RM 79/month | Custom domain, 5 emails, no trademark |

### E-commerce Hosting
| Plan | Price | Products | Features |
|------|-------|----------|----------|
| **Launch** | RM 69/month | 2 | Subdomain, 1 email |
| **Grow** | RM 99/month | 5 | Custom domain, 1 email |
| **Scale** | RM 399/month | 20 | Custom domain, 5 emails, priority support |

---

## 📁 Project Structure

```
kedai/
├── app/
│   ├── Http/Controllers/     # Controllers (to be created)
│   ├── Models/                # Eloquent models
│   └── Services/              # Business logic services
├── database/
│   ├── migrations/            # Database migrations (11 tables)
│   └── seeders/               # Data seeders (roles, plans, settings)
├── Documentation/             # Project documentation
│   ├── PRD.md                 # Product Requirements Document
│   ├── IMPLEMENTATION_PLAN.md # Development roadmap
│   ├── DATABASE_SCHEMA.md     # Database documentation
│   ├── TASKS.md               # Task checklist
│   └── WALKTHROUGH.md         # Phase 1 completion summary
├── resources/
│   ├── views/                 # Blade templates (to be created)
│   ├── js/                    # JavaScript/Vue components
│   └── css/                   # Stylesheets
└── routes/
    ├── web.php                # Web routes
    └── tenant.php             # Tenant-specific routes
```

---

## 🚀 Development Roadmap

### ✅ Phase 1: Planning & Architecture (Complete)
- [x] Product Requirements Document
- [x] Database schema design
- [x] Implementation plan
- [x] Project setup

### ✅ Phase 2: Core Infrastructure (Partial - 40%)
- [x] Multi-tenancy setup
- [x] Role-based authentication
- [ ] Dynamic theming system
- [ ] Multi-language support
- [ ] Notification system
- [ ] Math captcha

### 📋 Phase 3: Super Admin Module
- [ ] Dashboard with analytics
- [ ] Admin management (CRUD)
- [ ] System settings interface
- [ ] Subscription plan management
- [ ] Seller management
- [ ] Activity logging

### 📋 Phase 4: Admin Module
- [ ] Limited dashboard
- [ ] Self-management
- [ ] Seller oversight

### 📋 Phase 5: Seller Module
- [ ] Registration flow
- [ ] Dashboard
- [ ] Landing page builder
- [ ] Product management
- [ ] Order management
- [ ] Settings & customization

### 📋 Phase 6: Buyer Module
- [ ] Registration (guest & registered)
- [ ] Order tracking
- [ ] Dashboard for registered users

### 📋 Phase 7: Public Pages
- [ ] System landing page
- [ ] Hybrid login system
- [ ] Registration pages

### 📋 Phase 8: Payment Integration
- [ ] Payment gateway integration
- [ ] Subscription billing
- [ ] Payment history

### 📋 Phase 9: Testing & Deployment
- [ ] Unit & integration tests
- [ ] User acceptance testing
- [ ] StackCP deployment

**Estimated Timeline**: 16 weeks for MVP

---

## 📚 Documentation

Comprehensive documentation is available in the `Documentation/` folder:

- **[PRD.md](Documentation/PRD.md)** - Complete product requirements
- **[IMPLEMENTATION_PLAN.md](Documentation/IMPLEMENTATION_PLAN.md)** - Detailed development plan
- **[DATABASE_SCHEMA.md](Documentation/DATABASE_SCHEMA.md)** - Database structure
- **[TASKS.md](Documentation/TASKS.md)** - Development task checklist
- **[WALKTHROUGH.md](Documentation/WALKTHROUGH.md)** - Phase 1 completion summary

---

## 🎨 Branding

### Default Theme
- **Primary Color**: Navy Blue (#1e3a8a)
- **Secondary Color**: Light Blue (#3b82f6)
- **Tertiary Color**: Lighter Blue (#60a5fa)

### Customization
- Super Admin can change system-wide branding
- Sellers can customize their own dashboard colors
- Logo and favicon upload support

---

## 🌍 Multi-Language Support

Supported languages:
- 🇬🇧 English (en)
- 🇲🇾 Malaysian (ms)
- 🇮🇩 Indonesian (id)
- 🇨🇳 Mandarin (zh)
- 🇮🇳 Hindi (hi)

Language switcher available on all pages.

---

## 🔒 Security Features

- **Password Hashing**: Bcrypt encryption
- **Role-Based Access Control**: Spatie Permission package
- **Math Captcha**: Login/registration protection
- **CSRF Protection**: Laravel built-in
- **SQL Injection Prevention**: Eloquent ORM
- **XSS Protection**: Blade templating

---

## 🤝 Contributing

This is a private project currently in active development. Contribution guidelines will be added once the MVP is complete.

---

## 📄 License

This project is proprietary software. All rights reserved.

---

## 📞 Support

For questions or issues:
- Check the [Documentation](Documentation/) folder
- Review the [Implementation Plan](Documentation/IMPLEMENTATION_PLAN.md)
- Contact the development team

---

## 🎯 Current Status

**Phase**: 1 Complete, 2 In Progress (40%)  
**Last Updated**: November 26, 2025  
**Version**: 0.1.0 (Alpha)

---

**Built with ❤️ for entrepreneurs who want to start their online business journey.**
