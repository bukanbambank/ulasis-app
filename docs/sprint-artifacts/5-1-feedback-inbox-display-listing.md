# Story 5.1: Feedback Inbox Display & Listing

**Epic:** 5: Feedback Inbox & Management
**Story ID:** 5.1
**Status:** ready-for-dev
**Priority:** High

## Description

**As a** restaurant owner,
**I want** to view all customer feedback dalam organized inbox,
**So that** saya dapat review dan respond to customer input.

## Acceptance Criteria

### 1. Data Source
- [ ] Fetches `FeedbackResponses` scoped by `Tenant`.
- [ ] Loads relationships: `QrCode`, (optional) `Questionnaire`.

### 2. UI Layout
- [ ] **Table View:**
    - Date, QR Source, Rating Summary (Score), Status, Snippet of text.
- [ ] **Pagination:** 20 items per page.
- [ ] **Sorting:** Newest first.
- [ ] **Sentiment Indicator:** Visual cue (Color code or Icon) based on rating.

### 3. Performance
- [ ] Eager loading (`with('qrCode')`) to prevent N+1 queries.
- [ ] Fast load time (< 2s).

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Data View
**Component:** Inbox

- **Controller:** `InboxController@index`.
- **Query:** Eloquent model with pagination.

### Developer Guardrails
> [!IMPORTANT]
> **Data Privacy:** Ensure STRICT tenant scoping. User A must never see User B's feedback. Use the global scope from Story 1.2.
> **Sentiment Logic:** Calculate sentiment on the fly or via attribute: `< 3` (Red), `== 3` (Yellow), `> 3` (Green).

### Implementation Steps
1.  **View:** `resources/views/inbox/index.blade.php`.
2.  **Styles:** Tailwind table classes.

## Dependencies & Libraries
- None

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Daily operations hub.
