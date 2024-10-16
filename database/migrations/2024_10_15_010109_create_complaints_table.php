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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('complaint_type', ['online', 'offline']);
            $table->string('complainant_name')->nullable();
            $table->string('complainant_email')->nullable();
            $table->string('platform')->nullable();
            $table->string('complainant_name_offline')->nullable();
            $table->string('complainant_nic_offline')->nullable();
            $table->string('subject');
            $table->text('description');
            $table->boolean('delete_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
