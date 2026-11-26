<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nib', 20)->nullable();
            $table->string('business_name');
            $table->string('category');
            $table->string('kecamatan');
            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->boolean('e_catalog_pemko')->default(false);
            $table->string('cover_image')->nullable();
            $table->string('logo')->nullable();
            $table->string('whatsapp', 25)->nullable();
            $table->string('email', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};
