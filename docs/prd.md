---
stepsCompleted: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
inputDocuments:
  - "docs/analysis/product-brief-Ulasis 2.0-2025-12-05.md"
workflowType: 'prd'
lastStep: 10
project_name: 'Ulasis 2.0'
user_name: 'Lio'
date: '2025-12-05'
---

# Product Requirements Document - Ulasis 2.0

**Author:** Lio
**Date:** 2025-12-05
**Status:** Complete

---

## Executive Summary

Ulasis 2.0 adalah platform SaaS feedback berbasis QR code yang dirancang khusus untuk restoran dan café di Indonesia. Platform ini mengatasi masalah kritis dimana pemilik restoran tidak memiliki visibilitas yang jelas tentang pengalaman pelanggan mereka - kebanyakan hanya mengandalkan pertanyaan langsung atau word-of-mouth yang tidak efektif, tidak scalable, dan tidak memberikan data actionable.

Platform ini memberdayakan pemilik restoran untuk mendapatkan puluhan hingga ratusan feedback dengan effort minimal, memberikan insight yang dibutuhkan untuk improve kualitas makanan, pelayanan, dan pengalaman pelanggan secara keseluruhan. Dengan fokus pada restaurant-specific use case, simplicity, dan affordability, Ulasis 2.0 memungkinkan setup dalam waktu kurang dari 5 menit dan customer feedback completion dalam waktu kurang dari 60 detik.

### What Makes This Special

Ulasis 2.0 membedakan dirinya melalui tujuh pilar utama:

1. **Restaurant-First Design Philosophy** - Setiap aspek dirancang specifically untuk restaurant use case, bukan generic survey tool. Vertical SaaS approach yang deliver higher value dibanding horizontal survey platforms.

2. **Pre-Built Templates = Zero Learning Curve** - Pemilik restoran tidak perlu figure out pertanyaan apa yang harus ditanyakan. Template sudah include industry best practices untuk restaurant feedback collection.

3. **Mobile-Optimized End-to-End** - Dari customer experience (scan QR = mobile) hingga owner dashboard (accessible dari mobile), setiap touchpoint dioptimasi untuk mobile-first Indonesia market.

4. **Smart Simplicity with Actionable Insights** - Kombinasi unik antara kesederhanaan interface dan kedalaman analisis. Restoran mendapatkan sophisticated insights (sentiment trends, location-based performance, peak hours analysis) dalam format yang mudah dipahami dan langsung actionable.

5. **Rule-Based Analytics = Cost Efficiency** - Tidak menggunakan expensive AI/NLP untuk sentiment analysis. Menggunakan smart questionnaire design (rating-based + binary choices) yang generate structured data untuk accurate sentiment calculation, memungkinkan pricing yang sangat terjangkau.

6. **QR-Native Architecture** - Platform dibangun dari ground-up untuk QR-based workflow dengan multi-QR tracking, location attribution, dan QR-specific analytics sebagai core architecture.

7. **Indonesia Restaurant Market Focus** - Pemahaman mendalam tentang kebutuhan, behavior, dan pain points restoran Indonesia, dengan payment integration (Dana) dan pricing yang sesuai purchasing power UMKM Indonesia.

## Project Classification

**Technical Type:** SaaS B2B (saas_b2b)
**Domain:** General
**Complexity:** Medium

Ulasis 2.0 diklasifikasikan sebagai SaaS B2B platform dengan karakteristik multi-tenant architecture yang melayani restoran dan café sebagai business customers. Platform ini memerlukan subscription management, role-based access control, dan customer-specific data isolation. Domain complexity tergolong medium karena fokus pada restaurant feedback management tanpa regulatory compliance yang complex seperti healthcare atau fintech.

Sebagai web application dengan mobile-first approach, platform ini menggunakan responsive design untuk mendukung customer-facing feedback forms dan owner dashboard yang accessible dari smartphone. QR code integration menjadi core feature yang membedakan platform ini dari generic survey tools.

---

## Problem Statement

### Current State

Pemilik restoran dan café di Indonesia menghadapi tantangan signifikan dalam mengumpulkan feedback pelanggan yang berkualitas dan real-time. Metode tradisional seperti bertanya langsung atau mengandalkan feedback dari kerabat memiliki beberapa kelemahan fundamental:

**Ineffectiveness of Direct Inquiry:**
- Pelanggan enggan menyampaikan kritik secara langsung karena rasa tidak nyaman
- Jawaban cenderung tidak jujur atau diplomatic ("baik aja kok")
- Interaksi face-to-face membatasi kejujuran feedback
- Tidak scalable untuk volume pelanggan yang besar

**Lack of Structured Data:**
- Feedback verbal tidak terstruktur dan sulit dianalisis
- Tidak ada tracking historical data untuk identify trends
- Keputusan operasional berbasis feeling dan intuisi, bukan data
- Tidak ada metric untuk measure improvement over time

**Delayed Problem Discovery:**
- Masalah sering discovered terlambat via Google reviews atau social media
- By the time feedback received, damage to reputation sudah terjadi
- Lost opportunity untuk immediate corrective action
- Customer yang unhappy tidak memberikan second chance

### Impact on Business

Tanpa feedback yang memadai dan terstruktur, restoran mengalami dampak bisnis yang signifikan:

**Operational Blindness:**
- Tidak ada visibility tentang kualitas makanan dari perspektif pelanggan
- Service quality issues tidak terdeteksi sampai terlambat
- Operational problems (kebersihan, waktu tunggu) tidak teratasi
- Menu performance tidak terukur (mana yang popular/unpopular)

**Competitive Disadvantage:**
- Terlambat berkembang dibanding competitor yang data-driven
- Kehilangan edge di pasar F&B yang semakin kompetitif
- Tidak bisa justify investment untuk improvement tanpa data
- Missed opportunities untuk optimize operations dan customer experience

**Financial Impact:**
- Customer retention rendah karena unresolved issues
- Word-of-mouth marketing negatif dari unhappy customers
- Lost revenue dari menu items yang underperform tapi tidak diketahui
- Risiko public negative reviews yang damage reputation permanently

### Why Existing Solutions Don't Work

Generic survey tools seperti Google Forms, SurveyMonkey, dan Typeform tidak cocok untuk restaurant context karena:

**Not Restaurant-Specific:**
- Pemilik restoran harus design sendiri questionnaire yang efektif
- Tidak ada guidance tentang pertanyaan apa yang harus ditanyakan
- Generic analytics yang tidak tailored untuk restaurant operations
- Tidak ada restaurant industry best practices built-in

**Complexity & Poor UX:**
- UI/UX yang kompleks untuk non-tech-savvy restaurant owners
- Setup process yang panjang dan confusing
- Customer-facing forms tidak optimized untuk quick mobile completion
- Desktop-first design yang tidak cocok untuk QR code scan use case

**Pricing Barriers:**
- Subscription model yang terlalu expensive untuk UMKM Indonesia
- Pricing tiers yang tidak sesuai dengan restaurant budget constraints
- Hidden costs untuk features yang essential (export, unlimited responses)

**Lack of QR Integration:**
- QR code support sebagai afterthought, bukan core feature
- Tidak ada location-based tracking untuk multiple QR codes
- Tidak ada QR-specific analytics untuk compare performance by location
- Setup QR workflow yang tidak seamless

---

## Success Criteria

### User Success Definition

**For Restaurant Owners (Primary Users):**

Users sukses ketika mereka dapat:
1. **Collect Meaningful Feedback** - Mengumpulkan ratusan feedback dalam periode waktu tertentu (vs. hanya 2-3 review di Google)
2. **See Measurable Improvement** - Melihat rating café mereka improve secara measurable (contoh: dari 3.8 ke 4.2)
3. **Make Data-Driven Decisions** - Menggunakan analytics untuk justify operational changes ke owner dengan data konkret
4. **Take Timely Action** - Respond ke negative feedback dalam 2-3 hari dan resolve issues before they escalate

**Success Moment:**
"Ini exactly yang saya butuhkan untuk improve café!" - Ketika manager seperti Sari melihat rating improvement setelah mengambil action berdasarkan Ulasis data.

### Business Success Metrics

**3-Month Goals (MVP Phase):**
- **User Acquisition:** ~100 café/restoran successfully register
- **Activation Rate:** 70%+ complete onboarding (create angket + deploy QR)
- **Active Usage:** 50%+ users login at least weekly
- **Feedback Volume:** Average 50+ feedback responses per active café per month
- **Platform Activity:** Ribuan feedback responses diproses di platform

**12-Month Goals (Growth Phase):**
- **User Acquisition:** ~500 café/restoran sign up
- **Conversion Rate:** 60% conversion dari sign up ke paying customers
- **Revenue:** ~Rp 30 juta Monthly Recurring Revenue (MRR)
- **Platform Scale:** Ratusan ribu feedback responses diproses
- **User Retention:** 80%+ retention rate (low churn)

### Key Performance Indicators (KPIs)

