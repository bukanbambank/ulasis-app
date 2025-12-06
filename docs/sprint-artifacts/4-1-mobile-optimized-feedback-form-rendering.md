# Story 4.1: Mobile-Optimized Feedback Form Rendering

**Epic:** 4: Customer Feedback Collection
**Story ID:** 4.1
**Status:** ready-for-dev
**Priority:** Critical

## Description

**As a** customer,
**I want** to see feedback form optimized untuk my smartphone,
**So that** saya dapat easily complete form after scanning QR code.

## Acceptance Criteria

### 1. Public Access
- [ ] Route: `/feedback/{uuid}` (scanned from QR).
- [ ] No Login Required.
- [ ] If UUID invalid/inactive, show friendly "Form Inactive" message.

### 2. Mobile Layout
- [ ] Viewport meta tag configured.
- [ ] Container max-width ~640px.
- [ ] Full-width buttons.
- [ ] Fast load (<2s).

### 3. Content Display
- [ ] Restaurant Name/Logo (from Tenant).
- [ ] Introduction/Welcome text.
- [ ] Questions rendered based on JSON structure.
- [ ] Submit button at bottom.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / UI
**Component:** Feedback Form

- **Tech:** Blade (Server Rendered) + Alpine.js (Interactivity).
- **Styling:** Tailwind CSS (Mobile First).

### Developer Guardrails
> [!IMPORTANT]
> **Performance:** This is the most critical page. Minimize JS bundles. Don't load heavy analytics scripts yet.
> **Security:** The UUID must be unguessable. Rate limit per IP to prevent spam (Story 2.2 mentioned rate limits, apply here too).

### Implementation Steps
1.  **Route:** `routes/web.php` (outside auth group).
2.  **Controller:** `FeedbackController`.
3.  **View:** `resources/views/feedback/show.blade.php`.

## Dependencies & Libraries
- Alpine.js

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** The "Face" of the product to customers.
