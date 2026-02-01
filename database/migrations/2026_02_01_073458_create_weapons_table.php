<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weapons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->string('weapon_uuid'); //
            $table->string('weapon_name');
            $table->string('weapon_image');
            $table->string('category'); 
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('weapons'); }
};