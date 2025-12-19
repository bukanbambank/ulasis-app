# Story 1.3: Database Schema Setup - Core Tables

**Epic:** 1: Foundation & Technical Setup
**Story ID:** 1.3
**Status:** done
**Priority:** High

## Description

**As a** developer,
**I want** to create migration files untuk all core database tables,
**So that** complete data model ready untuk application features.

## Acceptance Criteria

### 1. Tenant-Specific Tables (with `tenant_id`)
- [ ] `restaurants`: metadata (name, logo, settings).
- [ ] `questionnaires`: angket definition (title, template_type, questions JSON).
- [ ] `qr_codes`: QR tracking (unique_id, name, angket_id).
- [ ] `feedback_responses`: answers (qr_code_id, ratings JSON, text_feedback).
- [ ] `support_tickets`: help requests.

### 2. Global Tables
- [ ] `users`: credentials (from Breeze) + `restaurant_id`.
- [ ] `admin_audit_logs`: admin actions.

### 3. Constraints & Indexes
- [ ] `tenant_id` indexed on all tenant-tables.
- [ ] Foreign keys configured with cascading options.
- [ ] `created_at` indexed on feedback_responses for analytics performance.

### 4. Verification
- [ ] Migrations run successfully (`php artisan migrate`).
- [ ] Database schema matches ERD/Architecture requirements.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Data
**Component:** Schema Definitions

- **JSON Columns:** Used for `questions` in `questionnaires` and `ratings` in `feedback_responses` to allow flexible schemas.
- **Tenant ID:** Must be present on all tables listed in Group 1.

### Developer Guardrails
> [!IMPORTANT]
> **Performance:** Ensure indexes are added for `tenant_id` and `created_at` in the migrations.
> **Foreign Keys:** Be careful with FKs across tenant boundaries; usually not needed if `tenant_id` scope is enforced, but ensure referential integrity within tenant data.

### Implementation Steps
1.  **Create Migrations:**
    ```bash
    php artisan make:migration create_restaurants_table
    php artisan make:migration create_questionnaires_table
    # ... and so on
    ```
2.  **Define Schema:**
    - Use `json` type for flexible data.
    - Use `string('tenant_id')` or `uuid('tenant_id')` consistently.
3.  **Run Migrations:**
    ```bash
    php artisan migrate
    ```

## Dependencies & Libraries
- Laravel Migrations (Standard)

## Dev Agent Record

### Implementation Plan
- [ ] Generate Migrations
- [ ] Define Schemas
- [ ] Run Migrations
- [ ] Verification

### Debug Log
- (Empty)

### Completion Notes
- ✅ Created migration for `restaurants`.
- ✅ Created migration for `questionnaires` (JSON schemas).
- ✅ Created migration for `qr_codes` (with FK to questionnaires).
- ✅ Created migration for `feedback_responses` (with FK to qr_codes).
- ✅ Created migration for `support_tickets` & `admin_audit_logs`.
- ✅ Resolved circular dependency/order issue between QR and Feedback tables.
- ✅ Verified all migrations run successfully.

## File List
- database/migrations/2025_12_06_061226_create_restaurants_table.php
- database/migrations/2025_12_06_061226_create_questionnaires_table.php
- database/migrations/2025_12_06_061227_create_qr_codes_table.php
- database/migrations/2025_12_06_061228_create_support_tickets_table.php
- database/migrations/2025_12_06_061228_create_admin_audit_logs_table.php
- database/migrations/2025_12_06_061229_create_feedback_responses_table.php

## Change Log
- 2025-12-06: Database Schema Setup (Story 1.3)
- 2025-12-06: Code Review - commited migration files



