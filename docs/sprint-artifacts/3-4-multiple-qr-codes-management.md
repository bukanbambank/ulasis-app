# Story 3.4: Multiple QR Codes Management

**Epic:** 3: Questionnaire Creation & QR Code Generation
**Story ID:** 3.4
**Status:** ready-for-dev
**Priority:** Medium

## Description

**As a** restaurant owner,
**I want** to manage multiple QR codes untuk different locations,
**So that** saya dapat track feedback by location (meja indoor/outdoor, kasir, etc).

## Acceptance Criteria

### 1. QR Code List
- [ ] Page: `/qr-codes`.
- [ ] Table shows: Thumbnail, Name, Questionnaire Title, Status, Scan Count.
- [ ] Actions: View, Edit, Deactivate/Activate, Delete, Download.

### 2. Management Features
- [ ] **Edit:** Rename label, Switch Questionnaire (keeps same QR image/ID).
- [ ] **Deactivate:** Sets `is_active` to false. Scanning shows "Inactive" message (handled in Epic 4).
- [ ] **Delete:** Soft delete or Hard delete (safeguard against feedback data loss).
- [ ] **Create:** Link to Story 3.3 flow.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Features
**Component:** QR Manager

- **Controller:** `QrCodeController`.
- **Relationship:** `Restaurant` -> `QrCodes`.

### Developer Guardrails
> [!IMPORTANT]
> **Data Integrity:** Deleting a QR code should ideally be Soft Delete if it has associated feedback, or blocked.
> **ID Persistence:** A QR code's Unique ID (UUID) must NEVER change after creation, otherwise printed materials become useless. Even if re-assigned to a different Questionnaire, the UUID stays same.

### Implementation Steps
1.  **View:** `index.blade.php`.
2.  **Controller:** Implement `index`, `update`, `destroy`.

## Dependencies & Libraries
- None

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Scaling up usage.
