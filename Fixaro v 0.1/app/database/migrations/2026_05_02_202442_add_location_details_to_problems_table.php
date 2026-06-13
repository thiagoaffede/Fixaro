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
        Schema::table('problems', function (Blueprint $table) {
            $table->string('address')->nullable()->after('location');
            $table->decimal('lat', 10, 8)->nullable()->after('address');
            $table->decimal('lng', 11, 8)->nullable()->after('lat');
            $table->decimal('approx_lat', 10, 8)->nullable()->after('lng');
            $table->decimal('approx_lng', 11, 8)->nullable()->after('approx_lat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('problems', function (Blueprint $table) {
            //
        });
    }
};
