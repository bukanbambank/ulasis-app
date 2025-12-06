# Story 6.4: Trend Analysis Time-Series Graph

**Epic:** 6: Dashboard & Analytics
**Story ID:** 6.4
**Status:** ready-for-dev
**Priority:** Medium

## Description

**As a** restaurant owner,
**I want** to see rating trends over time,
**So that** saya monitor if quality improving atau declining.

## Acceptance Criteria

### 1. Visualization
- [ ] Line Chart.
- [ ] X-Axis: Date.
- [ ] Y-Axis: Average Rating (0-5).

### 2. Time Granularity
- [ ] **Last 7 Days/30 Days:** Daily granularity.
- [ ] **Year:** Monthly granularity.
- [ ] Interactive Time Filter.

### 3. Data
- [ ] Plots average rating per day/month.
- [ ] Tooltip shows count and score.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Analytics
**Component:** Trend Graph

- **Library:** Chart.js.
- **Date Handling:** Carbon library for grouping.

### Developer Guardrails
> [!IMPORTANT]
> **Empty Data:** Handle days with 0 feedback (either skip point or connect gaps, usually skip or show 0 count).
> **Query:** `GROUP BY DATE(created_at)`.

### Implementation Steps
1.  **Backend:** Service aggregates data by date interval.
2.  **Frontend:** Render Line Chart.

## Dependencies & Libraries
- Chart.js

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Progress tracking.
