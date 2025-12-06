# Story 3.2: Questionnaire Customization & Editing

**Epic:** 3: Questionnaire Creation & QR Code Generation
**Story ID:** 3.2
**Status:** ready-for-dev
**Priority:** High

## Description

**As a** restaurant owner,
**I want** to customize questionnaire questions,
**So that** angket reflects specific needs restaurant saya.

## Acceptance Criteria

### 1. Editor UI
- [ ] Page: `/questionnaires/{id}/edit`.
- [ ] List of questions (drag-and-drop reordering).
- [ ] Edit/Delete buttons per question.
- [ ] "Add Question" button.

### 2. Question Editing
- [ ] Fields: Text, Type (Rating/Binary/Text), Required, Visual (Stars/Emoji).
- [ ] Updates `questions` JSON in database.
- [ ] Validation: Min 1 question required.

### 3. State Management
- [ ] Uses Alpine.js (or similar) for local state before saving.
- [ ] "Save" button commits changes via PUT request.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Features
**Component:** Questionnaire Editor

- **Frontend:** Alpine.js (recommended for JSON array manipulation).
- **Validation:** Server-side validation of the JSON structure.

### Developer Guardrails
> [!IMPORTANT]
> **JSON Validation:** Use Laravel's validation rules for arrays (e.g., `'questions.*.text' => 'required'`).
> **Security:** Verify `tenant_id` matches logged-in user before update.

### Implementation Steps
1.  **View:** `edit.blade.php` with Alpine `x-data="{ questions: @js($questionnaire->questions) }"`.
2.  **Controller:** `update` method.

## Dependencies & Libraries
- Alpine.js (Sortable.js optional for drag-drop)

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Core feature.
