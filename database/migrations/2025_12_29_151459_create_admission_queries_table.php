<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('admission_queries', function (Blueprint $table) {
            $table->id();

            // Form type and application number
            $table->string('form_type')->nullable(); // Added: form1, form2, form3
            $table->string('application_number')->unique()->nullable();

            // Student Information - Form 1 fields
            $table->string('surname')->nullable();
            $table->string('first_name')->nullable();

            // Student Information - Form 2 & Form 3 fields
            $table->string('student_name')->nullable();
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('date_of_birth_words')->nullable();
            $table->string('mother_tongue')->nullable();

            // Parent Information - Form 1 fields
            $table->string('father_full_name')->nullable();
            $table->string('mother_full_name')->nullable();
            $table->string('parents_guardian_full_name')->nullable();

            // Parent Information - Form 2 & Form 3 fields
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->string('father_designation')->nullable();
            $table->string('mother_designation')->nullable();

            // Address Information - Form 1 fields
            $table->text('local_address')->nullable();
            $table->string('last_school_address')->nullable();

            // Address Information - Form 2 & Form 3 fields
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('pin_code')->nullable();

            // Contact Information
            $table->string('mobile_1')->nullable();
            $table->string('mobile_2')->nullable();
            $table->string('phone_no1')->nullable(); // Added for Form 2 & 3
            $table->string('phone_no2')->nullable(); // Added for Form 2 & 3
            $table->string('email')->nullable();

            // Personal Details
            $table->string('religion')->nullable();
            $table->string('caste')->nullable();
            $table->string('nationality')->nullable();
            $table->string('place_of_birth')->nullable();

            // Education Information - Form 1 fields
            $table->string('last_school_attended')->nullable();
            $table->string('studying_in_std')->nullable();
            $table->string('medium_of_instruction')->nullable();
            $table->string('admission_sought_for_class')->nullable();

            // Education Information - Form 2 & Form 3 fields
            $table->string('admission_class')->nullable();
            $table->string('academic_year')->nullable();

            // ID Proof Details - Form 2 & Form 3 fields
            $table->string('aadhar_no')->nullable();
            $table->string('id_type')->nullable();
            $table->string('id_number')->nullable();

            // Stream and Subjects - Form 3 fields
            $table->string('stream')->nullable();
            $table->string('subject_group')->nullable();
            $table->json('selected_subjects')->nullable();

            // File Uploads
            $table->string('birth_certificate_path')->nullable();
            $table->string('passport_photo_path')->nullable(); // Form 1
            $table->string('student_photo_path')->nullable(); // Form 2 & 3
            $table->string('caste_certificate_path')->nullable();
            $table->string('leaving_certificate_path')->nullable();
            $table->string('marksheet_path')->nullable();

            // Declarations
            $table->boolean('is_physically_unfit')->default(false);
            $table->boolean('agreed_to_rules')->default(false);
            $table->boolean('agree_declaration')->default(false); // Added for Form 2 & 3

            // Status and Admin
            $table->enum('status', ['pending', 'reviewed', 'accepted', 'rejected'])->default('pending');
            $table->text('remarks')->nullable(); // Changed from admin_notes to remarks
            $table->text('admin_notes')->nullable();
            $table->timestamp('status_updated_at')->nullable();

            // Submission Info
            $table->string('submitted_ip')->nullable();
            $table->string('submitted_user_agent')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admission_queries');
    }
};
