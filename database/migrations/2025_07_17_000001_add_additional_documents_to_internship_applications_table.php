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
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->string('foto_nametag_path')->nullable();
            $table->string('screenshot_pospay_path')->nullable();
            $table->string('foto_prangko_prisma_path')->nullable();
            $table->string('ss_follow_ig_museum_path')->nullable();
            $table->string('ss_follow_ig_posindonesia_path')->nullable();
            $table->string('ss_subscribe_youtube_path')->nullable();
            $table->boolean('acknowledged_additional_requirements')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->dropColumn([
                'foto_nametag_path',
                'screenshot_pospay_path',
                'foto_prangko_prisma_path',
                'ss_follow_ig_museum_path',
                'ss_follow_ig_posindonesia_path',
                'ss_subscribe_youtube_path',
                'acknowledged_additional_requirements',
            ]);
        });
    }
}; 