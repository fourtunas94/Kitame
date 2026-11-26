<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type', 30); // procurement, job_vacancy
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('budget_estimate')->nullable();
            $table->date('deadline')->nullable();
            $table->string('status', 20)->default('open'); // open, closed, draft
            $table->string('agency')->nullable();
            $table->string('location')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
