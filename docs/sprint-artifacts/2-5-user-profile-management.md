# Story 2.5: User Profile Management

**Epic:** 2: User Authentication & Account Management
**Story ID:** 2.5
**Status:** ready-for-dev
**Priority:** Medium

## Description

**As a** restaurant owner,
**I want** to view dan update my profile information,
**So that** platform reflects current restaurant details.

## Acceptance Criteria

### 1. View Profile
- [ ] Page: `/profile` (Breeze default).
- [ ] Displays: Name (Owner), Email, Restaurant Name (Tenant info), Logo.

### 2. Update Profile Info
- [ ] Editable fields: Owner Name, Restaurant Name, Email.
- [ ] **Email Change:** Verification required. New email stored as `pending_email` (or standard Laravel "must verify" flow) until verified. Old email remains active.
- [ ] **Restaurant Name:** Updates `restaurants` table.

### 3. Logo Upload
- [ ] Upload image (JPG/PNG, max 2MB).
- [ ] Cropping tool (optional/nice-to-have, or just resize).
- [ ] Stored in `public/logos` (via Storage link).
- [ ] Updates `restaurants` table `logo_path`.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Features
**Component:** User Settings

- **Library:** `intervention/image` (if cropping/resizing needed).
- **Storage:** `public` disk.

### Developer Guardrails
> [!IMPORTANT]
> **Tenant Data:** Updating "Restaurant Name" updates the *Tenant* record, not the User record. Ensure the Controller handles this relationship correctly (`$user->restaurant->update(...)`).
> **Storage Link:** Ensure `php artisan storage:link` is run.

### Implementation Steps
1.  **View:** Customize `resources/views/profile/edit.blade.php`.
2.  **Controller:** `ProfileController`. Add method for updating Restaurant details.
3.  **Request:** Validation rules for logo (dimensions, size).

## Dependencies & Libraries
- Laravel Breeze
- `intervention/image` (optional, recommended for optimization)

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Managing identity.
