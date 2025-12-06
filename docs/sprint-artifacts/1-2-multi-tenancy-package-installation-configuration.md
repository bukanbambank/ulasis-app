# Story 1.2: Multi-Tenancy Package Installation & Configuration

**Epic:** 1: Foundation & Technical Setup
**Story ID:** 1.2
**Status:** ready-for-dev
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

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Critical for data security in shared environment.