**Engagement KPIs:**
- **Daily Active Users (DAU):** 70%+ of users login daily
- **QR Code Scans:** Average 50-100+ scans per café per week
- **Feedback Completion Rate:** 10-15% of café customers complete feedback
- **Feature Adoption:** 80%+ usage of core features (Dashboard, Inbox, Analytics)
- **Multi-QR Setup:** 30%+ of users deploy multiple QR codes

**Outcome KPIs:**
- **Rating Improvement:** 30%+ of active users report measurable café rating improvement
- **Action Response Time:** Average 2-3 days from negative feedback to action taken
- **Problem Resolution:** 80%+ of negative feedback tagged as "Selesai" within 1 week
- **User Testimonials:** 10+ users explicitly state "this solved my problem"

**Financial KPIs (Post-MVP):**
- **Monthly Recurring Revenue (MRR):** Rp 5 juta (3-month), Rp 30 juta (12-month)
- **Average Revenue Per User (ARPU):** Rp 100K-150K per paying customer per month
- **Customer Acquisition Cost (CAC):** CAC < 3 months of subscription value
- **Lifetime Value (LTV):** LTV > 3x CAC
- **Churn Rate:** < 5% monthly churn

**Technical KPIs:**
- **Platform Uptime:** 99.9% uptime
- **Dashboard Load Time:** < 3 seconds
- **Mobile Completion Rate:** > 80% (customers who scan actually complete)
- **Data Integrity:** Zero critical data loss incidents

---

## User Personas

### Primary Persona: Sari - Manager Operasional Café

**Demographics:**
- **Usia:** 28 tahun
- **Role:** Manager Operasional di café independen "Kopi Santai"
- **Experience:** 3 tahun mengelola café dengan 20-30 pelanggan per hari
- **Technical Skill:** Intermediate (dapat menggunakan smartphone & aplikasi dasar, tetapi bukan tech expert)
- **Location:** Jakarta
- **Motivasi:** Ingin café terus berkembang dan membangun loyalitas pelanggan

**Current Pain Points:**
- Mendapat komplain terlambat via Google review atau social media - already too late untuk fix
- Tidak ada data tentang menu mana yang pelanggan suka/tidak suka
- Bertanya langsung ke pelanggan tapi jawabannya kurang jujur
- Tidak punya data untuk justify improvement investment ke owner
- Keputusan operasional berbasis feeling, bukan data
- Setiap hari worry about silent unhappy customers yang tidak voice concerns

**Current Workarounds:**
- Sesekali bertanya ke pelanggan regular (tapi limited dan bias)
- Mengecek Google reviews (jarang ada yang memberikan review)
- Decision-making berbasis intuisi tanpa data pendukung
- React to problems setelah terjadi, bukan prevent

**Goals & Motivations:**
- Dapatkan visibility tentang customer satisfaction real-time
- Identify dan fix problems before they become public complaints
- Improve café quality berdasarkan data, bukan assumption
- Prove value to owner dengan measurable improvements
- Build customer loyalty through responsive service

**Success Vision dengan Ulasis 2.0:**
- Setiap hari mendapatkan 10-20 feedback real-time dari pelanggan
- Langsung take action kalau ada negative feedback (AC rusak, service lambat)
- Punya data konkret untuk present ke owner: "Rating kita naik dari 3.8 ke 4.2!"
- Tidak perlu awkward bertanya-tanya langsung ke pelanggan
- Data-driven decisions yang improve café performance secara measurable
- Habit formation: Check dashboard setiap pagi seperti check social media

**User Journey with Ulasis:**

1. **Discovery:** Menemukan Ulasis via social media ads atau rekomendasi komunitas F&B
2. **Sign-up:** Register dengan email, verify account (< 2 menit)
3. **Onboarding:** Pilih template café, customize, generate QR code, download & print (< 5 menit total)
4. **Deployment:** Letakkan QR code di meja, kasir, standing banner
5. **Daily Usage:**
   - Pagi: Check dashboard dari smartphone, lihat feedback semalam
   - Tindak lanjut: Baca inbox untuk negative ratings, tag status "Dalam Proses"
   - Coordinate action: Fix AC, improve menu, train staff
   - Update status: Mark feedback "Selesai"
   - Sore: Check analytics, identify trends, export laporan untuk owner
6. **Success Moment:** Minggu pertama dapat 50+ feedback, discover Nasi Goreng rating rendah (3.2), improve resep, 2 minggu kemudian rating naik ke 4.5
7. **Long-term:** Menjadi routine, upgrade ke paid tier, setup multiple QR codes, data-driven operations

### Secondary Persona: Dimas - Pelanggan Café

**Demographics:**
- **Usia:** 25 tahun
- **Occupation:** Pekerja kantoran / mahasiswa
- **Behavior:** Sering nongkrong di café untuk kerja atau hangout
- **Technical Skill:** High (smartphone native, comfortable dengan digital tools)
- **Location:** Jakarta

**Context of Interaction:**
- Melihat QR code dengan text "Scan untuk mengulas kami" di:
  - Meja makan (scan sambil tunggu makanan atau setelah makan)
  - Kasir (scan saat pembayaran)
  - Standing banner dekat entrance/exit café

**Motivations to Provide Feedback:**
- Ingin membantu café favorit untuk improve
- Process yang cepat dan tidak merepotkan (< 60 detik)
- Merasa feedback-nya akan actually didengar dan ditindaklanjuti
- Optional incentive (misal: "Tunjukkan layar ini untuk diskon")
- Anonymity - tidak perlu face-to-face confrontation

**Experience Requirements:**
- **Speed:** Total completion time < 60 detik
- **Simplicity:** Visual rating system (emoji/stars), quick binary questions
- **Mobile-Optimized:** Seamless experience dari scan to submit
- **Optional Depth:** Text feedback box untuk elaborate if needed
- **Confirmation:** Thank you screen yang acknowledge contribution

**Pain Points with Traditional Feedback:**
- Awkward memberikan kritik langsung face-to-face
- Google review terlalu formal dan time-consuming
- Tidak ada channel yang cepat dan anonymous untuk casual feedback
- Merasa feedback tidak akan actually make a difference

### Tertiary Persona: Andi - Platform Administrator

**Demographics:**
- **Usia:** 30 tahun
- **Role:** Internal Admin Team Ulasis 2.0
- **Technical Expertise:** High (full platform access dan technical troubleshooting)
- **Location:** Remote team

**Responsibilities:**
- Mengelola database platform dan infrastructure
- Handle support tickets dari restaurant users
- Manage subscription tiers dan billing (post-MVP)
- Troubleshoot technical issues di user accounts
- Monitor platform health dan system performance
- Manage payment processing (Dana integration post-MVP)

**Key Activities:**
- Review dan respond ke support tickets (target: < 24 jam)
- Investigate technical issues yang dilaporkan users
- User account management (activate, suspend)
- Access admin dashboard dengan elevated permissions
- Monitor platform uptime dan error logs
- Fraud detection dan payment anomaly monitoring (post-MVP)

**Success Metrics:**
- Support ticket response time < 24 jam
- Platform uptime 99.9%
- User satisfaction dengan support quality tinggi
- Smooth payment processing (post-MVP)
- Zero critical data loss incidents

**Tools & Features Needed:**
- Admin dashboard dengan user management interface
- Support ticket system dengan status tracking
- Database monitoring dan basic operations
- User activity logs dan analytics
- Platform health metrics dan error log access
- Impersonate functionality (post-MVP untuk advanced troubleshooting)

---

## Functional Requirements

### FR-1: Authentication & Account Management

**FR-1.1: User Registration**
- System MUST allow restaurant owners to register menggunakan email address
- System MUST support registration via Gmail OAuth untuk convenience
- System MUST send email verification link untuk aktivasi akun
- System MUST require email verification before account activation
- System MUST validate email format dan uniqueness
- System MUST store user credentials securely (hashed passwords)

**FR-1.2: Login & Session Management**
- System MUST allow users to login menggunakan email dan password
- System MUST support login via Gmail OAuth
- System MUST maintain secure session management
- System MUST implement "Remember Me" functionality
- System MUST auto-logout after period of inactivity
- System MUST support concurrent sessions dari multiple devices

**FR-1.3: Password Management**
- System MUST provide password reset functionality via email
- System MUST validate password strength (minimum requirements)
- System MUST allow users to change password from settings
- System MUST enforce secure password storage (bcrypt/argon2)

**FR-1.4: Profile Management**
- System MUST allow users to update profile information:
  - Restaurant name
  - Owner name
  - Email address
  - Profile photo/logo
- System MUST validate profile data before saving
- System MUST display current profile information in settings

### FR-2: Angket (Questionnaire) Management

**FR-2.1: Pre-Built Templates**
- System MUST provide 3 pre-built restaurant templates:
  - Casual Dining Template
  - Café Template
  - Fast Food Template
