# Story 2.4: Password Reset Flow

**Epic:** 2: User Authentication & Account Management
**Story ID:** 2.4
**Status:** Done
**Priority:** High

## Description

**As a** restaurant owner,
**I want** to reset my password jika saya lupa,
**So that** saya dapat regain access ke account.

## Acceptance Criteria

### 1. Request Flow
- [ ] "Forgot Password" link on Login page.
- [ ] Form takes Email.
- [ ] Sends reset link via Email (Queue).
- [ ] Token expires in 60 minutes.
- [ ] Rate limiting: 3 requests per hour.

### 2. Reset Flow
- [ ] User clicks link -> Redirects to Reset Password form.
- [ ] Form: Email (readonly/prefilled), New Password, Confirm.
- [ ] Validates token matches email.
- [ ] Updates password (re-hashed).
- [ ] Deletes token.
- [ ] Logs out other sessions (optional security best practice).

### 3. Security
- [ ] Generic success message ("If that email exists...") to prevent enumeration.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Auth
**Component:** Password Broker

- **Feature:** Laravel Breeze built-in.

### Developer Guardrails
> [!IMPORTANT]
> **Queue:** Ensure the email job is queued (Story 1.3/1.5 config).
> **Translation:** Ensure validation messages are in Indonesian (FR Requirement).

### Implementation Steps
1.  **Verify:** Breeze usually scaffolds this. Check `routes/auth.php`.
2.  **Views:** `forgot-password.blade.php` and `reset-password.blade.php`.
3.  **Testing:** Manually verify the email link generation.

## Tasks/Subtasks
- [x] **Config:** Verify Mail configuration (using `log` driver for local dev).
- [x] **Views:** Customize `forgot-password.blade.php` and `reset-password.blade.php` (Indonesian translations).
- [x] **Logic:** Verify Rate Limiting (3/hour).
- [x] **Testing:** Update `PasswordResetTest.php` to cover rate limiting and token expiry.

## Dev Agent Record

### Implementation Plan
- [x] Check `config/mail.php`
- [x] Update `forgot-password` View (Translation)
- [x] Update `reset-password` View (Translation)
- [x] Implement Rate Limiting in `PasswordResetLinkController`
- [x] Run/Update Tests

### Completion Notes
- Implemented strict Rate Limiting (3 requests/hour) using `RateLimiter::for('password-reset')` in `AppServiceProvider`.
- Applied `throttle:password-reset` middleware to `forgot-password` route.
- Translated `forgot-password.blade.php` and `reset-password.blade.php` to Indonesian.
- Enhanced `PasswordResetTest.php` to verify Rate Limiting functionality and use strong passwords for validation.
- Validated `config/mail.php` uses `log` driver.

## File List
- app/Providers/AppServiceProvider.php
- routes/auth.php
- resources/views/auth/forgot-password.blade.php
- resources/views/auth/reset-password.blade.php
- tests/Feature/Auth/PasswordResetTest.php

## Change Log
- [2025-12-06] Implemented Password Reset Flow (Story 2.4).
- [2025-12-06] Added Rate Limiting and Indonesian Translations.

## Dependencies & Libraries
- Laravel Breeze

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Essential account recovery.
