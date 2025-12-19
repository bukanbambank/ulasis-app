# Story 7.2: Profile Photo/Logo Management

**Epic:** 7: Reports & User Settings
**Story ID:** 7.2
**Status:** ready-for-dev
**Priority:** Medium

## Description

**As a** restaurant owner,
**I want** to upload dan manage my restaurant logo,
**So that** branding appears consistently across platform.

## Acceptance Criteria

### 1. Upload
- [ ] File Picker (Image only).
- [ ] Cropper UI (1:1 ratio aspect).
- [ ] Max size validation (2MB).

### 2. Processing
- [ ] Resizes to 3 variants: Original, QR (Med), Thumbnail.
- [ ] Optimizes (compression).
- [ ] Saves to Public Storage (linked).

### 3. Display
- [ ] Updates Header on Dashboard.
- [ ] Updates Header on Feedback Form (Story 4.1).

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Asset Methods
**Component:** Logo Manager

- **Package:** `intervention/image`.
- **Storage:** `public` disk.

### Developer Guardrails
> [!IMPORTANT]
> **Storage:** Ensure `php artisan storage:link` has been run.
> **Security:** Allow only images (`mimes:jpg,jpeg,png`). No PHPs.

### Implementation Steps
1.  **Controller:** `ProfileController@updateLogo`.
2.  **Frontend:** Alpine or Cropper.js for the UI.

## Dependencies & Libraries
- intervention/image

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Identity.

## Implementation Update
- **Date**: 2025-12-06
- **Note**: Updated ProfileController to handle Logo upload.
