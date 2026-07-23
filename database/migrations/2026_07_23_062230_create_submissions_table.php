<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->foreignId('citizen_id')->constrained()->cascadeOnDelete();
            $table->enum('service_type', ['kk', 'akta-lahir', 'akta-mati']);
            $table->json('form_data');
            $table->enum('status', ['SUBMITTED', 'IN_REVIEW', 'APPROVED', 'REJECTED', 'EXPIRED'])->default('SUBMITTED');
            $table->text('note')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
