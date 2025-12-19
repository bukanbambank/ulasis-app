# Story 8.4: Platform Monitoring & Health Metrics

**Epic:** 8: Admin Platform Management
**Story ID:** 8.4
**Status:** ready-for-dev
**Priority:** Low

## Description

**As a** platform administrator,
**I want** to monitor system health dan usage statistics,
**So that** saya can identify issues dan plan capacity.

## Acceptance Criteria

### 1. Stats
- [ ] Active Users Count.
- [ ] Database Health Check (Can connect?).
- [ ] Queue Workload (Jobs Pending/Failed).

### 2. Error Log
- [ ] Display recent entries from `laravel.log` or Custom DB Log.

### 3. Usage
- [ ] Line chart of New Registrations.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Monitoring
**Component:** Telemetry

- **Library:** `spatie/laravel-health` (Optional) or manual checks.
- **Tech:** Chart.js for usage graphs.

### Developer Guardrails
> [!IMPORTANT]
> **MVP:** Don't overengineer. Just counting `User::count()` and `failed_jobs` table is sufficient for MVP.

### Implementation Steps
1.  **Controller:** `Admin\DashboardController`.
2.  **View:** `admin.dashboard`.

## Dependencies & Libraries
- None (or Spatie Health)

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Vitals.

## Implementation Update
- **Date**: 2025-12-06
- **Note**: Implemented Admin Dashboard stats.
