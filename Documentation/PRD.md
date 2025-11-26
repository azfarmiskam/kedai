# Product Requirements Document: Kedai SaaS E-commerce Platform

## 1. Executive Summary

**Kedai** is a multi-tenant SaaS platform that enables students, non-tech individuals, startups, and SMEs to create and manage their own e-commerce stores and landing pages. The platform offers tiered subscription plans with varying features, from simple landing pages to full-featured e-commerce stores.

### Key Differentiators
- **Simplicity-first**: Designed for non-technical users
- **Multi-tenant architecture**: Each seller gets their own branded space
- **Flexible pricing**: From free trials to enterprise-level plans
- **Localized**: Multi-language support for Southeast Asian markets
- **Integrated payments**: Malaysian payment gateways built-in

---

## 2. System Overview

### 2.1 Technical Stack
- **Framework**: Laravel (backend)
- **Future Integration**: Vue.js, Tailwind CSS, Next.js
- **Current Hosting**: Local (Herd on Windows)
- **Production Hosting**: StackCP.com (unlimited storage)
- **Database**: MariaDB

### 2.2 System Branding
- **Default Name**: Kedai (configurable via Super Admin)
- **Color Scheme**: Navy Blue & Light Blue (configurable)
- **Customization**: Logo, favicon, colors can be changed in settings

### 2.3 Multi-Language Support
- English
- Malaysian (Bahasa Malaysia)
- Indonesian (Bahasa Indonesia)
- Mandarin (中文)
- Indian (हिन्दी/Tamil)

**Default**: User's selection from homepage

---

## 3. User Roles & Permissions

### 3.1 Role Hierarchy
```
Super Admin (Full System Control)
    ├── Admin (Limited System Management)
    ├── Seller/Subscriber (Store Owner)
    └── Buyer (Registered/Guest)
```

### 3.2 Access Paths
- **Super Admin**: `/superadmin/dashboard`
- **Admin**: `/admin/dashboard`
- **Seller**: `/{company-name}/dashboard`
- **Buyer (Registered)**: `/buyer-{ID}/dashboard`
- **Login**: `/login` (hybrid - redirects based on role)
- **Seller Registration**: `/seller/register`
- **Buyer Registration**: `/buyer/register`

---

## 4. Feature Requirements by Role

## 4.1 Super Admin Features

### Dashboard (`/superadmin/dashboard`)

#### Admin Management
- **List of Admins**
  - View all admins with status
  - CRUD operations
  - Role and permission assignment
  - Activity log tracking

#### System Settings

**General Settings**:
- System Name (affects all displays - no hardcoding)
- Site Description
- Logo upload/edit
- Favicon upload/edit
- Color scheme customization (affects entire system)

**Super Admin Management**:
- List of super admins with CRUD
- Super admin activity log

**Payment Integration**:
- Selectable gateways:
  - Toyyibpay
  - Billplz
  - Chip-In
  - PayPal
  - SenangPay

**Subscription Card Management**:
- Create/edit subscription plans
- Component checklist for each plan
- Sortable plans (drag/arrow controls)
- Currency selection: RM (default), USD, SGD, Rp

#### Seller Management
- List of subscribers with CRUD
- Subscription plan status
- Subscriber logo gallery
- Client information database
- Payment history (seller & buyer transactions)

#### Analytics
- Geographical location mapping (sellers)
- Geographical location mapping (clients/buyers)

### Notifications
- **Success**: Green tick icon, black text, white background
- **Error**: Red X icon, black text, white background

---

## 4.2 Admin Features

### Dashboard (`/admin/dashboard`)

#### Admin Management
- **Self-Management Only**:
  - Edit own name, email, password
  - View roles and permissions
  - **Cannot add new admins**
  - Activity log

#### System Settings
- **General**: Color scheme (affects own dashboard only)

#### Seller Management
- List of subscribers with CRUD
- Subscription plan status
- Subscriber logo gallery
- Client information
- Payment history

#### Analytics
- Geographical location (sellers & clients)

### Notifications
- Same as Super Admin

---

## 4.3 Seller/Subscriber Features

### Dashboard (`/{company-name}/dashboard`)

#### Registration Flow
- Register from system homepage
- Subdomain assigned based on company name

#### Dashboard Overview
- Graphs and analytics
- Quick actions

