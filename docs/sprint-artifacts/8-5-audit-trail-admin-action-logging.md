# Story 8.5: Audit Trail & Admin Action Logging

**Epic:** 8: Admin Platform Management
**Story ID:** 8.5
**Status:** ready-for-dev
**Priority:** Low

## Description

**As a** platform administrator,
**I want** to review audit logs of all admin actions,
**So that** saya maintain security dan accountability.

## Acceptance Criteria

### 1. Logging
- [ ] Automatically log critical actions (Suspend, Delete, Activate).
- [ ] Store: Admin ID, Action, Target ID, Timestamp, IP.

### 2. Viewing
- [ ] Table of Logs.
- [ ] Filter by Admin or Action Type.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Security
**Component:** Auditor

- **Middleware:** `LogAdminAction`.

### Developer Guardrails
> [!IMPORTANT]
> **Performance:** This table grows fast. Index the timestamp.
> **Scope:** Log only ADMIN actions for now, not every user action.

### Implementation Steps
1.  **Model:** `AuditLog`.
2.  **Middleware:** Intercept requests to admin routes and log destructive methods (POST/PUT/DELETE).

## Dependencies & Libraries
- None

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Accountability.

## Implementation Update
- **Date**: 2025-12-06
- **Note**: Created AuditLog model and Admin\AuditLogController.
