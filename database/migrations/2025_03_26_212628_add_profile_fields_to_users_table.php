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
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'surname')) {
                $table->string('surname')->nullable();
            }

            if (! Schema::hasColumn('users', 'phone_number')) {
                $table->string('phone_number')->nullable();
            }

            if (! Schema::hasColumn('users', 'badge_id')) {
                $table->string('badge_id')->nullable();
            }

            if (! Schema::hasColumn('users', 'image')) {
                $table->string('iamge')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('surname')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('badge_id')->nullable();
            $table->string('image')->nullable();
        });
    }
};
