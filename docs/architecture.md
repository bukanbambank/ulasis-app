---
stepsCompleted: [1, 2, 3, 4]
inputDocuments:
  - "docs/prd.md"
workflowType: 'architecture'
lastStep: 4
project_name: 'Ulasis 2.0'
user_name: 'Lio'
date: '2025-12-05'
---

# Architecture Decision Document

_This document builds collaboratively through step-by-step discovery. Sections are appended as we work through each architectural decision together._

## Project Context Analysis

### Requirements Overview

**Functional Requirements:**

Ulasis 2.0 memiliki 10 kelompok functional requirements yang mencakup complete lifecycle dari SaaS feedback platform:

1. **Authentication & Account Management (FR-1)** - Email/Gmail OAuth registration, email verification, password management, profile updates. Mendukung both convenience (OAuth) dan traditional authentication.

2. **Angket Management (FR-2)** - 3 pre-built restaurant templates (Casual Dining, Café, Fast Food) dengan CRUD operations, multiple question types (rating scales, binary, text feedback), preview functionality, dan customization capabilities.

3. **QR Code Management (FR-3)** - Generate unique QR codes dengan customization (logo, naming/labeling), multiple QR per restaurant, download high-resolution, dan activation/deactivation controls. QR codes adalah first-class citizens dalam arsitektur.

4. **Customer-Facing Feedback Form (FR-4)** - Mobile-optimized responsive form dengan visual rating system, sequential/single-page display, progress indicators, dan target completion < 60 seconds. Critical untuk adoption success.

5. **Dashboard - Overview & Analytics (FR-5)** - Real-time dashboard dengan sentiment visualization, total feedback count, trend indicators, alert notifications untuk negative ratings, dan time-based filtering (jam/hari/minggu/bulan/tahun).

6. **Inbox - Feedback Management (FR-6)** - Complete feedback management system dengan status workflow (Baru → Dalam Proses → Selesai), filtering capabilities (status/date/QR source/rating level), alert system, dan detail views.

7. **Analytics Dashboard (FR-7)** - Rule-based sentiment analysis (1-2=Negatif, 3=Netral, 4-5=Positif), QR performance comparison, time-series trend analysis, peak hours identification, dan category breakdown. Analytics yang actionable untuk restaurant operations.

8. **Report Export (FR-8)** - Excel dan CSV export dengan custom date ranges, comprehensive data inclusion (ratings, text, timestamps, QR attribution, status), proper formatting.

9. **Settings & Support (FR-9)** - Profile/logo management, account updates, password change, support ticket submission dengan status tracking.

10. **Admin Dashboard (FR-10)** - Platform management dengan user administration, support ticket management, database monitoring, platform health metrics, error logs, dan audit trails.

**Architectural Implications:**
- Multi-tenant architecture dengan strict data isolation
- Real-time updates requirement untuk dashboard/inbox
- Mobile-first responsive design critical path
- QR-native architecture dengan location attribution
- Rule-based analytics engine (cost-efficient vs AI/ML)
- Export/reporting background job processing
- Email service integration untuk notifications
- Admin elevated permissions dengan audit logging

**Non-Functional Requirements:**

**Performance (NFR-1):**
- Dashboard load < 3 seconds under normal conditions
- Feedback form load < 2 seconds after QR scan
- API response < 500ms for 95th percentile
- Database queries < 200ms for standard operations
- Analytics calculations < 5 seconds untuk 12-month dataset
- Support 100+ concurrent feedback submissions
- Handle 1000+ concurrent dashboard viewers
- Process 10,000+ feedback responses per day
- **Architecture Impact:** Requires caching strategy, query optimization, horizontal scaling capability, efficient time-series data storage

**Reliability & Availability (NFR-2):**
- 99.9% uptime (max 43 minutes downtime/month)
- Automated daily backups dengan 30-day retention
- Zero data loss tolerance dengan transaction rollback
- Graceful error handling dengan user-friendly messages
- Fault tolerance dengan degraded functionality fallback
- **Architecture Impact:** Redundancy requirements, backup strategy, error handling framework, monitoring/alerting system

**Security (NFR-3):**
- Multi-tenant data isolation (critical - legal liability risk)
- Encryption at rest dan in transit (TLS 1.3)
- Secure password hashing (bcrypt/argon2)
- CSRF protection, XSS prevention, SQL injection prevention
- RBAC dengan admin elevated permissions
- Session management dengan timeout dan invalidation
- Rate limiting untuk abuse prevention
- **Architecture Impact:** Security middleware layers, tenant context enforcement, input validation framework, secure session storage

**Usability (NFR-4):**
- Intuitive untuk non-tech-savvy users
- Mobile-first responsive design
- Bahasa Indonesia interface
- 5-minute onboarding target
- Touch targets minimum 44x44 pixels
- WCAG 2.1 Level A compliance
- **Architecture Impact:** Component library design, localization strategy, accessibility patterns

**Maintainability (NFR-5):**
- Modular dan loosely coupled code
- 70%+ test coverage minimum
- Comprehensive documentation
- CI/CD pipeline dengan automated deployment
- Zero-downtime deployments
- Infrastructure as code (IaC)
- **Architecture Impact:** Service boundaries, testing strategy, deployment architecture

**Compatibility (NFR-6):**
- Modern browsers (Chrome, Firefox, Safari, Edge - latest 2 versions)
- Mobile browsers (Chrome Mobile, Safari Mobile)
- Minimum screen width 320px support
- Work pada 3G network speeds
- No app installation required
- **Architecture Impact:** Progressive enhancement, offline indicators, responsive breakpoints

**Localization (NFR-7):**
- Bahasa Indonesia untuk all UI
- Indonesian date format (DD/MM/YYYY)
- Indonesian currency format (Rp)
- Cultural considerations untuk rating scales
- **Architecture Impact:** i18n/l10n framework, date/currency formatting utilities

