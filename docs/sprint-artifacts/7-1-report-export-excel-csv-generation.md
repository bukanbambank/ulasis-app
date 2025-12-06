# Story 7.1: Report Export - Excel & CSV Generation

**Epic:** 7: Reports & User Settings
**Story ID:** 7.1
**Status:** ready-for-dev
**Priority:** Medium

## Description

**As a** restaurant owner,
**I want** to export feedback data to Excel/CSV,
**So that** saya can analyze data externally atau share dengan stakeholders.

## Acceptance Criteria

### 1. Export Interface
- [ ] Date Range Selection.
- [ ] Format Choice (Excel/CSV).
- [ ] Column Selection (Checkboxes).

### 2. File Generation
- [ ] **Background Job:** Handles large exports.
- [ ] **Excel Structure:** Sheet 1 (Summary), Sheet 2 (Data).
- [ ] **CSV Structure:** Flat headers and rows.
- [ ] **Naming:** `{Restaurant}_{DateRange}.xlsx`.

### 3. Delivery
- [ ] Download link provided after generation.
- [ ] Email notification (optional for large files).

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Reporting
**Component:** Export Engine

- **Package:** `maatwebsite/excel`.
- **Infrastructure:** Queue Worker is essential here to prevent timeouts.

### Developer Guardrails
> [!IMPORTANT]
> **Performance:** Always use `FromQuery` or `chunk()` when exporting. Never load 10,000 rows into RAM.
> **Cleanup:** Delete temp files after 24h via Schedule.

### Implementation Steps
1.  **Job:** `GenerateExportJob`.
2.  **Export Class:** `App\Exports\FeedbackExport`.
3.  **Controller:** `ReportController`.

## Dependencies & Libraries
- maatwebsite/excel

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Data portability.
