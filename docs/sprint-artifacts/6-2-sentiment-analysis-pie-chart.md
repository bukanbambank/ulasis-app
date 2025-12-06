# Story 6.2: Sentiment Analysis Pie Chart

**Epic:** 6: Dashboard & Analytics
**Story ID:** 6.2
**Status:** ready-for-dev
**Priority:** Medium

## Description

**As a** restaurant owner,
**I want** to see sentiment distribution visualization,
**So that** saya understand overall customer satisfaction breakdown.

## Acceptance Criteria

### 1. Visualization
- [ ] Pie/Doughnut Chart: Positive (Green), Neutral (Yellow), Negative (Red).
- [ ] Legend with Counts and Percentages.

### 2. Logic
- [ ] Positive: >= 4 stars.
- [ ] Neutral: 3 stars.
- [ ] Negative: <= 2 stars.
- [ ] Aggregates all ratings from feedback within Selected Date Range.

### 3. Interaction
- [ ] Hover tooltips.
- [ ] Clicking a segment redirects to Inbox filtered by that sentiment (Optional enhancement).

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Analytics
**Component:** Sentiment Chart

- **Library:** Chart.js.
- **Data Source:** Aggregated `ratings` JSON from `FeedbackResponse`.

### Developer Guardrails
> [!IMPORTANT]
> **Data Parsing:** Since ratings are JSON, you might need to iterate in PHP or use a JSON-capable database query (MySQL 5.7+ supports `JSON_EXTRACT`).
> **Performance:** If iterating in PHP, chunk the results.

### Implementation Steps
1.  **View:** `analytics.index.blade.php`.
2.  **JS:** Initialize Chart.js instance.

## Dependencies & Libraries
- Chart.js

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Visual summary.
