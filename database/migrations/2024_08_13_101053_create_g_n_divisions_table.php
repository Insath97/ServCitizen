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
        Schema::create('g_n_divisions', function (Blueprint $table) {
            $table->id();
            $table->integer('code');
            $table->string('name');
            $table->foreignId('divisional_secretariat_id')->constrained('divisions')->onDelete('cascade');
            $table->boolean('delete_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('g_n_divisions');
    }
};
