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
    Schema::create('agent_pools', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('agent_uuid');
        $table->string('agent_name');
        $table->string('role');
        $table->string('role_icon')->nullable();
        $table->string('image_url'); 
        $table->string('mastery_level')->default('Beginner');
        $table->text('catatan_taktis')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_pools');
    }
};
