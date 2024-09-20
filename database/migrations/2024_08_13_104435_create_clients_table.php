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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nic')->unique();
            $table->string('client_number')->unique();
            $table->string('gender');
            $table->date('dob');
            $table->text('street_name');
            $table->foreignId('province_id')->constrained('provinces')->onDelete('cascade');
            $table->foreignId('district_id')->constrained('districts')->onDelete('cascade');
            $table->foreignId('divisional_secretariat_id')->constrained('divisions')->onDelete('cascade');
            $table->foreignId('gn_division_id')->constrained('g_n_divisions')->onDelete('cascade');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('tel')->nullable();
            $table->boolean('delete_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
