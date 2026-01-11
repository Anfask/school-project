<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admission_queries', function (Blueprint $table) {
            // Make ALL fields nullable except the absolute essentials
            $table->string('surname')->nullable()->change();
            $table->string('first_name')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('mobile_1')->nullable()->change();
            $table->string('mobile_2')->nullable()->change();
            $table->string('admission_sought_for_class')->nullable()->change();
            $table->string('application_number')->nullable()->change();
            $table->date('dob')->nullable()->change();
            $table->string('gender', 10)->nullable()->change();
            $table->string('nationality', 100)->nullable()->change();
            $table->text('address')->nullable()->change();
            $table->string('previous_school_name')->nullable()->change();
            $table->string('previous_class')->nullable()->change();
            $table->string('father_name')->nullable()->change();
            $table->string('father_occupation')->nullable()->change();
            $table->string('mother_name')->nullable()->change();
            $table->string('mother_occupation')->nullable()->change();
            $table->text('additional_info')->nullable()->change();
            $table->string('status')->nullable()->change();
            $table->text('remarks')->nullable()->change();

            // Add missing columns that might be causing errors
            if (!Schema::hasColumn('admission_queries', 'father_full_name')) {
                $table->string('father_full_name')->nullable();
            }
            if (!Schema::hasColumn('admission_queries', 'mother_full_name')) {
                $table->string('mother_full_name')->nullable();
            }
            if (!Schema::hasColumn('admission_queries', 'parents_guardian_full_name')) {
                $table->string('parents_guardian_full_name')->nullable();
            }
            if (!Schema::hasColumn('admission_queries', 'local_address')) {
                $table->text('local_address')->nullable();
            }
            if (!Schema::hasColumn('admission_queries', 'religion')) {
                $table->string('religion')->nullable();
            }
            if (!Schema::hasColumn('admission_queries', 'caste')) {
                $table->string('caste')->nullable();
            }
            if (!Schema::hasColumn('admission_queries', 'place_of_birth')) {
                $table->string('place_of_birth')->nullable();
            }
            if (!Schema::hasColumn('admission_queries', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable();
            }
            if (!Schema::hasColumn('admission_queries', 'is_physically_unfit')) {
                $table->boolean('is_physically_unfit')->default(false);
            }
        });
    }

    public function down(): void
    {
        // Optional: define rollback
    }
};
