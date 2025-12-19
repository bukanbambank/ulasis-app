# Retrospective: Epic 2 - User Authentication & Account Management

**Date:** 2025-12-06
**Facilitator:** BMad Agent
**Participants:** Project Lead (User), Scrum Master, Dev Team, QA, Architect

## 1. Epic Review
**Goal:** Restaurant owners dapat register, login, manage profile dengan secure authentication.

### Delivery Metrics
- **Completed:** 6/6 Stories (100%)
- **Status:** Done
- **Components:** Laravel Breeze, Socialite (Google Auth), Rate Limiting, Profile Management, Security Features.

### What Went Well? (Successes)
- **Comprehensive Auth:** Full suite delivered: Registration, Login, Social Auth, Password Reset, Profile Update, Password Change.
- **Security First:** Strict rate limits (3/hour for resets, 5/min for login), strong password enforcement, and secure session management were implemented and verified.
- **Socialite Integration:** Google OAuth was integrated smoothly, with automatic Tenant creation logic included.
- **Testing:** extensive testing using `withoutExceptionHandling()` to catch deep logic errors.

### What Could Be Improved? (Challenges)
- **Schema Mismatches:** We faced a disconnect between the Database Schema (`logo` column) and the Controller implementation (`logo_path` assumption), causing errors late in Verification.
- **Test Environment Limitations:** The `ProfileTest` failed initially because the GD image library was missing in the test environment. We had to implement a workaround using `UploadedFile::fake()->create()`.
- **Validation Consistency:** Ensuring validation messages were in Indonesian required extra attention across multiple views.

### Lessons Learned
- **Verify Schema Early:** Always cross-reference the `migration` files when writing Controllers to ensure column names match exactly.
- **Robust Testing Strategies:** When testing file uploads, design tests to be resilient to environment differences (GD vs Imagick) or ensure CI environment matches Production.
- **Relationship Integrity:** Always ensure `belongsTo` relationships (like `User` -> `Tenant`) are set up with correct Foreign Key data in factories/seeders to avoid `IntegrityConstraintViolation`.

---

## 2. Next Epic Preview: Epic 3 (Questionnaire & QR Code Creation)

### Focus
Restaurant owners can create angket (questionnaires) from templates and generate QR codes.

### Dependencies & Readiness
- **Authentication:** Ready (Epic 2 complete). Users can login to create resources.
- **Database:** `questionnaires` and `qr_codes` tables created in Epic 1, but need verification of JSON column casting.
- **Libraries:** Epic 3 requires QR generation and Image manipulation.

### Action Items
- [ ] **Install Packages:** Install `bacon/bacon-qr-code` for QR generation and `intervention/image` for logo overlays (Story 3.3).
- [ ] **Verify JSON Casts:** Ensure `Questionnaire` model casts `questions` attribute to array/JSON (Story 3.2).
- [ ] **Template Logic:** Decide where Pre-built Templates (Story 3.1) stored: Constants, Config, or Database Seeder? *Recommendation: Config file for MVP.*

## 3. Conclusion
Epic 2 established the user identity layer. We are now ready to build the core value proposition: Feedback collection.

**Status:** EPIC CLOSED
