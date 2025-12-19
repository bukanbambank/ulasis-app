# Story 1.2: Multi-Tenancy Package Installation & Configuration

**Epic:** 1: Foundation & Technical Setup
**Story ID:** 1.2
**Status:** done
**Priority:** High

## Description

**As a** developer,
**I want** to install dan configure stancl/tenancy package,
**So that** platform supports multiple restaurant tenants dengan automatic data isolation.

## Acceptance Criteria

### 1. Installation
- [ ] `stancl/tenancy` package installed via Composer (`v3.x`).
- [ ] Tenancy configuration published (`php artisan tenancy:install`).
- [ ] Migration files related to tenancy created.

### 2. Configuration (Single DB Strategy)
- [ ] Tenancy configured for **Single Database** mode (using `tenant_id` column).
- [ ] Tenant identification strategy configured (based on Session/User, NOT domain).
- [ ] `Tenant` model created or configured.
- [ ] Middleware pipeline configured to identify tenant from authenticated user context.

### 3. Database Updates
- [ ] Migration created to add `tenant_id` to all relevant tables (can be part of Story 1.3 or initial setup here).
- [ ] Global scopes implemented on models to automatically filter by `tenant_id`.

### 4. Verification
- [ ] Unit/Feature test verifies User A cannot access User B's data.
- [ ] Test verifies creating a record automatically assigns the correct `tenant_id`.

## Tasks/Subtasks

- [x] Install stancl/tenancy Package
    - Verify pre-install (Red)
    - Run `composer require stancl/tenancy`
    - Run `php artisan tenancy:install`
    - Verify basic files created
- [x] Configure Single Database Strategy
    - Verify configuration default (Red)
    - Update `config/tenancy.php` to disable database bootstrapper
    - Verify configuration change
- [x] Implement Tenant Model & Migration
    - Verify table missing (Red)
    - Create/Model Tenant with `tenant_id` support
    - Create core migration for `tenants` table
    - Run migration
- [x] Implement Scoping & Middleware
    - Verify scope missing (Red)
    - Implement Global Scope / Trait
    - Verify scope active
- [x] Verification
    - Automated tests for isolation
    - Manual verification steps

## Technical Implementation Context


### Architecture Compliance
**Layer:** Core / Data Access
**Component:** Multi-Tenancy Engine

- **Package:** `stancl/tenancy`
- **Strategy:** Single Database (Shared Schema)
- **Isolation Key:** `tenant_id` column (String/UUID)

### Developer Guardrails
> [!IMPORTANT]
> **Single Database Mode:** We are NOT using multi-database (one DB per tenant). We are using a SINGLE database with `tenant_id` columns.
> Ensure the configuration in `config/tenancy.php` reflects this (Bootstrappers should be minimal, mostly focused on Scopes).

### Implementation Steps
1.  **Install:**
    ```bash
    composer require stancl/tenancy
    php artisan tenancy:install
    ```
2.  **Configure `config/tenancy.php`:**
    - Disable `database` bootstrapper (as we share the DB).
    - Enable `TenancyScope` (or custom global scope).
3.  **Model Traits:**
    - Apply `BelongsToTenant` trait (from package or custom) to models.
4.  **Middleware:**
    - Ensure `InitializeTenancyByRequestData` or similar logic is applied to authenticated routes.
    - *Correction:* Since we use Session Auth for the *Owner*, the Tenant ID is likely derived from the logged-in User's `restaurant_id`.

## Dependencies & Libraries
- `stancl/tenancy`: ^3.0

## Dev Agent Record

### Implementation Plan
- [ ] Install Package
- [ ] Configure Single DB
- [ ] Tenant Model & Migration
- [ ] Scoping
- [ ] Verification

### Debug Log
- (Empty)

### Completion Notes
- ✅ Installed `stancl/tenancy` v3.
- ✅ Configured for Single Database mode (Database Bootstrapper disabled).
- ✅ Implemented `Tenant` model extending BaseTenant.
- ✅ Added `tenant_id` column to `users` table via migration.
- ✅ Implemented `BelongsToTenant` trait for global scoping.
- ✅ Verified data isolation with `IsolationTest` (Passed).

## File List
- config/tenancy.php
- routes/tenant.php
- app/Models/Tenant.php
- app/Models/User.php
- app/Models/Traits/BelongsToTenant.php
- database/migrations/2019_09_15_000010_create_tenants_table.php
- database/migrations/2019_09_15_000020_create_domains_table.php
- database/migrations/2025_12_06_060441_add_tenant_id_to_users_table.php
- tests/Feature/Tenancy/IsolationTest.php
- composer.json
- composer.lock

## Change Log
- 2025-12-06: Initial multi-tenancy setup (Story 1.2)
- 2025-12-06: Code Review - added missing files and committed changes



