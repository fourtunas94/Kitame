<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('talents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nik', 20)->nullable();
            $table->string('category');
            $table->string('kecamatan');
            $table->text('bio')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->boolean('disnaker_certified')->default(false);
            $table->string('expertise')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('talents');
    }
};
