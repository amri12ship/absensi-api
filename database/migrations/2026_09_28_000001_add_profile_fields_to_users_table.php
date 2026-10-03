<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('username')->nullable()->unique()->after('name');
            $table->string('role')->default('employee')->after('password');
            $table->boolean('is_active')->default(true)->after('role');
            $table->string('phone', 30)->nullable()->after('is_active');
            $table->string('photo')->nullable()->after('phone');
            $table->dateTime('last_login_at')->nullable()->after('photo');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropUnique(['username']);
            $table->dropColumn(['username', 'role', 'is_active', 'phone', 'photo', 'last_login_at']);
        });
    }
};
