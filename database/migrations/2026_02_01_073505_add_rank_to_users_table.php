<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('rank_tier')->default(0); 
            $table->string('rank_name')->default('Unranked');
            $table->string('rank_icon')->nullable(); 
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['rank_tier', 'rank_name', 'rank_icon']);
        });
    }
};