# Story 5.2: Status Management Workflow

**Epic:** 5: Feedback Inbox & Management
**Story ID:** 5.2
**Status:** ready-for-dev
**Priority:** Medium

## Description

**As a** restaurant owner,
**I want** to update feedback status to track resolution progress,
**So that** saya tahu which feedback needs action.

## Acceptance Criteria

### 1. Status States
- [ ] Enum: `Baru`, `Dalam Proses`, `Selesai`.
- [ ] Default on create: `Baru`.

### 2. UI Actions
- [ ] Dropdown/Select on Inbox row to change status.
- [ ] Updates via AJAX without page reload.
- [ ] Visual update (Badge color changes: Blue -> Yellow -> Green).

### 3. Bulk Actions (Optional but requested)
- [ ] Select multiple rows -> "Mark as Resolved".

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Workflow
**Component:** Status Engine

- **Tech:** Alpine.js for frontend interaction, API endpoint for update.

### Developer Guardrails
> [!IMPORTANT]
> **Validation:** Ensure only valid enum values are accepted.
> **Feedback:** Show a Toast notification on success ("Status Updated").

### Implementation Steps
1.  **Route:** `PUT /inbox/{id}/status`.
2.  **Controller:** `updateStatus` method.

## Dependencies & Libraries
- Alpine.js

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Workflow tracking.

## Implementation Update
- **Date**: 2025-12-06
- **Note**: Implemented status logic in Controller.
