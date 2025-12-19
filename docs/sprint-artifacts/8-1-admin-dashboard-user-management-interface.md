# Story 8.1: Admin Dashboard - User Management Interface

**Epic:** 8: Admin Platform Management
**Story ID:** 8.1
**Status:** ready-for-dev
**Priority:** High

## Description

**As a** platform administrator,
**I want** to view dan manage all registered restaurant accounts,
**So that** saya can provide support dan maintain platform health.

## Acceptance Criteria

### 1. Requirements
- [ ] List all Users (Restaurants).
- [ ] Columns: Name, Email, Status, Registered Date.
- [ ] Pagination & Search (by Name/Email).

### 2. Actions
- [ ] View Details (redirect to detail page).
- [ ] Suspend functionality (Story 8.2).

### 3. Protection
- [ ] Route protected by `admin` middleware.
- [ ] Non-admins redirected to home.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Admin
**Component:** User Manager

- **Middleware:** Create `EnsureUserIsAdmin`.
- **Role:** Add `is_admin` column to `users` table default 0.

### Developer Guardrails
> [!IMPORTANT]
> **Privacy:** Admins can see user emails but passwords must remain hashed/invisible.
> **Seeding:** Ensure `DatabaseSeeder` creates at least 1 Admin account.

### Implementation Steps
1.  **Migration:** Add `is_admin` to users.
2.  **Middleware:** `IsAdmin`.
3.  **Controller:** `Admin\UserController`.

## Dependencies & Libraries
- None

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** The God Mode.

## Implementation Update
- **Date**: 2025-12-06
- **Note**: Created Admin\UserController and dmin/users/index view.
