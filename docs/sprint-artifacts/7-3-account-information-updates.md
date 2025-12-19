# Story 7.3: Account Information Updates

**Epic:** 7: Reports & User Settings
**Story ID:** 7.3
**Status:** ready-for-dev
**Priority:** Medium

## Description

**As a** restaurant owner,
**I want** to update my account information,
**So that** platform data stays current.

## Acceptance Criteria

### 1. Editable Fields
- [ ] Restaurant Name, Owner Name, Phone, Address.
- [ ] Email (Special flow).

### 2. Email Change Verification
- [ ] If email changes, send "Verify New Email" link to NEW address.
- [ ] Send notification to OLD address.
- [ ] Update only after click.

### 3. Validation
- [ ] Phone number format (Indonesian 08.../+62...).
- [ ] Unique constraints checks.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Profile
**Component:** User Settings

- **Security:** Re-enter password might be required for email change (standard security practice).

### Developer Guardrails
> [!IMPORTANT]
> **Logic:** While "pending email" exists, do not assume it's valid. Keep `email` column as the working address until verified.

### Implementation Steps
1.  **Request:** `ProfileUpdateRequest`.
2.  **Controller:** `ProfileController`.

## Dependencies & Libraries
- None

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Maintenance.

## Implementation Update
- **Date**: 2025-12-06
- **Note**: Updated ProfileController for phone/address fields.