### Scale & Complexity Assessment

**Primary Domain:** Full-Stack Web Application (Mobile-First SaaS B2B)

**Complexity Level:** Medium-to-High

**Reasoning:**
- Medium business logic complexity (restaurant feedback domain)
- High technical complexity (multi-tenancy, real-time updates, analytics)
- Moderate data complexity (relational data dengan time-series aspects)
- High security requirements (multi-tenant isolation critical)
- Medium integration complexity (email, OAuth, future payment gateway)

**Estimated Architectural Components:** 10-12 major components

1. Authentication Service (Login, OAuth, Session Management)
2. User Management Service (Profiles, Restaurant Accounts)
3. Questionnaire Engine (Templates, CRUD, Preview)
4. QR Code Service (Generation, Customization, Attribution)
5. Feedback Collection Service (Form Rendering, Submission Processing)
6. Inbox Service (Feedback Management, Status Workflow, Filtering)
7. Analytics Engine (Sentiment Calculation, Time-Series Aggregation, Trend Analysis)
8. Dashboard Service (Real-Time Updates, Visualization Data)
9. Report Generator (Background Jobs, Excel/CSV Export)
10. Admin Service (Platform Management, Support Tickets, Monitoring)
11. Email Service (Verification, Notifications, Password Reset)
12. Storage Layer (Database, Caching, File Storage untuk QR images)

### Technical Constraints & Dependencies

**Architecture Decisions (from PRD):**

1. **Multi-Tenant SaaS Architecture** - Platform MUST implement data isolation per restaurant account dengan shared infrastructure dan logical separation. Performance isolation untuk prevent noisy neighbor.

2. **Mobile-First Web Application** - No native mobile app untuk MVP. Responsive web design untuk all screen sizes. QR scan triggers mobile browser navigation. Progressive Web App (PWA) optional enhancement.

3. **Rule-Based Analytics** - No AI/ML atau NLP untuk sentiment analysis dalam MVP. Cost-efficient approach berdasarkan rating thresholds (1-2 negative, 3 neutral, 4-5 positive). Text feedback displayed as-is tanpa automated categorization.

4. **cPanel Hosting Environment (Critical Constraint)** - Platform WILL BE deployed pada cPanel-based shared/cloud hosting. This significantly impacts architecture decisions:
   - **No Docker/Container Support** - Traditional file-based deployment instead of containers
   - **Limited Process Control** - Cannot run long-running background processes/workers
   - **Shared Server Resources** - Limited control over server configuration
   - **Standard LAMP/LEMP Stack** - Likely PHP/Node.js support dengan MySQL/PostgreSQL
   - **cPanel-managed Services** - Database, email, SSL certificates managed through cPanel interface
   - **File-based Deployments** - FTP/SFTP or Git-based deployments instead of CI/CD pipelines
   - **Cron Jobs for Scheduling** - Use cPanel cron jobs instead of queue workers
   - **Shared Hosting Limitations** - Memory limits, execution time limits, concurrent connection limits

**Technology Stack Recommendations (Adjusted for cPanel):**

**Frontend:**
- Modern JavaScript framework (React, Vue, atau Svelte)
- Mobile-responsive CSS framework (Tailwind CSS atau Bootstrap)
- Chart library (Chart.js atau Recharts)
- QR code generation library (qrcode.js)
- **Build Process:** Static files compiled locally and uploaded via FTP/Git

**Backend:**
- RESTful API architecture
- **Recommended: PHP/Laravel atau Node.js** (most compatible dengan cPanel environment)
  - PHP: Laravel/Lumen (native cPanel support, excellent documentation)
  - Node.js: Express (if cPanel supports Node.js apps via app manager)
- Authentication: Session-based (more reliable dalam shared hosting vs JWT)
- Email service: **cPanel built-in email atau SMTP** (SendGrid/Mailgun as backup)

**Database:**
- **MySQL** (standard cPanel database, better support than PostgreSQL dalam shared hosting)
- Database managed via cPanel phpMyAdmin
- Indexes optimized untuk common query patterns
- **Backup:** cPanel automated backups + manual exports

**Infrastructure (cPanel Constraints):**
- **cPanel-based Cloud Hosting** (Hostinger, Niagahoster, Dewaweb, atau similar)
- **No Docker/Containers** - Traditional file-based hosting
- **No Load Balancer** - Single server setup untuk MVP
- **Cloudflare CDN** (free tier) untuk static assets dan DDoS protection
- **SSL/TLS:** Let's Encrypt via cPanel AutoSSL
- **Deployment:** Git deployment hooks via cPanel atau FTP/SFTP
- **Cron Jobs:** cPanel cron interface untuk scheduled tasks

**Background Jobs (Workarounds):**
- **No Queue Workers** - Cannot run persistent processes
- **Cron-based Processing:** Email sending, report generation via scheduled cron jobs
- **Webhook/HTTP-based:** Use external services (Laravel Forge cron, EasyCron) to trigger jobs
- **On-demand Processing:** Some tasks execute synchronously (with timeout handling)

**Monitoring & Operations (cPanel-compatible):**
- Error tracking: **Sentry** (free tier, easy integration)
- Performance monitoring: **Application-level logging** (file-based logs via cPanel)
- Uptime monitoring: **UptimeRobot** (free tier, external pinging)
- Log management: **File-based logs** accessed via cPanel file manager/SSH
- **cPanel Metrics:** Built-in resource usage monitoring (CPU, memory, bandwidth)

**External Dependencies:**

1. **Email Service Provider** - cPanel built-in SMTP as primary. SendGrid/Mailgun as backup untuk high-volume. Risk: shared hosting email limits. Mitigation: external SMTP for critical emails, rate limiting.

