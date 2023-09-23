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
            $table->BigInteger('id_person')->nullable();
            $table->enum('role', config('enums.roles'))->default('client');
            $table->boolean('is_active')->default(true);

            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('id_person');
            $table->dropColumn('role');
            $table->dropColumn('is_active');
        });
    }
};
