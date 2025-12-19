# Story 1.4: Core Models & Relationships

**Epic:** 1: Foundation & Technical Setup
**Story ID:** 1.4
**Status:** Ready for Review
**Priority:** High

## Description

**As a** developer,
**I want** to create Eloquent models dengan proper relationships,
**So that** application can query database menggunakan Laravel ORM.

## Acceptance Criteria

### 1. Model Creation
- [ ] Models created for all tables defined in Story 1.3:
    - `Restaurant`
    - `Questionnaire`
    - `QrCode`
    - `FeedbackResponse`
    - `SupportTicket`
    - `AdminAuditLog`
- [ ] Models placed in `app/Models` directory.

### 2. Relationships
- [ ] `User` belongsTo `Restaurant`.
- [ ] `Restaurant` hasMany `Questionnaires`, `QrCodes`, `Users`.
- [ ] `Questionnaire` hasMany `QrCodes`.
- [ ] `QrCode` belongsTo `Questionnaire`, hasMany `FeedbackResponses`.
- [ ] `FeedbackResponse` belongsTo `QrCode`.

### 3. Mass Assignment Protection
- [ ] All models define `$fillable` or `$guarded` properties.
- [ ] JSON attributes casted correctly (`protected $casts = ['questions' => 'array', 'ratings' => 'array']`).

### 4. Verification
- [ ] Tinker test: Create related records and verify navigation (e.g., `$restaurant->questionnaires`).
- [ ] Relationships return expected Collection or Model instances.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Core / Data Access
**Component:** Eloquent ORM

- **Casts:** Use `array` or `AsArrayObject` for JSON columns.
- **Traits:** Apply `HasFactory` for testing, and `BelongsToTenant` (from Story 1.2) for scoping.

### Developer Guardrails
> [!IMPORTANT]
> **Tenant Scoping:** Ensure the global scope from Story 1.2 is applied here (via Trait). This is critical for data isolation. Do NOT extend a base model unless necessary; Traits are preferred.

### Implementation Steps
1.  **Generate Models:**
    ```bash
    php artisan make:model Restaurant
    php artisan make:model Questionnaire
    # ...
    ```
2.  **Define Relationships:**
    - Use standard Eloquent methods (`hasMany`, `belongsTo`).
3.  **Configure Casts:**
    - `protected $casts = [...]`
4.  **Apply Scopes:**
    - `use BelongsToTenant;`

## Dependencies & Libraries
- Laravel Eloquent

## Dev Agent Record

### Implementation Plan
- [x] Generate Models
- [x] Implement Restaurant Model
- [x] Implement Questionnaire Model
- [x] Implement QrCode Model
- [x] Implement FeedbackResponse Model
- [x] Implement SupportTicket Model
- [x] Implement AdminAuditLog Model
- [x] Update User Model
- [x] Verification

### Debug Log
- (Empty)

### Completion Notes
- ✅ Implemented `Restaurant` model with relationships.
- ✅ Implemented `Questionnaire` model with relationships and JSON casting.
- ✅ Implemented `QrCode` model with relationships.
- ✅ Implemented `FeedbackResponse` model (ratings cast to array).
- ✅ Implemented `SupportTicket` and `AdminAuditLog` models.
- ✅ Updated `User` model with tenant/ticket relationships.
- ✅ Verified all models use `BelongsToTenant` trait (except AuditLog).

## File List
- app/Models/Restaurant.php
- app/Models/Questionnaire.php
- app/Models/QrCode.php
- app/Models/FeedbackResponse.php
- app/Models/SupportTicket.php
- app/Models/AdminAuditLog.php
- app/Models/User.php
- tests/Feature/ModelRelationshipTest.php

## Change Log
- 2025-12-06: Core Models Implementation (Story 1.4)