2. **cPanel Cloud Hosting Provider** - Infrastructure foundation (Hostinger, Niagahoster, Dewaweb recommended for Indonesia market). Risk: shared hosting limitations, resource constraints. Mitigation: Choose plan dengan adequate resources, monitor usage, plan untuk VPS upgrade jika scale meningkat.

3. **OAuth Provider (Gmail)** - Convenience login feature. Risk: API changes, policy changes. Mitigation: email/password as primary, OAuth as enhancement.

4. **QR Code Library** - Core feature dependency. Risk: bugs, maintenance discontinued. Mitigation: well-maintained popular library, fallback identified.

5. **Post-MVP: Payment Gateway (Dana)** - Future subscription billing. Risk: integration complexity, regulatory changes. Mitigation: thorough testing, compliance monitoring.

**cPanel-Specific Architectural Considerations:**

**Advantages:**
- ✅ **Cost-Effective:** Significantly cheaper than cloud infrastructure untuk MVP stage
- ✅ **Simple Management:** Web-based cPanel interface untuk database, email, SSL, domains
- ✅ **Indonesia-Friendly:** Local hosting providers dengan Indonesian support dan payment
- ✅ **Quick Setup:** No complex infrastructure setup, faster time to deployment
- ✅ **Built-in Tools:** phpMyAdmin, file manager, cron jobs, email accounts included

**Limitations & Workarounds:**

1. **No Background Queue Workers**
   - Limitation: Cannot run Laravel queues, Node.js workers, Redis queues
   - Workaround: Use cron jobs untuk batch processing (every 1-5 minutes)
   - Impact: Slight delays dalam email sending, report generation (acceptable untuk MVP)

2. **Resource Limits (CPU, Memory, Execution Time)**
   - Limitation: Shared hosting has strict limits (e.g., 30-60s execution time, 128-512MB memory)
   - Workaround: Optimize queries, paginate large datasets, chunk processing dalam cron jobs
   - Impact: Must design for efficiency, cannot process huge datasets dalam single request

3. **No Horizontal Scaling**
   - Limitation: Cannot scale to multiple servers easily
   - Workaround: Start dengan adequate shared hosting plan, plan VPS migration jika traffic tinggi
   - Impact: MVP limited to ~500-1000 concurrent users (sufficient untuk initial 100 restaurants)

4. **Limited Real-Time Capabilities**
   - Limitation: No WebSockets support dalam most shared hosting
   - Workaround: Use polling (AJAX requests every 30-60 seconds) atau Server-Sent Events jika supported
   - Impact: Dashboard updates slightly delayed but acceptable (30-60s refresh vs instant)

5. **Deployment Process**
   - Limitation: No automated CI/CD pipelines
   - Workaround: Git deployment hooks via cPanel (push to Git repo → auto-deploy) atau manual FTP
   - Impact: Manual deployment process, more prone to human error

6. **Database Performance**
   - Limitation: Shared MySQL server, no read replicas
   - Workaround: Aggressive caching (file-based atau Memcached jika available), query optimization
   - Impact: Must optimize database access patterns carefully

**Scaling Strategy (When to Upgrade):**

**Stay on cPanel Shared Hosting IF:**
- < 100 active restaurant accounts
- < 5,000 feedback submissions per day
- < 500 concurrent dashboard viewers
- Adequate performance (dashboard < 3s load time)

**Upgrade to cPanel VPS IF:**
- 100-500 restaurant accounts
- 5,000-20,000 feedback submissions per day
- Need better performance/resources
- Still want cPanel management interface

**Migrate to Cloud Infrastructure IF:**
- 500+ restaurant accounts
- 20,000+ daily feedback submissions
- Need horizontal scaling, load balancing
- Need advanced features (WebSockets, microservices, etc.)

### Cross-Cutting Concerns Identified

**1. Multi-Tenancy & Data Isolation**
- Affects: All services dan database layers
- Requirements: Tenant ID enforcement dalam all queries, row-level security, data access auditing
- Risk Level: Critical (legal liability jika data leaked)
- Architecture Decision Needed: Tenant context propagation strategy, database isolation approach

**2. Security & Authentication**
- Affects: All API endpoints, all user-facing interfaces
- Requirements: RBAC, session management, input validation, CSRF/XSS protection, encryption
- Risk Level: Critical
- Architecture Decision Needed: Authentication mechanism (JWT vs session), middleware design, security framework selection

**3. Performance & Scalability**
- Affects: Dashboard rendering, analytics calculations, feedback submissions
- Requirements: Sub-3s dashboard load, 100+ concurrent users, 10,000+ daily feedback
- Risk Level: High (directly impacts user experience)
- Architecture Decision Needed: Caching strategy, database optimization, horizontal scaling approach, CDN usage

**4. Real-Time Updates**
- Affects: Dashboard, Inbox, Alert notifications
- Requirements: Dashboard updates tanpa manual refresh, new feedback notifications
- Risk Level: Medium
- Architecture Decision Needed: Real-time mechanism (WebSockets, Server-Sent Events, Polling), update propagation strategy

**5. Mobile Responsiveness**
- Affects: Customer feedback form (critical), Dashboard, all user interfaces
- Requirements: Mobile-first design, < 60s feedback completion, touch-optimized
- Risk Level: High (core value proposition depends on mobile UX)
- Architecture Decision Needed: Responsive framework, mobile optimization strategy, progressive enhancement approach

**6. Analytics & Reporting**
- Affects: Analytics engine, Report generator, Dashboard visualizations
- Requirements: Time-series aggregation, sentiment calculation, export generation
- Risk Level: Medium
- Architecture Decision Needed: Analytics calculation approach (real-time vs pre-aggregated), export job processing (background vs on-demand)

