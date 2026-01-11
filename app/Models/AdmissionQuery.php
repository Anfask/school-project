<?php
// app/Models/AdmissionQuery.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionQuery extends Model
{
    use HasFactory;

    protected $table = 'admission_queries';

    protected $fillable = [
        // Form Type
        'form_type',

        // Application Info
        'application_number',
        'academic_year',

        // Student Information (Common)
        'surname',
        'first_name',
        'student_name',
        'gender',
        'dob',
        'date_of_birth',
        'date_of_birth_words',
        'place_of_birth',
        'nationality',
        'religion',
        'caste',
        'mother_tongue',

        // Parent Information
        'father_name',
        'father_full_name',
        'father_occupation',
        'father_designation',
        'mother_name',
        'mother_full_name',
        'mother_occupation',
        'mother_designation',
        'parents_guardian_full_name',

        // Contact Information
        'email',
        'mobile_1',
        'mobile_2',
        'phone_no1',
        'phone_no2',

        // Address Information
        'address',
        'local_address',
        'present_address',
        'permanent_address',
        'pin_code',

        // Educational Information
        'admission_sought_for_class',
        'admission_class',
        'previous_school_name',
        'previous_class',
        'last_school_attended',
        'last_school_address',
        'studying_in_std',
        'medium_of_instruction',

        // ID Details (Form 2 & 3)
        'aadhar_no',
        'id_type',
        'id_number',

        // Form 3 Specific
        'stream',
        'subject_group',
        'selected_subjects',

        // File Paths
        'passport_photo_path',
        'student_photo_path',
        'birth_certificate_path',
        'caste_certificate_path',
        'leaving_certificate_path',
        'marksheet_path',
        'family_photo_path',

        // Declarations
        'is_physically_unfit',
        'agreed_to_rules',
        'agree_declaration',

        // Additional Information
        'additional_info',

        // Status tracking
        'status',
        'remarks',
        'processed_at',
        'admin_notes',
        'submitted_ip',
        'submitted_user_agent',
        'status_updated_at',
    ];

    protected $casts = [
        'dob' => 'date',
        'date_of_birth' => 'date',
        'is_physically_unfit' => 'boolean',
        'agreed_to_rules' => 'boolean',
        'agree_declaration' => 'boolean',
        'selected_subjects' => 'array',
        'processed_at' => 'datetime',
        'status_updated_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'pending',
        'is_physically_unfit' => false,
        'agreed_to_rules' => false,
        'agree_declaration' => false,
        'form_type' => 'form1',
    ];

    // Helper method to get table columns
    public static function getTableColumns()
    {
        return \DB::getSchemaBuilder()->getColumnListing((new static)->getTable());
    }

    // Helper methods
    public function getFullNameAttribute()
    {
        if ($this->form_type === 'form1') {
            return trim($this->first_name . ' ' . $this->surname);
        } else {
            return $this->student_name ?? trim($this->first_name . ' ' . $this->surname);
        }
    }

    public function getFormTypeNameAttribute()
    {
        $formNames = [
            'form1' => 'Pre-primary to Class 2',
            'form2' => 'Class 3 to 10',
            'form3' => 'Higher Secondary (11th-12th)'
        ];

        return $formNames[$this->form_type] ?? 'Unknown';
    }

    public function getContactNumberAttribute()
    {
        return $this->phone_no1 ?? $this->mobile_1;
    }

    public function getAddressAttribute()
    {
        if ($this->form_type === 'form1') {
            return $this->local_address ?? $this->attributes['address'] ?? '';
        } else {
            return $this->present_address ?? $this->permanent_address ?? '';
        }
    }
}
