# Story 2.2: Login dengan Session Management

**Epic:** 2: User Authentication & Account Management
**Story ID:** 2.2
**Status:** Done
**Priority:** High

## Description

**As a** restaurant owner,
**I want** to login dengan email dan password,
**So that** saya dapat access my dashboard.

## Acceptance Criteria

### 1. Login Form
- [ ] Fields: `Email`, `Password`, `Remember Me` checkbox.
- [ ] Rate limiting: 5 attempts per minute per IP. Throttled for 1 minute after lockout.

### 2. Authentication Logic
- [ ] Validates credentials against `users` table.
- [ ] Checks `email_verified_at` (must be verified or redirected to verification notice).
- [ ] Creates Session (File driver).
- [ ] Redirects to Dashboard upon success.

### 3. Session Features
- [ ] "Remember Me" extends session lifetime (default 2 weeks).
- [ ] Secure Cookies enabled in production (`SameSite=Lax`, `Secure`).
- [ ] Concurrent sessions allowed.
- [ ] Idle timeout (config: 30-120 mins).

### 4. Logout
- [ ] POST `/logout` destroys session.
- [ ] Redirects to Landing Page (or Login).

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Auth
**Component:** Session Manager

- **Driver:** `file` (compatible with cPanel).
- **Security:** CSRF tokens required.

### Developer Guardrails
> [!IMPORTANT]
> **Verification Check:** Ensure the `verified` middleware is applied to dashboard routes so unverified users cannot access them.
> **Redirects:** Update `RouteServiceProvider::HOME` (or `App/Providers/RouteServiceProvider`) to point to `/dashboard`.

### Implementation Steps
1.  **Config:** Verify `config/session.php`.
2.  **Controller:** Breeze `AuthenticatedSessionController` usually handles this.
3.  **View:** `resources/views/auth/login.blade.php`.
4.  **Middleware:** Ensure `auth` and `verified` group used for protected routes.

## Tasks/Subtasks
- [x] **Config:** Verify `config/session.php` for file driver and secure cookies
- [x] **Controller:** Configure `AuthenticatedSessionController` updates (if needed)
- [x] **View:** Verify `login.blade.php` fields and Remember Me
- [x] **Middleware:** Enforce `auth` and `verified` middleware on dashboard routes
- [x] **Testing:** Create/Update `AuthenticationTest.php` to cover session requirements

## Dev Agent Record

### Implementation Plan
- [x] Check `config/session.php`
- [x] Review `AuthenticatedSessionController`
- [x] Check `login.blade.php`
- [x] Update `web.php` routes
- [x] Run Tests

### Completion Notes
- Configured `config/session.php` with 2-week lifetime and secure defaults.
- Validated `LoginRequest` includes rate limiting (5 attempts/min).
- Verified `authentication` and `verified` middleware in `web.php`.
- Enhanced `AuthenticationTest.php` to verify Rate Limiting, Remember Me, and Session errors.
- Confirmed all Acceptance Criteria met.

## File List
- config/session.php
- app/Http/Requests/Auth/LoginRequest.php
- resources/views/auth/login.blade.php
- routes/web.php
- tests/Feature/Auth/AuthenticationTest.php

## Change Log
- [2025-12-06] Implemented Login with Session Management (Story 2.2).
- [2025-12-06] Enhanced Security: 2-week session lifetime, Rate Limiting, Secure Cookies.
- [2025-12-06] Code Review Fix: Reverted session `lifetime` to 120 mins to match AC "Idle timeout". `Remember Me` cookie handles long-term persistence.

## Dependencies & Libraries
- Laravel Breeze

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Standard secure login.
