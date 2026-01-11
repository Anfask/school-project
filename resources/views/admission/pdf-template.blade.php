<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admission Application #{{ $admission->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            color: #1e3a8a;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        .section-title {
            background-color: #2563eb;
            color: white;
            padding: 10px;
            font-weight: bold;
            margin-bottom: 15px;
            border-radius: 3px;
        }
        .row {
            display: flex;
            margin-bottom: 10px;
        }
        .col {
            flex: 1;
            padding-right: 20px;
        }
        .label {
            font-weight: bold;
            color: #333;
            min-width: 150px;
        }
        .value {
            color: #666;
        }
        .footer {
            border-top: 2px solid #ccc;
            margin-top: 40px;
            padding-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #999;
        }
        .app-id {
            background-color: #f0f9ff;
            padding: 15px;
            border-left: 4px solid #2563eb;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Admission Application Form</h1>
            <p>P.A. Inamdar English Medium School (Primary)</p>
            <p>Iqra Campus, Govindpura, Ahmednagar</p>
        </div>

        <div class="app-id">
            <strong>Application ID:</strong> #{{ $admission->id }}<br>
            <strong>Date of Submission:</strong> {{ $admission->submitted_at->format('d/m/Y H:i') }}<br>
            <strong>Status:</strong> {{ ucfirst($admission->status) }}
        </div>

        <!-- Personal Information -->
        <div class="section">
            <div class="section-title">1. PERSONAL INFORMATION</div>
            <div class="row">
                <div class="col">
                    <div class="label">Surname:</div>
                    <div class="value">{{ $admission->surname }}</div>
                </div>
                <div class="col">
                    <div class="label">First Name:</div>
                    <div class="value">{{ $admission->first_name }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="label">Father's Name:</div>
                    <div class="value">{{ $admission->father_name }}</div>
                </div>
                <div class="col">
                    <div class="label">Mother's Name:</div>
                    <div class="value">{{ $admission->mother_name }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="label">Guardian's Name:</div>
                    <div class="value">{{ $admission->guardian_name ?? 'N/A' }}</div>
                </div>
                <div class="col">
                    <div class="label">Date of Birth:</div>
                    <div class="value">{{ $admission->date_of_birth->format('d/m/Y') }} (Age: {{ $admission->age }})</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="label">Place of Birth:</div>
                    <div class="value">{{ $admission->place_of_birth }}</div>
                </div>
                <div class="col">
                    <div class="label">Nationality:</div>
                    <div class="value">{{ $admission->nationality }}</div>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="section">
            <div class="section-title">2. CONTACT INFORMATION</div>
            <div class="row">
                <div class="col">
                    <div class="label">Email:</div>
                    <div class="value">{{ $admission->email }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="label">Mobile No. 1:</div>
                    <div class="value">{{ $admission->mobile_1 }}</div>
                </div>
                <div class="col">
                    <div class="label">Mobile No. 2:</div>
                    <div class="value">{{ $admission->mobile_2 ?? 'N/A' }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="label">Local Address:</div>
                    <div class="value">{{ $admission->local_address }}</div>
                </div>
            </div>
        </div>

        <!-- Demographics -->
        <div class="section">
            <div class="section-title">3. DEMOGRAPHICS</div>
            <div class="row">
                <div class="col">
                    <div class="label">Religion:</div>
                    <div class="value">{{ $admission->religion ?? 'N/A' }}</div>
                </div>
                <div class="col">
                    <div class="label">Caste:</div>
                    <div class="value">{{ $admission->caste ?? 'N/A' }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="label">Sub-Caste:</div>
                    <div class="value">{{ $admission->sub_caste ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Academic Information -->
        <div class="section">
            <div class="section-title">4. ACADEMIC INFORMATION</div>
            <div class="row">
                <div class="col">
                    <div class="label">Last School Attended:</div>
                    <div class="value">{{ $admission->last_school_name }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="label">School Address:</div>
                    <div class="value">{{ $admission->last_school_address }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="label">Currently in Std:</div>
                    <div class="value">{{ $admission->studying_std }}</div>
                </div>
                <div class="col">
                    <div class="label">Since:</div>
                    <div class="value">{{ $admission->since_date->format('d/m/Y') }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="label">Medium of Instruction:</div>
                    <div class="value">{{ $admission->medium_of_instruction }}</div>
                </div>
                <div class="col">
                    <div class="label">Occupation:</div>
                    <div class="value">{{ $admission->occupation ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Application Details -->
        <div class="section">
            <div class="section-title">5. APPLICATION DETAILS</div>
            <div class="row">
                <div class="col">
                    <div class="label">Desired Class:</div>
                    <div class="value">{{ $admission->desired_class }}</div>
                </div>
                <div class="col">
                    <div class="label">Academic Year:</div>
                    <div class="value">{{ $admission->academic_year }}</div>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>This is a computer-generated document. No signature required.</p>
            <p>Generated on: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
