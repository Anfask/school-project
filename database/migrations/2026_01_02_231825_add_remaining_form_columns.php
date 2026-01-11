<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('admission_queries', function (Blueprint $table) {
            // Columns needed for Form 2 (Class 3 to 10)
            if (!Schema::hasColumn('admission_queries', 'student_name')) {
                $table->string('student_name', 255)->nullable()->after('first_name');
            }

            if (!Schema::hasColumn('admission_queries', 'date_of_birth_words')) {
                $table->string('date_of_birth_words', 255)->nullable()->after('date_of_birth');
            }

            if (!Schema::hasColumn('admission_queries', 'mother_tongue')) {
                $table->string('mother_tongue', 100)->nullable()->after('caste');
            }

            if (!Schema::hasColumn('admission_queries', 'father_designation')) {
                $table->string('father_designation', 255)->nullable()->after('father_occupation');
            }

            if (!Schema::hasColumn('admission_queries', 'mother_designation')) {
                $table->string('mother_designation', 255)->nullable()->after('mother_occupation');
            }

            if (!Schema::hasColumn('admission_queries', 'present_address')) {
                $table->text('present_address')->nullable()->after('local_address');
            }

            if (!Schema::hasColumn('admission_queries', 'permanent_address')) {
                $table->text('permanent_address')->nullable()->after('present_address');
            }

            if (!Schema::hasColumn('admission_queries', 'pin_code')) {
                $table->string('pin_code', 6)->nullable()->after('permanent_address');
            }

            if (!Schema::hasColumn('admission_queries', 'phone_no1')) {
                $table->string('phone_no1', 15)->nullable()->after('pin_code');
            }

            if (!Schema::hasColumn('admission_queries', 'phone_no2')) {
                $table->string('phone_no2', 15)->nullable()->after('phone_no1');
            }

            if (!Schema::hasColumn('admission_queries', 'aadhar_no')) {
                $table->string('aadhar_no', 20)->nullable()->after('phone_no2');
            }

            if (!Schema::hasColumn('admission_queries', 'id_type')) {
                $table->string('id_type', 100)->nullable()->after('aadhar_no');
            }

            if (!Schema::hasColumn('admission_queries', 'id_number')) {
                $table->string('id_number', 100)->nullable()->after('id_type');
            }

            if (!Schema::hasColumn('admission_queries', 'student_photo_path')) {
                $table->string('student_photo_path', 500)->nullable()->after('id_number');
            }

            if (!Schema::hasColumn('admission_queries', 'admission_class')) {
                $table->string('admission_class', 50)->nullable()->after('admission_sought_for_class');
            }

            if (!Schema::hasColumn('admission_queries', 'agree_declaration')) {
                $table->boolean('agree_declaration')->default(false)->after('agreed_to_rules');
            }

            // Columns needed for Form 3 (Higher Secondary)
            if (!Schema::hasColumn('admission_queries', 'stream')) {
                $table->string('stream', 50)->nullable()->after('admission_class');
            }

            if (!Schema::hasColumn('admission_queries', 'subject_group')) {
                $table->string('subject_group', 100)->nullable()->after('stream');
            }

            if (!Schema::hasColumn('admission_queries', 'selected_subjects')) {
                $table->json('selected_subjects')->nullable()->after('subject_group');
            }
        });
    }

    public function down()
    {
        // Optional: Add down method if you want to be able to rollback
        // But for now, we can leave it empty since these are new columns
    }
};
