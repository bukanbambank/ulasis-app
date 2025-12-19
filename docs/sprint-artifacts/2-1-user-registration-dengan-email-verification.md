# Story 2.1: User Registration dengan Email Verification

**Epic:** 2: User Authentication & Account Management
**Story ID:** 2.1
**Status:** Done
**Priority:** High

## Description

**As a** restaurant owner,
**I want** to register account menggunakan email address,
**So that** saya dapat access Ulasis platform.

## Acceptance Criteria

### 1. Registration Form
- [ ] Form includes: `Restaurant Name`, `Owner Name`, `Email`, `Password`, `Confirm Password`.
- [ ] Validations:
    - Email: RFC 5322 format, unique in `users` table.
    - Password: Min 8 chars, 1 uppercase, 1 number, 1 special char.
    - Password Confirmation: Must match.

### 2. Registration Process
- [ ] New user created in `users` table.
- [ ] Tenant created in `restaurants` table (or linked metadata).
- [ ] Password hashed with Bcrypt.
- [ ] `email_verified_at` is initially `null`.
- [ ] Rate limiting: 5 registrations per hour per IP.

### 3. Email Verification
- [ ] Verification email sent immediately upon registration (via Queue).
- [ ] Contains unique signed link (`/verify-email/{id}/{hash}`).
- [ ] User redirected to "Verify Email" notice page.
- [ ] Login blocked (or restricted) until email is verified.

### 4. Verification Completion
- [ ] Clicking link verifies email (`email_verified_at` updated).
- [ ] Redirects to Dashboard.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Auth
**Component:** Registration Flow

- **Controller:** Customized `RegisteredUserController`.
- **Notification:** `MustVerifyEmail` interface on User model.

### Developer Guardrails
> [!IMPORTANT]
> **Custom Fields:** Breeze default only has `name`. You must add `restaurant_name` and `owner_name`.
> **Tenant Creation:** When a user registers, a `Restaurant` (Tenant) record MUST be created and linked. This is the "Owner" context.

### Implementation Steps
1.  **Migration:** Ensure `users` has `owner_name` (if distinct) or use `name` as owner name. Create `restaurants` table if not done in 1.3.
2.  **Controller:** Update `store` method in `RegisteredUserController`.
    - Create `Restaurant` first or transactionally.
    - Create `User` linked to `restaurant_id`.
3.  **View:** Add fields to `resources/views/auth/register.blade.php`.
4.  **Request:** Update `RegisterRequest` (or validation logic).

## Tasks/Subtasks
- [x] **Migration:** Ensure `users` has `owner_name` and create `restaurants` table if needed
- [x] **Controller:** Update `RegisteredUserController::store` to handle Tenant creation
    - [x] Create `Restaurant` (Tenant) record
    - [x] Create `User` linked to `restaurant_id`
    - [x] Handle database transaction
- [x] **View:** Add `restaurant_name` and `owner_name` to `register.blade.php`
- [x] **Request:** Update validation logic in `RegisterRequest` (custom rules for new fields)

## Dev Agent Record

### Implementation Plan
- [x] Analyze existing migrations for `users` and `restaurants`
- [x] Create/Update migrations if fields are missing
- [x] Modify `RegisteredUserController`
- [x] Update Registration View
- [x] Verify Email Verification flow

### Completion Notes
- Implemented `RegisteredUserController` to handle `restaurant_name` and create `Tenant`/`Restaurant`/`User`.
- Updated `User` model to implement `MustVerifyEmail`.
- Updated `register.blade.php` to include `Restaurant Name` and rename `Name` to `Owner Name`.
- Verified implementation with `RegistrationTest.php` covering database creation and email notification.

## File List
- app/Http/Controllers/Auth/RegisteredUserController.php
- app/Models/User.php
- app/Providers/AppServiceProvider.php
- resources/views/auth/register.blade.php
- routes/auth.php
- tests/Feature/Auth/RegistrationTest.php

## Change Log
- [2025-12-06] Implementation of User Registration with Tenant creation (Story 2.1)
- [2025-12-06] Code Review Fixes: Added Rate Limiting (5/min), Password Complexity Rules, and Queue configuration.

## Dependencies & Libraries
- Laravel Breeze (Built-in)
- `Illuminate\Auth\MustVerifyEmail`

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Main entry point for customers.
