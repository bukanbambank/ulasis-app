# Story 3.5: Questionnaire Preview & Testing

**Epic:** 3: Questionnaire Creation & QR Code Generation
**Story ID:** 3.5
**Status:** ready-for-dev
**Priority:** Medium

## Description

**As a** restaurant owner,
**I want** to preview questionnaire as customer will see it,
**So that** saya verify UX before deployment.

## Acceptance Criteria

### 1. Preview Trigger
- [ ] "Preview" button on Edit/Detail page.
- [ ] Opens in new tab or modal.
- [ ] URL: `/questionnaires/{id}/preview`.

### 2. Preview Render
- [ ] Display logic identical to Customer Form (Epic 4).
- [ ] Warning Banner: "PREVIEW MODE - Feedback will not be saved".
- [ ] Submission disabled (or mocked).

### 3. Responsiveness
- [ ] Forced mobile-width container (if on desktop) to simulate phone view.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / UI
**Component:** Previewer

- **Reuse:** Should reuse the same Blade component definition as the real Feedback Form to ensure accuracy.

### Developer Guardrails
> [!IMPORTANT]
> **Code Reuse:** Do NOT duplicate the form HTML. Extract the form loop into a Blade Component (e.g., `x-feedback-form`) and use it in both `feedback.show` and `questionnaire.preview`.
> **Security:** Preview route should require Authentication (only Owner sees preview).

### Implementation Steps
1.  **Route:** `GET /questionnaires/{id}/preview`.
2.  **Controller:** `QuestionnaireController@preview`.
3.  **Component:** Extract form logic to `resources/views/components/feedback-form.blade.php`.

## Dependencies & Libraries
- None

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Confidence builder.
