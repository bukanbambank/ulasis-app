# Story 2.3: Gmail OAuth Registration & Login

**Epic:** 2: User Authentication & Account Management
**Story ID:** 2.3
**Status:** Done
**Priority:** Medium

## Description

**As a** restaurant owner,
**I want** to register/login menggunakan Gmail account,
**So that** saya tidak perlu remember another password.

## Acceptance Criteria

### 1. OAuth Flow
- [ ] "Sign in with Google" button on Login and Register pages.
- [ ] Redirects to Google Consent Screen.
- [ ] Handles callback (`/auth/google/callback`).

### 2. User Handling
- [ ] **New User:** Creates account using Google email & name. `email_verified_at` auto-set (trusted provider). Random password generated. Auto-logins.
- [ ] **Existing User:** Logs in if email matches. Links `google_id` to existing record.

### 3. Error Handling
- [ ] Handles cancellation or failure gracefully (redirect to login with error message).

### 4. Verification
- [ ] User can login via Google.
- [ ] User table reflects `google_id`.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Auth
**Component:** Socialite

- **Package:** `laravel/socialite`
- **Provider:** Google

### Developer Guardrails
> [!IMPORTANT]
> **Environment Variables:** Do NOT commit `GOOGLE_CLIENT_ID` or `SECRET`. Use `.env`.
> **Tenant Metadata:** If a new user signs up via Google, you MUST still create a `Restaurant` (Tenant) record. You might need to redirect them to an "Onboarding" page to set their Restaurant Name if not provided, OR create a default one (e.g., "My Restaurant"). *Recommendation: Redirect to an onboarding step if restaurant_name is missing, OR auto-create.*

### Implementation Steps
1.  **Install:** `composer require laravel/socialite`.
2.  **Config:** Setup `config/services.php`.
3.  **Migration:** Add `google_id` (string, nullable) and `google_token` (text, nullable, optional) to `users`.
4.  **Controller:** Create `SocialResponseController` (or add methods to Auth controllers).
    - `redirect`: `Socialite::driver('google')->redirect()`
    - `callback`: Handle user creation/lookup.

## Tasks/Subtasks
- [x] **Install:** `composer require laravel/socialite`
- [x] **Config:** Setup `config/services.php` for Google provider
- [x] **Migration:** Add `google_id` to `users` table
- [x] **Controller:** Implement `SocialAuthController` (redirect & callback)
- [x] **UI:** Add "Sign in with Google" button to Login/Register pages
- [x] **Testing:** Create/Update `SocialAuthTest.php`

## Dev Agent Record

### Implementation Plan
- [x] Install Socialite
- [x] Create Migration for `google_id`
- [x] Configure `services.php`
- [x] Implement `SocialAuthController`
    - [x] Handle new user registration (auto-create Tenant?)
    - [x] Link existing users
- [x] Update Login/Register Blade Views
- [x] Test Implementation

### Completion Notes
- Integrated `laravel/socialite` for Google OAuth.
- Implemented `SocialAuthController` with automatic Tenant/Restaurant creation ("My Restaurant (Default)") for new users.
- Added UI buttons to Login and Register views.
- Verified flow with Mocked `SocialAuthTest`.
- Added `google_id` to `User` `$fillable`.

## File List
- config/services.php
- database/migrations/2025_12_06_075442_add_google_id_to_users_table.php
- app/Models/User.php
- app/Http/Controllers/Auth/SocialAuthController.php
- routes/auth.php
- resources/views/auth/login.blade.php
- resources/views/auth/register.blade.php
- tests/Feature/Auth/SocialAuthTest.php

## Change Log
- [2025-12-06] Implemented Google OAuth Registration & Login (Story 2.3).
- [2025-12-06] Configured default Tenant creation for social sign-ups.

## Dependencies & Libraries
- `laravel/socialite`

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Convenience feature.
