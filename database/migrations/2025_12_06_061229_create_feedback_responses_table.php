<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('feedback_responses', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id');
            $table->foreignId('qr_code_id')->constrained('qr_codes')->onDelete('cascade');
            $table->json('ratings')->nullable(); // Stores feedback answers
            $table->text('feedback_text')->nullable();
            $table->json('customer_info')->nullable(); // Stores optional customer data
            $table->timestamp('created_at')->useCurrent()->index(); // Indexed for analytics
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('tenant_id')->references('id')->on('tenants')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_responses');
    }
};
