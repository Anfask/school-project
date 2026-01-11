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
            // Add new columns if they don't exist
            if (!Schema::hasColumn('admission_queries', 'form_type')) {
                $table->string('form_type')->nullable()->after('id');
            }

            if (!Schema::hasColumn('admission_queries', 'student_name')) {
                $table->string('student_name')->nullable()->after('first_name');
            }

            if (!Schema::hasColumn('admission_queries', 'gender')) {
                $table->string('gender')->nullable()->after('student_name');
            }

            if (!Schema::hasColumn('admission_queries', 'date_of_birth_words')) {
                $table->string('date_of_birth_words')->nullable()->after('date_of_birth');
            }

            if (!Schema::hasColumn('admission_queries', 'mother_tongue')) {
                $table->string('mother_tongue')->nullable()->after('caste');
            }

            if (!Schema::hasColumn('admission_queries', 'father_name')) {
                $table->string('father_name')->nullable()->after('mother_full_name');
            }

            if (!Schema::hasColumn('admission_queries', 'mother_name')) {
                $table->string('mother_name')->nullable()->after('father_name');
            }

            if (!Schema::hasColumn('admission_queries', 'father_occupation')) {
                $table->string('father_occupation')->nullable()->after('mother_name');
            }

            if (!Schema::hasColumn('admission_queries', 'mother_occupation')) {
                $table->string('mother_occupation')->nullable()->after('father_occupation');
            }

            if (!Schema::hasColumn('admission_queries', 'father_designation')) {
                $table->string('father_designation')->nullable()->after('mother_occupation');
            }

            if (!Schema::hasColumn('admission_queries', 'mother_designation')) {
                $table->string('mother_designation')->nullable()->after('father_designation');
            }

            if (!Schema::hasColumn('admission_queries', 'present_address')) {
                $table->text('present_address')->nullable()->after('local_address');
            }

            if (!Schema::hasColumn('admission_queries', 'permanent_address')) {
                $table->text('permanent_address')->nullable()->after('present_address');
            }

            if (!Schema::hasColumn('admission_queries', 'pin_code')) {
                $table->string('pin_code')->nullable()->after('permanent_address');
            }

            if (!Schema::hasColumn('admission_queries', 'phone_no1')) {
                $table->string('phone_no1')->nullable()->after('mobile_2');
            }

            if (!Schema::hasColumn('admission_queries', 'phone_no2')) {
                $table->string('phone_no2')->nullable()->after('phone_no1');
            }

            if (!Schema::hasColumn('admission_queries', 'admission_class')) {
                $table->string('admission_class')->nullable()->after('admission_sought_for_class');
            }

            if (!Schema::hasColumn('admission_queries', 'aadhar_no')) {
                $table->string('aadhar_no')->nullable()->after('academic_year');
            }

            if (!Schema::hasColumn('admission_queries', 'id_type')) {
                $table->string('id_type')->nullable()->after('aadhar_no');
            }

            if (!Schema::hasColumn('admission_queries', 'id_number')) {
                $table->string('id_number')->nullable()->after('id_type');
            }

            if (!Schema::hasColumn('admission_queries', 'stream')) {
                $table->string('stream')->nullable()->after('id_number');
            }

            if (!Schema::hasColumn('admission_queries', 'subject_group')) {
                $table->string('subject_group')->nullable()->after('stream');
            }

            if (!Schema::hasColumn('admission_queries', 'selected_subjects')) {
                $table->json('selected_subjects')->nullable()->after('subject_group');
            }

            if (!Schema::hasColumn('admission_queries', 'student_photo_path')) {
                $table->string('student_photo_path')->nullable()->after('passport_photo_path');
            }

            if (!Schema::hasColumn('admission_queries', 'agree_declaration')) {
                $table->boolean('agree_declaration')->default(false)->after('agreed_to_rules');
            }

            if (!Schema::hasColumn('admission_queries', 'remarks')) {
                $table->text('remarks')->nullable()->after('admin_notes');
            }

            if (!Schema::hasColumn('admission_queries', 'status_updated_at')) {
                $table->timestamp('status_updated_at')->nullable()->after('remarks');
            }

            if (!Schema::hasColumn('admission_queries', 'submitted_ip')) {
                $table->string('submitted_ip')->nullable()->after('status_updated_at');
            }

            if (!Schema::hasColumn('admission_queries', 'submitted_user_agent')) {
                $table->string('submitted_user_agent')->nullable()->after('submitted_ip');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admission_queries', function (Blueprint $table) {
            // Remove added columns
            $columnsToDrop = [
                'form_type', 'student_name', 'gender', 'date_of_birth_words',
                'mother_tongue', 'father_name', 'mother_name', 'father_occupation',
                'mother_occupation', 'father_designation', 'mother_designation',
                'present_address', 'permanent_address', 'pin_code', 'phone_no1',
                'phone_no2', 'admission_class', 'aadhar_no', 'id_type', 'id_number',
                'stream', 'subject_group', 'selected_subjects', 'student_photo_path',
                'agree_declaration', 'remarks', 'status_updated_at', 'submitted_ip',
                'submitted_user_agent'
            ];

            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('admission_queries', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
