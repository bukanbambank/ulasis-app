# Story 2.1: User Registration dengan Email Verification

**Epic:** 2: User Authentication & Account Management
**Story ID:** 2.1
**Status:** ready-for-dev
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

## Dependencies & Libraries
- Laravel Breeze (Built-in)
- `Illuminate\Auth\MustVerifyEmail`

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Main entry point for customers.
