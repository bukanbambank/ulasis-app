# Story 7.4: Support Ticket Submission & Tracking

**Epic:** 7: Reports & User Settings
**Story ID:** 7.4
**Status:** ready-for-dev
**Priority:** Low

## Description

**As a** restaurant owner,
**I want** to submit support tickets when saya encounter issues,
**So that** saya can get help from platform admin.

## Acceptance Criteria

### 1. Submission
- [ ] Form: Subject, Category, Message, Attachments.
- [ ] Generates ID `TICKET-{Ymd}-{Rand}`.

### 2. Tracking
- [ ] List View: ID, Subject, Status (Open/Closed).
- [ ] Detail View: Thread history of responses.

### 3. Notifications
- [ ] Email on submission.
- [ ] Email when Admin responds (Story 8.3).

## Technical Implementation Context

### Architecture Compliance
**Layer:** Shared / Support
**Component:** Ticket System

- **Storage:** Private storage for attachments (not public).

### Developer Guardrails
> [!IMPORTANT]
> **Scope:** This is a simple MVP ticketing system. Don't build Zendesk. Threaded comments + Status is enough.

### Implementation Steps
1.  **Model:** `SupportTicket`.
2.  **Controller:** `SupportTicketController`.

## Dependencies & Libraries
- None

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Lifeline.
