# Story 6.1: Dashboard Home - Overview Statistics

**Epic:** 6: Dashboard & Analytics
**Story ID:** 6.1
**Status:** ready-for-dev
**Priority:** High

## Description

**As a** restaurant owner,
**I want** to see key metrics at a glance when logged in,
**So that** saya understand current performance quickly.

## Acceptance Criteria

### 1. Stats Cards
- [ ] **Overall Sentiment:** Avg Rating (e.g., 4.2), Color Indicator.
- [ ] **Feedback Count:** Total responses + comparison (vs last month).
- [ ] **Response Rate:** (Count / Estimated Scans) - *Note: Estimated scans might be hard to track without a "Scan Counter" middleware on the QR redirect.* (For MVP, maybe just Scan Count if tracked, or omit Rate).
- [ ] **Negative Alerts:** Count of unresolved issues.

### 2. Global Filter
- [ ] Time Period Dropdown (Today, 7 Days, 30 Days, Year).
- [ ] Updates all widgets via AJAX or Page Reload.

### 3. Navigation
- [ ] Quick links to Inbox, Analytics, QR Create.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Data View
**Component:** Dashboard

- **Performance:** Cache statistics for 5-10 minutes (`Cache::remember`).
- **Query:** `FeedbackResponse::where('tenant_id', ...)->whereBetween(...)`.

### Developer Guardrails
> [!IMPORTANT]
> **Optimization:** Do not run heavy aggregations on every page load. Use Caching.
> **Scan Tracking:** To calculate response rate, you need to track "Scans". Ensure the QR redirect route (Story 3.3) increments a `scans` counter on the `QrCode` model.

### Implementation Steps
1.  **Controller:** `DashboardController`.
2.  **Service:** `DashboardService` for heavy lifting.
3.  **View:** `dashboard.blade.php`.

## Dependencies & Libraries
- Chart.js (for mini sparklines if needed)

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** The Pilot's Cockpit.
