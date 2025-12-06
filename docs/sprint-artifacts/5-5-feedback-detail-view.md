# Story 5.5: Feedback Detail View

**Epic:** 5: Feedback Inbox & Management
**Story ID:** 5.5
**Status:** ready-for-dev
**Priority:** Medium

## Description

**As a** restaurant owner,
**I want** to see complete feedback details dengan all context,
**So that** saya fully understand customer's experience.

## Acceptance Criteria

### 1. View Page
- [ ] Route: `/inbox/{id}`.
- [ ] Displays:
    - Customer Text (Full).
    - Ratings Breakdown (per Question).
    - Metadata (Date, QR Source).
    - Status History.

### 2. Actions
- [ ] Change Status.
- [ ] Delete (soft/hard).
- [ ] Back to Inbox button.

### 3. Layout
- [ ] Responsive stacked layout.
- [ ] Readable typography for long text.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / View
**Component:** Detail Card

- **Reusability:** Reuse `rating-display` components.

### Developer Guardrails
> [!IMPORTANT]
> **Context:** Show the **Question Text** alongside the rating value, so the user knows what "3 Stars" refers to.
> **Navigation:** Ensure "Back" button preserves previous filters/pagination filters if possible (check `url()->previous()`).

### Implementation Steps
1.  **Controller:** `show` method.
2.  **View:** `resources/views/inbox/show.blade.php`.

## Dependencies & Libraries
- None

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Deep dive.
