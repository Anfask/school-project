<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdmissionQuery;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\StudentApplicationStatusMail;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total' => AdmissionQuery::count(),
            'pending' => AdmissionQuery::where('status', 'pending')->count(),
            'reviewed' => AdmissionQuery::where('status', 'reviewed')->count(),
            'accepted' => AdmissionQuery::where('status', 'accepted')->count(),
            'rejected' => AdmissionQuery::where('status', 'rejected')->count(),
            'today' => AdmissionQuery::whereDate('created_at', today())->count(),
        ];

        $formTypeStats = AdmissionQuery::select('form_type', DB::raw('count(*) as count'))
            ->groupBy('form_type')
            ->get();

        $topClasses = AdmissionQuery::select(
            DB::raw('CASE
                    WHEN form_type = "form1" THEN admission_sought_for_class
                    ELSE admission_class
                END as class_name'),
            'form_type',
            DB::raw('count(*) as total')
        )
            ->groupBy('class_name', 'form_type')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        // FIXED: Removed the non-existent 'user' relationship
        $recentApplications = AdmissionQuery::latest()
            ->limit(10)
            ->get();

        $monthlyStats = AdmissionQuery::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('count(*) as count')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'formTypeStats',
            'topClasses',
            'recentApplications',
            'monthlyStats'
        ));
    }

    /**
     * Show all applications with filtering and search
     */
    public function applications(Request $request)
    {
        try {
            $query = AdmissionQuery::query();

            // Search
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('surname', 'like', "%{$search}%")
                        ->orWhere('student_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('mobile_1', 'like', "%{$search}%")
                        ->orWhere('mobile_2', 'like', "%{$search}%")
                        ->orWhere('phone_no1', 'like', "%{$search}%")
                        ->orWhere('phone_no2', 'like', "%{$search}%")
                        ->orWhere('application_number', 'like', "%{$search}%");
                });
            }

            // Filter by form type
            if ($request->filled('form_type')) {
                $query->where('form_type', $request->form_type);
            }

            // Filter by status - using lowercase status values
            if ($request->filled('status') && in_array($request->status, ['pending', 'reviewed', 'accepted', 'rejected'])) {
                $query->where('status', $request->status);
            }

            // Filter by class
            if ($request->filled('class')) {
                $class = $request->class;
                $query->where(function ($q) use ($class) {
                    $q->where('admission_sought_for_class', 'like', "%{$class}%")
                        ->orWhere('admission_class', 'like', "%{$class}%");
                });
            }

            // Filter by date range
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            // Export functionality
            if ($request->has('export') && $request->export == 'true') {
                $filename = 'applications_export_' . date('Y-m-d_H-i-s') . '.csv';
                $headers = [
                    "Content-type" => "text/csv",
                    "Content-Disposition" => "attachment; filename=$filename",
                    "Pragma" => "no-cache",
                    "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                    "Expires" => "0"
                ];

                $columns = ['ID', 'Application No', 'Form Type', 'Student Name', 'Gender', 'DOB', 'Class', 'Father Name', 'Mobile', 'Email', 'Status', 'Date'];

                $callback = function () use ($query, $columns) {
                    $file = fopen('php://output', 'w');
                    fputcsv($file, $columns);

                    $query->chunk(100, function ($rows) use ($file) {
                        foreach ($rows as $row) {
                            $data = [
                                $row->id,
                                $row->application_number,
                                $row->form_type,
                                $row->full_name,
                                $row->gender,
                                $row->date_of_birth ? optional($row->date_of_birth)->format('d/m/Y') : '',
                                $row->admission_sought_for_class ?? $row->admission_class,
                                $row->father_name ?? $row->father_full_name,
                                $row->mobile_1 ?? $row->phone_no1,
                                $row->email,
                                ucfirst($row->status),
                                $row->created_at->format('d/m/Y H:i')
                            ];
                            fputcsv($file, $data);
                        }
                    });
                    fclose($file);
                };

                return response()->stream($callback, 200, $headers);
            }

            // Get applications with pagination
            $applications = $query->latest()->paginate(20);

            // Get status counts for this view
            $statusCounts = [
                'total' => AdmissionQuery::count(),
                'pending' => AdmissionQuery::where('status', 'pending')->count(),
                'accepted' => AdmissionQuery::where('status', 'accepted')->count(),
                'rejected' => AdmissionQuery::where('status', 'rejected')->count(),
            ];

            // Get unique classes for filter dropdown
            $classes = AdmissionQuery::select('admission_sought_for_class')
                ->whereNotNull('admission_sought_for_class')
                ->distinct()
                ->pluck('admission_sought_for_class')
                ->merge(
                    AdmissionQuery::select('admission_class')
                        ->whereNotNull('admission_class')
                        ->distinct()
                        ->pluck('admission_class')
                )
                ->unique()
                ->sort()
                ->values();

            return view('admin.applications', compact('applications', 'classes', 'statusCounts'));

        } catch (\Exception $e) {
            Log::error('Applications list error: ' . $e->getMessage());
            return back()->with('error', 'Failed to load applications: ' . $e->getMessage());
        }
    }

    /**
     * View single application
     */
    public function viewApplication($id)
    {
        try {
            $application = AdmissionQuery::findOrFail($id);
            return view('admin.applications.view', compact('application'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Application not found - ID: ' . $id);
            return redirect()->route('admin.applications')
                ->with('error', 'Application not found. It may have been deleted or the ID is incorrect.');
        } catch (\Exception $e) {
            Log::error('View application error: ' . $e->getMessage());
            return back()->with('error', 'Error loading application details.');
        }
    }

    /**
     * Show send email modal
     */
    public function showSendEmail($id)
    {
        try {
            $application = AdmissionQuery::findOrFail($id);
            return view('admin.modals.send-email', compact('application'));
        } catch (\Exception $e) {
            Log::error('Show send email error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load email modal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send application email to student
     */
    public function sendApplicationEmail(Request $request, $id)
    {
        try {
            $application = AdmissionQuery::findOrFail($id);

            // Validate request - Accept string values for checkboxes
            $validated = $request->validate([
                'subject' => 'nullable|string|max:255',
                'message' => 'nullable|string',
                'send_copy_to_admin' => 'nullable|string|in:1,0,true,false,on,off,yes,no',
                'include_remarks' => 'nullable|string|in:1,0,true,false,on,off,yes,no',
            ]);

            // Convert string values to proper booleans
            $sendCopyToAdmin = filter_var($request->get('send_copy_to_admin', false), FILTER_VALIDATE_BOOLEAN);
            $includeRemarks = filter_var($request->get('include_remarks', false), FILTER_VALIDATE_BOOLEAN);

            // Generate PDF - USE YOUR EXISTING PDF VIEW
            $pdf = PDF::loadView('admission.pdf', ['admission' => $application]);
            $pdfPath = 'applications/application-' . $application->id . '-' . time() . '.pdf';
            Storage::put($pdfPath, $pdf->output());

            // Get current admin user
            $adminUser = auth()->user();

            // Prepare email data
            $emailData = [
                'application' => $application,
                'additional_message' => $validated['message'] ?? null,
                'subject' => $validated['subject'] ?? null,
                'admin_name' => $adminUser->name,
                'admin_email' => $adminUser->email,
            ];

            // Send email to student
            Mail::to($application->email)
                ->send(new StudentApplicationStatusMail($application, $pdfPath, $emailData));

            // Send copy to admin if requested
            if ($sendCopyToAdmin) {
                Mail::to($adminUser->email)
                    ->send(new StudentApplicationStatusMail($application, $pdfPath, $emailData));
            }

            // Clean up temporary PDF
            Storage::delete($pdfPath);

            // Log activity
            Log::info('Application email sent', [
                'application_id' => $id,
                'student_email' => $application->email,
                'sent_by' => $adminUser->id,
                'admin_copy' => $sendCopyToAdmin,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Email sent successfully to ' . $application->email,
            ]);

        } catch (\Exception $e) {
            Log::error('Send application email error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update application status
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            // Use lowercase status values: pending, reviewed, accepted, rejected
            $validated = $request->validate([
                'status' => 'required|in:pending,reviewed,accepted,rejected',
                'remarks' => 'nullable|string|max:500',
            ]);

            $application = AdmissionQuery::findOrFail($id);

            // Update status and remarks
            $application->status = $validated['status'];
            $application->remarks = $validated['remarks'] ?? null;
            $application->status_updated_at = now();
            $application->save();

            // Log activity
            Log::info('Application status updated', [
                'application_id' => $id,
                'new_status' => $validated['status'],
                'updated_by' => auth()->id(),
            ]);

            // Send WhatsApp Notification
            try {
                $whatsapp = new \App\Services\WhatsAppService();
                $whatsapp->sendStatusUpdate(
                    $application->contact_number,
                    $validated['status'],
                    $application->full_name
                );
            } catch (\Exception $e) {
                Log::error('WhatsApp Notification Failed: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!',
                'status' => $validated['status'],
                'status_text' => ucfirst($validated['status']), // Capitalize for display
                'status_class' => $validated['status'] == 'accepted' ? 'success' :
                    ($validated['status'] == 'reviewed' ? 'info' :
                        ($validated['status'] == 'rejected' ? 'danger' : 'warning')),
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Update status error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download application PDF
     */
    public function downloadApplication($id)
    {
        try {
            $application = AdmissionQuery::findOrFail($id);

            // If PDF exists in storage, download it
            if ($application->pdf_path && \Storage::exists($application->pdf_path)) {
                return \Storage::download($application->pdf_path);
            }

            // Otherwise, redirect to public download route
            return redirect()->route('admission.download', $id);

        } catch (\Exception $e) {
            Log::error('Download application error: ' . $e->getMessage());
            return back()->with('error', 'Failed to download application.');
        }
    }

    /**
     * Bulk update applications status
     */
    public function bulkUpdateStatus(Request $request)
    {
        try {
            $validated = $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'integer|exists:admission_queries,id',
                'status' => 'required|in:pending,reviewed,accepted,rejected',
            ]);

            $updated = AdmissionQuery::whereIn('id', $validated['ids'])
                ->update([
                    'status' => $validated['status'],
                ]);

            Log::info('Bulk status update', [
                'count' => $updated,
                'status' => $validated['status'],
                'updated_by' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => $updated . ' application(s) updated successfully!',
                'count' => $updated,
            ]);

        } catch (\Exception $e) {
            Log::error('Bulk update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update applications: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get application statistics for charts
     */
    public function getStatistics(Request $request)
    {
        try {
            $range = $request->get('range', 'monthly');

            switch ($range) {
                case 'weekly':
                    $data = AdmissionQuery::select(
                        DB::raw('WEEK(created_at) as period'),
                        DB::raw('COUNT(*) as count')
                    )
                        ->whereYear('created_at', date('Y'))
                        ->groupBy('period')
                        ->orderBy('period')
                        ->get();
                    break;

                case 'daily':
                    $data = AdmissionQuery::select(
                        DB::raw('DATE(created_at) as period'),
                        DB::raw('COUNT(*) as count')
                    )
                        ->whereDate('created_at', '>=', now()->subDays(30))
                        ->groupBy('period')
                        ->orderBy('period')
                        ->get();
                    break;

                default: // monthly
                    $data = AdmissionQuery::select(
                        DB::raw('DATE_FORMAT(created_at, "%Y-%m") as period'),
                        DB::raw('COUNT(*) as count')
                    )
                        ->whereYear('created_at', '>=', date('Y') - 1)
                        ->groupBy('period')
                        ->orderBy('period')
                        ->get();
            }

            return response()->json([
                'success' => true,
                'data' => $data,
                'range' => $range,
            ]);

        } catch (\Exception $e) {
            Log::error('Get statistics error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update application details and documents
     */
    public function updateApplication(Request $request, $id)
    {
        try {
            $application = AdmissionQuery::findOrFail($id);

            // Validation
            $rules = [
                'first_name' => 'required|string|max:100',
                'surname' => 'required|string|max:100',
                'email' => 'required|email|max:150',
                'mobile_1' => 'required|string|max:20',
                'admission_sought_for_class' => 'nullable|string|max:50',
                'date_of_birth' => 'nullable|date',
                'address' => 'nullable|string',
                'aadhar_no' => 'nullable|string|max:20',
            ];

            // Add dynamic validation for files
            $fileFields = [
                'passport_photo',
                'student_photo',
                'birth_certificate',
                'caste_certificate',
                'leaving_certificate',
                'marksheet',
                'family_photo'
            ];

            foreach ($fileFields as $field) {
                $rules[$field] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            }

            $validated = $request->validate($rules);

            // Handle text fields
            $updateData = $request->only([
                'first_name',
                'surname',
                'email',
                'mobile_1',
                'mobile_2',
                'admission_sought_for_class',
                'admission_class',
                'date_of_birth',
                'gender',
                'religion',
                'caste',
                'nationality',
                'mother_tongue',
                'father_name',
                'father_occupation',
                'mother_name',
                'mother_occupation',
                'place_of_birth',
                'address',
                'local_address',
                'present_address',
                'permanent_address',
                'aadhar_no',
                'previous_school_name',
                'previous_class',
                'stream',
                'subject_group'
            ]);

            // Handle files
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $pathField = $field . '_path';

                    // Special case for passport_photo/student_photo mapping
                    if ($field === 'passport_photo' && !isset($application->passport_photo_path) && isset($application->student_photo_path)) {
                        // Some forms use student_photo_path, some use passport_photo_path
                    }

                    // Store new file
                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('admission-documents/' . date('Y/m'), $fileName, 'public');

                    // Delete old file if exists
                    if ($application->$pathField && \Storage::disk('public')->exists($application->$pathField)) {
                        \Storage::disk('public')->delete($application->$pathField);
                    }

                    $updateData[$pathField] = $path;
                }
            }

            $application->update($updateData);

            return back()->with('success', 'Application updated successfully.');

        } catch (\Exception $e) {
            Log::error('Update application error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update application: ' . $e->getMessage());
        }
    }

    /**
     * Delete application
     */
    public function deleteApplication($id)
    {
        try {
            $application = AdmissionQuery::findOrFail($id);
            $application->delete();

            Log::info('Application deleted', [
                'application_id' => $id,
                'deleted_by' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Application deleted successfully!',
            ]);

        } catch (\Exception $e) {
            Log::error('Delete application error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete application: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Serve uploaded files securely
     */
    public function serveFile($path)
    {
        try {
            // Decode the path
            $filePath = base64_decode($path);

            // Use the public disk since files are stored there
            $disk = Storage::disk('public');

            // Check if file exists
            if (!$disk->exists($filePath)) {
                Log::error('File not found: ' . $filePath);
                abort(404, 'File not found');
            }

            // Get file
            $file = $disk->get($filePath);
            $fileName = basename($filePath);

            // Detect MIME type
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($file);

            // Return file response
            return response($file, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline; filename="' . $fileName . '"')
                ->header('Cache-Control', 'public, max-age=3600')
                ->header('Access-Control-Allow-Origin', '*');

        } catch (\Exception $e) {
            Log::error('Serve file error: ' . $e->getMessage());
            abort(404, 'File not found');
        }
    }
}