**7. Monitoring & Observability**
- Affects: All services, infrastructure
- Requirements: Error tracking, performance monitoring, uptime monitoring, audit logging
- Risk Level: Medium (critical untuk operations)
- Architecture Decision Needed: Monitoring tools selection, logging strategy, alerting configuration

**8. Email & Notifications**
- Affects: Authentication, Support system, Future alert features
- Requirements: Verification emails, password resets, support ticket notifications
- Risk Level: Medium
- Architecture Decision Needed: Email service provider, queuing strategy, template management

**9. Localization**
- Affects: All user-facing text, date/currency formatting
- Requirements: Bahasa Indonesia support, Indonesian formats
- Risk Level: Low (single locale untuk MVP)
- Architecture Decision Needed: i18n framework selection, content management approach

**10. Testing & Quality**
- Affects: All components
- Requirements: 70%+ test coverage, CI/CD pipeline, automated testing
- Risk Level: Medium
- Architecture Decision Needed: Testing strategy, test infrastructure, deployment pipeline design

## Starter Template Evaluation

### Technical Preferences Discovery

**User Profile:**
- Experience Level: Beginner
- Priority: Speed-to-Market
- Deployment Environment: cPanel Shared Hosting

**Key Constraints:**
- Must work excellently with cPanel environment
- Minimize learning curve for faster development
- Production-ready with minimal configuration
- Simple deployment process without complex build pipelines

### Primary Technology Domain

**Full-Stack Web Application (SaaS Platform)** with mobile-first responsive design.

Based on project requirements analysis:
- Multi-tenant restaurant feedback platform
- Customer-facing mobile-optimized forms
- Dashboard with analytics and real-time updates
- Admin panel for platform management
- Report generation and export capabilities

### Starter Options Considered

**Option 1: Laravel 11 + Breeze (Blade + Alpine)** ✅ SELECTED
- Lightweight authentication scaffolding
- Server-side rendering with Blade templates
- Minimal JavaScript with Alpine.js
- Tailwind CSS for styling
- Perfect cPanel compatibility
- Beginner-friendly with excellent documentation

**Option 2: Laravel 11 + Breeze (Vue + Inertia)**
- Modern SPA experience with Vue.js
- More complex build process (npm run build required)
- Steeper learning curve for beginners
- More setup complexity for cPanel deployment
- ❌ Rejected: Too complex for beginner + speed-to-market priority

**Option 3: Laravel 11 + Jetstream**
- Advanced features (teams, 2FA, API tokens)
- More overwhelming for beginners
- Includes features beyond MVP requirements
- ❌ Rejected: Over-engineered for current needs, steep learning curve

**Option 4: Plain Laravel 11 (no starter kit)**
- Maximum flexibility
- Requires manual authentication implementation
- Significantly more development time
- ❌ Rejected: Too slow for speed-to-market priority
### Selected Starter: Laravel 11 + Breeze (Blade + Alpine)

**Rationale for Selection:**

**1. Beginner-Friendly Architecture:**
- **Blade Templates**: Familiar PHP-based templating without learning React/Vue
- **Alpine.js**: Minimal JavaScript framework for interactive components (easier than full SPA frameworks)
- **Simple Mental Model**: Traditional server-side rendering, straightforward request/response cycle
- **Visible Code**: All authentication code published to project, easy to understand and customize

**2. Speed-to-Market Benefits:**
- **Built-in Authentication**: Login, registration, password reset, email verification ready out-of-the-box
- **Pre-configured Stack**: Tailwind CSS, Vite, testing framework already integrated
- **No Frontend Build Complexity**: Simpler than managing Vue/React state and components
- **Rapid Iteration**: Modify Blade templates and see changes immediately
- **Minimal Decisions**: Breeze makes sensible defaults, fewer choices to paralyze development

**3. Excellent cPanel Compatibility:**
- **Native PHP Support**: Laravel is PHP-based, perfect match for cPanel's LAMP stack
- **Simple Deployment**: Compile assets locally (`npm run build`), upload via FTP/Git
- **No Containerization Required**: Traditional file-based deployment works perfectly
- **Database Queue Driver**: Use database for queues instead of Redis (cPanel-friendly)
- **Cron Integration**: Laravel scheduler works seamlessly with cPanel cron jobs

**4. Production-Ready Foundation:**
- **Security Built-in**: CSRF protection, password hashing (bcrypt), XSS prevention
- **Multi-Tenant Ready**: Laravel ecosystem has excellent packages (e.g., `stancl/tenancy`)
- **Email Integration**: Built-in mail system with SMTP support for cPanel
- **Session Management**: File-based or database sessions (both cPanel-compatible)
- **Extensible**: Easy to add features as platform grows

**5. Community & Learning Resources:**
- **Best-in-Class Documentation**: Laravel has the best PHP framework documentation
- **Large Community**: Abundant tutorials, courses, forums (many in Bahasa Indonesia)
- **Laracasts**: Premium learning resource for Laravel development
- **Active Ecosystem**: Regular updates, security patches, package ecosystem

**Initialization Commands:**

```bash
# Step 1: Create new Laravel 11 project
composer create-project laravel/laravel ulasis-v2

# Navigate to project directory
cd ulasis-v2

# Step 2: Install Laravel Breeze package
composer require laravel/breeze --dev

# Step 3: Install Breeze with Blade stack
php artisan breeze:install blade

# During installation, select:
# - Stack: Blade with Alpine
# - Dark mode support: Yes (optional, can add visual polish)
# - Testing framework: Pest (modern, beginner-friendly syntax)

# Step 4: Install NPM dependencies
npm install

# Step 5: Build frontend assets
npm run build

# Step 6: Configure environment
# - Copy .env.example to .env
# - Set database credentials (MySQL)
# - Set APP_URL to your domain
# - Configure MAIL settings (SMTP)

# Step 7: Generate application key
php artisan key:generate

# Step 8: Run database migrations
php artisan migrate

# Step 9: (Development) Start local server
php artisan serve
# or use Laravel Valet/Herd for local development
```

