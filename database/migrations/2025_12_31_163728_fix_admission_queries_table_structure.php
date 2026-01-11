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
            // First, check which columns exist and which don't
            $columns = [
                'dob', 'gender', 'nationality', 'address', 'previous_school_name',
                'previous_class', 'father_name', 'father_occupation', 'mother_name',
                'mother_occupation', 'additional_info'
            ];

            // Add columns that might be missing
            if (!Schema::hasColumn('admission_queries', 'dob')) {
                $table->date('dob')->nullable()->after('email');
            }

            if (!Schema::hasColumn('admission_queries', 'gender')) {
                $table->string('gender', 10)->nullable()->after('dob');
            }

            if (!Schema::hasColumn('admission_queries', 'nationality')) {
                $table->string('nationality', 100)->nullable()->after('gender');
            }

            if (!Schema::hasColumn('admission_queries', 'address')) {
                $table->text('address')->nullable()->after('nationality');
            }

            if (!Schema::hasColumn('admission_queries', 'previous_school_name')) {
                $table->string('previous_school_name', 255)->nullable()->after('address');
            }

            if (!Schema::hasColumn('admission_queries', 'previous_class')) {
                $table->string('previous_class', 50)->nullable()->after('previous_school_name');
            }

            if (!Schema::hasColumn('admission_queries', 'father_name')) {
                $table->string('father_name', 255)->nullable()->after('previous_class');
            }

            if (!Schema::hasColumn('admission_queries', 'father_occupation')) {
                $table->string('father_occupation', 255)->nullable()->after('father_name');
            }

            if (!Schema::hasColumn('admission_queries', 'mother_name')) {
                $table->string('mother_name', 255)->nullable()->after('father_occupation');
            }

            if (!Schema::hasColumn('admission_queries', 'mother_occupation')) {
                $table->string('mother_occupation', 255)->nullable()->after('mother_name');
            }

            if (!Schema::hasColumn('admission_queries', 'additional_info')) {
                $table->text('additional_info')->nullable()->after('mother_occupation');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // You can optionally define the rollback here
    }
};
