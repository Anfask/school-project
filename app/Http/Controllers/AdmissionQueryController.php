<?php

namespace App\Http\Controllers;

use App\Models\AdmissionQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AdmissionQueryController extends Controller
{
    // Show the admission form
    public function create()
    {
        $currentYear = date('Y');
        $nextYear = $currentYear + 1;
        $academicYear = "{$currentYear}-{$nextYear}";

        return view('admission.form', compact('academicYear'));
    }

    // Store the admission form data
    public function store(Request $request)
    {
        // Debug: Log what's being received
        \Log::info('Form submission received:', $request->all());

        // Validate ONLY fields that exist in your AdmissionQuery model
        $validated = $request->validate([
            // These fields EXIST in your model's $fillable array
            'surname' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_1' => 'required|string|max:15',
            'mobile_2' => 'nullable|string|max:15',
            'admission_sought_for_class' => 'required|string|max:50',

            // Optional fields that exist in your model
            'gender' => 'nullable|string|max:10',
            'dob' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'previous_school_name' => 'nullable|string|max:255',
            'previous_class' => 'nullable|string|max:50',
            'father_name' => 'nullable|string|max:255',
            'father_occupation' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'mother_occupation' => 'nullable|string|max:255',
            'additional_info' => 'nullable|string',

            // File uploads (optional for now)
            'passport_photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',

            // Agreement (we'll handle this differently since it's not in your model)
            'agreed_to_rules' => 'nullable|accepted',

            // Remove fields that don't exist in your model
            // 'father_full_name', 'mother_full_name', 'parents_guardian_full_name',
            // 'local_address', 'religion', 'caste', 'place_of_birth', 'date_of_birth',
            // 'is_physically_unfit', 'last_school_attended', 'last_school_address',
            // 'studying_in_std', 'medium_of_instruction', 'academic_year',
            // 'birth_certificate', 'caste_certificate', 'leaving_certificate',
            // 'marksheet', 'family_photo'

            // reCAPTCHA
            'g-recaptcha-response' => 'nullable',
        ], [
            'surname.required' => 'Surname is required.',
            'first_name.required' => 'First name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'mobile_1.required' => 'Mobile number is required.',
            'admission_sought_for_class.required' => 'Class applied for is required.',
        ]);

        try {
            // Handle file uploads (optional - you can remove if not needed)
            $passportPhotoPath = null;
            if ($request->hasFile('passport_photo')) {
                $passportPhotoPath = $request->file('passport_photo')->store('admission_documents/photos', 'public');
            }

            // Generate application number
            $applicationNumber = 'ADM' . date('Y') . str_pad(AdmissionQuery::count() + 1, 6, '0', STR_PAD_LEFT);

            // Prepare data for creation - ONLY fields that exist in your model
            $admissionData = [
                // Basic Information
                'surname' => $request->surname,
                'first_name' => $request->first_name,
                'email' => $request->email,
                'mobile_1' => $request->mobile_1,
                'mobile_2' => $request->mobile_2,
                'admission_sought_for_class' => $request->admission_sought_for_class,

                // Optional fields
                'gender' => $request->gender,
                'dob' => $request->dob ? Carbon::parse($request->dob) : null,
                'nationality' => $request->nationality,
                'address' => $request->address,
                'previous_school_name' => $request->previous_school_name,
                'previous_class' => $request->previous_class,
                'father_name' => $request->father_name,
                'father_occupation' => $request->father_occupation,
                'mother_name' => $request->mother_name,
                'mother_occupation' => $request->mother_occupation,
                'additional_info' => $request->additional_info,

                // Application details
                'application_number' => $applicationNumber,
                'status' => 'pending',

                // Add other form fields to additional_info if they're important
                // but don't have a database column
                // We'll store some extra data in additional_info field
            ];

            // Store extra form data in additional_info if needed
            $extraInfo = [];
            if ($request->has('father_full_name')) {
                $extraInfo['father_full_name'] = $request->father_full_name;
            }
            if ($request->has('mother_full_name')) {
                $extraInfo['mother_full_name'] = $request->mother_full_name;
            }
            if ($request->has('religion')) {
                $extraInfo['religion'] = $request->religion;
            }
            if ($request->has('caste')) {
                $extraInfo['caste'] = $request->caste;
            }
            if ($request->has('place_of_birth')) {
                $extraInfo['place_of_birth'] = $request->place_of_birth;
            }
            if ($request->has('academic_year')) {
                $extraInfo['academic_year'] = $request->academic_year;
            }

            // Append extra info to additional_info
            if (!empty($extraInfo)) {
                $existingInfo = $admissionData['additional_info'] ?? '';
                $extraInfoJson = json_encode($extraInfo);
                $admissionData['additional_info'] = trim($existingInfo . "\n\n[Extra Form Data: " . $extraInfoJson . "]");
            }

            \Log::info('Creating admission with data:', $admissionData);

            // Create the admission query
            $admissionQuery = AdmissionQuery::create($admissionData);

            // Generate PDF if needed
            try {
                $pdf = PDF::loadView('admission.pdf', compact('admissionQuery'));

                // Send email to user with PDF attachment
                Mail::send('emails.admission_confirmation', compact('admissionQuery'), function ($message) use ($admissionQuery, $pdf) {
                    $message->to($admissionQuery->email)
                            ->subject('Admission Application Received - Application No: ' . $admissionQuery->application_number)
                            ->attachData($pdf->output(), 'admission_application_' . $admissionQuery->application_number . '.pdf');
                });
            } catch (\Exception $e) {
                \Log::error('PDF generation or email sending failed: ' . $e->getMessage());
                // Don't fail the whole process if PDF/email fails
            }

            // Redirect with success message
            return redirect()->route('admission.success', $admissionQuery->id)
                            ->with('success', 'Application submitted successfully! Your application number is: ' . $applicationNumber);

        } catch (\Exception $e) {
            \Log::error('Admission form submission error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return back()->withErrors(['error' => 'Failed to submit application. Please try again. Error: ' . $e->getMessage()])->withInput();
        }
    }

    // Show success page
    public function success($id)
    {
        try {
            $admissionQuery = AdmissionQuery::findOrFail($id);
            return view('admission.success', compact('admissionQuery'));
        } catch (\Exception $e) {
            \Log::error('Error loading success page: ' . $e->getMessage());
            return redirect()->route('admission.create')->with('error', 'Application not found.');
        }
    }

    // Download PDF
    public function downloadPdf($id)
    {
        try {
            $admissionQuery = AdmissionQuery::findOrFail($id);
            $pdf = PDF::loadView('admission.pdf', compact('admissionQuery'));
            return $pdf->download('admission_application_' . $admissionQuery->application_number . '.pdf');
        } catch (\Exception $e) {
            \Log::error('PDF download error: ' . $e->getMessage());
            return back()->with('error', 'Failed to generate PDF.');
        }
    }

    // Admin dashboard
    public function dashboard()
    {
        $queries = AdmissionQuery::orderBy('created_at', 'desc')->paginate(20);

        // Statistics - updated to match your database status values
        $stats = [
            'total' => AdmissionQuery::count(),
            'pending' => AdmissionQuery::where('status', 'pending')->count(),
            'reviewed' => AdmissionQuery::where('status', 'reviewed')->count(),
            'accepted' => AdmissionQuery::where('status', 'accepted')->count(),
            'rejected' => AdmissionQuery::where('status', 'rejected')->count(),
        ];

        return view('admin.dashboard', compact('queries', 'stats'));
    }

    // View a single admission query
    public function show($id)
    {
        try {
            $admissionQuery = AdmissionQuery::findOrFail($id);
            return view('admin.applications.view', compact('admissionQuery'));
        } catch (\Exception $e) {
            \Log::error('Error loading application: ' . $e->getMessage());
            return redirect()->route('admin.applications')->with('error', 'Application not found.');
        }
    }

    // Update status
    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,reviewed,accepted,rejected',
                'remarks' => 'nullable|string|max:1000',
            ]);

            $admissionQuery = AdmissionQuery::findOrFail($id);

            $admissionQuery->update([
                'status' => $request->status,
                'remarks' => $request->remarks,
                'status_updated_at' => now(),
            ]);

            // Send status update email
            try {
                Mail::send('emails.admission_status_update', compact('admissionQuery'), function ($message) use ($admissionQuery) {
                    $message->to($admissionQuery->email)
                            ->subject('Admission Application Status Update - ' . $admissionQuery->application_number);
                });
            } catch (\Exception $e) {
                \Log::error('Failed to send status update email: ' . $e->getMessage());
            }

            return redirect()->back()->with('success', 'Status updated successfully and notification sent to applicant.');

        } catch (\Exception $e) {
            \Log::error('Status update error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update status: ' . $e->getMessage());
        }
    }

    // Search admissions
    public function search(Request $request)
    {
        $query = AdmissionQuery::query();

        if ($request->filled('application_number')) {
            $query->where('application_number', 'like', '%' . $request->application_number . '%');
        }

        if ($request->filled('name')) {
            $query->where(function($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->name . '%')
                  ->orWhere('surname', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('class')) {
            $query->where('admission_sought_for_class', $request->class);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        $queries = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.search', compact('queries'));
    }
}