- Each template MUST include optimized questions untuk:
  - Kualitas makanan & minuman
  - Kecepatan & kualitas pelayanan
  - Kebersihan restoran
  - Value for money
  - Overall experience & likelihood to return

**FR-2.2: Questionnaire CRUD Operations**
- System MUST allow users to create new angket dari template atau from scratch
- System MUST allow users to read/view existing angket
- System MUST allow users to update/edit angket content
- System MUST allow users to delete angket (with confirmation)
- System MUST prevent deletion of angket yang sedang linked ke active QR codes

**FR-2.3: Question Types Support**
- System MUST support rating scale questions (1-5 stars/points)
- System MUST support binary choice questions (Yes/No)
- System MUST support optional text feedback boxes
- System MUST allow character limit configuration untuk text feedback
- System MUST support visual rating displays (emoji/stars)

**FR-2.4: Questionnaire Preview**
- System MUST provide preview functionality untuk test angket
- System MUST display preview dalam mobile-optimized format
- System MUST allow preview before publishing/linking to QR code
- System MUST show sampul hasil (thumbnail) dari angket yang dibuat

**FR-2.5: Questionnaire Customization**
- System MUST allow users to add/remove questions
- System MUST allow users to reorder questions via drag-and-drop
- System MUST allow users to customize question text
- System MUST allow users to set questions as required or optional
- System MUST allow users to add restaurant logo/branding ke angket

### FR-3: QR Code Management

**FR-3.1: QR Code Generation**
- System MUST generate unique QR codes untuk each angket
- System MUST link QR code ke specific angket
- System MUST generate high-resolution QR codes suitable for printing
- System MUST assign unique ID ke each QR code
- System MUST store QR code metadata dalam database

**FR-3.2: QR Code Customization**
- System MUST allow users to add restaurant logo ke QR code center
- System MUST allow users to name/label QR codes untuk tracking (misal: "Meja Indoor", "Kasir")
- System MUST allow users to customize QR code colors (optional)
- System MUST maintain scannability setelah customization

**FR-3.3: QR Code CRUD Operations**
- System MUST allow users to create multiple QR codes
- System MUST display list of all QR codes dengan names dan status
- System MUST allow users to preview QR code before download
- System MUST allow users to download QR code dalam format PNG/JPG
- System MUST allow users to edit QR code name/label
- System MUST allow users to deactivate/reactivate QR codes
- System MUST allow users to delete unused QR codes

**FR-3.4: QR Code Analytics Integration**
- System MUST track which QR code generated each feedback response
- System MUST store QR code attribution data dengan each response
- System MUST enable analytics comparison by QR code
- System MUST display QR code performance dalam analytics dashboard

### FR-4: Customer-Facing Feedback Form

**FR-4.1: Mobile-Optimized Interface**
- System MUST display feedback form dalam mobile-responsive design
- System MUST optimize form untuk smartphone screens (primary device)
- System MUST work seamlessly dalam mobile browsers (no app installation required)
- System MUST support both portrait dan landscape orientations
- System MUST ensure fast load times (< 2 seconds)

**FR-4.2: Visual Rating System**
- System MUST display rating questions menggunakan visual elements (emoji/stars)
- System MUST provide intuitive tap/click interface untuk rating selection
- System MUST highlight selected rating clearly
- System MUST support 1-5 rating scales
- System MUST make rating selections engaging dan easy to use

**FR-4.3: Form Interaction**
- System MUST display questions sequentially atau as single-page form
- System MUST show progress indicator untuk multi-question forms
- System MUST validate required fields before submission
- System MUST provide clear error messages untuk validation failures
- System MUST prevent duplicate submissions (within short timeframe)

**FR-4.4: Text Feedback Collection**
- System MUST provide optional text feedback box
- System MUST enforce character limits where configured
- System MUST allow customers to skip text feedback if optional
- System MUST support multi-line text input

**FR-4.5: Submission & Confirmation**
- System MUST store all feedback responses dalam database
- System MUST capture timestamp untuk each response
- System MUST link response ke originating QR code
- System MUST display thank you screen after successful submission
- System MUST show completion confirmation (optional incentive message)
- System MUST target total completion time < 60 seconds

### FR-5: Dashboard - Overview & Analytics

**FR-5.1: Dashboard Home**
- System MUST display overall sentiment score dengan visual representation
- System MUST show total feedback count
- System MUST show response rate statistics
- System MUST display rating trend indicators (up/down/stable)
- System MUST show alert notifications untuk negative ratings (< 3 stars)
- System MUST provide quick stats summary

**FR-5.2: Time-Based Filtering**
- System MUST allow analysis filtering by:
  - Jam (hourly breakdown)
  - Hari (daily view)
  - Minggu (weekly aggregate)
  - Bulan (monthly aggregate)
  - Tahun (yearly aggregate)
- System MUST update all dashboard charts based on selected filter
- System MUST persist filter selection during session

**FR-5.3: Real-Time Updates**
- System MUST display new feedback dalam dashboard tanpa manual refresh
- System MUST show notification badges untuk new responses
- System MUST update statistics automatically when new data arrives

### FR-6: Inbox - Feedback Management

**FR-6.1: Feedback Display**
- System MUST display all text feedback responses dalam inbox view
- System MUST show associated rating data dengan each text feedback
- System MUST display timestamp untuk each feedback
- System MUST show QR code source attribution
- System MUST support pagination atau infinite scroll untuk large datasets

**FR-6.2: Status Management System**
- System MUST assign default status "Baru" ke new feedback
- System MUST allow users to update status ke:
  - "Dalam Proses" (being addressed)
  - "Selesai" (resolved)
- System MUST track status change history
- System MUST display status badges clearly
- System MUST allow bulk status updates (optional enhancement)

**FR-6.3: Filter Capabilities**
- System MUST allow filtering by status (Baru/Dalam Proses/Selesai)
- System MUST allow filtering by date range (date picker)
- System MUST allow filtering by QR code source
- System MUST allow filtering by rating level (negative/neutral/positive)
- System MUST support multiple simultaneous filters
- System MUST preserve filter state during session

**FR-6.4: Alert System**
- System MUST generate alerts untuk negative feedback (ratings < 3 stars)
- System MUST display alert badges dalam inbox
- System MUST prioritize negative feedback dalam default view
- System MUST support notification preferences (email/in-app)

**FR-6.5: Feedback Detail View**
- System MUST allow users to click feedback untuk detailed view
- System MUST display complete feedback information:
  - All rating responses
  - Text feedback
  - Timestamp
  - QR code source
  - Current status
  - Status history
- System MUST allow status updates dari detail view

### FR-7: Analisis - Analytics Dashboard

**FR-7.1: Overall Sentiment Analysis**
- System MUST calculate sentiment berdasarkan rating scales:
  - Ratings 1-2 = Negatif
  - Rating 3 = Netral
  - Ratings 4-5 = Positif
- System MUST display pie chart dengan percentage breakdown (Positif/Netral/Negatif)
- System MUST show numerical percentages alongside visual chart
- System MUST update calculations based on selected time filters

**FR-7.2: QR Code Performance Comparison**
- System MUST display bar chart comparing average rating per QR code
- System MUST identify dan highlight QR dengan highest rating (paling positif)
- System MUST identify dan highlight QR dengan lowest rating (paling negatif)
- System MUST display QR code name dan ID dalam chart
- System MUST show sample size (number of responses) per QR code

**FR-7.3: Trend Analysis**
- System MUST display line graph dengan time series data
- System MUST show rating average over selected time period (Hari/Minggu/Bulan/Tahun)
- System MUST visualize improvement/decline trends clearly
- System MUST allow zoom/pan untuk detailed time period inspection
- System MUST highlight significant changes dalam trend line

**FR-7.4: Peak Hours Analysis**
- System MUST identify time periods dengan highest negative sentiment
- System MUST identify time periods dengan highest positive sentiment
- System MUST display hourly breakdown heatmap atau bar chart
- System MUST provide insights untuk operational decisions (staffing, quality control timing)

**FR-7.5: Category Breakdown**
- System MUST show rating breakdown by question category:
  - Food quality
  - Service quality
  - Cleanliness
  - Value for money
  - Overall experience
- System MUST display comparison bar chart across categories
- System MUST identify lowest-rated categories untuk focus improvement

### FR-8: Laporan - Report Export

**FR-8.1: Export Formats**
- System MUST support export ke Excel format (.xlsx)
- System MUST support export ke CSV format (.csv)
- System MUST generate properly formatted files dengan headers

**FR-8.2: Report Contents**
- System MUST include dalam export:
  - All feedback responses dengan timestamps
  - Rating data per category/question
  - QR code attribution
  - Status information (Baru/Dalam Proses/Selesai)
  - Text feedback content
  - Sentiment classification
- System MUST structure data dalam readable table format

**FR-8.3: Date Range Selection**
- System MUST allow users to specify custom date ranges untuk reports
- System MUST provide preset date range options (Last 7 days, Last 30 days, Last 3 months)
- System MUST validate date range selections

