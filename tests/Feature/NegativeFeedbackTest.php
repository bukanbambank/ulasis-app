<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\QrCode;
use App\Models\Tenant;
use App\Mail\NegativeFeedbackAlert;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB; // Use DB facade for setup to avoid Tenancy issues
use Tests\TestCase;

class NegativeFeedbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_negative_feedback_triggers_email_alert()
    {
        Mail::fake();

        // 1. Setup Tenant and User
        $tenantId = 'test-tenant-alert';
        DB::table('tenants')->insert(['id' => $tenantId, 'created_at' => now(), 'updated_at' => now()]);

        $user = User::factory()->create([
            'tenant_id' => $tenantId,
            'email' => 'owner@example.com'
        ]);

        // 2. Setup Questionnaire and QR Code
        $questionnaireId = DB::table('questionnaires')->insertGetId([
            'tenant_id' => $tenantId,
            'title' => 'Test Q',
            'template_type' => 'custom',
            'questions' => json_encode([]),
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $qrCodeId = DB::table('qr_codes')->insertGetId([
            'tenant_id' => $tenantId,
            'unique_code' => 'neg-feedback-code',
            'name' => 'Table 1',
            'is_active' => true,
            'questionnaire_id' => $questionnaireId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Submit Negative Feedback (Avg < 3)
        $response = $this->post(route('feedback.store', 'neg-feedback-code'), [
            'ratings' => [1 => 1, 2 => 2], // Avg 1.5
            'feedback_text' => 'Terrible service',
        ]);

        // 4. Assertions
        $response->assertRedirect(route('feedback.thank-you'));

        Mail::assertSent(NegativeFeedbackAlert::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function test_positive_feedback_does_not_trigger_email()
    {
        Mail::fake();

        // 1. Setup Tenant and User
        $tenantId = 'test-tenant-positive';
        DB::table('tenants')->insert(['id' => $tenantId, 'created_at' => now(), 'updated_at' => now()]);

        $user = User::factory()->create([
            'tenant_id' => $tenantId,
            'email' => 'owner2@example.com'
        ]);

        // 2. Setup Questionnaire and QR Code
        $questionnaireId = DB::table('questionnaires')->insertGetId([
            'tenant_id' => $tenantId,
            'title' => 'Test Q',
            'template_type' => 'custom',
            'questions' => json_encode([]),
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $qrCodeId = DB::table('qr_codes')->insertGetId([
            'tenant_id' => $tenantId,
            'unique_code' => 'pos-feedback-code',
            'name' => 'Table 2',
            'is_active' => true,
            'questionnaire_id' => $questionnaireId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Submit Positive Feedback (Avg 5)
        $response = $this->post(route('feedback.store', 'pos-feedback-code'), [
            'ratings' => [1 => 5, 2 => 5], // Avg 5
            'feedback_text' => 'Great!',
        ]);

        // 4. Assertions
        Mail::assertNotSent(NegativeFeedbackAlert::class);
    }
}
