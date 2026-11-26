<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $hasDuplicateApplications = DB::table('applications')
            ->select('announcement_id', 'user_id')
            ->groupBy('announcement_id', 'user_id')
            ->havingRaw('COUNT(*) > 1')
            ->exists();

        if ($hasDuplicateApplications) {
            throw new RuntimeException('Hapus atau gabungkan pengajuan ganda sebelum menerapkan batas satu lamaran per pengumuman.');
        }

        Schema::table('applications', function (Blueprint $table) {
            $table->string('applicant_name')->nullable();
            $table->string('identifier', 50)->nullable();
            $table->unique(['announcement_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropUnique(['announcement_id', 'user_id']);
            $table->dropColumn(['applicant_name', 'identifier']);
        });
    }
};