#### Website Management

**Landing Page**:
- Drag-and-drop website builder (like Vercel)
- Visual editor for non-technical users

**Store** (E-commerce plans only):
- Product management
- Product quantity limits based on subscription plan
- Product display on storefront

#### Order Management (E-commerce plans)
- **New Orders**:
  - Buyer details
  - Status tracking (editable)
- **On-going Orders**:
  - Status updates
- **Completed Orders**:
  - Order history

#### Settings

**General**:
- Login email/password
- Color scheme (affects own dashboard only)
- Logo and favicon
- Company details:
  - Address
  - Phone number
  - Registration ID (optional)
  - Other business info

**Payment Integration** (E-commerce plans):
- Configure payment gateways

#### Analytics
- Buyer demographics
- Visitor demographics

#### Notifications
- Email notifications for new orders
- Telegram notifications for new orders
- Same success/error UI notifications

---

## 4.4 Buyer Features

### Registered Buyer (`/buyer-{ID}/dashboard`)

**Registration**: From seller's website

**Features**:
- Order history view
- Order tracking
- Email notifications

### Guest/Unregistered Buyer

**Features**:
- Email notifications
- Order tracking page (by PO number)
- Track order link in email

---

## 5. Subscription Plans

### 5.1 Website Hosting Plans

#### Free (1-month trial)
- 1 landing page
- Subdomain included
- **Price**: Free

#### Starter
- 1 landing page
- Subdomain included
- **Price**: RM 19/month

#### Professional
- 1 landing page
- Custom domain support
- Remove system trademark
- 5 email accounts under custom domain
- **Price**: RM 79/month

### 5.2 E-commerce Hosting Plans

#### Launch
- 1 landing page
- 1 dashboard
- 1 subdomain
- 1 email (subdomain)
- **2 products** on store
- **Price**: RM 69/month

#### Grow
- 1 landing page
- 1 dashboard
- Custom domain support
- 1 email (custom domain)
- **5 products** on store
- **Price**: RM 99/month

#### Scale
- 1 landing page
- 1 dashboard
- Custom domain support
- 5 email accounts (custom domain)
- **20 products** on store
- Priority support
- **Price**: RM 399/month

> **Note**: All plans are editable by Super Admin in dashboard

---

## 6. Authentication & Security

### 6.1 Login System (`/login`)
- **Hybrid Login**: Redirects to appropriate dashboard based on role
- **Math Captcha**: Required for all logins

### 6.2 Seller Registration (`/seller/register`)

**Form Fields**:
- Company logo (upload)
- Company name
- Company registration ID (optional)
- Company address
- Company phone number
- Site name (becomes subdomain - **cannot be changed later**)
- Company industry (dropdown)
- Owner name
- Login email
- Login password
- Math captcha

### 6.3 Buyer Registration (`/buyer/register`)

**Form Fields**:
- Full name
- Login email
- Password
- Math captcha

---

## 7. System Landing Page

### Design Requirements
- **Aesthetic**: Minimalist, modern, professional
- **Color Scheme**: Uses system colors from Super Admin settings
- **Responsive**: Mobile-friendly design

### Content Sections
1. **Hero Section**: Value proposition
2. **Features Overview**: Key platform benefits
3. **Subscription Plans**: Interactive pricing cards
4. **Testimonials** (optional)
5. **CTA**: Sign up buttons
6. **Footer**: Links, contact, social media

---

## 8. Technical Requirements

### 8.1 Multi-Tenancy
- Subdomain-based tenant identification
- Custom domain support (Professional/Scale plans)
- Isolated data per tenant
- Shared infrastructure

### 8.2 Database Schema (High-Level)

**Core Tables**:
- `users` (polymorphic - all user types)
- `roles` & `permissions`
- `tenants` (sellers/companies)
- `subscriptions` & `subscription_plans`
- `products`
- `orders` & `order_items`
- `payments`
- `activity_logs`
- `system_settings`
- `translations`

### 8.3 Notification System
- **Email**: Transactional emails (orders, registrations)
- **Telegram**: Order notifications for sellers
- **In-App**: Toast notifications (success/error)

### 8.4 Payment Integration
- Gateway abstraction layer
- Support for multiple providers
- Webhook handling
- Payment history tracking
- Subscription billing automation

