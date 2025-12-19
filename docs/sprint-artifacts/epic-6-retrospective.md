# Epic 6 Retrospective: Dashboard & Analytics

## Summary
Delivered a functional Dashboard with key metrics and visualization charts (Sentiment & Trends).

## What Went Well
-   **Visualization**: Chart.js integration provides immediate visual value to the user.
-   **Service Layer**: Refactoring logic into `DashboardService` kept the Controller clean.

## Challenges
-   **Tenancy in Tests**: Testing the Dashboard required careful mocking/setup of the Tenant context to avoid "Table not found" or connection errors.
-   **Date Handling**: Ensuring charts handle timezones and empty data points correctly.

## Action Items
-   [ ] Add more granular filters (e.g., custom date range) in the future.
