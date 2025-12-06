# Story 2.3: Gmail OAuth Registration & Login

**Epic:** 2: User Authentication & Account Management
**Story ID:** 2.3
**Status:** ready-for-dev
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

## Dependencies & Libraries
- `laravel/socialite`

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Convenience feature.
