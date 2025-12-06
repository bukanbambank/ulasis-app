# Story 6.6: Category Breakdown Analysis

**Epic:** 6: Dashboard & Analytics
**Story ID:** 6.6
**Status:** ready-for-dev
**Priority:** Medium

## Description

**As a** restaurant owner,
**I want** to see which specific aspects performing well/poorly,
**So that** saya focus improvement efforts on weak areas.

## Acceptance Criteria

### 1. Visualization
- [ ] Grouped Bar Chart by Category (Food, Service, Atmosphere).
- [ ] Colors indicate score (Red < 3, Green > 4).

### 2. Drill Down
- [ ] Clicking a bar shows details for that category.
- [ ] Highlights "Lowest Rated Category" with a warning.

### 3. Data Parsing
- [ ] Parses JSON `ratings` to aggregate scores by "Question Label".
- [ ] Merges similar questions if possible (e.g., "Food Taste" and "Kualitas Makanan").

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Analytics
**Component:** Category Chart

- **Complexity:** Parsing JSON to pivot data is CPU intensive. Cache this!

### Developer Guardrails
> [!IMPORTANT]
> **Standardization:** Since users can edit question labels, aggregation might get messy. Group exact matches. Add a note: "Aggregated by Question Text".

### Implementation Steps
1.  **Backend:** Iterator over Feedbacks -> Accumulate scores per Question Key.
2.  **Frontend:** Chart.js Bar Chart.

## Dependencies & Libraries
- Chart.js

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Pinpointing problems.
