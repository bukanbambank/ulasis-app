# Story 5.4: Alert System untuk Negative Feedback

**Epic:** 5: Feedback Inbox & Management
**Story ID:** 5.4
**Status:** ready-for-dev
**Priority:** High

## Description

**As a** restaurant owner,
**I want** to be alerted about negative feedback immediately,
**So that** saya dapat address problems quickly.

## Acceptance Criteria

### 1. Detection
- [ ] Threshold: Rating <= 2 stars (or configurable).
- [ ] Priority: Flagged as "High Priority".

### 2. UI Persistence
- [ ] **Inbox:** Highlighted row (Red border or Badge).
- [ ] **Dashboard:** Widget showing count of unresolved negative feedback.
- [ ] **Navigation:** Notification badge on "Inbox" link.

### 3. Resolution
- [ ] Changing status to "Resolved" removes the urgent alert/badge.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / logic
**Component:** Alerting

- **Calculation:** Compute `is_negative` attribute on the Model level or saved to DB.

### Developer Guardrails
> [!IMPORTANT]
> **Optimization:** Do not re-calculate "Negative Count" on every page load repeatedly if expensive. Cache it or use a fast query (`count where status != 'resolved' and rating <= 2`).
> **Notifications:** Email alerts are Post-MVP but you can stub the Job now.

### Implementation Steps
1.  **Model:** Accessor `getIsNegativeAttribute`.
2.  **View:** Blade conditional classes for row styling.

## Dependencies & Libraries
- None

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Service recovery tool.
