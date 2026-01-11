<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Application #{{ $application->id }} - {{ config('app.name') }}</title>
    <style>
        @page {
            margin: 20px;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #333;
        }

        .header h1 {
            font-size: 24px;
            margin: 0 0 5px 0;
            color: #2c3e50;
        }

        .header .subtitle {
            font-size: 14px;
            color: #7f8c8d;
        }

        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .info-item {
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: bold;
            color: #34495e;
            margin-bottom: 3px;
        }

        .info-value {
            color: #2c3e50;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
        }

        .status-pending {
            background-color: #f39c12;
        }

        .status-reviewed {
            background-color: #3498db;
        }

        .status-accepted {
            background-color: #27ae60;
        }

        .status-rejected {
            background-color: #e74c3c;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }

        .table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #7f8c8d;
            font-size: 11px;
        }

        .page-break {
            page-break-before: always;
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo img {
            max-height: 50px;
        }

        /* Ensure content stays within page */
        .page-content {
            max-width: 100%;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div class="page-content">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <h1>{{ config('app.name', 'Admission System') }}</h1>
            </div>
            <div class="subtitle">Application Details - #{{ $application->id }}</div>
            <div style="margin-top: 10px;">
                <span class="status-badge status-{{ $application->status }}">
                    Status: {{ ucfirst($application->status) }}
                </span>
                <span style="margin-left: 15px; font-size: 11px;">
                    Generated: {{ now()->format('F d, Y h:i A') }}
                </span>
            </div>
        </div>

        <!-- Application Summary -->
        <div class="section">
            <div class="section-title">Application Summary</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Application ID</div>
                    <div class="info-value">#{{ $application->id }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Application Number</div>
                    <div class="info-value">{{ $application->application_number ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Student Name</div>
                    <div class="info-value">{{ $application->first_name }} {{ $application->surname }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Date of Birth</div>
                    <div class="info-value">
                        @if($application->date_of_birth)
                            {{ \Carbon\Carbon::parse($application->date_of_birth)->format('F d, Y') }}
                            ({{ \Carbon\Carbon::parse($application->date_of_birth)->age }} years)
                        @else
                            N/A
                        @endif
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Class Applied For</div>
                    <div class="info-value">{{ $application->admission_sought_for_class ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Academic Year</div>
                    <div class="info-value">{{ $application->academic_year ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $application->email }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Mobile</div>
                    <div class="info-value">{{ $application->mobile_1 ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="section">
            <div class="section-title">Personal Information</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Gender</div>
                    <div class="info-value">{{ $application->gender ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Place of Birth</div>
                    <div class="info-value">{{ $application->place_of_birth ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Religion</div>
                    <div class="info-value">{{ $application->religion ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Caste</div>
                    <div class="info-value">{{ $application->caste ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Nationality</div>
                    <div class="info-value">{{ $application->nationality ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Blood Group</div>
                    <div class="info-value">{{ $application->blood_group ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Aadhar Number</div>
                    <div class="info-value">{{ $application->aadhar_number ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Physically Unfit</div>
                    <div class="info-value">{{ $application->is_physically_unfit ? 'Yes' : 'No' }}</div>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="section">
            <div class="section-title">Contact Information</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Local Address</div>
                    <div class="info-value">{{ $application->local_address ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Permanent Address</div>
                    <div class="info-value">{{ $application->permanent_address ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">City</div>
                    <div class="info-value">{{ $application->city ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">State</div>
                    <div class="info-value">{{ $application->state ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Pincode</div>
                    <div class="info-value">{{ $application->pincode ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Secondary Phone</div>
                    <div class="info-value">{{ $application->mobile_2 ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Parent Information -->
        <div class="section">
            <div class="section-title">Parent Information</div>
            <div style="margin-bottom: 15px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Details</th>
                            <th>Father</th>
                            <th>Mother</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Full Name</td>
                            <td>{{ $application->father_full_name ?? 'N/A' }}</td>
                            <td>{{ $application->mother_full_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Occupation</td>
                            <td>{{ $application->father_occupation ?? 'N/A' }}</td>
                            <td>{{ $application->mother_occupation ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>{{ $application->father_mobile ?? 'N/A' }}</td>
                            <td>{{ $application->mother_mobile ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $application->father_email ?? 'N/A' }}</td>
                            <td>{{ $application->mother_email ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Annual Income</td>
                            <td>{{ $application->father_annual_income ? '₹' . number_format($application->father_annual_income) : 'N/A' }}</td>
                            <td>{{ $application->mother_annual_income ? '₹' . number_format($application->mother_annual_income) : 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if($application->parents_guardian_full_name)
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Guardian Name</div>
                    <div class="info-value">{{ $application->parents_guardian_full_name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Relationship</div>
                    <div class="info-value">{{ $application->guardian_relationship ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Guardian Mobile</div>
                    <div class="info-value">{{ $application->guardian_mobile ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Guardian Email</div>
                    <div class="info-value">{{ $application->guardian_email ?? 'N/A' }}</div>
                </div>
            </div>
            @endif
        </div>

        <!-- Educational Information -->
        <div class="section">
            <div class="section-title">Educational Information</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Last School Attended</div>
                    <div class="info-value">{{ $application->last_school_attended ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Last School Address</div>
                    <div class="info-value">{{ $application->last_school_address ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Currently Studying</div>
                    <div class="info-value">{{ $application->studying_in_std ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Medium of Instruction</div>
                    <div class="info-value">{{ $application->medium_of_instruction ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Board/University</div>
                    <div class="info-value">{{ $application->board_university ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Year of Passing</div>
                    <div class="info-value">{{ $application->year_of_passing ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Percentage/CGPA</div>
                    <div class="info-value">{{ $application->percentage_cgpa ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Marks Obtained</div>
                    <div class="info-value">{{ $application->marks_obtained ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Emergency Contact -->
        <div class="section">
            <div class="section-title">Emergency Contact</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Emergency Contact Person</div>
                    <div class="info-value">{{ $application->emergency_contact_person ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Emergency Contact Number</div>
                    <div class="info-value">{{ $application->emergency_contact_number ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Relationship</div>
                    <div class="info-value">{{ $application->emergency_relationship ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Family Doctor</div>
                    <div class="info-value">{{ $application->family_doctor ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Doctor's Contact</div>
                    <div class="info-value">{{ $application->doctor_contact ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Medical Conditions</div>
                    <div class="info-value">{{ $application->medical_conditions ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Additional Services -->
        <div class="section">
            <div class="section-title">Additional Services</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Requires Transport</div>
                    <div class="info-value">{{ $application->requires_transport ? 'Yes' : 'No' }}</div>
                </div>
                @if($application->requires_transport)
                <div class="info-item">
                    <div class="info-label">Pickup Point</div>
                    <div class="info-value">{{ $application->pickup_point ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Drop Point</div>
                    <div class="info-value">{{ $application->drop_point ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Bus Route Number</div>
                    <div class="info-value">{{ $application->bus_route_number ?? 'N/A' }}</div>
                </div>
                @endif
                <div class="info-item">
                    <div class="info-label">Requires Hostel</div>
                    <div class="info-value">{{ $application->requires_hostel ? 'Yes' : 'No' }}</div>
                </div>
                @if($application->requires_hostel)
                <div class="info-item">
                    <div class="info-label">Hostel Type</div>
                    <div class="info-value">{{ $application->hostel_type ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Room Preference</div>
                    <div class="info-value">{{ $application->room_preference ?? 'N/A' }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Documents Information -->
        <div class="section">
            <div class="section-title">Documents Submitted</div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Document Type</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Passport Photo</td>
                        <td>{{ $application->passport_photo_path ? 'Uploaded' : 'Not Uploaded' }}</td>
                    </tr>
                    <tr>
                        <td>Birth Certificate</td>
                        <td>{{ $application->birth_certificate_path ? 'Uploaded' : 'Not Uploaded' }}</td>
                    </tr>
                    <tr>
                        <td>Caste Certificate</td>
                        <td>{{ $application->caste_certificate_path ? 'Uploaded' : 'Not Uploaded' }}</td>
                    </tr>
                    <tr>
                        <td>Leaving Certificate</td>
                        <td>{{ $application->leaving_certificate_path ? 'Uploaded' : 'Not Uploaded' }}</td>
                    </tr>
                    <tr>
                        <td>Marksheet</td>
                        <td>{{ $application->marksheet_path ? 'Uploaded' : 'Not Uploaded' }}</td>
                    </tr>
                    <tr>
                        <td>Aadhar Card</td>
                        <td>{{ $application->aadhar_card_path ? 'Uploaded' : 'Not Uploaded' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Declaration -->
        <div class="section">
            <div class="section-title">Declaration & Agreement</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Agreed to Rules & Regulations</div>
                    <div class="info-value">{{ $application->agreed_to_rules ? 'Yes' : 'No' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Agreed to Terms & Conditions</div>
                    <div class="info-value">{{ $application->agreed_to_terms ? 'Yes' : 'No' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Agreed to Privacy Policy</div>
                    <div class="info-value">{{ $application->agreed_to_privacy ? 'Yes' : 'No' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Declaration Date</div>
                    <div class="info-value">
                        @if($application->declaration_date)
                            {{ \Carbon\Carbon::parse($application->declaration_date)->format('F d, Y') }}
                        @else
                            N/A
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Remarks -->
        @if($application->remarks || $application->additional_info)
        <div class="section">
            <div class="section-title">Additional Information</div>
            @if($application->additional_info)
            <div style="margin-bottom: 15px;">
                <div class="info-label">Additional Information:</div>
                <div style="margin-top: 5px;">{{ $application->additional_info }}</div>
            </div>
            @endif

            @if($application->remarks)
            <div>
                <div class="info-label">Remarks:</div>
                <div style="margin-top: 5px;">{{ $application->remarks }}</div>
            </div>
            @endif
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <div>--- End of Application Details ---</div>
            <div style="margin-top: 10px;">
                This document was generated by {{ config('app.name', 'Admission System') }}<br>
                For any queries, contact: admissions@{{ str_replace(['https://', 'http://', 'www.'], '', config('app.url')) }}<br>
                Generated on: {{ now()->format('F d, Y h:i A') }}
            </div>
        </div>
    </div>
</body>
</html>
