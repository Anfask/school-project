<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();

            // Personal Information
            $table->string('surname');
            $table->string('first_name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('guardian_name')->nullable();

            // Contact Information
            $table->string('local_address');
            $table->string('mobile_1');
            $table->string('mobile_2')->nullable();
            $table->string('email');

            // Demographics
            $table->string('religion')->nullable();
            $table->string('caste')->nullable();
            $table->string('sub_caste')->nullable();
            $table->string('nationality');
            $table->string('place_of_birth');
            $table->date('date_of_birth');

            // Academic Information
            $table->string('last_school_name');
            $table->string('last_school_address');
            $table->string('studying_std');
            $table->date('since_date');
            $table->string('medium_of_instruction');
            $table->string('occupation')->nullable();

            // Application Details
            $table->string('desired_class');
            $table->string('academic_year');

            // Documents
            $table->string('birth_certificate')->nullable();
            $table->string('passport_photo')->nullable();
            $table->string('family_photo')->nullable();

            // Status
            $table->enum('status', ['pending', 'approved', 'rejected', 'interview'])->default('pending');
            $table->text('remarks')->nullable();

            // Tracking
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->string('processed_by')->nullable();
            $table->ipAddress('ip_address')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
