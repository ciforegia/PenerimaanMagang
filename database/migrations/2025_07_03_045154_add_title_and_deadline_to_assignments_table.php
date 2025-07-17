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
        Schema::table('assignments', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->date('deadline')->nullable();
            $table->boolean('is_revision')->nullable()->after('grade');
            $table->text('feedback')->nullable()->after('is_revision');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropColumn(['title', 'deadline', 'is_revision', 'feedback']);
        });
    }
};
