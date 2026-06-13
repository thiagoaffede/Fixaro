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
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('problem_id')->constrained()->onDelete('cascade');
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->decimal('price_estimate', 10, 2)->nullable();
            $table->string('time_estimate')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'accepted', 'ignored', 'expired'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responses');
    }
};