**FR-8.4: Download Functionality**
- System MUST generate report file on-demand
- System MUST use proper file naming convention (restaurant_name_date_range.xlsx)
- System MUST trigger browser download automatically
- System MUST show progress indicator during report generation
- System MUST handle large datasets efficiently (streaming atau pagination)

### FR-9: Settings - Account & Support

**FR-9.1: Profile Photo/Logo Management**
- System MUST allow users to upload profile photo atau restaurant logo
- System MUST support common image formats (JPG, PNG)
- System MUST enforce maximum file size limits
- System MUST provide image cropping tool untuk square logos
- System MUST display current logo dengan option to replace

**FR-9.2: Account Information Updates**
- System MUST allow users to update:
  - Restaurant name
  - Owner name
  - Email address (with verification)
- System MUST validate updates before saving
- System MUST send confirmation email untuk email address changes

**FR-9.3: Password Change**
- System MUST require current password untuk security verification
- System MUST validate new password strength
- System MUST confirm new password dengan re-entry
- System MUST update password securely
- System MUST send notification email about password change

**FR-9.4: Support Ticket System**
- System MUST provide contact admin functionality
- System MUST allow users to submit support tickets dengan:
  - Subject line
  - Detailed message
  - Optional file attachments (screenshots)
- System MUST assign ticket ID untuk tracking
- System MUST display ticket status (Open/In Progress/Resolved)
- System MUST show ticket submission history
- System MUST send email confirmation upon ticket submission

### FR-10: Admin Dashboard - Platform Management

**FR-10.1: User Management Interface**
- System MUST display list of all registered users (restaurants)
- System MUST show user details:
  - Restaurant name
  - Email
  - Registration date
  - Account status (Active/Suspended)
  - Last login date
- System MUST allow admin to search/filter users
- System MUST allow admin to view user activity logs

**FR-10.2: Account Administration**
- System MUST allow admin to activate user accounts
- System MUST allow admin to suspend user accounts (with reason)
- System MUST allow admin to manually verify email addresses
- System MUST log all admin actions untuk audit trail

**FR-10.3: Database Management**
- System MUST provide basic database monitoring interface
- System MUST show database health metrics (size, connection pool)
- System MUST allow admin to trigger manual backups
- System MUST display backup history dan status
- System MUST perform data integrity checks

**FR-10.4: Support Ticket Management**
- System MUST display incoming support tickets dari users
- System MUST show ticket details:
  - User information
  - Subject & message
  - Attachments
  - Submission timestamp
  - Current status
- System MUST allow admin to respond ke tickets
- System MUST allow admin to add internal notes (not visible to users)
- System MUST allow admin to update ticket status (Open/In Progress/Resolved)
- System MUST support priority tagging untuk urgent issues
- System MUST send email notifications ke users when status updated

**FR-10.5: Platform Monitoring**
- System MUST display platform health metrics:
  - Uptime percentage
  - Response time statistics
  - Active user count
  - Total feedback processed today/week/month
- System MUST provide access ke error logs
- System MUST show recent system errors dengan timestamps
- System MUST allow filtering/searching error logs
- System MUST display user activity monitoring dashboard

**FR-10.6: Audit Trail**
- System MUST log all admin actions dengan timestamps
- System MUST record which admin performed which action
- System MUST maintain audit log untuk compliance
- System MUST allow searching audit logs by date/admin/action type

---

## Non-Functional Requirements

### NFR-1: Performance

**NFR-1.1: Response Time**
- Dashboard pages MUST load within 3 seconds under normal conditions
- Feedback form MUST load within 2 seconds after QR code scan
- API endpoints MUST respond within 500ms for 95th percentile requests
- Database queries MUST execute within 200ms for standard operations
- Analytics calculations MUST complete within 5 seconds untuk 12-month dataset

**NFR-1.2: Throughput**
- System MUST support 100+ concurrent feedback submissions tanpa degradation
- System MUST handle 1000+ concurrent dashboard viewers
- System MUST process 10,000+ feedback responses per day
- API rate limiting MUST allow 100 requests per minute per user

**NFR-1.3: Scalability**
- System architecture MUST support horizontal scaling
- Database MUST scale untuk handle 100,000+ feedback responses
- System MUST maintain performance dengan 500+ active restaurant accounts
- Infrastructure MUST auto-scale based on load

### NFR-2: Reliability & Availability

**NFR-2.1: Uptime**
- System MUST maintain 99.9% uptime (max 43 minutes downtime per month)
- Planned maintenance windows MUST be scheduled during low-traffic hours
- System MUST notify users 48 hours before planned maintenance

**NFR-2.2: Data Integrity**
- System MUST prevent data loss dengan automated backups
- Database MUST perform automatic backups daily
- Backup retention MUST span minimum 30 days
- System MUST implement transaction rollback untuk failed operations
- System MUST validate all data before persisting ke database

**NFR-2.3: Error Handling**
- System MUST handle errors gracefully tanpa exposing technical details ke users
- System MUST log all errors dengan sufficient context untuk debugging
- System MUST display user-friendly error messages dalam Bahasa Indonesia
- System MUST recover automatically dari transient failures

**NFR-2.4: Fault Tolerance**
- System MUST continue operating with degraded functionality if subsystems fail
- Critical paths (feedback submission) MUST have redundancy
- System MUST queue feedback submissions if database temporarily unavailable

### NFR-3: Security

**NFR-3.1: Authentication & Authorization**
- System MUST implement secure authentication mechanisms (JWT atau session-based)
- System MUST enforce role-based access control (RBAC)
- System MUST implement multi-tenant data isolation
- System MUST prevent unauthorized access ke other restaurants' data
- Admin accounts MUST have elevated permissions dengan audit logging

**NFR-3.2: Data Protection**
- System MUST encrypt sensitive data at rest (passwords, PII)
- System MUST encrypt data in transit (HTTPS/TLS 1.3)
- System MUST use secure password hashing (bcrypt atau argon2)
- System MUST implement CSRF protection untuk all forms
- System MUST sanitize all user inputs untuk prevent XSS attacks

**NFR-3.3: Privacy**
- System MUST anonymize customer feedback data (no PII collection from customers)
- System MUST comply dengan basic data privacy principles
- System MUST provide data export functionality untuk users (GDPR-inspired)
- System MUST allow users to delete their accounts dan associated data

**NFR-3.4: Session Management**
- System MUST implement secure session handling
- System MUST timeout idle sessions after 30 minutes of inactivity
- System MUST invalidate sessions on password change
- System MUST prevent session fixation attacks

**NFR-3.5: Input Validation**
- System MUST validate all inputs on both client and server side
- System MUST sanitize inputs untuk prevent SQL injection
- System MUST implement rate limiting untuk prevent abuse
- System MUST validate file uploads (type, size, content)

### NFR-4: Usability

**NFR-4.1: User Interface**
- Interface MUST be intuitive untuk non-tech-savvy users
- Interface MUST use consistent design language across all pages
- Interface MUST provide clear visual hierarchy
- Interface MUST support mobile-first responsive design
- Interface MUST be accessible dalam Bahasa Indonesia

**NFR-4.2: Learnability**
- New users MUST be able to complete onboarding within 5 minutes
- Core features MUST be discoverable tanpa extensive documentation
- System MUST provide contextual help untuk complex features
- System MUST include tooltips untuk non-obvious UI elements

**NFR-4.3: Accessibility**
- Interface MUST support minimum WCAG 2.1 Level A compliance
- Forms MUST have proper labels untuk screen readers
- Color contrast MUST meet minimum ratios untuk readability
- Interface MUST be navigable via keyboard

**NFR-4.4: Mobile Experience**
- Customer feedback forms MUST be optimized untuk one-handed mobile use
- Touch targets MUST be minimum 44x44 pixels
- Dashboard MUST be fully functional pada smartphone screens
- System MUST work seamlessly dalam mobile browsers (no app required)

### NFR-5: Maintainability

**NFR-5.1: Code Quality**
- Codebase MUST follow consistent coding standards
- Code MUST be modular dan loosely coupled
- Code MUST include meaningful comments untuk complex logic
- Code MUST have minimum 70% test coverage

**NFR-5.2: Documentation**
- System MUST have comprehensive API documentation
- System MUST have database schema documentation
- System MUST have deployment documentation
- System MUST have user manual dalam Bahasa Indonesia

**NFR-5.3: Monitoring & Logging**
- System MUST implement comprehensive logging
- System MUST use structured logging format (JSON)
- System MUST integrate dengan monitoring tools (error tracking, performance monitoring)
- Logs MUST be retained for minimum 30 days

**NFR-5.4: Deployment**
- System MUST support automated deployment pipeline (CI/CD)
- System MUST use infrastructure as code (IaC)
- System MUST support zero-downtime deployments
- System MUST allow easy rollback ke previous versions

### NFR-6: Compatibility

