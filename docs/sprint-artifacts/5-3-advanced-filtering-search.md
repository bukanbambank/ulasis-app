# Story 5.3: Advanced Filtering & Search

**Epic:** 5: Feedback Inbox & Management
**Story ID:** 5.3
**Status:** ready-for-dev
**Priority:** Medium

## Description

**As a** restaurant owner,
**I want** to filter feedback by various criteria,
**So that** saya dapat find specific feedback quickly.

## Acceptance Criteria

### 1. Filter Options
- [ ] **Status:** Baru, Dalam Proses, Selesai.
- [ ] **Date Range:** From/To date pickers.
- [ ] **QR Source:** Dropdown of available QRs.
- [ ] **Sentiment:** Positive, Neutral, Negative.

### 2. Behavior
- [ ] Results update when filters applied.
- [ ] Active filters displayed as "Chips" (can close to remove).
- [ ] Empty state handles "No results found for these filters".

### 3. Search
- [ ] Search input for text feedback content.
- [ ] Debounced search.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Data View
**Component:** Filter Engine

- **Logic:** Eloquent scopes (`scopeFiltered`).
- **State:** Keep filter params in URL (`?status=baru&date=...`) for shareability, or partial refresh.

### Developer Guardrails
> [!IMPORTANT]
> **Performance:** Ensure database indexes exist for commonly filtered columns (`status`, `created_at`, `qr_code_id`).
> **UI:** On mobile, hide filters behind a "Filter" button/drawer.

### Implementation Steps
1.  **Backend:** Add `scopeFilter` to `FeedbackResponse`.
2.  **Frontend:** Alpine.js state derived from URL params.

## Dependencies & Libraries
- None (or Flatpickr for dates)

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Finding needles in haystacks.

## Implementation Update
- **Date**: 2025-12-06
- **Note**: Added search and status query parameters to FeedbackInboxController.
