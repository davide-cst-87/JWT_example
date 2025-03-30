<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scans', function (Blueprint $table) {
            $table->dropColumn('timestamp'); // Remove old timestamp field
            $table->unsignedBigInteger('user_id')->nullable()->after('badge_id');
            $table->enum('type', ['entrance', 'exit'])->default('entrance');
            $table->string('notes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('scans', function (Blueprint $table) {
            $table->timestamp('timestamp'); // Restore if rolling back
            $table->dropColumn(['user_id', 'type', 'notes']);
        });
    }
};
