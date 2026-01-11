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
        Schema::table('admission_queries', function (Blueprint $table) {
            // Add gender field after first_name
            $table->enum('gender', ['Male', 'Female', 'Other'])->after('first_name');

            // Add email field if it doesn't exist
            if (!Schema::hasColumn('admission_queries', 'email')) {
                $table->string('email')->after('mobile_2');
            }

            // Add application_number field if it doesn't exist
            if (!Schema::hasColumn('admission_queries', 'application_number')) {
                $table->string('application_number')->unique()->nullable()->after('id');
            }

            // Add remarks field for admin comments
            if (!Schema::hasColumn('admission_queries', 'remarks')) {
                $table->text('remarks')->nullable()->after('status');
            }

            // Add processed_at timestamp
            if (!Schema::hasColumn('admission_queries', 'processed_at')) {
                $table->timestamp('processed_at')->nullable()->after('remarks');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admission_queries', function (Blueprint $table) {
            $table->dropColumn(['gender', 'email', 'application_number', 'remarks', 'processed_at']);
        });
    }
};
