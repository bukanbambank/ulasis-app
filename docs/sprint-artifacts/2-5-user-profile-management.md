# Story 2.5: User Profile Management

**Epic:** 2: User Authentication & Account Management
**Story ID:** 2.5
**Status:** Done

// ... (omitted headers)

## Tasks/Subtasks
- [x] **Config:** Setup filesystem (link storage).
- [x] **Data Model:** Ensure `User` -> `Restaurant` relationship is active.
- [x] **View:** Update `profile/edit.blade.php` to include Restaurant Name input and Logo upload.
- [x] **Logic:** Update `ProfileController` to handle Restaurant Name and Logo upload (store in `public/logos`).
- [x] **Validation:** Ensure strict validation for Logo updates.
- [x] **Testing:** Verify Profile Update (User + Restaurant name) and Logo Upload.

## Dev Agent Record

### Implementation Plan
- [x] Link Storage
- [x] Update `ProfileController` (edit/update)
- [x] Update `profile.edit` View
- [x] Implement `ProfileTest` (including logo)

### Completion Notes

## File List

## Change Log

## Dependencies & Libraries
- Laravel Breeze
- `intervention/image` (optional, recommended for optimization)

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Managing identity.
