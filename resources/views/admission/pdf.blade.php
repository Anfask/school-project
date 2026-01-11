<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Application - {{ $admission->application_number ?? 'N/A' }}</title>
    <style>
        @page {
            margin: 15px;
            size: A4 portrait;
        }

        body {
            font-family: 'DejaVu Sans', 'Helvetica', Arial, sans-serif;
            line-height: 1.4;
            color: #333;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }

        /* Header Styles */
        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 3px solid #0d6efd;
        }

        .header h1 {
            font-size: 20px;
            margin: 0;
            color: #0d6efd;
            font-weight: bold;
        }

        .header h2 {
            font-size: 16px;
            margin: 5px 0;
            color: #495057;
            font-weight: bold;
        }

        .header h3 {
            font-size: 14px;
            margin: 5px 0;
            color: #dc3545;
            font-weight: bold;
        }

        /* Student Photo Section */
        .student-photo-section {
            float: right;
            width: 120px;
            margin-left: 15px;
            margin-bottom: 10px;
            text-align: center;
        }

        .student-photo {
            width: 100px;
            height: 120px;
            object-fit: cover;
            border: 2px solid #333;
            padding: 2px;
            background: white;
        }

        .photo-label {
            font-size: 9px;
            margin-top: 3px;
            font-weight: bold;
            color: #333;
        }

        .no-photo-box {
            width: 100px;
            height: 120px;
            border: 2px dashed #ccc;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 9px;
            text-align: center;
            padding: 5px;
        }

        /* Application Info */
        .application-info {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 3px;
            margin-bottom: 15px;
            overflow: hidden;
            border: 1px solid #dee2e6;
        }

        .info-row {
            display: flex;
            margin-bottom: 5px;
        }

        .info-label {
            font-weight: bold;
            color: #495057;
            min-width: 120px;
        }

        .info-value {
            flex: 1;
            border-bottom: 1px dotted #ccc;
            padding-bottom: 2px;
        }

        /* Section Styles */
        .section {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .section-title {
            background: #0d6efd;
            color: white;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 2px;
            margin-bottom: 8px;
        }

        /* Table Styles */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .data-table td {
            padding: 4px 8px;
            border: 1px solid #dee2e6;
            vertical-align: top;
        }

        .data-table .label {
            font-weight: bold;
            background: #f8f9fa;
            width: 30%;
        }

        .data-table .value {
            width: 70%;
        }

        /* Documents Grid */
        .documents-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 5px;
            margin-top: 10px;
        }

        .document-item {
            border: 1px solid #dee2e6;
            padding: 5px;
            border-radius: 3px;
            text-align: center;
            font-size: 9px;
        }

        .document-check {
            font-weight: bold;
            margin-right: 3px;
        }

        .document-check.submitted {
            color: #198754;
        }

        .document-check.missing {
            color: #dc3545;
        }

        /* Signature Section */
        .signature-section {
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .signature-line {
            width: 200px;
            border-top: 1px solid #333;
            margin-top: 25px;
            padding-top: 3px;
            text-align: center;
            font-size: 10px;
            font-weight: bold;
        }

        .signature-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 8px;
            color: #6c757d;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }

        /* Watermark */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 60px;
            color: rgba(0, 0, 0, 0.05);
            z-index: -1;
            white-space: nowrap;
            font-weight: bold;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-pending {
            background: #ffc107;
            color: #000;
        }

        .status-reviewed {
            background: #17a2b8;
            color: #fff;
        }

        .status-accepted {
            background: #28a745;
            color: #fff;
        }

        .status-rejected {
            background: #dc3545;
            color: #fff;
        }

        /* Page Break Avoid */
        .page-break-avoid {
            page-break-inside: avoid;
        }

        /* Utility Classes */
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-bold {
            font-weight: bold;
        }

        .mb-1 {
            margin-bottom: 5px;
        }

        .mb-2 {
            margin-bottom: 10px;
        }

        .mb-3 {
            margin-bottom: 15px;
        }

        .mt-1 {
            margin-top: 5px;
        }

        .mt-2 {
            margin-top: 10px;
        }

        .mt-3 {
            margin-top: 15px;
        }

        .pt-1 {
            padding-top: 5px;
        }

        .pt-2 {
            padding-top: 10px;
        }

        .pt-3 {
            padding-top: 15px;
        }
    </style>
</head>

<body>
    <!-- Watermark -->
    <div class="watermark">
        PA. INAMIDAR SCHOOL
    </div>

    <!-- Header -->
    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" style="height: 60px; margin-bottom: 5px;">
        <h1>IQRA EDUCATION & WELFARE SOCIETY'S</h1>
        <h2>P.A. INAMIDAR ENGLISH MEDIUM SCHOOL</h2>
        <h3>ADMISSION APPLICATION ({{ $admission->academic_year ?? date('Y') . '-' . (date('Y') + 1) }})</h3>
        <div style="font-size: 10px; color: #666; margin-top: 5px;">
            Application No: <b>{{ $admission->application_number }}</b> | Date: {{ $admission->created_at->format('d/m/Y') }}
        </div>
    </div>

    <!-- Application Info with Photo -->
    <div class="application-info page-break-avoid">
        <!-- Student Photo -->
        <div class="student-photo-section">
            @php
                $photoPath = $admission->passport_photo_path ?? $admission->student_photo_path;
            @endphp
            @if($photoPath && file_exists(storage_path('app/public/' . $photoPath)))
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $photoPath))) }}"
                    alt="Student Photo" class="student-photo">
                <div class="photo-label">STUDENT PHOTO</div>
            @else
                <div class="no-photo-box">
                    <div style="font-size: 24px; margin-bottom: 5px;">📷</div>
                    <div>NO PHOTO</div>
                    <div>UPLOADED</div>
                </div>
                <div class="photo-label">STUDENT PHOTO</div>
            @endif
        </div>

        <!-- Application Details -->
        <div>
            <div class="info-row">
                <div class="info-label">Application Number:</div>
                <div class="info-value text-bold">{{ $admission->application_number ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Application Date:</div>
                <div class="info-value">{{ $admission->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Status:</div>
                <div class="info-value">
                    <span class="status-badge status-{{ $admission->status }}">
                        {{ strtoupper($admission->status) }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Student Name:</div>
                <div class="info-value text-bold">{{ $admission->first_name }} {{ $admission->surname }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Applied Class:</div>
                <div class="info-value text-bold">{{ $admission->admission_sought_for_class }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Academic Year:</div>
                <div class="info-value">{{ $admission->academic_year }}</div>
            </div>
        </div>
    </div>

    <!-- Section 1: Personal Information -->
    <div class="section page-break-avoid">
        <div class="section-title">1. PERSONAL INFORMATION</div>
        <table class="data-table">
            <tr>
                <td class="label">Surname</td>
                <td class="value">{{ $admission->surname }}</td>
                <td class="label">First Name</td>
                <td class="value">{{ $admission->first_name }}</td>
            </tr>
            <tr>
                <td class="label">Father's Full Name</td>
                <td class="value">{{ $admission->father_full_name }}</td>
                <td class="label">Mother's Full Name</td>
                <td class="value">{{ $admission->mother_full_name }}</td>
            </tr>
            <tr>
                <td class="label">Parents/Guardian's Name</td>
                <td class="value" colspan="3">{{ $admission->parents_guardian_full_name }}</td>
            </tr>
            <tr>
                <td class="label">Date of Birth</td>
                <td class="value">{{ \Carbon\Carbon::parse($admission->date_of_birth)->format('d/m/Y') }}</td>
                <td class="label">Place of Birth</td>
                <td class="value">{{ $admission->place_of_birth }}</td>
            </tr>
        </table>
    </div>

    <!-- Section 2: Contact Information -->
    <div class="section page-break-avoid">
        <div class="section-title">2. CONTACT INFORMATION</div>
        <table class="data-table">
            <tr>
                <td class="label">Local Address</td>
                <td class="value" colspan="3">{{ $admission->local_address }}</td>
            </tr>
            <tr>
                <td class="label">Mobile Number 1</td>
                <td class="value">{{ $admission->mobile_1 }}</td>
                <td class="label">Mobile Number 2</td>
                <td class="value">{{ $admission->mobile_2 ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Email Address</td>
                <td class="value" colspan="3">{{ $admission->email }}</td>
            </tr>
        </table>
    </div>

    <!-- Section 3: Personal Details -->
    <div class="section page-break-avoid">
        <div class="section-title">3. PERSONAL DETAILS</div>
        <table class="data-table">
            <tr>
                <td class="label">Religion</td>
                <td class="value">{{ $admission->religion }}</td>
                <td class="label">Caste</td>
                <td class="value">{{ $admission->caste }}</td>
            </tr>
            <tr>
                <td class="label">Nationality</td>
                <td class="value">{{ $admission->nationality }}</td>
                <td class="label">Physically Unfit</td>
                <td class="value">{{ $admission->is_physically_unfit ? 'Yes' : 'No' }}</td>
            </tr>
        </table>
    </div>

    <!-- Section 4: Educational Background -->
    <div class="section page-break-avoid">
        <div class="section-title">4. EDUCATIONAL BACKGROUND</div>
        <table class="data-table">
            <tr>
                <td class="label">Last School Attended</td>
                <td class="value">{{ $admission->last_school_attended ?? 'N/A' }}</td>
                <td class="label">Current Class</td>
                <td class="value">{{ $admission->studying_in_std ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Last School Address</td>
                <td class="value" colspan="3">{{ $admission->last_school_address ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Medium of Instruction</td>
                <td class="value">{{ $admission->medium_of_instruction ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <!-- Section 5: Admission Details -->
    <div class="section page-break-avoid">
        <div class="section-title">5. ADMISSION DETAILS</div>
        <table class="data-table">
            <tr>
                <td class="label">Admission Sought for Class</td>
                <td class="value text-bold">{{ $admission->admission_sought_for_class ?? $admission->admission_class }}</td>
                <td class="label">Academic Year</td>
                <td class="value">{{ $admission->academic_year }}</td>
            </tr>
            @if($admission->stream || $admission->subject_group)
            <tr>
                <td class="label">Stream</td>
                <td class="value">{{ $admission->stream ?? 'N/A' }}</td>
                <td class="label">Subject Group</td>
                <td class="value">{{ $admission->subject_group ?? 'N/A' }}</td>
            </tr>
            @endif
        </table>
    </div>

    <!-- Section 6: Documents Submitted -->
    <div class="section page-break-avoid">
        <div class="section-title">6. DOCUMENTS SUBMITTED</div>
        <div class="documents-grid">
            <div class="document-item">
                <span class="document-check {{ ($admission->passport_photo_path || $admission->student_photo_path) ? 'submitted' : 'missing' }}">
                    {{ ($admission->passport_photo_path || $admission->student_photo_path) ? '✓' : '✗' }}
                </span>
                Student Photo
            </div>
            <div class="document-item">
                <span class="document-check {{ $admission->birth_certificate_path ? 'submitted' : 'missing' }}">
                    {{ $admission->birth_certificate_path ? '✓' : '✗' }}
                </span>
                Birth Certificate
            </div>
            <div class="document-item">
                <span class="document-check {{ $admission->caste_certificate_path ? 'submitted' : 'missing' }}">
                    {{ $admission->caste_certificate_path ? '✓' : '✗' }}
                </span>
                Caste Certificate
            </div>
            <div class="document-item">
                <span class="document-check {{ $admission->leaving_certificate_path ? 'submitted' : 'missing' }}">
                    {{ $admission->leaving_certificate_path ? '✓' : '✗' }}
                </span>
                Leaving Certificate
            </div>
            <div class="document-item">
                <span class="document-check {{ $admission->marksheet_path ? 'submitted' : 'missing' }}">
                    {{ $admission->marksheet_path ? '✓' : '✗' }}
                </span>
                Marksheet
            </div>
        </div>
    </div>

    <!-- Section 7: Declaration -->
    <div class="section page-break-avoid">
        <div class="section-title">7. DECLARATION</div>
        <div style="padding: 10px; border: 1px solid #dee2e6; border-radius: 3px; margin-top: 10px; font-size: 10px;">
            <p style="margin-bottom: 10px;">
                <strong>I declare that I have read the rules and regulations of the School and I promise to abide by
                    them and see that my ward conforms to the standards required of him in his conduct and
                    studies.</strong>
            </p>
            <table class="data-table" style="margin-top: 10px;">
                <tr>
                    <td class="label">Agreed to Rules</td>
                    <td class="value">{{ $admission->agreed_to_rules ? '✓ YES' : '✗ NO' }}</td>
                    <td class="label">Declaration Date</td>
                    <td class="value">{{ $admission->created_at->format('d/m/Y') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Signatures Section -->
    <div class="signature-section page-break-avoid">
        <div class="signature-container">
            <div class="text-center">
                <div class="signature-line"></div>
                <div style="margin-top: 5px; font-size: 10px; font-weight: bold;">
                    Signature of Parent/Guardian
                </div>
            </div>
            <div class="text-center">
                <div class="signature-line"></div>
                <div style="margin-top: 5px; font-size: 10px; font-weight: bold;">
                    Signature of Principal
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p style="margin-bottom: 5px;">This is a computer-generated document. No physical signature is required.</p>
        <p style="margin-bottom: 5px;"><strong>Generated on:</strong> {{ now()->format('d/m/Y H:i:s') }} |
            <strong>Document ID:</strong> {{ Str::random(10) }}</p>
        <p style="margin-bottom: 0;"><strong>PA. INAMIDAR ENGLISH MEDIUM SCHOOL (Primary)</strong> | All Rights Reserved
        </p>
        <p style="margin-bottom: 0; font-size: 7px;">Application ID: {{ $admission->id }} | Ref:
            {{ $admission->application_number ?? 'N/A' }}</p>
    </div>
</body>

</html>