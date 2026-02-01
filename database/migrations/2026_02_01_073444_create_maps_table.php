<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->string('map_uuid');
            $table->string('map_name');
            $table->string('map_image');
            $table->text('tactic_note')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('maps'); }
};