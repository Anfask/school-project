<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\AdmissionQuery;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AdmissionController extends Controller
{
    // Home Page with School Details
    public function home()
    {
        return view('home', [
            'academicYear' => date('Y') . '-' . (date('Y') + 1)
        ]);
    }

    // Form Selection Page
    public function showFormSelection()
    {
        return view('admission.select-form', [
            'academicYear' => date('Y') . '-' . (date('Y') + 1)
        ]);
    }

    // Process Form Selection
    public function processFormSelection(Request $request)
    {
        $request->validate([
            'selected_form' => 'required|in:form1,form2,form3'
        ]);

        $routeMap = [
            'form1' => 'admission.form1',
            'form2' => 'admission.form2',
            'form3' => 'admission.form3'
        ];

        return redirect()->route($routeMap[$request->selected_form]);
    }

    // Show Form 1 (Pre-primary to Class 2)
    public function showForm1()
    {
        $currentYear = date('Y');
        $nextYear = $currentYear + 1;
        $academicYear = "{$currentYear}-{$nextYear}";

        return view('admission.form1', [
            'academicYear' => $academicYear,
            'classes' => ['Nursery', 'Jr.KG', 'Sr.KG', '1st Standard', '2nd Standard']
        ]);
    }

    // Show Form 2 (Class 3 to 10)
    public function showForm2()
    {
        $currentYear = date('Y');
        $nextYear = $currentYear + 1;
        $academicYear = "{$currentYear}-{$nextYear}";

        return view('admission.form2', [
            'academicYear' => $academicYear,
            'classes' => ['3rd', '4th', '5th', '6th', '7th', '8th', '9th', '10th'],
            'idTypes' => ['Aadhar', 'Birth Certificate', 'Passport', 'PAN Card', 'Voter ID', 'Other']
        ]);
    }

    // Show Form 3 (Higher Secondary)
    public function showForm3()
    {
        $currentYear = date('Y');
        $nextYear = $currentYear + 1;
        $academicYear = "{$currentYear}-{$nextYear}";

        $subjectGroups = [
            'Group A (Arts 1)' => [
                'English',
                'History',
                'Politics',
                'Education',
                'EVS'
            ],
            'Group B (Arts 2)' => [
                'English',
                'History',
                'Politics',
                'Education',
                'Islamic Studies'
            ],
            'Group C (Inter-Arts 1)' => [
                'English',
                'History',
                'Politics',
                'Mathematics',
                'EVS'
            ],
            'Group D (Inter-Arts 2)' => [
                'English',
                'History',
                'Politics',
                'Mathematics',
                'Islamic Studies'
            ],
            'Group E (Medical 1)' => [
                'English',
                'Physics',
                'Chemistry',
                'Biology',
                'EVS'
            ],
            'Group F (Medical 2)' => [
                'English',
                'Physics',
                'Chemistry',
                'Biology',
                'Islamic Studies'
            ],
            'Group G (Non Medical 1)' => [
                'English',
                'Physics',
                'Chemistry',
                'Mathematics',
                'EVS'
            ],
            'Group H (Non Medical 2)' => [
                'English',
                'Physics',
                'Chemistry',
                'Mathematics',
                'Islamic Studies'
            ]
        ];

        return view('admission.form3', [
            'academicYear' => $academicYear,
            'classes' => ['11th', '12th'],
            'subjectGroups' => $subjectGroups,
        ]);
    }

    // Submit Form 1 (Pre-primary to Class 2)
    public function submitForm1(Request $request)
    {
        \Log::info('Form 1 submission started', [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'session_id' => session()->getId()
        ]);

        // CSRF Token validation
        if (!$this->validateCsrfToken($request)) {
            return $this->handleCsrfError($request);
        }

        $validated = $request->validate([
            // Basic Information
            'surname' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_1' => 'required|string|max:15',
            'admission_sought_for_class' => 'required|string|max:50',

            // Personal Information
            'gender' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required|string|max:255',
            'nationality' => 'required|string|max:100',
            'religion' => 'required|string|max:100',
            'caste' => 'required|string|max:100',

            // Address
            'local_address' => 'required|string',

            // Parent Information
            'father_full_name' => 'required|string|max:255',
            'mother_full_name' => 'required|string|max:255',
            'parents_guardian_full_name' => 'required|string|max:255',

            // Previous School (if any)
            'last_school_attended' => 'nullable|string|max:255',
            'studying_in_std' => 'nullable|string|max:50',
            'last_school_address' => 'nullable|string',
            'medium_of_instruction' => 'nullable|string|max:100',

            // Academic Year
            'academic_year' => 'required|string|max:20',

            // Files
            'passport_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'birth_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'marksheet' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'caste_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'leaving_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',

            // Declarations
            'is_physically_unfit' => 'nullable|boolean',
            'agreed_to_rules' => 'required|accepted',

            // Captcha
            'g-recaptcha-response' => 'required|captcha'
        ]);

        // Validate captcha
        if (!$this->validateCaptcha($request->input('g-recaptcha-response'))) {
            return back()->withErrors([
                'g-recaptcha-response' => 'Please complete the security verification.'
            ])->withInput();
        }

        try {
            // Handle file uploads
            $filePaths = [];
            $fileFields = [
                'passport_photo' => 'passport_photo_path',
                'birth_certificate' => 'birth_certificate_path',
                'marksheet' => 'marksheet_path',
                'caste_certificate' => 'caste_certificate_path',
                'leaving_certificate' => 'leaving_certificate_path'
            ];

            foreach ($fileFields as $field => $dbField) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $extension = $file->getClientOriginalExtension();
                    $fileName = time() . '_' . uniqid() . '.' . $extension;
                    $path = $file->storeAs('admission-documents/' . date('Y/m'), $fileName, 'public');
                    $filePaths[$dbField] = $path;
                }
            }

            // Generate application number
            $applicationNumber = 'ADM' . date('Y') . str_pad(AdmissionQuery::count() + 1, 6, '0', STR_PAD_LEFT);

            // Prepare data
            $admissionData = [
                'form_type' => 'form1',
                'application_number' => $applicationNumber,
                'academic_year' => $validated['academic_year'],

                // Student Info
                'surname' => $validated['surname'],
                'first_name' => $validated['first_name'],
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'],
                'place_of_birth' => $validated['place_of_birth'],
                'nationality' => $validated['nationality'],
                'religion' => $validated['religion'],
                'caste' => $validated['caste'],

                // Contact
                'email' => $validated['email'],
                'mobile_1' => $validated['mobile_1'],
                'mobile_2' => $request->input('mobile_2'),

                // Address
                'local_address' => $validated['local_address'],

                // Parent Info
                'father_full_name' => $validated['father_full_name'],
                'mother_full_name' => $validated['mother_full_name'],
                'parents_guardian_full_name' => $validated['parents_guardian_full_name'],

                // Education
                'admission_sought_for_class' => $validated['admission_sought_for_class'],
                'last_school_attended' => $validated['last_school_attended'] ?? null,
                'studying_in_std' => $validated['studying_in_std'] ?? null,
                'last_school_address' => $validated['last_school_address'] ?? null,
                'medium_of_instruction' => $validated['medium_of_instruction'] ?? null,

                // Declarations
                'is_physically_unfit' => $request->boolean('is_physically_unfit'),
                'agreed_to_rules' => true,

                // Status
                'status' => 'pending',
                'submitted_ip' => $request->ip(),
                'submitted_user_agent' => $request->userAgent(),
            ];

            // Merge file paths
            $admissionData = array_merge($admissionData, $filePaths);

            // Create the admission query
            $admission = AdmissionQuery::create($admissionData);

            // Send confirmation email
            $this->sendConfirmationEmail($admission);

            \Log::info('Form 1 application submitted successfully', [
                'application_id' => $admission->id,
                'application_number' => $admission->application_number,
            ]);

            // Regenerate CSRF token after successful submission
            $request->session()->regenerateToken();

            return redirect()->route('admission.success', $admission->id)
                ->with('success', 'Application submitted successfully! Your application number is ' . $admission->application_number);

        } catch (\Exception $e) {
            \Log::error('Form 1 submission error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors(['error' => 'Failed to submit application. Error: ' . $e->getMessage()])->withInput();
        }
    }

    // Submit Form 2 (Class 3 to 10)
    public function submitForm2(Request $request)
    {
        \Log::info('Form 2 submission started', [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'session_id' => session()->getId()
        ]);

        // CSRF Token validation
        if (!$this->validateCsrfToken($request)) {
            return $this->handleCsrfError($request);
        }

        $validated = $request->validate([
            // Student Information
            'student_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'father_occupation' => 'required|string|max:255',
            'mother_occupation' => 'required|string|max:255',
            'father_designation' => 'nullable|string|max:255',
            'mother_designation' => 'nullable|string|max:255',

            // Date of Birth
            'date_of_birth' => 'required|date',
            'date_of_birth_words' => 'required|string|max:255',

            // Personal Details
            'gender' => 'required|in:Male,Female,Other',
            'nationality' => 'required|string|max:100',
            'religion' => 'required|string|max:100',
            'caste' => 'required|string|max:100',
            'mother_tongue' => 'required|string|max:100',

            // Previous School
            'last_school_attended' => 'required|string|max:255',

            // Address
            'present_address' => 'required|string',
            'permanent_address' => 'required|string',
            'pin_code' => 'required|digits:6',

            // Contact
            'email' => 'required|email|max:255',
            'phone_no1' => 'required|digits:10',
            'phone_no2' => 'nullable|digits:10',

            // ID Details
            'aadhar_no' => 'required|digits:12',
            'id_type' => 'required|string',
            'id_number' => 'required|string|max:100',

            // Admission Details
            'admission_class' => 'required|string|max:50',
            'academic_year' => 'required|string|max:20',

            // Photo
            'student_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',

            // Declaration
            'agree_declaration' => 'required|accepted',
            'agreed_to_rules' => 'required|accepted',

            // Documents
            'birth_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'leaving_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'marksheet' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'caste_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',

            // Captcha
            'g-recaptcha-response' => 'required|captcha'
        ]);

        // Validate captcha
        if (!$this->validateCaptcha($request->input('g-recaptcha-response'))) {
            return back()->withErrors([
                'g-recaptcha-response' => 'Please complete the security verification.'
            ])->withInput();
        }

        try {
            // Handle file uploads
            $filePaths = [];
            $fileFields = [
                'student_photo' => 'student_photo_path',
                'birth_certificate' => 'birth_certificate_path',
                'marksheet' => 'marksheet_path',
                'caste_certificate' => 'caste_certificate_path',
                'leaving_certificate' => 'leaving_certificate_path'
            ];

            foreach ($fileFields as $field => $dbField) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $extension = $file->getClientOriginalExtension();
                    $fileName = time() . '_' . uniqid() . '.' . $extension;
                    $path = $file->storeAs('admission-documents/' . date('Y/m'), $fileName, 'public');
                    $filePaths[$dbField] = $path;
                }
            }

            // Generate application number
            $applicationNumber = 'ADM' . date('Y') . str_pad(AdmissionQuery::count() + 1, 6, '0', STR_PAD_LEFT);

            // Prepare data
            $admissionData = [
                'form_type' => 'form2',
                'application_number' => $applicationNumber,
                'academic_year' => $validated['academic_year'],

                // Student Info
                'student_name' => $validated['student_name'],
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'],
                'date_of_birth_words' => $validated['date_of_birth_words'],
                'nationality' => $validated['nationality'],
                'religion' => $validated['religion'],
                'caste' => $validated['caste'],
                'mother_tongue' => $validated['mother_tongue'],

                // Parent Info
                'father_name' => $validated['father_name'],
                'mother_name' => $validated['mother_name'],
                'father_occupation' => $validated['father_occupation'],
                'mother_occupation' => $validated['mother_occupation'],
                'father_designation' => $validated['father_designation'] ?? null,
                'mother_designation' => $validated['mother_designation'] ?? null,

                // Address
                'present_address' => $validated['present_address'],
                'local_address' => $validated['present_address'], // Map to local_address to satisfy DB constraint
                'permanent_address' => $validated['permanent_address'],
                'pin_code' => $validated['pin_code'],

                // Contact
                'email' => $validated['email'],
                'phone_no1' => $validated['phone_no1'],
                'phone_no2' => $validated['phone_no2'] ?? null,

                // Education
                'admission_class' => $validated['admission_class'],
                'last_school_attended' => $validated['last_school_attended'],

                // ID Details
                'aadhar_no' => $validated['aadhar_no'],
                'id_type' => $validated['id_type'],
                'id_number' => $validated['id_number'],

                // Declarations
                'agree_declaration' => true,
                'agreed_to_rules' => true,

                // Status
                'status' => 'pending',
                'submitted_ip' => $request->ip(),
                'submitted_user_agent' => $request->userAgent(),
            ];

            // Normalize names for consistency (Form 1 style)
            $nameParts = explode(' ', trim($validated['student_name']));
            $surname = array_pop($nameParts);
            $firstName = implode(' ', $nameParts);
            if (empty($firstName)) {
                $firstName = $surname; // Fallback if single word name
                $surname = '';
            }

            $admissionData['first_name'] = $firstName;
            $admissionData['surname'] = $surname;
            $admissionData['father_full_name'] = $validated['father_name'];
            $admissionData['mother_full_name'] = $validated['mother_name'];
            $admissionData['parents_guardian_full_name'] = $validated['father_name']; // Default to father

            // Default values for fields not in Form 2
            $admissionData['place_of_birth'] = 'N/A';
            $admissionData['last_school_address'] = 'N/A';
            $admissionData['studying_in_std'] = 'N/A';
            $admissionData['medium_of_instruction'] = 'N/A';

            // Normalize Class (Form 2 sends admission_class, map to admission_sought_for_class too)
            $admissionData['admission_sought_for_class'] = $validated['admission_class'];

            // Merge file paths
            $admissionData = array_merge($admissionData, $filePaths);

            // Create the admission query
            $admission = AdmissionQuery::create($admissionData);

            // Send confirmation email
            $this->sendConfirmationEmail($admission);

            \Log::info('Form 2 application submitted successfully', [
                'application_id' => $admission->id,
                'application_number' => $admission->application_number,
            ]);

            // Regenerate CSRF token after successful submission
            $request->session()->regenerateToken();

            return redirect()->route('admission.success', $admission->id)
                ->with('success', 'Application submitted successfully! Your application number is ' . $admission->application_number);

        } catch (\Exception $e) {
            \Log::error('Form 2 submission error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors(['error' => 'Failed to submit application. Error: ' . $e->getMessage()])->withInput();
        }
    }






    // Submit Form 3 (Higher Secondary)
    public function submitForm3(Request $request)
    {
        \Log::info('Form 3 submission started', [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'session_id' => session()->getId()
        ]);

        // CSRF Token validation
        if (!$this->validateCsrfToken($request)) {
            return $this->handleCsrfError($request);
        }

        // Validate captcha first
        if (!$this->validateCaptcha($request->input('g-recaptcha-response'))) {
            return back()->withErrors([
                'g-recaptcha-response' => 'Please complete the security verification.'
            ])->withInput();
        }

        // UPDATED VALIDATION RULES - Documents are now optional
        $validated = $request->validate([
            // Basic Information (similar to Form 2)
            'student_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'father_occupation' => 'required|string|max:255',
            'mother_occupation' => 'required|string|max:255',

            // Date of Birth
            'date_of_birth' => 'required|date',
            'date_of_birth_words' => 'required|string|max:255',

            // Personal Details
            'gender' => 'required|in:Male,Female,Other',
            'nationality' => 'required|string|max:100',
            'religion' => 'required|string|max:100',
            'caste' => 'required|string|max:100',
            'mother_tongue' => 'required|string|max:100',

            // Previous School
            'last_school_attended' => 'required|string|max:255',

            // Address
            'present_address' => 'required|string',
            'place_of_birth' => 'nullable|string|max:100', // Added validation
            'permanent_address' => 'required|string',
            'pin_code' => 'required|digits:6',

            // Contact
            'email' => 'required|email|max:255',
            'phone_no1' => 'required|digits:10',
            'phone_no2' => 'nullable|digits:10',

            // ID Details
            'aadhar_no' => 'required|digits:12',
            'id_type' => 'required|string',
            'id_number' => 'required|string|max:100',

            // Admission Details
            'admission_class' => 'required|string|max:50',
            'academic_year' => 'required|string|max:20',

            // Subject Group Selection
            'subject_group' => 'required|string|max:100',

            // Photo - STILL REQUIRED
            'student_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',

            // Declaration
            'agree_declaration' => 'required|accepted',
            'agreed_to_rules' => 'required|accepted',

            // Documents - NOW ALL OPTIONAL
            'birth_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'leaving_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'marksheet' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'caste_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);
        \Log::info('Form 3 validation passed', ['validated_data' => array_keys($validated)]);

        try {
            // Handle file uploads
            $filePaths = [];
            $fileFields = [
                'student_photo' => 'student_photo_path',
                'birth_certificate' => 'birth_certificate_path',
                'marksheet' => 'marksheet_path',
                'caste_certificate' => 'caste_certificate_path',
                'leaving_certificate' => 'leaving_certificate_path'
            ];

            foreach ($fileFields as $field => $dbField) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $extension = $file->getClientOriginalExtension();
                    $fileName = time() . '_' . uniqid() . '.' . $extension;
                    $path = $file->storeAs('admission-documents/' . date('Y/m'), $fileName, 'public');
                    $filePaths[$dbField] = $path;
                } else {
                    // Set to null if file not uploaded (optional)
                    $filePaths[$dbField] = null;
                }
            }

            // Generate application number
            $applicationNumber = 'ADM' . date('Y') . str_pad(AdmissionQuery::count() + 1, 6, '0', STR_PAD_LEFT);

            // Prepare data for database - Match all fields with your AdmissionQuery model
            $admissionData = [
                'form_type' => 'form3',
                'application_number' => $applicationNumber,
                'academic_year' => $validated['academic_year'],

                // Student Info
                'student_name' => $validated['student_name'],
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'],
                'date_of_birth_words' => $validated['date_of_birth_words'],
                'place_of_birth' => $validated['place_of_birth'] ?? 'N/A', // Save actual value
                'nationality' => $validated['nationality'],
                'religion' => $validated['religion'],
                'caste' => $validated['caste'],
                'mother_tongue' => $validated['mother_tongue'],

                // Parent Info
                'father_name' => $validated['father_name'],
                'father_full_name' => $validated['father_name'],
                'mother_name' => $validated['mother_name'],
                'mother_full_name' => $validated['mother_name'],
                'father_occupation' => $validated['father_occupation'],
                'mother_occupation' => $validated['mother_occupation'],

                // Address
                'present_address' => $validated['present_address'],
                'local_address' => $validated['present_address'], // Map to local_address to satisfy DB constraint
                'permanent_address' => $validated['permanent_address'],
                'pin_code' => $validated['pin_code'],

                // Contact
                'email' => $validated['email'],
                'phone_no1' => $validated['phone_no1'],
                'phone_no2' => $validated['phone_no2'] ?? null,
                'mobile_1' => $validated['phone_no1'],
                'mobile_2' => $validated['phone_no2'] ?? null,

                // Education
                'admission_class' => $validated['admission_class'],
                'admission_sought_for_class' => $validated['admission_class'],
                'last_school_attended' => $validated['last_school_attended'],

                // ID Details
                'aadhar_no' => $validated['aadhar_no'],
                'id_type' => $validated['id_type'],
                'id_number' => $validated['id_number'],

                // Subject Group
                'subject_group' => $validated['subject_group'],

                // Declarations
                'agree_declaration' => true,
                'agreed_to_rules' => true,
                'is_physically_unfit' => false,

                // Status
                'status' => 'pending',
                'submitted_ip' => $request->ip(),
                'submitted_user_agent' => $request->userAgent(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Normalize names for consistency
            $nameParts = explode(' ', trim($validated['student_name']));
            $surname = array_pop($nameParts);
            $firstName = implode(' ', $nameParts);
            if (empty($firstName)) {
                $firstName = $surname;
                $surname = '';
            }

            $admissionData['first_name'] = $firstName;
            $admissionData['surname'] = $surname;
            $admissionData['parents_guardian_full_name'] = $validated['father_name'];

            // Default values for fields not in Form 3
            // place_of_birth is now handled above
            $admissionData['last_school_address'] = 'N/A';
            $admissionData['studying_in_std'] = 'N/A';
            $admissionData['medium_of_instruction'] = 'N/A';

            // Normalize Stream from Subject Group
            if (isset($validated['subject_group'])) {
                $group = $validated['subject_group']; // e.g., "Group A"
                // Groups A, B, C, D are Arts/Inter-Arts
                if (in_array($group, ['Group A', 'Group B', 'Group C', 'Group D'])) {
                    $admissionData['stream'] = 'Arts';
                } else {
                    $admissionData['stream'] = 'Science';
                }
            }

            // Merge file paths
            $admissionData = array_merge($admissionData, $filePaths);

            // Log the data for debugging
            \Log::info('Admission data prepared:', array_keys($admissionData));

            // Create the admission query
            $admission = AdmissionQuery::create($admissionData);

            // Send confirmation email
            $this->sendConfirmationEmail($admission);

            \Log::info('Form 3 application submitted successfully', [
                'application_id' => $admission->id,
                'application_number' => $admission->application_number,
            ]);

            // Regenerate CSRF token after successful submission
            $request->session()->regenerateToken();

            return redirect()->route('admission.success', $admission->id)
                ->with('success', 'Application submitted successfully! Your application number is ' . $admission->application_number);

        } catch (\Exception $e) {
            \Log::error('Form 3 submission error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data' => $validated ?? [],
                'file_errors' => $e->getMessage()
            ]);

            return back()->withErrors(['error' => 'Failed to submit application. Error: ' . $e->getMessage()])->withInput();
        }
    }






    // Show Success Page
    public function showSuccess($id)
    {
        try {
            $admission = AdmissionQuery::findOrFail($id);

            if ($admission->date_of_birth) {
                $admission->age = Carbon::parse($admission->date_of_birth)->age;
            }

            return view('admission.success', compact('admission'));

        } catch (\Exception $e) {
            \Log::error('Error showing success page: ' . $e->getMessage());
            return redirect()->route('home')->withErrors(['error' => 'Application not found.']);
        }
    }

    // Download PDF
    public function downloadPDF($id)
    {
        try {
            $admission = AdmissionQuery::findOrFail($id);

            $studentPhotoBase64 = null;

            // Get student photo (check both possible field names)
            $photoPath = $admission->student_photo_path ?? $admission->passport_photo_path;

            if ($photoPath && Storage::disk('public')->exists($photoPath)) {
                $photoFullPath = Storage::disk('public')->path($photoPath);
                $studentPhotoBase64 = base64_encode(file_get_contents($photoFullPath));
                $photoMime = mime_content_type($photoFullPath);
            }

            $data = [
                'admission' => $admission,
                'student_photo_base64' => $studentPhotoBase64 ? "data:{$photoMime};base64,{$studentPhotoBase64}" : null,
                'current_date' => now()->format('d/m/Y'),
            ];

            $pdf = Pdf::loadView('admission.pdf', $data);
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOption('defaultFont', 'DejaVu Sans');
            $pdf->setOption('isHtml5ParserEnabled', true);
            $pdf->setOption('isRemoteEnabled', true);

            $filename = 'Admission_Application_' . ($admission->application_number ?? $admission->id) . '.pdf';

            return $pdf->download($filename);

        } catch (\Exception $e) {
            \Log::error('PDF download error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to generate PDF.']);
        }
    }

    // Send Confirmation Email
    private function sendConfirmationEmail($admission)
    {
        try {
            if (config('mail.default') !== 'log') {
                Mail::send('emails.admission-confirmation', ['admission' => $admission], function ($message) use ($admission) {
                    $message->to($admission->email)
                        ->subject('Admission Application Received - ' . ($admission->application_number ?? ''));
                });

                \Log::info('Confirmation email sent to: ' . $admission->email);
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send confirmation email: ' . $e->getMessage());
        }
    }

    // Legacy method for compatibility (optional)
    public function showForm()
    {
        return $this->showFormSelection();
    }

    // CSRF Token validation helper
    private function validateCsrfToken(Request $request)
    {
        $csrfToken = $request->input('_token');
        $sessionToken = session()->token();

        return hash_equals($sessionToken, $csrfToken);
    }

    // Handle CSRF error
    private function handleCsrfError(Request $request)
    {
        \Log::warning('CSRF token mismatch detected', [
            'session_token' => session()->token(),
            'submitted_token' => $request->input('_token'),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // Regenerate session token
        $request->session()->regenerateToken();

        return back()
            ->withInput($request->except('_token', 'password', 'password_confirmation'))
            ->withErrors([
                'csrf_error' => 'Your session has expired. Please refresh the page and try again.'
            ]);
    }

    // Captcha validation helper
    private function validateCaptcha($response)
    {
        if (empty($response)) {
            return false;
        }

        $secret = config('captcha.secret_key');

        // For local development/testing, you might want to bypass captcha
        if (app()->environment('local') && $response === 'test') {
            return true;
        }

        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';

        $data = [
            'secret' => $secret,
            'response' => $response,
            'remoteip' => request()->ip()
        ];

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($verifyUrl, false, $context);
        $resultJson = json_decode($result);

        return $resultJson->success ?? false;
    }
}
