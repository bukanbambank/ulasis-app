# Story 4.3: Form Interaction & Validation

**Epic:** 4: Customer Feedback Collection
**Story ID:** 4.3
**Status:** ready-for-dev
**Priority:** Medium

## Description

**As a** customer,
**I want** clear validation feedback,
**So that** saya tahu jika ada required field yang missing.

## Acceptance Criteria

### 1. Requirements Logic
- [ ] Required questions marked visually (*).
- [ ] Submit button disabled/greyed until valid (optional, or error on click).

### 2. Validation UI
- [ ] On Submit attempt: Highlight missing fields in Red.
- [ ] Scroll to first error.
- [ ] Text fields: Max char count with visual indicator (e.g., 450/500 turns yellow).

### 3. Error Handling
- [ ] Friendly error messages in Indonesian.
- [ ] Network errors allow retry without losing data.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / UI Logic
**Component:** Form Validator

- **Frontend:** Alpine.js client-side validation for instant feedback.
- **Backend:** Request Validation (safety net).

### Developer Guardrails
> [!IMPORTANT]
> **UX:** Do not frustrate the user using mobile. Auto-scrolling to errors is key.
> **Language:** Use natural Indonesian phrasing ("Mohon isi bagian ini"), not robotic computer errors.

### Implementation Steps
1.  **Logic:** Add `validate()` method in Alpine component.
2.  **UI:** Error message divs toggled by Alpine state.

## Dependencies & Libraries
- Alpine.js

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Reducing drop-off.
