# Story 8.2: Account Administration - Suspend/Activate Users

**Epic:** 8: Admin Platform Management
**Story ID:** 8.2
**Status:** ready-for-dev
**Priority:** Medium

## Description

**As a** platform administrator,
**I want** to suspend atau activate user accounts,
**So that** saya can manage abusive accounts atau billing issues.

## Acceptance Criteria

### 1. Actions
- [ ] **Suspend:** Sets status to `suspended`. Kills sessions.
- [ ] **Activate:** Restores status to `active`.

### 2. Logic
- [ ] Suspended users cannot login (Middleware check).
- [ ] Reason logged in Audit Log (Story 8.5).

### 3. Notification
- [ ] Email sent to user upon suspension.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Admin
**Component:** User Status

- **Guard:** Update `LoginController` to check status.

### Developer Guardrails
> [!IMPORTANT]
> **Safety:** Admin cannot suspend *themselves* or other Admins (prevent lockout).

### Implementation Steps
1.  **Controller:** `Admin\UserController@suspend`.
2.  **Middleware:** Update `Authenticate` (or new Global middleware) to catch suspended users.

## Dependencies & Libraries
- None

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Ban hammer.

## Implementation Update
- **Date**: 2025-12-06
- **Note**: Implemented suspend and ctivate methods in Admin\UserController.
