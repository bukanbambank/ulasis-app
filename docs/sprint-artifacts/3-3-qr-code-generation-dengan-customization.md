# Story 3.3: QR Code Generation dengan Customization

**Epic:** 3: Questionnaire Creation & QR Code Generation
**Story ID:** 3.3
**Status:** ready-for-dev
**Priority:** High

## Description

**As a** restaurant owner,
**I want** to generate QR code untuk my questionnaire,
**So that** customers dapat scan dan provide feedback.

## Acceptance Criteria

### 1. Generation Form
- [ ] Select Questionnaire.
- [ ] Input Name/Label (e.g., "Meja 1").
- [ ] Optional: Upload Logo for overlay.

### 2. Processing
- [ ] Generates Unique ID (UUID).
- [ ] Creates `QrCode` record in DB.
- [ ] Generates PNG image (High Res 1024px) using `simplesoftwareio/simple-qrcode`.
- [ ] Saves image to `public/qr-codes/{tenant}/{id}.png`.

### 3. Output
- [ ] Redirects to Detail Page.
- [ ] Shows Preview.
- [ ] Download Button.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Service
**Component:** QR Generator

- **Library:** `simplesoftwareio/simple-qrcode`.
- **Format:** PNG.

### Developer Guardrails
> [!IMPORTANT]
> **Storage:** Store generated images in `storage/app/public` and ensure symlinked.
> **Logo Overlay:** If logo is uploaded, use `merge()` function of the library.
> **URL:** The QR code must store the URL to the feedback form, e.g., `route('feedback.show', $uuid)`.

### Implementation Steps
1.  **Install:** `composer require simplesoftwareio/simple-qrcode`.
2.  **Controller:** `QrCodeController@store`.

## Dependencies & Libraries
- `simplesoftwareio/simple-qrcode`

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** The physical link to the digital app.
