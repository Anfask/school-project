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
            // Check and add missing columns
            if (!Schema::hasColumn('admission_queries', 'passport_photo_path')) {
                $table->string('passport_photo_path')->nullable();
            }
            if (!Schema::hasColumn('admission_queries', 'birth_certificate_path')) {
                $table->string('birth_certificate_path')->nullable();
            }
            if (!Schema::hasColumn('admission_queries', 'caste_certificate_path')) {
                $table->string('caste_certificate_path')->nullable();
            }
            if (!Schema::hasColumn('admission_queries', 'leaving_certificate_path')) {
                $table->string('leaving_certificate_path')->nullable();
            }
            if (!Schema::hasColumn('admission_queries', 'marksheet_path')) {
                $table->string('marksheet_path')->nullable();
            }
            if (!Schema::hasColumn('admission_queries', 'family_photo_path')) {
                $table->string('family_photo_path')->nullable();
            }
            if (!Schema::hasColumn('admission_queries', 'status_updated_at')) {
                $table->timestamp('status_updated_at')->nullable();
            }

            // Modify existing columns to be nullable if they aren't already
            if (Schema::hasColumn('admission_queries', 'mobile_2')) {
                $table->string('mobile_2')->nullable()->change();
            }
            if (Schema::hasColumn('admission_queries', 'gender')) {
                $table->string('gender')->nullable()->change();
            }
            if (Schema::hasColumn('admission_queries', 'dob')) {
                $table->date('dob')->nullable()->change();
            }
            if (Schema::hasColumn('admission_queries', 'nationality')) {
                $table->string('nationality')->nullable()->change();
            }
            if (Schema::hasColumn('admission_queries', 'address')) {
                $table->longText('address')->nullable()->change();
            }
            if (Schema::hasColumn('admission_queries', 'previous_school_name')) {
                $table->string('previous_school_name')->nullable()->change();
            }
            if (Schema::hasColumn('admission_queries', 'previous_class')) {
                $table->string('previous_class')->nullable()->change();
            }
            if (Schema::hasColumn('admission_queries', 'father_name')) {
                $table->string('father_name')->nullable()->change();
            }
            if (Schema::hasColumn('admission_queries', 'father_occupation')) {
                $table->string('father_occupation')->nullable()->change();
            }
            if (Schema::hasColumn('admission_queries', 'mother_name')) {
                $table->string('mother_name')->nullable()->change();
            }
            if (Schema::hasColumn('admission_queries', 'mother_occupation')) {
                $table->string('mother_occupation')->nullable()->change();
            }
            if (Schema::hasColumn('admission_queries', 'additional_info')) {
                $table->longText('additional_info')->nullable()->change();
            }
            if (Schema::hasColumn('admission_queries', 'remarks')) {
                $table->text('remarks')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admission_queries', function (Blueprint $table) {
            // Drop added columns
            $columns = [
                'passport_photo_path',
                'birth_certificate_path',
                'caste_certificate_path',
                'leaving_certificate_path',
                'marksheet_path',
                'family_photo_path',
                'status_updated_at'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('admission_queries', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