**NFR-6.1: Browser Support**
- System MUST support modern browsers:
  - Chrome (latest 2 versions)
  - Firefox (latest 2 versions)
  - Safari (latest 2 versions)
  - Edge (latest 2 versions)
- System MUST work dalam mobile browsers (Chrome Mobile, Safari Mobile)

**NFR-6.2: Device Support**
- System MUST work pada devices dengan minimum screen width 320px
- System MUST support portrait dan landscape orientations
- QR codes MUST be scannable dengan standard smartphone cameras
- System MUST work tanpa requiring app installation

**NFR-6.3: Network Conditions**
- System MUST function acceptably pada 3G network speeds
- System MUST provide offline indicators when connection lost
- System MUST queue submissions during temporary network failures

### NFR-7: Localization

**NFR-7.1: Language Support**
- System MUST support Bahasa Indonesia untuk all UI text
- System MUST format dates dalam Indonesian format (DD/MM/YYYY)
- System MUST use Indonesian currency format (Rp)
- Error messages MUST be dalam Bahasa Indonesia

**NFR-7.2: Cultural Considerations**
- Rating scales MUST use culturally appropriate visual elements
- Communication tone MUST align dengan Indonesian business culture
- Examples dan help text MUST use local restaurant contexts

---

## Technical Constraints & Considerations

### Architecture Decisions

**Multi-Tenant SaaS Architecture:**
- Platform MUST implement data isolation per restaurant account
- Each restaurant MUST have separate data partition atau tenant ID
- Shared infrastructure dengan logical data separation
- Performance isolation untuk prevent noisy neighbor problems

**Mobile-First Web Application:**
- No native mobile app untuk MVP - web-based only
- Responsive web design untuk support all screen sizes
- Progressive Web App (PWA) capabilities optional enhancement
- QR code scan triggers mobile browser navigation

**Rule-Based Analytics:**
- No AI/ML atau NLP untuk sentiment analysis dalam MVP
- Sentiment calculated berdasarkan rating thresholds (1-2 negative, 3 neutral, 4-5 positive)
- Text feedback displayed as-is dalam inbox (no automated categorization)
- Cost-efficient approach yang delivers core value tanpa expensive ML infrastructure

### Technology Stack Recommendations

**Frontend:**
- Modern JavaScript framework (React, Vue, atau Svelte)
- Mobile-responsive CSS framework (Tailwind CSS atau Bootstrap)
- Chart library untuk analytics visualization (Chart.js atau Recharts)
- QR code generation library (qrcode.js)

**Backend:**
- RESTful API architecture
- Modern backend framework (Node.js/Express, Python/FastAPI, atau Go)
- Authentication: JWT atau session-based dengan secure cookies
- Email service integration (SendGrid, AWS SES, atau Mailgun)

**Database:**
- Relational database (PostgreSQL atau MySQL) untuk structured data
- Consider read replicas untuk analytics queries
- Indexes optimized untuk common query patterns
- Backup automation dan point-in-time recovery