### 8.5 Analytics
- Geographical tracking (IP-based)
- User demographics
- Sales metrics
- Visitor analytics

---

## 9. UI/UX Requirements

### 9.1 Design System
- **Colors**: Configurable (default: Navy Blue & Light Blue)
- **Typography**: Clean, readable fonts
- **Icons**: Consistent icon set
- **Spacing**: Consistent padding/margins

### 9.2 Notification Design
- **Success**:
  - Green tick icon ✓
  - Black text
  - White background
  - Auto-dismiss after 3-5 seconds

- **Error**:
  - Red X icon ✗
  - Black text
  - White background
  - Manual dismiss or auto-dismiss after 5-7 seconds

### 9.3 Responsive Design
- Mobile-first approach
- Tablet optimization
- Desktop experience

---

## 10. Development Phases

### Phase 1: Foundation (Weeks 1-2)
- Laravel setup with multi-tenancy
- Database schema design
- Authentication system
- Role-based access control

### Phase 2: Super Admin Module (Weeks 3-4)
- Dashboard
- Admin management
- System settings
- Subscription plan management

### Phase 3: Admin Module (Week 5)
- Dashboard
- Limited management features

### Phase 4: Seller Module (Weeks 6-8)
- Registration flow
- Dashboard
- Landing page builder
- Product management
- Order management

### Phase 5: Buyer Module (Week 9)
- Registration
- Dashboard
- Order tracking

### Phase 6: Public Pages (Week 10)
- Landing page
- Login/registration pages

### Phase 7: Payment & Notifications (Weeks 11-12)
- Payment gateway integration
- Email/Telegram notifications
- Subscription billing

### Phase 8: Analytics & Polish (Weeks 13-14)
- Analytics dashboards
- UI/UX refinements
- Performance optimization

### Phase 9: Testing & Deployment (Weeks 15-16)
- Testing
- Bug fixes
- StackCP deployment
- Documentation

---

## 11. Success Metrics

### User Acquisition
- Number of registered sellers
- Conversion rate (free → paid plans)
- User retention rate

### Platform Performance
- Page load times < 2 seconds
- 99.9% uptime
- Zero critical security vulnerabilities

### Business Metrics
- Monthly recurring revenue (MRR)
- Average revenue per user (ARPU)
- Customer lifetime value (CLV)

---

## 12. Future Enhancements

### Phase 2 Features (Post-MVP)
- Mobile app (React Native/Flutter)
- Advanced analytics (AI-powered insights)
- Marketing automation
- Inventory management
- Multi-warehouse support
- Affiliate/dropship system (inspired by OnPay.my)
- Event booking system
- SMS/WhatsApp notifications
- Advanced SEO tools
- Social media integration

### Integrations
- Accounting software (Xero, QuickBooks)
- Shipping providers (Pos Laju, J&T, DHL)
- CRM systems
- Marketing platforms (Mailchimp, SendGrid)

---

## 13. Constraints & Assumptions

### Constraints
- Initial development: Solo/small team
- Budget: Bootstrap/minimal external funding
- Timeline: 16 weeks for MVP

### Assumptions
- Users have basic internet literacy
- Sellers will provide their own product content
- Payment gateways are accessible in target markets
- StackCP hosting meets performance requirements

---

## 14. Risks & Mitigation

| Risk | Impact | Mitigation |
|------|--------|------------|
| Payment gateway integration issues | High | Start integration early, have fallback options |
| Multi-tenancy performance | High | Load testing, caching strategy, CDN |
| User adoption | Medium | Marketing plan, referral program, free tier |
| Security vulnerabilities | High | Regular audits, penetration testing, updates |
| Scope creep | Medium | Strict MVP definition, phased approach |

---

## 15. Appendix

### A. Glossary
- **Tenant**: A seller/company using the platform
- **PO Number**: Purchase Order number for tracking
- **CRUD**: Create, Read, Update, Delete operations
- **MRR**: Monthly Recurring Revenue

### B. References
- OnPay.my (inspiration for features)
- Bagisto.com (e-commerce platform reference)
- Laravel Multi-tenancy packages
- StackCP documentation

---

**Document Version**: 1.0  
**Last Updated**: 2025-11-26  
**Author**: Product Team  
**Status**: Draft - Pending Approval
