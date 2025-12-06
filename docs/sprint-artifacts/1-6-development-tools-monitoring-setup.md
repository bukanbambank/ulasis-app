# Story 1.6: Development Tools & Monitoring Setup

**Epic:** 1: Foundation & Technical Setup
**Story ID:** 1.6
**Status:** ready-for-dev
**Priority:** Medium

## Description

**As a** developer,
**I want** to install debugging and monitoring tools,
**So that** we can efficiently troubleshoot issues during development and production.

## Acceptance Criteria

### 1. Dev Tools
- [ ] Laravel Debugbar installed (`barryvdh/laravel-debugbar`) -- *Dev only*.
- [ ] Laravel Ide Helper installed (optional but recommended for autocompletion).
- [ ] Pint or PHP-CS-Fixer configured for code style.

### 2. Monitoring (Production)
- [ ] Logging configuration optimized (`daily` channel).
- [ ] Sentry / GlitchTip integration (optional, if key provided).
- [ ] Health check endpoint configured (e.g., `/up`).

### 3. Verification
- [ ] Debugbar visible in local environment.
- [ ] Debugbar NOT visible in production environment (`APP_DEBUG=false`).
- [ ] Logs are written correctly to `storage/logs`.

## Technical Implementation Context

### Architecture Compliance
**Layer:** Infrastructure
**Component:** Observability

- **Tools:** Standard Laravel ecosystem.

### Developer Guardrails
> [!IMPORTANT]
> **Performance:** Debugbar must be `require-dev` only.
> **Security:** Ensure `/up` or health checks don't expose sensitive info.

### Implementation Steps
1.  **Install Debugbar:**
    ```bash
    composer require barryvdh/laravel-debugbar --dev
    ```
2.  **Config:**
    - Publish config if needed.
3.  **Logging:**
    - Verify `config/logging.php`.

## Dependencies & Libraries
- `barryvdh/laravel-debugbar`: Dev dependency.

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Quality of life for developers.
