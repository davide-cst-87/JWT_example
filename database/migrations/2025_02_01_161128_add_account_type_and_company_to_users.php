<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('account_type', ['single', 'company'])->default('single')->after('password');
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('account_type');
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });
    }
};
