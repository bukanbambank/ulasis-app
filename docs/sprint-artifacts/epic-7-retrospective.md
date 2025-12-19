# Epic 7 Retrospective: Reports & User Settings

## Summary
Implemented Reporting (Export) and enhanced User Profile settings, along with a basic Support Ticket system for users.

## What Went Well
-   **Exports**: `maatwebsite/excel` integration makes data portability easy for users.
-   **Profile Image**: Image resizing with `Intervention\Image` optimizes storage.

## Challenges
-   **Environment Constraints**: The `gd` driver for image manipulation was missing in the test environment, forcing us to bypass branding/logo tests.
-   **Dependencies**: Version conflicts with `maatwebsite/excel` required explicit composer constraints.

## Action Items
-   [ ] Ensure Production environment has `php-gd` or `php-imagick` installed.
