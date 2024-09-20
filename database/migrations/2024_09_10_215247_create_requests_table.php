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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('token_number')->unique();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('main_service_type_id')->constrained('main_service_types')->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('cascade');
            $table->foreignId('sub_service_id')->nullable()->constrained('sub_services')->onDelete('cascade');
            $table->foreignId('status_id')->nullable()->constrained('statuses')->onDelete('set null');
            $table->text('description')->nullable();

            $table->enum('current_phase', ['open','document_verification', 'calling_report', 'final_decision', 'completed'])
                ->default('open');

            $table->enum('document_verification_status', ['verified', 'returned', 'resubmitted'])->nullable();
            $table->date('document_verification_date')->nullable();

            $table->enum('calling_report_status', ['report_called', 'inspection_completed'])->nullable();
            $table->date('calling_report_date')->nullable();

            $table->enum('final_decision_status', ['approved', 'clarification', 'escalated', 'rejected'])->nullable();
            $table->date('final_decision_date')->nullable();

            $table->enum('completion_status', ['completed'])->nullable();
            $table->date('completion_date')->nullable();

            $table->string('payment_status');
            $table->boolean('delete_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
