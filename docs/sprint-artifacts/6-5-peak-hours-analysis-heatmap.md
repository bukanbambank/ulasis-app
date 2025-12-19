# Story 6.5: Peak Hours Analysis Heatmap

**Epic:** 6: Dashboard & Analytics
**Story ID:** 6.5
**Status:** ready-for-dev
**Priority:** Medium

## Description

**As a** restaurant owner,
**I want** to identify when negative/positive feedback occurs,
**So that** saya optimize staffing dan quality control timing.

## Acceptance Criteria

### 1. Visualization
- [ ] Heatmap (Time vs Day) OR Hourly Bar Chart.
- [ ] Shows "Hot" zones (bad ratings) vs "Cold/Good" zones (good ratings).

### 2. Time Buckets
- [ ] Groups feedback by Hour of Day.
- [ ] Option to split by Weekday vs Weekend.

### 3. Insights
- [ ] Basic recommendation engine: "Warning: Low ratings at 12:00-14:00".

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Analytics
**Component:** Heatmap

- **Query:** `GROUP BY HOUR(created_at)`.
- **UI:** Chart.js Matrix Plugin or simple CSS Grid Heatmap.

### Developer Guardrails
> [!IMPORTANT]
> **Data Density:** Heatmaps need a lot of data to look good. For new accounts, maybe default to a simpler Bar Chart ("Average Rating by Hour") until volume increases.

### Implementation Steps
1.  **Backend:** Query hourly averages.
2.  **Frontend:** Render Heatmap/Bar chart.

## Dependencies & Libraries
- Chart.js

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Operational efficiency.

## Implementation Update
- **Date**: 2025-12-06
- **Note**: Logic included in Dashboard stats.
