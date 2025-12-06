# Story 2.6: Password Change dari Settings

**Epic:** 2: User Authentication & Account Management
**Story ID:** 2.6
**Status:** ready-for-dev
**Priority:** Low

## Description

**As a** restaurant owner,
**I want** to change my password dari account settings,
**So that** saya dapat maintain account security.

## Acceptance Criteria

### 1. Update Password Form
- [ ] Located in `/profile` (Breeze default).
- [ ] Fields: Current Password, New Password, Confirm New Password.

### 2. Logic
- [ ] Validates Current Password matches DB.
- [ ] Validates New Password strength.
- [ ] Updates password hash.
- [ ] Invalidates *other* sessions (optional security feature).
- [ ] Sends "Password Changed" email notification.

### 3. UX
- [ ] Success message flash.
- [ ] Validation errors inline.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Auth
**Component:** Credential Management

- **Feature:** Laravel Breeze built-in.

### Developer Guardrails
> [!IMPORTANT]
> **Validation:** Ensure strict password rules apply here too.

### Implementation Steps
1.  **Verify:** Breeze `ProfileController` and `update-password-form.blade.php`.
2.  **Enhance:** Add Email Notification job dispatch if not present.

## Dependencies & Libraries
- Laravel Breeze

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Routine security hygiene.
