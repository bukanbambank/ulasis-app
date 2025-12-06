# Story 3.1: Pre-Built Questionnaire Templates

**Epic:** 3: Questionnaire Creation & QR Code Generation
**Story ID:** 3.1
**Status:** ready-for-dev
**Priority:** High

## Description

**As a** restaurant owner,
**I want** to pilih dari pre-built questionnaire templates,
**So that** saya tidak perlu design questions from scratch.

## Acceptance Criteria

### 1. Template Selection
- [ ] Page: `/questionnaires/create`.
- [ ] Displays 3 templates:
    1.  **Casual Dining** (Food, Service, Hygiene, Value).
    2.  **Café** (Drink, Food, Speed, Ambience).
    3.  **Fast Food** (Taste, Speed, Hygiene, Accuracy).
- [ ] Each card shows Title, Icon, Preview Thumbnail.

### 2. Creation Process
- [ ] Clicking "Use Template" creates a new `Questionnaire` record.
- [ ] `questions` column (JSON) populated with template data.
- [ ] `template_type` stored (e.g., 'cafe').
- [ ] `title` defaulted to Template Name (e.g., "Café Feedback Form").
- [ ] Redirects to Edit Page (`/questionnaires/{id}/edit`).

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Features
**Component:** Questionnaire Engine

- **Data Structure:** Questions stored as JSON array.
- **Controller:** `QuestionnaireController`.

### Developer Guardrails
> [!IMPORTANT]
> **Seed Data:** Define the templates in a config file (`config/templates.php`) or a Seeder/Service so they are reusable and don't muddy the controller.
> **Tenant Scope:** Ensure the created record belongs to the current Tenant (`Restaurant`).

### Implementation Steps
1.  **Config:** Create `config/questionnaire_templates.php`.
2.  **Controller:** `store` method reads template key matches config -> saves to DB.

## Dependencies & Libraries
- None

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Lowers entry barrier for users.
