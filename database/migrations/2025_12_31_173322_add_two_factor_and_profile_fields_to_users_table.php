<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Profile fields
            $table->string('profile_photo_path')->nullable()->after('email');
            $table->string('phone')->nullable()->after('profile_photo_path');
            $table->string('timezone')->default('UTC')->after('phone');

            // 2FA fields
            $table->boolean('two_factor_enabled')->default(false)->after('remember_token');
            $table->string('two_factor_method')->nullable()->after('two_factor_enabled'); // 'app' or 'sms'
            $table->text('two_factor_secret')->nullable()->after('two_factor_method');
            $table->string('two_factor_backup_codes')->nullable()->after('two_factor_secret');
            $table->timestamp('two_factor_confirmed_at')->nullable()->after('two_factor_backup_codes');

            // Security fields
            $table->timestamp('password_changed_at')->nullable()->after('two_factor_confirmed_at');
            $table->ipAddress('last_login_ip')->nullable()->after('password_changed_at');
            $table->timestamp('last_login_at')->nullable()->after('last_login_ip');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'profile_photo_path',
                'phone',
                'timezone',
                'two_factor_enabled',
                'two_factor_method',
                'two_factor_secret',
                'two_factor_backup_codes',
                'two_factor_confirmed_at',
                'password_changed_at',
                'last_login_ip',
                'last_login_at'
            ]);
        });
    }
};
