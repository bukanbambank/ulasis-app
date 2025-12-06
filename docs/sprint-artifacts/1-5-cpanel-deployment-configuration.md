# Story 1.5: cPanel Deployment Configuration

**Epic:** 1: Foundation & Technical Setup
**Story ID:** 1.5
**Status:** ready-for-dev
**Priority:** High

## Description

**As a** developer,
**I want** to prepare deployment scripts and configuration files,
**So that** project can be deployed to cPanel shared hosting smoothly.

## Acceptance Criteria

### 1. Build & Config
- [ ] `npm run build` generates assets in `public/build`.
- [ ] `.htaccess` configured for cPanel subfolder/root deployment.
- [ ] `config/app.php` and `config/filesystems.php` optimized for shared hosting structure.

### 2. Deployment Script/Guide
- [ ] `DEPLOY.md` created with step-by-step cPanel instructions (FTP/Git).
- [ ] Optional: Github Action or script to automate FTP upload (if feasible).

### 3. Environment Check
- [ ] Script or checklist to verify cPanel requirements (PHP version, Extensions).
- [ ] Cron job command documented (`php /path/to/artisan schedule:run`).

### 4. Verification
- [ ] Project can be simulated in a folder structure similar to cPanel (e.g., `public_html` separation).

## Technical Implementation Context

### Architecture Compliance
**Layer:** Infrastructure
**Component:** Deployment

- **Hosting:** cPanel Shared
- **Strategy:** File-based deployment (Source safe to be outside `public_html`).

### Developer Guardrails
> [!IMPORTANT]
> **Deploy Structure:** Standard cPanel practice:
> 1. App code in `~/ulasis-v2/` (outside public_html).
> 2. Public assets in `~/public_html/` (or subdomain folder).
> 3. `index.php` modified to point to specific paths.
> **Symlinks:** Ensure `storage:link` works or use absolute paths config if symlinks are blocked.

### Implementation Steps
1.  **Draft DEPLOY.md:** Document the directory structure plan.
2.  **Config Adjustments:** Ensure `AppServiceProvider` forces HTTPS in production (`URL::forceScheme('https')`).

## Dependencies & Libraries
- None

## Worklog & Notes
- **Created:** 2025-12-06
- **Context:** Ensuring "it just works" when the user deploys.
