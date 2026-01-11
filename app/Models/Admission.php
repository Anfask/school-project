<?php
// app/Models/Admission.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [
        'surname', 'first_name', 'father_name', 'mother_name', 'guardian_name',
        'local_address', 'mobile_1', 'mobile_2', 'email',
        'religion', 'caste', 'sub_caste', 'nationality', 'place_of_birth', 'date_of_birth',
        'last_school_name', 'last_school_address', 'studying_std', 'since_date',
        'medium_of_instruction', 'occupation',
        'desired_class', 'academic_year',
        'birth_certificate', 'passport_photo', 'family_photo',
        'status', 'remarks', 'submitted_at', 'processed_at', 'processed_by', 'ip_address'
    ];

    protected $dates = [
        'date_of_birth',
        'since_date',
        'submitted_at',
        'processed_at',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'since_date' => 'date',
        'submitted_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->surname}";
    }

    public function getAgeAttribute()
    {
        return \Carbon\Carbon::parse($this->date_of_birth)->age;
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeInterview($query)
    {
        return $query->where('status', 'interview');
    }
}
