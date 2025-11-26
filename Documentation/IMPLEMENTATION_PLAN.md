# Implementation Plan: Kedai SaaS E-commerce Platform

## Overview

This plan outlines the step-by-step implementation of the Kedai SaaS e-commerce platform - a multi-tenant system that enables users to create landing pages and e-commerce stores with tiered subscription plans.

## User Review Required

> [!IMPORTANT]
> **Multi-Tenancy Approach Decision Required**
> 
> We need to decide on the multi-tenancy architecture:
> 
> **Option 1: Single Database with Tenant Scoping** (Recommended for MVP)
> - Pros: Simpler setup, easier maintenance, cost-effective
> - Cons: Less isolation, potential data leakage if not careful
> - Best for: Starting out with limited tenants
> 
> **Option 2: Multi-Database (Separate DB per tenant)**
> - Pros: Complete data isolation, better security
> - Cons: More complex, higher resource usage
> - Best for: Enterprise-level with many tenants
> 
> **Recommendation**: Start with Option 1 (Single Database) using Laravel's tenant scoping. We can migrate to multi-database later if needed.

> [!WARNING]
> **Breaking Changes**
> 
> This is a fresh installation. The following decisions will affect future scalability:
> 1. **Subdomain routing**: Requires wildcard DNS configuration (e.g., `*.kedai.test`)
> 2. **Custom domains**: Requires SSL certificate management (Let's Encrypt)
> 3. **File storage**: Using local storage initially, should migrate to S3/StackCP storage for production

> [!CAUTION]
> **Security Considerations**
> 
> - Math captcha is basic security; consider adding rate limiting
> - Payment gateway credentials must be stored encrypted
> - Activity logs will grow large; plan for archiving strategy
> - Multi-language inputs need XSS protection

---

## Proposed Changes

### Phase 1: Project Foundation

#### [NEW] Laravel Installation & Configuration

**Files to create:**
- `.env` - Environment configuration
- `config/tenancy.php` - Multi-tenancy configuration
- `config/app.php` - App configuration (will be modified)

**Packages to install:**
```bash
composer create-project laravel/laravel .
composer require stancl/tenancy
composer require spatie/laravel-permission
composer require spatie/laravel-activitylog
composer require spatie/laravel-translatable
composer require intervention/image
composer require laravel/cashier
```

**Actions:**
1. Install Laravel in the current directory
2. Configure `.env` for local Herd environment
3. Set up database connection (MySQL/MariaDB)
4. Install required packages

---

### Phase 2: Database Schema Design

#### [NEW] Migration Files

All migrations will be created in `database/migrations/`:

**Core System Tables:**
- `create_system_settings_table.php` - System-wide settings (name, logo, colors)
- `create_roles_and_permissions_tables.php` - Spatie permission tables (auto-created)
- `create_activity_log_table.php` - Spatie activity log (auto-created)
- `create_translations_table.php` - Multi-language translations

**User & Tenant Tables:**
- `create_users_table.php` - All users (polymorphic)
- `create_tenants_table.php` - Seller/company tenants
- `create_tenant_settings_table.php` - Per-tenant settings
- `create_user_profiles_table.php` - Extended user information

**Subscription Tables:**
- `create_subscription_plans_table.php` - Plan definitions
- `create_plan_features_table.php` - Features per plan
- `create_subscriptions_table.php` - User subscriptions
- `create_payments_table.php` - Payment history

**E-commerce Tables:**
- `create_products_table.php` - Product catalog
- `create_product_images_table.php` - Product images
- `create_orders_table.php` - Order headers
- `create_order_items_table.php` - Order line items
- `create_order_statuses_table.php` - Status tracking

**Page Builder Tables:**
- `create_pages_table.php` - Landing pages
- `create_page_sections_table.php` - Page sections/blocks
- `create_page_templates_table.php` - Reusable templates

**Analytics Tables:**
- `create_visitor_logs_table.php` - Visitor tracking
- `create_analytics_events_table.php` - Custom events

---

### Phase 3: Multi-Tenancy Setup

#### [MODIFY] [config/tenancy.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/config/tenancy.php)

Configure tenant identification:
- Subdomain-based routing
- Custom domain support
- Tenant model configuration

#### [NEW] [app/Models/Tenant.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Models/Tenant.php)

Tenant model with:
- Subdomain validation
- Custom domain support
- Relationship to users, products, orders
- Settings accessor

#### [NEW] [app/Http/Middleware/InitializeTenancy.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Middleware/InitializeTenancy.php)

Middleware to:
- Identify current tenant from subdomain/domain
- Set tenant context for queries
- Handle tenant-not-found scenarios

---

### Phase 4: Authentication & Authorization

#### [NEW] [app/Models/User.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Models/User.php)

Enhanced user model:
- Spatie roles/permissions integration
- Polymorphic relationships (SuperAdmin, Admin, Seller, Buyer)
- Activity logging
- Multi-language preference

#### [NEW] [app/Http/Controllers/Auth/LoginController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/Auth/LoginController.php)

Hybrid login:
- Math captcha validation
- Role-based redirection
- Activity logging

#### [NEW] [app/Http/Controllers/Auth/SellerRegisterController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/Auth/SellerRegisterController.php)

Seller registration:
- Tenant creation
- Subdomain validation (uniqueness)
- Default subscription assignment
- Welcome email

#### [NEW] [app/Http/Controllers/Auth/BuyerRegisterController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/Auth/BuyerRegisterController.php)

Buyer registration:
- Simple registration flow
- Email verification

#### [NEW] [app/Services/CaptchaService.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Services/CaptchaService.php)

Math captcha generation and validation

---

### Phase 5: Dynamic Theming System

#### [NEW] [app/Models/SystemSetting.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Models/SystemSetting.php)

System-wide settings:
- System name
- Logo, favicon paths
- Color scheme (main, secondary, tertiary)
- Default language

#### [NEW] [app/Models/TenantSetting.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Models/TenantSetting.php)

Per-tenant settings:
- Custom colors (override system)
- Logo, favicon
- Company details

#### [NEW] [app/View/Composers/ThemeComposer.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/View/Composers/ThemeComposer.php)

View composer to inject theme variables into all views

#### [NEW] [resources/css/app.css](file:///c:/Users/user/Documents/Project/Laravel/kedai/resources/css/app.css)

CSS with custom properties:
```css
:root {
    --color-primary: /* from settings */;
    --color-secondary: /* from settings */;
    --color-tertiary: /* from settings */;
}
```

---

### Phase 6: Multi-Language Support

#### [NEW] [app/Http/Middleware/SetLocale.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Middleware/SetLocale.php)

Language detection:
- User preference
- Session storage
- Fallback to default

#### [NEW] Language Files

- `lang/en/` - English
- `lang/ms/` - Malaysian
- `lang/id/` - Indonesian
- `lang/zh/` - Mandarin
- `lang/hi/` - Hindi

Each with subdirectories:
- `auth.php` - Authentication messages
- `dashboard.php` - Dashboard labels
- `validation.php` - Validation messages

---

### Phase 7: Super Admin Module

#### [NEW] [app/Http/Controllers/SuperAdmin/DashboardController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/SuperAdmin/DashboardController.php)

Dashboard with analytics overview

#### [NEW] [app/Http/Controllers/SuperAdmin/AdminController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/SuperAdmin/AdminController.php)

Admin CRUD:
- List with pagination
- Create with role assignment
- Edit (name, email, password, roles)
- Delete with confirmation
- Activity log view

#### [NEW] [app/Http/Controllers/SuperAdmin/SystemSettingController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/SuperAdmin/SystemSettingController.php)

System settings management:
- General settings (name, logo, colors)
- Payment gateway configuration
- Subscription plan CRUD

#### [NEW] [app/Http/Controllers/SuperAdmin/SubscriptionPlanController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/SuperAdmin/SubscriptionPlanController.php)

Subscription plan management:
- CRUD operations
- Feature checklist
- Sortable plans
- Currency selection

#### [NEW] [app/Http/Controllers/SuperAdmin/SellerController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/SuperAdmin/SellerController.php)

Seller management:
- List with subscription status
- CRUD operations
- Logo gallery
- Payment history

#### [NEW] [app/Http/Controllers/SuperAdmin/AnalyticsController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/SuperAdmin/AnalyticsController.php)

Analytics dashboard:
- Geographical maps
- User demographics
- Revenue charts

#### [NEW] Views in `resources/views/superadmin/`

- `dashboard.blade.php`
- `admins/index.blade.php`
- `admins/create.blade.php`
- `admins/edit.blade.php`
- `settings/general.blade.php`
- `settings/payment.blade.php`
- `subscription-plans/index.blade.php`
- `sellers/index.blade.php`
- `analytics/index.blade.php`

---

### Phase 8: Admin Module

#### [NEW] [app/Http/Controllers/Admin/DashboardController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/Admin/DashboardController.php)

Limited dashboard (no admin creation)

#### [NEW] [app/Http/Controllers/Admin/ProfileController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/Admin/ProfileController.php)

Self-management:
- Edit own profile
- Change password
- Color scheme preference

#### [NEW] Views in `resources/views/admin/`

- `dashboard.blade.php`
- `profile/edit.blade.php`
- `sellers/index.blade.php` (read-only or limited CRUD)
- `analytics/index.blade.php`

---

### Phase 9: Seller Module

#### [NEW] [app/Http/Controllers/Seller/DashboardController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/Seller/DashboardController.php)

Seller dashboard with quick actions

#### [NEW] [app/Http/Controllers/Seller/PageBuilderController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/Seller/PageBuilderController.php)

Landing page builder:
- Drag-and-drop interface (using GrapesJS or similar)
- Template selection
- Save/publish

**Additional package:**
```bash
npm install grapesjs
```

#### [NEW] [app/Http/Controllers/Seller/ProductController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/Seller/ProductController.php)

Product management:
- CRUD with image upload
- Product limit validation (based on plan)
- Stock management

#### [NEW] [app/Http/Controllers/Seller/OrderController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/Seller/OrderController.php)

Order management:
- New orders list
- Status update (New → On-going → Completed)
- Buyer details view

#### [NEW] [app/Http/Controllers/Seller/SettingController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/Seller/SettingController.php)

Seller settings:
- Profile edit
- Company details
- Color scheme
- Payment gateway config

#### [NEW] [app/Http/Controllers/Seller/AnalyticsController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/Seller/AnalyticsController.php)

Seller analytics:
- Buyer demographics
- Visitor tracking

#### [NEW] Views in `resources/views/seller/`

- `dashboard.blade.php`
- `pages/builder.blade.php`
- `products/index.blade.php`
- `products/create.blade.php`
- `products/edit.blade.php`
- `orders/index.blade.php`
- `orders/show.blade.php`
- `settings/general.blade.php`
- `settings/payment.blade.php`
- `analytics/index.blade.php`

---

### Phase 10: Buyer Module

#### [NEW] [app/Http/Controllers/Buyer/DashboardController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/Buyer/DashboardController.php)

Buyer dashboard with order history

#### [NEW] [app/Http/Controllers/Buyer/OrderController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/Buyer/OrderController.php)

Order tracking:
- Order history
- Track order status

#### [NEW] [app/Http/Controllers/Guest/OrderTrackingController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/Guest/OrderTrackingController.php)

Guest order tracking by PO number

#### [NEW] Views in `resources/views/buyer/`

- `dashboard.blade.php`
- `orders/index.blade.php`
- `orders/track.blade.php`

#### [NEW] Views in `resources/views/guest/`

- `track-order.blade.php`

---

### Phase 11: Public Pages

#### [NEW] [app/Http/Controllers/HomeController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/HomeController.php)

Landing page with subscription plans

#### [NEW] [resources/views/welcome.blade.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/resources/views/welcome.blade.php)

System landing page:
- Hero section
- Features
- Pricing cards (dynamic from DB)
- CTA buttons

#### [NEW] [resources/views/auth/login.blade.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/resources/views/auth/login.blade.php)

Login page with math captcha

#### [NEW] [resources/views/auth/seller-register.blade.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/resources/views/auth/seller-register.blade.php)

Seller registration form

#### [NEW] [resources/views/auth/buyer-register.blade.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/resources/views/auth/buyer-register.blade.php)

Buyer registration form

---

### Phase 12: Notification System

#### [NEW] [app/Services/NotificationService.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Services/NotificationService.php)

Centralized notification service:
- Email notifications
- Telegram notifications
- In-app toast notifications

#### [NEW] [app/Notifications/OrderCreatedNotification.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Notifications/OrderCreatedNotification.php)

Email/Telegram notification for new orders

#### [NEW] [resources/js/components/Toast.vue](file:///c:/Users/user/Documents/Project/Laravel/kedai/resources/js/components/Toast.vue)

Toast notification component:
- Success (green tick, white bg, black text)
- Error (red X, white bg, black text)

**Additional packages:**
```bash
composer require laravel/slack-notification-channel
composer require laravel-notification-channels/telegram
npm install vue-toastification
```

---

### Phase 13: Payment Integration

#### [NEW] [app/Services/PaymentGateway/PaymentGatewayInterface.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Services/PaymentGateway/PaymentGatewayInterface.php)

Payment gateway abstraction

#### [NEW] Gateway Implementations

- `app/Services/PaymentGateway/ToyyibpayGateway.php`
- `app/Services/PaymentGateway/BillplzGateway.php`
- `app/Services/PaymentGateway/ChipInGateway.php`
- `app/Services/PaymentGateway/PaypalGateway.php`
- `app/Services/PaymentGateway/SenangPayGateway.php`

#### [NEW] [app/Http/Controllers/PaymentController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/PaymentController.php)

Payment processing:
- Initiate payment
- Callback handling
- Webhook processing

#### [NEW] [app/Http/Controllers/SubscriptionController.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/app/Http/Controllers/SubscriptionController.php)

Subscription management:
- Subscribe to plan
- Upgrade/downgrade
- Cancel subscription

---

### Phase 14: Routing

#### [MODIFY] [routes/web.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/routes/web.php)

Route definitions:
- Public routes (landing, login, register)
- Super admin routes (prefix: `/superadmin`)
- Admin routes (prefix: `/admin`)
- Seller routes (subdomain-based: `{tenant}`)
- Buyer routes (prefix: `/buyer-{id}`)

#### [NEW] [routes/tenant.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/routes/tenant.php)

Tenant-specific routes (for sellers)

---

### Phase 15: Seeders

#### [NEW] [database/seeders/DatabaseSeeder.php](file:///c:/Users/user/Documents/Project/Laravel/kedai/database/seeders/DatabaseSeeder.php)

Master seeder calling:
- `RoleSeeder` - Create roles (SuperAdmin, Admin, Seller, Buyer)
- `SuperAdminSeeder` - Create default super admin
- `SystemSettingSeeder` - Default system settings
- `SubscriptionPlanSeeder` - Default subscription plans

---

### Phase 16: Frontend Assets

#### [MODIFY] [resources/css/app.css](file:///c:/Users/user/Documents/Project/Laravel/kedai/resources/css/app.css)

Tailwind CSS setup with custom theme variables

#### [NEW] [resources/js/app.js](file:///c:/Users/user/Documents/Project/Laravel/kedai/resources/js/app.js)

Vue.js initialization:
- Toast component
- Page builder component
- Language switcher component

#### [NEW] Shared Components in `resources/views/components/`

- `notification.blade.php` - Toast notification
- `language-switcher.blade.php` - Language dropdown
- `sidebar.blade.php` - Dashboard sidebar
- `navbar.blade.php` - Dashboard navbar

---

## Verification Plan

### Automated Tests

Due to the complexity and scope of this project, we'll implement tests incrementally. For the MVP, we'll focus on critical path testing:

#### Unit Tests

**To create:**
```bash
php artisan make:test Unit/CaptchaServiceTest
php artisan make:test Unit/PaymentGatewayTest
php artisan make:test Unit/TenantScopingTest
```

**Run command:**
```bash
php artisan test --filter=Unit
```

#### Feature Tests

**To create:**
```bash
php artisan make:test Feature/Auth/LoginTest
php artisan make:test Feature/Auth/SellerRegistrationTest
php artisan make:test Feature/SuperAdmin/SubscriptionPlanTest
php artisan make:test Feature/Seller/ProductManagementTest
php artisan make:test Feature/Buyer/OrderTrackingTest
```

**Run command:**
```bash
php artisan test --filter=Feature
```

### Manual Verification

#### 1. Initial Setup Verification

**Steps:**
1. Clone/navigate to project directory
2. Run `composer install`
3. Run `npm install && npm run dev`
4. Copy `.env.example` to `.env`
5. Set database credentials in `.env`
6. Run `php artisan key:generate`
7. Run `php artisan migrate --seed`
8. Start Herd or run `php artisan serve`
9. Visit `http://kedai.test` (or configured domain)

**Expected Result:**
- Landing page loads with system name "Kedai"
- Navy blue and light blue color scheme visible
- Subscription plans displayed (6 plans total)
- Language switcher shows 5 languages

---

#### 2. Super Admin Flow

**Steps:**
1. Navigate to `/login`
2. Solve math captcha
3. Login with seeded super admin credentials:
   - Email: `superadmin@kedai.test`
   - Password: `password`
4. Should redirect to `/superadmin/dashboard`
5. Navigate to "System Settings" → "General"
6. Change system name to "MyStore"
7. Upload a logo
8. Change primary color to red (#FF0000)
9. Click "Save"

**Expected Result:**
- Green tick notification appears: "Settings saved successfully"
- System name changes throughout the app
- Logo appears in navbar
- Primary color changes to red across all pages

**Verify:**
- Logout and check landing page reflects new name/logo/color
- Login again to verify persistence

---

#### 3. Subscription Plan Management

**Steps:**
1. Login as super admin
2. Navigate to "System Settings" → "Subscription Plans"
3. Click "Create New Plan"
4. Fill in:
   - Name: "Custom Plan"
   - Price: 150
   - Currency: RM
   - Features: Check "Landing Page", "Custom Domain", "10 Products"
5. Click "Save"
6. Use arrow buttons to reorder plans
7. Edit the plan and change price to 199
8. Delete the plan

**Expected Result:**
- Each action shows appropriate success notification
- Plan appears on landing page immediately after creation
- Reordering updates the display order
- Deletion removes from landing page

---

#### 4. Seller Registration & Tenant Creation

**Steps:**
1. Logout from super admin
2. Navigate to `/seller/register`
3. Fill in form:
   - Company Name: "Test Shop"
   - Site Name: "testshop" (becomes subdomain)
   - Owner Name: "John Doe"
   - Email: `john@testshop.com`
   - Password: `password123`
   - Solve math captcha
4. Submit form
5. Should redirect to `testshop.kedai.test/dashboard`

**Expected Result:**
- Success notification: "Registration successful"
- Subdomain created automatically
- Default "Free" plan assigned
- Welcome email sent (check logs if mail not configured)

**Verify:**
- Visit `testshop.kedai.test` - should show seller's landing page
- Check super admin panel - "Test Shop" appears in seller list

---

#### 5. Product Management (Seller)

**Steps:**
1. Login as seller (john@testshop.com)
2. Navigate to "Store" → "Products"
3. Click "Add Product"
4. Fill in:
   - Name: "Test Product"
   - Price: 99.99
   - Description: "Test description"
   - Upload image
5. Save product
6. Try to add 3rd product (should fail on Free plan - limit 2)

**Expected Result:**
- Product created successfully
- Product appears on storefront at `testshop.kedai.test/store`
- 3rd product shows error: "Product limit reached for your plan"

---

#### 6. Order Flow (Buyer → Seller)

**Steps:**
1. Open incognito window
2. Visit `testshop.kedai.test/store`
3. Add "Test Product" to cart
4. Proceed to checkout
5. Fill in buyer details (or register as buyer)
6. Complete order (payment can be mocked for testing)

**Expected Result:**
- Order created successfully
- Seller receives email notification
- Order appears in seller dashboard under "New Orders"
- Buyer receives order confirmation email
- Guest can track order using PO number

**Verify:**
1. Login as seller
2. Navigate to "Orders" → "New Orders"
3. Click on order to view details
4. Change status to "On-going"
5. Verify order moves to "On-going Orders" tab

---

#### 7. Multi-Language Switching

**Steps:**
1. On landing page, click language switcher
2. Select "Bahasa Malaysia"
3. Verify all text changes to Malay
4. Login as any user
5. Language preference should persist

**Expected Result:**
- All UI text translates correctly
- User preference saved in session/database
- Dashboard reflects selected language

---

#### 8. Analytics Verification

**Steps:**
1. Login as super admin
2. Navigate to "Analytics"
3. Verify geographical map shows seller locations
4. Login as seller
5. Navigate to seller analytics
6. Verify visitor demographics displayed

**Expected Result:**
- Maps render correctly (using Chart.js or similar)
- Data reflects actual visitors/orders

---

#### 9. Payment Gateway Integration

**Steps:**
1. Login as super admin
2. Navigate to "System Settings" → "Payment Integration"
3. Select "Toyyibpay"
4. Enter test API credentials
5. Save settings
6. Login as seller
7. Navigate to "Settings" → "Payment Integration"
8. Enable Toyyibpay
9. Create test order and process payment

**Expected Result:**
- Payment redirects to Toyyibpay sandbox
- Callback updates order status
- Payment recorded in payment history

---

#### 10. Responsive Design Check

**Steps:**
1. Open landing page
2. Resize browser to mobile width (375px)
3. Verify layout adapts
4. Test on actual mobile device if possible

**Expected Result:**
- All pages responsive
- Navigation collapses to hamburger menu
- Forms remain usable
- No horizontal scrolling

---

### Browser Testing

We'll use the browser automation tool to verify critical user flows:

**Test 1: Complete Seller Onboarding**
- Navigate to landing page
- Click "Get Started"
- Fill registration form
- Verify dashboard loads
- Create first product

**Test 2: Guest Order Tracking**
- Place order as guest
- Receive email with tracking link
- Click link and verify order status

**Test 3: Theme Customization**
- Login as super admin
- Change colors
- Verify changes reflect across all pages

---

### Performance Testing

**Manual checks:**
1. Page load time < 2 seconds (use browser DevTools)
2. Database queries optimized (use Laravel Debugbar)
3. Image optimization (compress uploads)

---

### Security Testing

**Manual checks:**
1. SQL injection attempts on forms
2. XSS attempts in multi-language inputs
3. CSRF token validation
4. Role-based access control (try accessing super admin routes as seller)

---

## Post-Implementation Checklist

- [ ] All migrations run successfully
- [ ] Seeders populate default data
- [ ] Super admin can login and manage system
- [ ] Seller can register and create tenant
- [ ] Products can be created within plan limits
- [ ] Orders flow from buyer to seller
- [ ] Notifications sent (email/Telegram)
- [ ] Multi-language works across all pages
- [ ] Theme customization applies globally
- [ ] Payment gateway processes test transactions
- [ ] Analytics display data correctly
- [ ] Responsive design verified on mobile
- [ ] All user roles have correct permissions

---

## Notes

- **Development Timeline**: Estimated 16 weeks for full MVP
- **Priority**: Focus on core flows first (auth, tenancy, products, orders)
- **Testing**: Manual testing initially, add automated tests incrementally
- **Documentation**: Update as features are implemented
- **Deployment**: Test on StackCP staging before production

---

## Questions for User

1. **Drag-and-Drop Page Builder**: Should we use GrapesJS, or do you have a preference for another library (e.g., Craft.js, Builder.io)?

2. **Email Service**: Which email provider should we use? (Mailgun, SendGrid, AWS SES, or local SMTP for testing?)

3. **Telegram Notifications**: Do you have a Telegram Bot Token, or should we create one during implementation?

4. **Payment Gateway Priority**: Which payment gateway should we integrate first? (Toyyibpay seems most relevant for Malaysian market)

5. **Analytics**: Should we use a third-party service (Google Analytics, Mixpanel) or build custom analytics?

6. **File Storage**: For production, should we use StackCP's storage or integrate S3/DigitalOcean Spaces?

7. **Domain Configuration**: Do you already have a domain for testing (e.g., `kedai.test`), or should we set one up?

8. **Initial Super Admin**: What email/password should we use for the seeded super admin account?