### Architectural Decisions Provided by Starter

**Language & Runtime:**
- **PHP 8.2+**: Modern PHP with type declarations, enums, improved performance
- **Laravel 11**: Latest LTS framework with streamlined structure
- **Composer**: Dependency management for PHP packages

**Frontend Layer:**
- **Blade Templating Engine**: Server-side rendering for SEO-friendly pages, component-based architecture with Blade components, slot system for flexible layouts
- **Alpine.js**: Lightweight JavaScript framework (~15kb gzipped), declarative syntax in HTML attributes, perfect for interactive elements (dropdowns, modals, tabs)
- **Tailwind CSS**: Utility-first CSS framework, consistent design system out-of-the-box, responsive utilities for mobile-first design

**Build Tooling:**
- **Vite**: Modern, fast build tool with HMR, optimized production builds, CSS/JS bundling and minification, asset versioning for cache busting
- **PostCSS**: CSS processing with autoprefixer
- **NPM Scripts**: `npm run dev`, `npm run build`, `npm run watch`

**Authentication System:**
- Registration with email verification, session-based login with "Remember Me", password reset flow, email verification, profile management, authentication middleware and guards

**Testing Framework:**
- **Pest PHP**: Modern testing framework with expressive syntax, simpler than PHPUnit for beginners, pre-written tests for authentication flows

**Code Organization:**
- **MVC Architecture**: Models (Eloquent ORM), Views (Blade templates), Controllers (HTTP handlers)
- Routing, Middleware, Service Providers, Environment-based configuration

**Database Layer:**
- **Eloquent ORM**: Expressive database queries
- Migrations for version control, Seeders for test data, Factories for fake data generation

**Development Experience:**
- **Artisan CLI**: `make:model`, `make:controller`, `make:migration`, `route:list`, `tinker`
- Error handling with Ignition, comprehensive logging, Laravel Telescope for debugging

**Security Features:**
- CSRF protection, XSS prevention (Blade auto-escapes), SQL injection protection (parameterized queries), Bcrypt password hashing, rate limiting, encrypted sessions

**Email System:**
- SMTP/Mailgun/SendGrid/SES support, Markdown Mailable, queue support, built-in email verification

**Session Management:**
- File-based sessions (default, works on any hosting), database sessions (scalable), cookie sessions (lightweight)

### cPanel Deployment Considerations

**Pre-Deployment Checklist:**
1. **Local Build**: Run `npm run build` to compile production assets
2. **Optimize Autoloader**: Run `composer install --optimize-autoloader --no-dev`
3. **Cache Configuration**: Run `php artisan config:cache`
4. **Cache Routes**: Run `php artisan route:cache`
5. **Cache Views**: Run `php artisan view:cache`

**Deployment Structure:**
```
/home/username/
├── ulasis-v2/           # Laravel application root (outside public_html)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── resources/
│   ├── routes/
│   ├── storage/         # Ensure writable permissions (755)
│   └── vendor/
└── public_html/         # Web-accessible directory
    ├── index.php        # Modified to point to ../ulasis-v2
    ├── css/             # Compiled assets from public/build
    ├── js/              # Compiled assets from public/build
    └── .htaccess        # Laravel's .htaccess rules
```

**Key Deployment Steps:**
1. Upload entire Laravel project to `/home/username/ulasis-v2/` (outside public_html)
2. Copy contents of `public/` directory to `public_html/`
3. Edit `public_html/index.php` to update paths to Laravel installation
4. Set storage and bootstrap/cache folders to writable (755 or 775)
5. Configure `.env` file with production settings (database, mail, APP_ENV=production)
6. Setup cPanel cron job for Laravel scheduler: `php /home/username/ulasis-v2/artisan schedule:run >> /dev/null 2>&1` (every minute)

**Note:** Project initialization using Laravel + Breeze should be the first implementation story/task.
## Core Architectural Decisions

### Decision Framework Summary

**Decision-Making Context:**
- User Experience Level: Beginner
- Priority: Speed-to-Market
- Deployment Constraint: cPanel Shared Hosting
- Starter Template: Laravel 11 + Breeze (Blade + Alpine)

**Decision Priorities:**
- **Critical Decisions:** Block implementation if not decided - all addressed below
- **Important Decisions:** Shape architecture significantly - all documented
- **Deferred Decisions:** Can be added post-MVP - noted where applicable

---

### Data Architecture Decisions

**Decision 1.1: Multi-Tenancy Approach**
- **Choice:** Single Database with Tenant ID
- **Package:** `stancl/tenancy` v3.x (latest stable)
- **Implementation:**
  - Every tenant-specific table includes `tenant_id` column
  - Global scopes automatically filter by tenant
  - Middleware sets tenant context from session
  - Zero risk of cross-tenant data leakage
- **Rationale:**
  - Simplest approach for <1000 tenants
  - Excellent Laravel package with automatic scoping
  - Single database backup/restore
  - Cost-effective for cPanel shared hosting
- **Affects:** All models, migrations, seeders, queries

**Decision 1.2: Caching Strategy**
- **Choice:** File-Based Caching
- **Driver:** `file` (Laravel native)
- **Cache Location:** `storage/framework/cache/`
- **TTL Strategy:**
  - Analytics results: 5 minutes
  - Dashboard statistics: 1 minute
  - QR code images: Permanent (until updated)
  - Config/routes/views: Cached in production
- **Rationale:**
  - Native cPanel support, zero additional services
  - Sufficient for MVP performance requirements
  - Simple cache clear: `php artisan cache:clear`
  - Upgrade path to Redis when moving to VPS
- **Affects:** Dashboard performance, analytics calculations, QR image serving

