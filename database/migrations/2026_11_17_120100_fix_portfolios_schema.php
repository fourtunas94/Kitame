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
        Schema::table('portfolios', function (Blueprint $table) {
            if (! Schema::hasColumn('portfolios', 'talent_id')) {
                $table->foreignId('talent_id')->nullable()->constrained('talents')->onDelete('cascade');
            }

            if (! Schema::hasColumn('portfolios', 'title')) {
                $table->string('title')->nullable();
            }

            if (! Schema::hasColumn('portfolios', 'description')) {
                $table->text('description')->nullable();
            }

            if (! Schema::hasColumn('portfolios', 'link')) {
                $table->string('link')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            if (Schema::hasColumn('portfolios', 'link')) {
                $table->dropColumn('link');
            }

            if (Schema::hasColumn('portfolios', 'description')) {
                $table->dropColumn('description');
            }

            if (Schema::hasColumn('portfolios', 'title')) {
                $table->dropColumn('title');
            }

            if (Schema::hasColumn('portfolios', 'talent_id')) {
                $table->dropConstrainedForeignId('talent_id');
            }
        });
    }
};
