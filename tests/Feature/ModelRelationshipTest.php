<?php

use App\Models\User;
use App\Models\Restaurant;
use App\Models\Questionnaire;
use App\Models\QrCode;
use App\Models\FeedbackResponse;
use App\Models\SupportTicket;
use App\Models\AdminAuditLog;
use Illuminate\Support\Facades\Schema;

test('models exist', function () {
    expect(class_exists(Restaurant::class))->toBeTrue();
    expect(class_exists(Questionnaire::class))->toBeTrue();
    expect(class_exists(QrCode::class))->toBeTrue();
    expect(class_exists(FeedbackResponse::class))->toBeTrue();
    expect(class_exists(SupportTicket::class))->toBeTrue();
    expect(class_exists(AdminAuditLog::class))->toBeTrue();
});

test('relationships are instance of correct class', function () {
    $restaurant = new Restaurant();
    expect($restaurant->questionnaires())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
    expect($restaurant->qrCodes())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);

    $questionnaire = new Questionnaire();
    expect($questionnaire->restaurant())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    expect($questionnaire->qrCodes())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);

    $qrCode = new QrCode();
    expect($qrCode->questionnaire())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    expect($qrCode->feedbackResponses())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);

    $feedback = new FeedbackResponse();
    expect($feedback->qrCode())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);

    $ticket = new SupportTicket();
    expect($ticket->user())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);

    $audit = new AdminAuditLog();
    expect($audit->user())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
});

test('tenant trait is applied', function () {
    expect(in_array('App\Models\Traits\BelongsToTenant', class_uses_recursive(Restaurant::class)))->toBeTrue();
    expect(in_array('App\Models\Traits\BelongsToTenant', class_uses_recursive(Questionnaire::class)))->toBeTrue();
    expect(in_array('App\Models\Traits\BelongsToTenant', class_uses_recursive(QrCode::class)))->toBeTrue();
    expect(in_array('App\Models\Traits\BelongsToTenant', class_uses_recursive(FeedbackResponse::class)))->toBeTrue();
    expect(in_array('App\Models\Traits\BelongsToTenant', class_uses_recursive(SupportTicket::class)))->toBeTrue();
});