**Decision 1.3: Queue Driver**
- **Choice:** Database Queue with Cron Jobs
- **Driver:** `database`
- **Tables:** `jobs`, `failed_jobs`
- **Cron Configuration:** `* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1`
- **Queue Processing:**
  - Email sending (background)
  - Report generation (async)
  - Analytics pre-aggregation (scheduled)
  - Feedback processing (if heavy operations needed)
- **Rationale:**
  - Perfect cPanel compatibility
  - No Redis/Beanstalk required
  - Monitoring via database queries
  - Simple retry logic for failed jobs
- **Affects:** Email system, report generator, background processing

**Decision 1.4: Data Validation**
- **Choice:** Laravel Form Requests + Real-time Alpine.js
- **Server-Side:** Form Request classes for complex validation
- **Client-Side:** Alpine.js for UX feedback (not security)
- **Validation Display:** Blade `@error` directive, flash messages
- **Rationale:**
  - Server-side as source of truth (security)
  - Client-side enhances UX without compromising security
  - Form Requests keep controllers clean
- **Affects:** All forms, API endpoints, data integrity

**Decision 1.5: Database Migrations**
- **Choice:** Version-Controlled Incremental Migrations
- **Strategy:**
  - Never modify existing migrations after deployment
  - Create new migrations for schema changes
  - Use seeders for initial/reference data
  - Factories for testing data generation
- **Migration Execution:** Manual via SSH or deploy script
- **Rationale:**
  - Standard Laravel best practice
  - Clear change history
  - Safe rollback capability
- **Affects:** Database schema evolution, deployment process

---

### Authentication & Security Decisions

**Decision 2.1: Authentication Method**
- **Choice:** Session-Based Authentication (from Laravel Breeze)
- **Session Driver:** `file` (default, cPanel-compatible)
- **Features Included:**
  - Email/password login
  - Gmail OAuth (optional convenience)
  - "Remember Me" functionality
  - Email verification
  - Password reset via email
- **Session Configuration:**
  - Lifetime: 120 minutes
  - Expire on close: false (if Remember Me checked)
  - Secure cookies in production
  - SameSite: lax
- **Rationale:** More reliable than JWT in shared hosting, built into Breeze
- **Affects:** All authenticated routes, user experience

**Decision 2.2: Authorization Pattern**
- **Choice:** Laravel Gates & Policies
- **Implementation:**
  - Gates for simple checks: `Gate::define('update-post', ...)`
  - Policies for model authorization: `PostPolicy`
  - Middleware: `can:ability` for route protection
  - Blade: `@can('update', $post)` directives
- **Rationale:** Laravel's native authorization, flexible and powerful
- **Affects:** All permission checks, access control

**Decision 2.3: Multi-Tenant Data Security**
- **Choice:** Automatic Tenant Scoping + Middleware
- **Implementation:**
  - Tenant ID stored in session after login
  - Global scope on all tenant-specific models
  - Middleware enforces tenant context on all requests
  - Database-level: Impossible to query other tenant data
- **Security Measures:**
  - Double-check tenant ownership before sensitive operations
  - Audit log for data access (post-MVP enhancement)
  - Regular security testing with different tenant accounts
- **Rationale:** Critical security requirement, automated protection
- **Affects:** All database queries, data access security

**Decision 2.4: Password Security**
- **Choice:** Bcrypt with 10 Rounds
- **Configuration:**
  - Hashing: Bcrypt (Laravel default)
  - Rounds: 10 (balance security vs performance)
  - Password reset: Secure tokens, 60-minute expiry
  - Rate limiting: 5 login attempts per minute
- **Session Security:**
  - Idle timeout: 30 minutes
  - Force logout after password change
  - Secure session regeneration
- **Rationale:** Industry standard, Laravel defaults are well-tested
- **Affects:** User registration, login, password management

**Decision 2.5: API Security (Future)**
- **Choice:** Laravel Sanctum (Deferred to Post-MVP)
- **Plan:**
  - Sanctum for API token authentication
  - Token abilities for scoped permissions
  - Rate limiting: 60 requests/minute per user
- **Current:** Focus on web auth, defer API until needed
- **Rationale:** Not needed for MVP (web-only), easy to add later
- **Affects:** Future mobile app, third-party integrations

**Decision 2.6: Input Security**
- **Choice:** Multi-Layer Protection
- **XSS Prevention:**
  - Blade auto-escapes: `{{ $variable }}`
  - Raw output only when necessary: `{!! $html !!}` (sanitize first)
- **SQL Injection Prevention:**
  - Eloquent parameterized queries
  - Never raw queries with user input
- **CSRF Protection:**
  - Automatic token validation (Laravel middleware)
  - All POST/PUT/DELETE require CSRF token
- **Mass Assignment Protection:**
  - Define `$fillable` or `$guarded` on all models
- **Rationale:** Defense in depth, Laravel provides excellent defaults
- **Affects:** All input handling, data security

---

### API & Communication Decisions

**Decision 3.1: API Design Pattern**
- **Choice:** RESTful API
- **Conventions:**
  - Resource-based URLs: `/api/feedbacks`, `/api/qr-codes`
  - HTTP verbs: GET (read), POST (create), PUT (update), DELETE (delete)
  - Resource controllers: `php artisan make:controller --resource`
- **Route Organization:**
  - Web routes: `routes/web.php` (Blade views)
  - API routes: `routes/api.php` (JSON responses)
  - Prefix: `/api` for all API endpoints
- **Rationale:** Standard, well-understood, Laravel native support
- **Affects:** API structure, frontend AJAX calls

**Decision 3.2: Error Handling**
- **Choice:** Standardized HTTP Status Codes + JSON Format
- **Status Codes:**
  - 200 OK, 201 Created
  - 400 Bad Request, 401 Unauthorized, 403 Forbidden, 404 Not Found
  - 422 Unprocessable Entity (validation errors)
  - 500 Internal Server Error
