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
        Schema::create('phase_histroys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('requests')->onDelete('cascade');
            $table->enum('phase_name', ['open','document_verification', 'calling_report', 'final_decision', 'completed']);
            $table->enum('status', ['open','verified', 'returned', 'resubmitted', 'report_called', 'inspection_completed', 'approved', 'clarification', 'escalated', 'rejected', 'completed']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phase_histroys');
    }
};