**Infrastructure:**
- Cloud hosting (AWS, Google Cloud, atau DigitalOcean)
- Container-based deployment (Docker)
- Load balancer untuk high availability
- CDN untuk static assets
- SSL/TLS certificates (Let's Encrypt)

**Monitoring & Operations:**
- Error tracking (Sentry)
- Performance monitoring (New Relic atau DataDog)
- Uptime monitoring (UptimeRobot atau Pingdom)
- Log aggregation (CloudWatch, Stackdriver, atau ELK stack)

### Data Model Considerations

**Core Entities:**
1. **Users (Restaurant Owners)**
   - User credentials, profile information
   - Restaurant metadata
   - Subscription tier (post-MVP)

2. **Angket (Questionnaires)**
   - Question definitions, types, ordering
   - Template metadata
   - Customization settings

3. **QR Codes**
   - Unique IDs, names/labels
   - Linked angket ID
   - Activation status
   - Creation timestamp

4. **Feedback Responses**
   - Rating values per question
   - Text feedback content
   - Timestamp, QR code attribution
   - Status (Baru/Dalam Proses/Selesai)

5. **Support Tickets (Admin)**
   - Ticket details, status, priority
   - Admin responses dan notes
   - Resolution timestamps

**Relationships:**
- User → Angket (1:many)
- User → QR Code (1:many)
- Angket → QR Code (1:many)
- QR Code → Feedback Response (1:many)
- User → Support Ticket (1:many)

**Data Retention:**
- Feedback data retained indefinitely untuk historical analysis
- Deleted accounts: data anonymized atau purged after grace period
- Backup retention: 30 days minimum

### Integration Points

**MVP Integrations:**
- **Email Service:** Untuk verification emails, password resets, support ticket notifications
- **QR Code Generation:** Server-side library untuk generate high-quality QR codes

**Post-MVP Integrations:**
- **Payment Gateway:** Dana integration untuk subscription billing
- **SMS Service:** Optional SMS notifications untuk critical alerts
- **Social Login:** Google OAuth (already planned untuk MVP), potential Facebook login
- **Analytics Tools:** Google Analytics untuk platform usage tracking

### Performance Optimization Strategies

**Frontend Optimization:**
- Lazy loading untuk non-critical components
- Image optimization dan compression
- Asset minification dan bundling
- Browser caching strategies
- Code splitting untuk reduce initial load

**Backend Optimization:**
- Database query optimization dengan proper indexes
- Caching frequently accessed data (Redis atau in-memory)
- Connection pooling untuk database
- Pagination untuk large datasets
- Background jobs untuk heavy processing (report generation)

**Analytics Optimization:**
- Pre-aggregated statistics untuk common time ranges
- Materialized views untuk complex analytics queries
- Incremental calculations untuk real-time updates
- Efficient time-series data storage

### Security Best Practices

**Application Security:**
- Input validation dan sanitization di all layers
- Parameterized queries untuk prevent SQL injection
- CSRF tokens untuk all state-changing operations
- Secure headers (CSP, HSTS, X-Frame-Options)
- Rate limiting untuk prevent abuse

**Infrastructure Security:**
- Firewall rules untuk restrict access
- Regular security patches dan updates
- Secrets management (environment variables, secret stores)
- Database access restricted to application layer only
- Regular security audits

**Data Security:**
- Encryption at rest untuk sensitive data
- TLS 1.3 untuk all connections
- Secure password hashing (bcrypt rounds: 12+)
- Multi-tenant data isolation strictly enforced
- Regular backup testing dan disaster recovery drills

### Compliance Considerations

**Data Privacy:**
- Customer feedback collected anonymously (no PII required)
- Restaurant owner data protected dan not shared
- Clear privacy policy communicated
- Data export capability for users
- Account deletion functionality

**Accessibility:**
- Minimum WCAG 2.1 Level A compliance
- Keyboard navigation support
- Screen reader compatibility
- Sufficient color contrast ratios

**Indonesian Regulations:**
- Comply dengan Indonesian data protection principles
- Payment processing compliance (post-MVP dengan Dana)
- Tax considerations untuk SaaS business
- Terms of Service dan Privacy Policy dalam Bahasa Indonesia

---

## MVP Scope & Boundaries

### MVP Core Features (In Scope)

**Phase 1: Foundation (Must Have)**

1. **Public Pages & Authentication**
   - Landing page dengan value proposition
   - User registration (email + Gmail OAuth)
   - Email verification system
   - Login/logout functionality
   - Password reset flow
   - Session management

2. **Restaurant Owner Dashboard**
   - Dashboard home dengan overview stats
   - Overall sentiment score visualization
   - Total feedback count display
   - Rating trend indicators
   - Alert notifications untuk negative ratings
   - Time-based filtering (hari/minggu/bulan/tahun)

3. **Angket Management**
   - 3 pre-built restaurant templates (Casual Dining, Café, Fast Food)
   - CRUD operations untuk angket
   - Question types: Rating scales (1-5), Binary (Yes/No), Text feedback
   - Preview functionality
   - Template customization (add/remove/reorder questions)

4. **QR Code Management**
   - QR code generation dengan unique IDs
   - Link QR code ke specific angket
   - QR code naming/labeling untuk tracking
   - Download QR code (PNG/JPG, high-resolution)
   - Multiple QR codes per restaurant
   - QR code CRUD operations

5. **Customer-Facing Feedback Form**
   - Mobile-optimized responsive design
   - Visual rating system (emoji/stars)
   - Quick binary questions
   - Optional text feedback box
   - Progress indicator
   - Thank you screen
   - Target completion time: < 60 seconds
   - QR code attribution tracking

6. **Inbox - Feedback Management**
   - Display all text feedback responses
   - Associated rating data dengan feedback
   - Status management (Baru/Dalam Proses/Selesai)
   - Filter by status, date range, QR code source
   - Alert system untuk negative feedback
   - Feedback detail view
   - Timestamp tracking

7. **Analisis - Analytics Dashboard**
   - Overall sentiment pie chart (Positif/Netral/Negatif)
   - QR code performance comparison bar chart
   - Trend analysis line graph dengan time-series
   - Peak hours analysis
   - Category breakdown by question type
   - Time-based filtering (hari/minggu/bulan/tahun)

8. **Laporan - Report Export**
   - Export ke Excel (.xlsx)
   - Export ke CSV (.csv)
   - Custom date range selection
   - Comprehensive data: ratings, text feedback, timestamps, QR attribution, status
   - Proper file naming convention
   - Download functionality

9. **Settings - Profile & Account**
   - Profile photo/logo upload
   - Update restaurant name, owner name, email
   - Password change functionality
   - Contact admin/support ticket submission
   - View ticket status dan history

10. **Admin Dashboard - Platform Management**
    - User management interface (list, search, filter users)
    - Account administration (activate/suspend accounts)
    - Support ticket management system
    - Ticket response dan internal notes
    - Platform health monitoring (uptime, active users, feedback processed)
    - Error log access
    - Audit trail for admin actions

### MVP Out of Scope (Deferred to V2)

**Subscription & Payment System (Deferred):**
- Dana payment integration
- Free/Starter/Business tier management
- Billing dashboard dan invoice generation
- Subscription upgrade/downgrade flows
- Payment history dan transaction logs
- **Rationale:** MVP will operate as unlimited free trial untuk validate product-market fit dan user adoption sebelum introduce monetization complexity

**Advanced Admin Features (Deferred):**
- Impersonate user functionality (debug tool)
- Advanced fraud detection
- Automated user analytics dan insights
- Bulk user operations
- **Rationale:** Manual admin operations sufficient untuk MVP dengan projected ~100 users dalam 3 bulan

**Additional Analytics Graphs (Deferred):**
- Advanced correlation analysis (misal: "Negative service ratings spike during lunch rush")
- Predictive analytics (forecast rating trends)
- Comparative benchmarking (compare performance vs similar restaurants)
- Custom dashboard builder untuk users
- A/B testing untuk questionnaire optimization
- **Rationale:** Core analytics (sentiment, QR performance, trends, peak hours) already deliver MVP value proposition

**Advanced Questionnaire Features (Deferred):**
- Conditional logic (skip logic based on answers)
- Question branching
- Media upload (image/video dalam questions atau responses)
- Multi-language support untuk questionnaires
- Template marketplace (users share/sell templates)
- **Rationale:** Pre-built templates dengan standard question types sufficient untuk MVP

**Integration & API (Deferred):**
- Third-party integrations (Google My Business, social media)
- Public API untuk developers
- Webhook notifications
- Export to other platforms (Zapier)
- POS system integrations
- CRM integrations
- **Rationale:** MVP fokus standalone functionality. Integrations adalah enhancement untuk scaling phase

**Collaboration Features (Deferred):**
- Multi-user accounts (owner, manager, staff dengan different permissions)
- Team collaboration on feedback resolution
- Internal notes dan communication on feedback items
- Role-based access control (RBAC) beyond basic admin
- **Rationale:** MVP targets single-user restaurant management. Multi-user support adds complexity

**Advanced Mobile Features (Deferred):**
- Progressive Web App (PWA) capabilities
- Offline mode untuk dashboard
- Push notifications
- Native mobile app (iOS/Android)
- **Rationale:** Mobile-responsive web sufficient untuk MVP. PWA/native apps enhance experience but not critical

### MVP Success Criteria (3-Month Target)

**User Adoption:**
- 100 café/restoran successfully register dan verify accounts
- 70%+ activation rate (complete onboarding: create angket + deploy QR)
- 50%+ active usage (login at least weekly)
- Average 50+ feedback responses per active café per month

**Problem Validation:**
- 10+ user testimonials explicitly stating "this solved my problem"
- 30%+ of active users report measurable café rating improvement
- Users checking dashboard daily (habit formation)
- Users creating multiple QR codes (advanced adoption)

**Technical Feasibility:**
- 99%+ platform uptime during MVP period
- Dashboard load time < 3 seconds
- Feedback form completion rate > 80% (customers who scan actually complete)
- Zero critical data loss incidents

**Business Model Validation (Pre-Monetization):**
- User surveys showing willingness to pay when subscription introduced
- Users exporting reports regularly (indicates data dependency)
- < 10% user churn during free trial period
- All core features used by 80%+ of active users

**Go/No-Go Decision Point:**
- **GO to V2 (with subscription):** If 50+ paying customers commit dalam surveys, 70%+ active usage, clear rating improvement evidence
- **PIVOT:** If activation rate < 30%, feedback volume low, users not seeing rating improvement
- **ITERATE MVP:** If engagement mixed, optimize specific features before monetization

### MVP Constraints

**Time Constraint:**
- Target MVP launch timeline based on development team capacity
- Phased rollout approach: internal testing → beta users → public launch

**Budget Constraint:**
- Infrastructure costs minimized dengan cloud provider free tiers atau cost-effective options
- Email service free tier sufficient untuk MVP volume
- No paid third-party services beyond essential infrastructure

**Team Constraint:**
- Development team size determines feature prioritization
- Focus on core value delivery over polish
- Iterative approach: ship minimal viable features, improve based on feedback

**Technical Constraint:**
- Use proven technologies untuk reduce development risk
- Avoid bleeding-edge tech yang requires extensive learning
- Leverage open-source libraries untuk common functionality
- Keep architecture simple dan maintainable

---

## Implementation Roadmap

### Phase 1: Foundation & Core Infrastructure

**Duration:** ~4-6 weeks

**Objectives:**
- Establish technical foundation
- Implement authentication dan basic user management
- Set up database schema dan API structure
- Deploy basic infrastructure

**Key Deliverables:**
1. **Infrastructure Setup**
   - Cloud hosting environment (AWS/GCP/DigitalOcean)
   - Database setup (PostgreSQL/MySQL)
   - CI/CD pipeline configuration
   - Domain dan SSL certificates
   - Monitoring dan error tracking setup

2. **Authentication System**
   - User registration dengan email
   - Gmail OAuth integration
   - Email verification flow
   - Login/logout functionality
   - Password reset mechanism
   - Session management

3. **Database Schema**
   - Users table (restaurant owners)
   - Angket/questionnaires table
   - QR codes table
   - Feedback responses table
   - Support tickets table
   - Admin audit logs table

4. **API Foundation**
   - RESTful API structure
   - Authentication middleware
   - Multi-tenant data isolation
   - Input validation framework
   - Error handling patterns

5. **Admin Dashboard Basic**
   - Admin authentication
   - User management interface
   - Basic platform monitoring

**Success Criteria:**
- Infrastructure deployed dan accessible
- Users can register, verify email, dan login
- Database schema validated dan optimized
- API endpoints documented dan tested

### Phase 2: Restaurant Owner Core Features

**Duration:** ~6-8 weeks

**Objectives:**
- Implement core restaurant owner features
- Enable angket creation dan QR code generation
- Build dashboard dengan basic analytics

**Key Deliverables:**
1. **Angket Management**
   - 3 pre-built restaurant templates
   - CRUD operations untuk angket
   - Question builder interface
   - Preview functionality
   - Template customization

2. **QR Code System**
   - QR code generation
   - QR code naming/labeling
   - Download functionality
   - Multiple QR codes management
   - QR-angket linking

3. **Dashboard Home**
   - Overview statistics
   - Sentiment score visualization
   - Total feedback count
   - Rating trend indicators
   - Alert notifications
   - Time-based filtering UI

4. **Settings & Profile**
   - Profile photo/logo upload
   - Account information updates
   - Password change
   - Support ticket submission

**Success Criteria:**
- Restaurant owners can create angket dari template
- QR codes successfully generated dan downloadable
- Dashboard displays meaningful overview stats
- Users can manage their profile dan submit support tickets

### Phase 3: Customer-Facing & Feedback Collection

**Duration:** ~4-5 weeks

**Objectives:**
- Build mobile-optimized feedback form
- Implement feedback storage dan processing
- Enable QR code scan → feedback submission flow

**Key Deliverables:**
1. **Feedback Form**
   - Mobile-responsive design
   - Visual rating system (emoji/stars)
   - Binary questions
   - Text feedback box
   - Progress indicator
   - Thank you screen
   - QR code attribution tracking

2. **Feedback Processing**
   - Store feedback responses
   - Link responses ke QR codes
   - Timestamp tracking
   - Status initialization (default: "Baru")
   - Real-time dashboard updates

3. **Inbox System**
   - Display all feedback responses
   - Show associated rating data
   - Status management UI
   - Filter by status, date, QR source
   - Alert system untuk negative feedback
   - Feedback detail view

**Success Criteria:**
- Customers can scan QR codes dan complete feedback < 60 seconds
- Feedback correctly stored dan attributed ke QR codes
- Restaurant owners can view dan manage feedback dalam inbox
- Negative feedback triggers alerts

### Phase 4: Analytics & Insights

**Duration:** ~4-5 weeks

**Objectives:**
- Implement analytics calculations
- Build visualization charts
- Enable trend analysis dan insights

**Key Deliverables:**
1. **Sentiment Analysis**
   - Rule-based sentiment calculation (1-2 negative, 3 neutral, 4-5 positive)
   - Pie chart visualization
   - Percentage breakdown display
   - Time-filtered calculations

2. **QR Code Performance**
   - Average rating per QR code
   - Bar chart comparison
   - Identify highest/lowest performing QR codes
   - Sample size display

3. **Trend Analysis**
   - Time-series data aggregation
   - Line graph visualization
   - Trend direction indicators
   - Zoom/pan functionality

4. **Peak Hours Analysis**
   - Hourly sentiment breakdown
   - Heatmap atau bar chart
   - Identify peak negative/positive periods
   - Operational insights display

5. **Category Breakdown**
   - Rating breakdown by question category
   - Comparison bar charts
   - Identify lowest-rated categories

**Success Criteria:**
- Analytics accurately calculate sentiment berdasarkan rating data
- Charts render correctly dengan meaningful visualizations
- Time-based filtering works seamlessly
- Insights are actionable untuk restaurant operations

### Phase 5: Reports & Advanced Features

**Duration:** ~3-4 weeks

**Objectives:**
- Implement report export functionality
- Build admin platform management features
- Optimize performance dan polish UX

**Key Deliverables:**
1. **Report Export**
   - Excel (.xlsx) export
   - CSV export
   - Custom date range selection
   - Comprehensive data inclusion
   - Proper file formatting dan naming

2. **Admin Dashboard Advanced**
   - Support ticket management
   - Ticket response system
   - Internal notes
   - Priority tagging
   - Platform health metrics
   - Error log access
   - Audit trail

3. **Performance Optimization**
   - Database query optimization
   - Caching implementation
   - Frontend lazy loading
   - Image optimization
   - Load time improvements

4. **UX Polish**
   - Loading states dan progress indicators
   - Error message improvements
   - Tooltips dan contextual help
   - Responsive design refinements
   - Accessibility improvements

**Success Criteria:**
- Users can export reports dalam Excel dan CSV format
- Admin team can efficiently manage support tickets
- Dashboard loads < 3 seconds
- Mobile experience smooth dan intuitive

### Phase 6: Testing, Beta Launch & Iteration

**Duration:** ~4-6 weeks

**Objectives:**
- Comprehensive testing (functionality, performance, security)
- Beta launch dengan selected restaurants
- Gather feedback dan iterate
- Prepare for public launch

**Key Deliverables:**
1. **Testing**
   - Unit tests untuk critical paths
   - Integration tests untuk API endpoints
   - End-to-end tests untuk user flows
   - Performance testing (load, stress)
   - Security testing (penetration testing, vulnerability scanning)
   - Accessibility testing
   - Mobile device testing

2. **Beta Launch**
   - Select 10-20 beta restaurant partners
   - Onboard beta users dengan support
   - Monitor usage patterns dan issues
   - Gather qualitative feedback
   - Track success metrics

3. **Iteration Based on Feedback**
   - Fix critical bugs
   - Improve confusing UX elements
   - Optimize performance bottlenecks
   - Enhance features based on user requests
   - Refine onboarding flow

4. **Documentation**
   - User manual dalam Bahasa Indonesia
   - FAQ documentation
   - Video tutorials (optional)
   - Support knowledge base

5. **Launch Preparation**
   - Landing page optimization
   - Marketing materials preparation
   - Support process establishment
   - Monitoring dan alerting setup
   - Backup dan disaster recovery testing

**Success Criteria:**
- All critical bugs fixed
- Beta users successfully onboarded dan active
- Performance metrics meet NFR targets
- Security vulnerabilities addressed
- Documentation complete dan helpful
- Ready for public launch

### Phase 7: Public Launch & Growth

**Objectives:**
- Public launch dengan marketing campaign
- Onboard first 100 restaurants
- Monitor platform stability
- Iterate based on user feedback
- Validate MVP success criteria

**Key Activities:**
1. **Launch Execution**
   - Public announcement (social media, komunitas F&B)
   - Landing page live dengan registration
   - Support team ready untuk inquiries
   - Monitoring dashboard active
   - Error tracking dan alerting

2. **User Acquisition**
   - Marketing campaigns (paid ads, content marketing)
   - Community outreach (F&B groups, forums)
   - Referral program (optional)
   - Partnership dengan F&B associations

3. **Monitoring & Support**
   - Daily platform health checks
   - Rapid response to critical issues
   - Support ticket management
   - User feedback collection
   - Usage analytics tracking

4. **Iteration & Improvement**
   - Weekly feature improvements
   - Bug fixes prioritization
   - Performance optimizations
   - UX refinements based on feedback

5. **Success Metrics Tracking**
   - User acquisition rate
   - Activation rate (onboarding completion)
   - Active usage rate
   - Feedback volume per restaurant
   - User satisfaction surveys
   - Rating improvement testimonials

**3-Month Checkpoint:**
- Evaluate MVP success criteria
- Decide: GO to V2 (subscription) vs. PIVOT vs. ITERATE MVP
- Plan next phase based on learnings

---

## Dependencies & Risks

### External Dependencies

**Third-Party Services:**

1. **Email Service Provider**
   - **Dependency:** SendGrid, AWS SES, atau Mailgun untuk email verification, password resets, notifications
   - **Risk:** Service outage atau rate limiting
   - **Mitigation:** Choose reliable provider dengan 99.9%+ uptime SLA. Implement email queuing untuk retry failed sends. Have backup provider configured.

2. **Cloud Hosting Provider**
   - **Dependency:** AWS, Google Cloud, atau DigitalOcean untuk infrastructure
   - **Risk:** Service outage, pricing changes, region unavailability
   - **Mitigation:** Choose provider dengan strong SLA. Implement auto-scaling dan redundancy. Monitor costs closely. Design architecture untuk potential multi-cloud.

3. **SSL Certificate Provider**
   - **Dependency:** Let's Encrypt untuk SSL/TLS certificates
   - **Risk:** Certificate expiration, renewal failures
   - **Mitigation:** Automated renewal process dengan monitoring. Alerts untuk certificate expiration. Manual renewal fallback.

4. **QR Code Generation Library**
   - **Dependency:** Open-source library (qrcode.js atau similar)
   - **Risk:** Library bugs, maintenance discontinued
   - **Mitigation:** Use well-maintained popular library. Keep updated. Have fallback library identified.

5. **OAuth Provider (Gmail)**
   - **Dependency:** Google OAuth API untuk Gmail login
   - **Risk:** API changes, service interruptions, policy changes
   - **Mitigation:** Email/password login as primary option. OAuth as convenience feature. Monitor Google API announcements.

**Post-MVP Dependencies:**

6. **Payment Gateway (Dana)**
   - **Dependency:** Dana API untuk subscription payments
   - **Risk:** Integration complexity, API changes, regulatory changes
   - **Mitigation:** Thorough integration testing. Monitor Dana API updates. Compliance with payment regulations.

### Technical Risks

**TR-1: Performance at Scale**
- **Risk:** Platform performance degrades dengan increased user load atau data volume
- **Impact:** High - Poor performance leads to user churn
- **Probability:** Medium - Expected dengan growth
- **Mitigation:**
  - Design for horizontal scalability from start
  - Implement caching strategies (Redis)
  - Optimize database queries dengan proper indexes
  - Use pagination untuk large datasets
  - Load testing before launch
  - Monitor performance metrics continuously
  - Plan for auto-scaling infrastructure

**TR-2: Data Loss or Corruption**
- **Risk:** Critical feedback data lost atau corrupted
- **Impact:** Critical - Loss of trust, legal issues
- **Probability:** Low - With proper safeguards
- **Mitigation:**
  - Automated daily backups dengan 30-day retention
  - Point-in-time recovery capability
  - Transaction rollback untuk failed operations
  - Data validation before persistence
  - Regular backup restoration testing
  - Audit trails untuk data changes

**TR-3: Security Vulnerabilities**
- **Risk:** Security breach, unauthorized access, data leak
- **Impact:** Critical - Reputation damage, legal liability
- **Probability:** Medium - Constant threat
- **Mitigation:**
  - Follow security best practices (OWASP Top 10)
  - Input validation dan sanitization
  - SQL injection prevention (parameterized queries)
  - XSS prevention (output encoding)
  - CSRF protection
  - Regular security audits
  - Penetration testing before launch
  - Bug bounty program (post-MVP)

**TR-4: Multi-Tenant Data Isolation Failure**
- **Risk:** Restaurant data leaked ke other restaurants
- **Impact:** Critical - Legal liability, trust destruction
- **Probability:** Low - With proper implementation
- **Mitigation:**
  - Strict tenant ID enforcement dalam all queries
  - Database-level row security policies
  - Comprehensive integration tests untuk data isolation
  - Regular audit of data access patterns
  - Security code reviews

**TR-5: Mobile Browser Compatibility Issues**
- **Risk:** Feedback form doesn't work properly pada certain mobile browsers atau devices
- **Impact:** Medium - Reduced feedback completion rate
- **Probability:** Medium - Browser fragmentation
- **Mitigation:**
  - Test pada multiple mobile browsers (Chrome Mobile, Safari Mobile, etc.)
  - Use progressive enhancement approach
  - Fallback functionality untuk unsupported features
  - Monitor browser analytics
  - Quick fix process untuk critical compatibility issues

**TR-6: Third-Party Service Failures**
- **Risk:** Email service, cloud hosting, atau other dependencies fail
- **Impact:** High - Platform unavailable atau degraded
- **Probability:** Low - With reliable providers
- **Mitigation:**
  - Choose providers dengan strong SLA guarantees
  - Implement retry logic dengan exponential backoff
  - Queue critical operations (email sending)
  - Graceful degradation untuk non-critical features
  - Monitoring dan alerting untuk service health
  - Have backup providers identified

### Product Risks

**PR-1: Low User Adoption**
- **Risk:** Restaurants don't sign up atau activate accounts
- **Impact:** High - MVP fails to validate market
- **Probability:** Medium - New product, unproven market fit
- **Mitigation:**
  - Clear value proposition pada landing page
  - Simplified onboarding flow (< 5 minutes)
  - Free trial dengan no credit card required
  - Pre-launch beta dengan selected restaurants untuk testimonials
  - Strong marketing campaign targeting restaurant communities
  - Referral incentives

**PR-2: Poor Feedback Completion Rate**
- **Risk:** Customers scan QR codes but don't complete feedback forms
- **Impact:** High - Core value proposition fails
- **Probability:** Medium - Dependent pada form UX
- **Mitigation:**
  - Aggressive form optimization (< 60 second completion target)
  - Visual rating system yang engaging
  - Minimal required fields
  - Progress indicators
  - A/B testing form variations (post-launch)
  - Optional incentives (discount untuk completed feedback)

**PR-3: Insufficient Actionable Insights**
- **Risk:** Analytics don't provide actionable insights untuk restaurants
- **Impact:** High - Users don't see value, churn
- **Probability:** Low - With restaurant-specific analytics
- **Mitigation:**
  - Pre-built analytics tailored untuk restaurant operations
  - Focus on actionable metrics (peak hours, QR performance, category breakdown)
  - User research untuk identify most valuable insights
  - Iterate analytics based on user feedback
  - Provide interpretation guidance dalam UI

**PR-4: Competition from Existing Tools**
- **Risk:** Generic survey tools (Google Forms, etc.) good enough untuk restaurants
- **Impact:** Medium - Slower adoption
- **Probability:** Medium - Alternatives exist
- **Mitigation:**
  - Strong differentiation (restaurant-first design, QR-native, pre-built templates)
  - Emphasize ease of use dan time savings
  - Show comparative advantages dalam marketing
  - Build features generic tools can't (QR-specific analytics, location-based insights)

**PR-5: Users Not Seeing Rating Improvement**
- **Risk:** Restaurants collect feedback but don't see measurable improvement
- **Impact:** High - Core value proposition invalidated
- **Probability:** Medium - Dependent pada restaurants taking action
- **Mitigation:**
  - Provide clear guidance pada taking action based on feedback
  - Best practices documentation untuk responding to feedback
  - Case studies dari successful beta users
  - Inbox workflow encourages action (status tracking)
  - Trend analysis shows improvement over time
  - User education webinars atau content

### Business Risks

**BR-1: Pricing Model Rejection (Post-MVP)**
- **Risk:** Users unwilling to pay proposed subscription prices
- **Impact:** High - Revenue model fails
- **Probability:** Medium - Price sensitivity dalam UMKM segment
- **Mitigation:**
  - Pricing research during MVP phase (surveys, interviews)
  - Multiple tier options untuk different budget levels
  - Free tier dengan basic features untuk price-sensitive users
  - Clear ROI communication (improved ratings = more customers)
  - Grandfather pricing untuk early adopters
  - Flexible pricing adjustments based on feedback

**BR-2: High Customer Acquisition Cost**
- **Risk:** CAC too high relative to potential LTV
- **Impact:** High - Unsustainable business model
- **Probability:** Medium - Depends on marketing efficiency
- **Mitigation:**
  - Focus on organic growth channels (content marketing, community)
  - Referral program untuk lower CAC
  - Targeted advertising to specific geographic areas
  - Partnership dengan F&B associations untuk bulk acquisition
  - Optimize conversion funnel untuk improve efficiency
  - Track CAC closely dan iterate marketing strategy

**BR-3: High Churn Rate**
- **Risk:** Restaurants sign up but stop using platform quickly
- **Impact:** High - Unable to build sustainable user base
- **Probability:** Medium - Depends on ongoing value delivery
- **Mitigation:**
  - Strong onboarding untuk ensure initial success
  - Regular engagement (email newsletters, feature updates)
  - Customer success outreach untuk at-risk accounts
  - Continuously improve product based on feedback
  - Build habit formation (daily dashboard check)
  - Retention-focused features (historical data, trend analysis)

**BR-4: Regulatory Changes (Payment/Data)**
- **Risk:** Changes dalam Indonesian regulations affect operations
- **Impact:** Medium-High - Depending on regulation type
- **Probability:** Low - Stable regulatory environment
- **Mitigation:**
  - Stay informed about regulatory developments
  - Legal consultation untuk compliance
  - Privacy-first design (anonymous feedback collection)
  - Flexible architecture untuk adapt to regulatory changes
  - Compliance documentation maintained

**BR-5: Team Capacity Constraints**
- **Risk:** Development team unable to deliver MVP on timeline
- **Impact:** Medium - Delayed launch, missed market opportunities
- **Probability:** Medium - Common dalam software development
- **Mitigation:**
  - Realistic timeline planning dengan buffer
  - Ruthless prioritization of MVP features
  - Phased rollout approach (soft launch before full public launch)
  - Technical debt management
  - Consider contractors untuk specific tasks if needed
  - Regular progress reviews dan adjustments

### Risk Monitoring & Management

**Risk Management Process:**

1. **Weekly Risk Review**
   - Review risk register
   - Assess new risks
   - Update risk probabilities dan impacts
   - Adjust mitigation strategies

2. **Key Risk Indicators (KRIs)**
   - Platform uptime percentage
   - Error rate trends
   - User activation rate
   - Feedback completion rate
   - Support ticket volume dan resolution time

3. **Escalation Triggers**
   - Platform downtime > 1 hour
   - Security incident detected
   - Critical bug affecting > 10% of users
   - User activation rate < 30%
   - Feedback completion rate < 50%

4. **Contingency Plans**
   - Disaster recovery procedure documented
   - Rollback process tested
   - Communication templates untuk service interruptions
   - Emergency contact list (team, vendors, partners)
   - Post-incident review process

---

## Appendix

### Glossary

**Key Terms:**

- **Angket:** Questionnaire atau survey form yang di-customize oleh restaurant owner
- **QR Code Attribution:** Tracking system untuk identify which QR code generated specific feedback
- **Sentiment Analysis:** Rule-based calculation untuk classify feedback sebagai Positif, Netral, atau Negatif berdasarkan rating values
- **Multi-Tenant Architecture:** System design yang allows multiple restaurants (tenants) to use platform dengan data isolation
- **MVP (Minimum Viable Product):** Initial version dengan core features sufficient untuk validate product-market fit
- **Activation Rate:** Percentage of registered users yang complete onboarding (create angket + deploy QR)
- **Feedback Completion Rate:** Percentage of customers yang scan QR code dan actually complete feedback submission
- **Peak Hours Analysis:** Analytics feature untuk identify time periods dengan highest positive atau negative sentiment
- **Status Management:** System untuk track feedback resolution progress (Baru → Dalam Proses → Selesai)

### References

**Industry Best Practices:**
- Restaurant feedback collection methodologies
- QR code implementation guidelines
- Mobile-first web design principles
- SaaS B2B onboarding best practices
- Multi-tenant SaaS architecture patterns

**Technical Standards:**
- WCAG 2.1 Accessibility Guidelines
- OWASP Top 10 Security Principles
- RESTful API Design Standards
- Mobile Web Best Practices (Google, Mozilla)

**Market Research:**
- Indonesia restaurant industry statistics
- F&B UMKM survey data
- Customer feedback platform landscape analysis
- Mobile internet usage patterns di Indonesia

### Document History

| Version | Date | Author | Changes |
|---------|------|--------|---------|
| 1.0 | 2025-12-05 | Lio | Initial PRD creation - Complete MVP specification |

### Approval

**Stakeholders:**
- Product Owner: Lio
- Technical Lead: [To be assigned]
- Business Stakeholder: [To be assigned]

**Approval Status:**
- [X] PRD Draft Complete
- [ ] Technical Review
- [ ] Stakeholder Approval
- [ ] Development Ready

---

**END OF DOCUMENT**