- **Response Format:**
  - Success: `{"success": true, "data": {...}}`
  - Error: `{"success": false, "message": "Error description", "errors": {...}}`
- **User-Facing:**
  - Blade error pages for web routes
  - Friendly error messages in Bahasa Indonesia
- **Logging:** All errors to `storage/logs/laravel.log`
- **Rationale:** Consistent error handling improves debugging and UX
- **Affects:** All API endpoints, error pages, logging

**Decision 3.3: Rate Limiting**
- **Choice:** Laravel Throttle Middleware
- **Limits:**
  - Login attempts: 5 per minute per IP
  - API requests: 60 per minute per authenticated user
  - Feedback submission: 10 per minute per IP (prevent spam)
  - Password reset: 3 per hour per email
- **Implementation:** `throttle:60,1` middleware in routes
- **Rationale:** Prevent abuse, protect against brute force
- **Affects:** All public-facing endpoints, authentication

**Decision 3.4: Real-Time Updates**
- **Choice:** AJAX Polling (cPanel-Compatible)
- **Implementation:**
  - Poll interval: 30-60 seconds
  - Endpoint: `/api/dashboard/updates`
  - Client: Alpine.js with `setInterval()`
  - Response: Delta updates (only what changed)
- **Future Enhancement:** WebSockets/Pusher when migrate to VPS
- **Rationale:**
  - WebSockets not available in cPanel shared hosting
  - Polling sufficient for dashboard updates
  - Easy upgrade path later
- **Affects:** Dashboard real-time updates, inbox notifications

---

### Frontend Architecture Decisions

**Decision 4.1: State Management**
- **Choice:** Alpine.js for Component State
- **Pattern:**
  - Local state: Alpine `x-data` in components
  - Shared state: Pass via Blade component props
  - Form state: Alpine reactive data binding
  - Dashboard state: AJAX poll + Alpine update
- **No Global Store:** Not needed for MVP, keep simple
- **Rationale:** Alpine.js sufficient for interactive components, avoid complexity
- **Affects:** All interactive UI components

**Decision 4.2: Component Architecture**
- **Choice:** Blade Components
- **Organization:**
  - Anonymous components: `resources/views/components/button.blade.php`
  - Class-based for complex logic: `app/View/Components/Alert.php`
  - Slots for flexible layouts
  - Props for data passing
- **Component Library:**
  - Build custom components as needed
  - No external UI library (keep bundle small)
- **Rationale:** Blade components powerful enough, no React/Vue overhead
- **Affects:** UI consistency, code reusability

**Decision 4.3: Form Handling**
- **Choice:** Server-Side Validation with Client-Side UX
- **Pattern:**
  - Server validates all data (Form Requests)
  - Client provides instant feedback (Alpine.js)
  - Display errors via `@error` Blade directive
  - Success messages via flash sessions
- **AJAX Forms:**
  - Submit via Alpine + fetch API
  - Return JSON validation errors
  - Update UI without page reload
- **Rationale:** Security on server, enhanced UX on client
- **Affects:** All forms, user input handling

**Decision 4.4: Asset Management**
- **Choice:** Vite Build Tool
- **Assets:**
  - CSS: Tailwind (JIT compilation)
  - JavaScript: Alpine.js + custom scripts
  - Images: Manual optimization before upload
  - Charts: Chart.js for analytics
- **Build Process:**
  - Development: `npm run dev` (hot reload)
  - Production: `npm run build` (minified, versioned)
- **Rationale:** Vite is fast, modern, included with Laravel 11
- **Affects:** Build process, asset loading performance

**Decision 4.5: Mobile-First Design**
- **Choice:** Tailwind Responsive Utilities
- **Breakpoints:**
  - Default: Mobile (< 640px)
  - sm: Tablet (≥ 640px)
  - md: Small desktop (≥ 768px)
  - lg: Desktop (≥ 1024px)
  - xl: Large desktop (≥ 1280px)
- **Pattern:** Design for mobile first, enhance for larger screens
- **Touch Targets:** Minimum 44x44px for mobile usability
- **Rationale:** Most users will access via mobile (QR code use case)
- **Affects:** All UI design, customer feedback form

---

### Infrastructure & Deployment Decisions

**Decision 5.1: Environment Configuration**
- **Choice:** Laravel .env Files
- **Environments:**
  - Local development: `.env` (git-ignored)
  - Production: `.env` on server (git-ignored)
  - Template: `.env.example` (committed)
- **Production Optimizations:**
  - Config cache: `php artisan config:cache`
  - Route cache: `php artisan route:cache`
  - View cache: `php artisan view:cache`
- **Rationale:** Laravel standard, secure, flexible
- **Affects:** Configuration management, deployment

**Decision 5.2: Deployment Strategy**
- **Choice:** Git Deployment via cPanel
- **Process:**
  1. Local: `npm run build` (compile assets)
  2. Local: `composer install --optimize-autoloader --no-dev`
  3. Git: Push to repository
  4. cPanel: Pull via Git Version Control feature
  5. Post-deploy: Run optimization commands
  6. Post-deploy: Set permissions `chmod -R 755 storage bootstrap/cache`
- **Alternative:** Manual FTP upload (if Git not available)
- **Rationale:** Git provides version control + easier deployments
- **Affects:** Deployment workflow, rollback capability

**Decision 5.3: Logging**
- **Choice:** Laravel Monolog (File-Based)
- **Configuration:**
  - Channel: `daily` (rotated daily logs)
  - Location: `storage/logs/`
  - Production log level: `error` and above
  - Development log level: `debug`
