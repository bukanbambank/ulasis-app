# Story 1.4: Core Models & Relationships

**Epic:** 1: Foundation & Technical Setup
**Story ID:** 1.4
**Status:** ready-for-dev
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

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Enforces business logic and data integrity at the app level.
