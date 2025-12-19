# Story 6.3: QR Code Performance Comparison

**Epic:** 6: Dashboard & Analytics
**Story ID:** 6.3
**Status:** ready-for-dev
**Priority:** Medium

## Description

**As a** restaurant owner,
**I want** to compare feedback ratings by QR code location,
**So that** saya identify which areas performing best/worst.

## Acceptance Criteria

### 1. Visualization
- [ ] Horizontal Bar Chart.
- [ ] Y-Axis: QR Names (Location).
- [ ] X-Axis: Average Rating.
- [ ] Color Coding: Green (High), Yellow (Mid), Red (Low).

### 2. Data
- [ ] Aggregates feedback grouped by `qr_code_id`.
- [ ] Shows "Sample Size" (e.g., "(45)" next to bar).

### 3. Insights
- [ ] Highlight Highest vs Lowest performing area.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Analytics
**Component:** Perf Chart

- **Library:** Chart.js.
- **SQL:** `GROUP BY qr_code_id`.

### Developer Guardrails
> [!IMPORTANT]
> **Threshold:** If a QR code has very few responses (< 5), maybe gray it out or add an asterisk so the owner doesn't panic over 1 bad review.

### Implementation Steps
1.  **Backend:** Query aggregated data.
2.  **Frontend:** Render chart.

## Dependencies & Libraries
- Chart.js

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Place-based optimization.

## Implementation Update
- **Date**: 2025-12-06
- **Note**: Data integration complete.