- **Retention:** 14 days (Laravel default rotation)
- **Rationale:** Simple, works in cPanel, sufficient for MVP
- **Affects:** Error tracking, debugging

**Decision 5.4: Error Tracking**
- **Choice:** Sentry (Free Tier)
- **Package:** `sentry/sentry-laravel`
- **Features:**
  - Auto-capture exceptions
  - Email notifications for critical errors
  - Error grouping and trends
  - Release tracking
- **Free Tier:** 5,000 events/month (sufficient for MVP)
- **Rationale:** Professional error tracking, free for small projects
- **Affects:** Production error monitoring

**Decision 5.5: Uptime Monitoring**
- **Choice:** UptimeRobot (Free Tier)
- **Configuration:**
  - HTTP(s) monitoring
  - Check interval: 5 minutes
  - Alert via email/SMS on downtime
- **Free Tier:** 50 monitors (more than enough)
- **Rationale:** Essential for production, free and reliable
- **Affects:** Uptime awareness, incident response

**Decision 5.6: Backup Strategy**
- **Automated Backups:**
  - Database: cPanel daily backups (30-day retention)
  - Files: cPanel file backups (included)
- **Manual Backups:**
  - Weekly: Download full site backup via cPanel
  - Before major changes: Manual backup
- **Code Backup:** Git repository (GitHub/GitLab)
- **Rationale:** Multiple backup layers for data safety
- **Affects:** Disaster recovery capability

**Decision 5.7: Scaling Strategy**
- **Phase 1 (MVP): cPanel Shared Hosting**
  - Target: 0-100 restaurants, <5,000 daily feedbacks
  - Single server, file cache, database queue
  - Budget: ~Rp 50K-150K/month

- **Phase 2 (Growth): cPanel VPS**
  - Target: 100-500 restaurants, 5K-20K daily feedbacks
  - More resources (2-4GB RAM, 2-4 CPU cores)
  - Consider Redis for cache/queue
  - Budget: ~Rp 200K-500K/month

- **Phase 3 (Scale): Cloud Infrastructure**
  - Target: 500+ restaurants, 20K+ daily feedbacks
  - AWS/DigitalOcean with load balancers
  - Separate database server
  - WebSockets for real-time
  - Budget: Variable based on usage

- **Migration Triggers:**
  - Performance degradation (dashboard >5s load)
  - Resource limits hit frequently
  - Need for high availability
  - Real-time features become critical
- **Rationale:** Clear growth path, minimize premature optimization
- **Affects:** Long-term architecture planning

---

### Additional Technical Decisions

**Decision 6.1: Core Laravel Packages**
- **Multi-Tenancy:** `stancl/tenancy` ^3.0
- **Excel Export:** `maatwebsite/excel` ^3.1
- **QR Code:** `simplesoftwareio/simple-qrcode` ^4.2
- **Image Processing:** `intervention/image` ^2.7
- **Error Tracking:** `sentry/sentry-laravel` ^3.0

**Decision 6.2: Testing Strategy**
- **Framework:** Pest PHP (included with Breeze)
- **Coverage Target:** 70%+ for core features
- **Test Types:**
  - Unit tests: Business logic, calculations
  - Feature tests: HTTP requests, auth flows, CRUD operations
  - Browser tests: Deferred to post-MVP (Laravel Dusk)
- **Continuous Testing:** Run before deployment
- **Rationale:** Balance test coverage with development speed
- **Affects:** Code quality, regression prevention

**Decision 6.3: Code Organization**
- **Pattern:** Service-Oriented
- **Structure:**
  - Controllers: Thin, delegate to Services
  - Services: Business logic in `app/Services/`
  - Models: Eloquent models, relationships
  - Repositories: Deferred (start without)
  - Actions: Single-purpose classes for complex operations
- **Rationale:** Separation of concerns, testable code
- **Affects:** Code maintainability, testability

**Decision 6.4: Email Configuration**
- **Development:** `log` driver (emails to log file)
- **Production:** SMTP driver
  - Primary: cPanel SMTP
  - Backup: SendGrid free tier (100 emails/day)
- **Templates:** Markdown Mailables
- **Queueing:** Always queue emails (async via database queue)
- **Rationale:** Don't block user requests, reliable delivery
- **Affects:** Email system, user notifications

---

### Decision Impact Analysis

**Implementation Priority (First to Last):**

1. **Project Setup:** Laravel + Breeze installation
2. **Multi-Tenancy:** Install and configure `stancl/tenancy`
3. **Database Schema:** Create migrations for all tables with tenant_id
4. **Authentication:** Customize Breeze for restaurant context
5. **Core Models:** User, Restaurant, Angket, QRCode, FeedbackResponse
6. **Services Layer:** RestaurantService, AngketService, QRCodeService, FeedbackService, AnalyticsService
7. **Frontend Components:** Dashboard, Inbox, Analytics, QR Management
8. **Caching Layer:** Implement for analytics and dashboard
9. **Queue Setup:** Configure database driver + cron job
10. **Testing:** Write tests for critical paths
11. **Deployment:** Set up cPanel Git deployment
12. **Monitoring:** Configure Sentry + UptimeRobot

**Cross-Component Dependencies:**

- **Multi-Tenancy affects:** All models, controllers, services, database queries
- **Authentication affects:** All protected routes, user context, tenant identification
- **Caching affects:** Dashboard, analytics, QR image serving
- **Queue affects:** Email sending, report generation
- **API design affects:** Frontend AJAX calls, mobile app future compatibility

**Risk Mitigation:**

- **Multi-tenant data leakage:** Automated tests with multiple tenants, security audit before launch
- **Performance bottlenecks:** Caching strategy, database indexing, query optimization
- **Deployment errors:** Staging environment testing, deployment checklist
- **Security vulnerabilities:** Regular package updates, Sentry monitoring, penetration testing (post-MVP)
