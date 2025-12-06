# Story 4.4: Feedback Submission & QR Attribution

**Epic:** 4: Customer Feedback Collection
**Story ID:** 4.4
**Status:** ready-for-dev
**Priority:** Critical

## Description

**As a** customer,
**I want** to submit my feedback quickly,
**So that** saya dapat continue dengan day saya.

## Acceptance Criteria

### 1. Submission Payload
- [ ] JSON data sent to `POST /feedback/{uuid}`.
- [ ] Includes mapping of `question_id` to `value`.

### 2. Processing
- [ ] Resolves Tenant from QR.
- [ ] Saves to `feedback_responses` table.
- [ ] Stores Ratings JSON.
- [ ] Stores Text Feedback.
- [ ] Links to correct `qr_code_id`.

### 3. Duplicate Prevention
- [ ] Session flag set after submit.
- [ ] Subsequent submits blocked or redirected to Thanks page.

### 4. Redirect
- [ ] Success -> /feedback/thank-you.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Data Ingestion
**Component:** Feedback Controller

- **Optimization:** This is a high-write endpoint. Ensure database inserts are efficient.

### Developer Guardrails
> [!IMPORTANT]
> **Data Loss:** If the insert fails, log it critically.
> **Attribution:** Ensure the `qr_code_id` is saved. This is vital for analytics (Story 3.4).

### Implementation Steps
1.  **Request:** `StoreFeedbackRequest` handles validation.
2.  **Controller:** `store` method.
3.  **Model:** `FeedbackResponse::create()`.

## Dependencies & Libraries
- None

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** The moment of truth.
