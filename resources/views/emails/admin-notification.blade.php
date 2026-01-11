<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Admission Application - {{ config('app.name', 'Admission System') }}</title>
    <style>
        /* Reset styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #2d3748;
            background-color: #f7fafc;
            padding: 20px;
        }

        .email-container {
            max-width: 680px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }

        /* Header */
        .email-header {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            padding: 30px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 200"><path fill="rgba(255,255,255,0.1)" d="M0,200 Q250,100 500,200 T1000,200 L1000,0 L0,0 Z"/></svg>') bottom center no-repeat;
            background-size: cover;
        }

        .logo-container {
            position: relative;
            z-index: 2;
        }

        .logo-text {
            font-size: 28px;
            font-weight: 800;
            color: white;
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .logo-subtitle {
            color: rgba(255,255,255,0.9);
            font-size: 14px;
            margin-top: 8px;
            font-weight: 500;
        }

        .notification-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.15);
            padding: 12px 24px;
            border-radius: 50px;
            margin-top: 20px;
            backdrop-filter: blur(10px);
        }

        .notification-icon {
            font-size: 24px;
        }

        .badge-text {
            color: white;
            font-weight: 600;
            font-size: 15px;
        }

        /* Content */
        .email-content {
            padding: 40px 30px;
        }

        .application-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f1f5f9;
        }

        .application-title {
            font-size: 24px;
            font-weight: 700;
            color: #059669;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .application-id {
            display: inline-block;
            background: #f0fdf4;
            color: #059669;
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            border: 1px solid #86efac;
        }

        .intro-message {
            text-align: center;
            font-size: 16px;
            color: #475569;
            margin-bottom: 30px;
            line-height: 1.7;
        }

        /* Student Info Card */
        .student-card {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid #86efac;
            position: relative;
            overflow: hidden;
        }

        .student-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #10b981, #059669);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .student-avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 20px;
        }

        .student-basic-info h3 {
            color: #064e3b;
            margin-bottom: 5px;
            font-size: 20px;
        }

        .student-basic-info p {
            color: #047857;
            font-size: 14px;
        }

        /* Information Table */
        .info-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 25px 0;
        }

        .info-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .info-table td {
            padding: 16px;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-table tr:last-child td {
            border-bottom: none;
        }

        .info-label {
            color: #475569;
            font-weight: 600;
            font-size: 14px;
            width: 35%;
        }

        .info-value {
            color: #1e293b;
            font-size: 15px;
        }

        .info-value.highlight {
            color: #059669;
            font-weight: 600;
        }

        /* Action Buttons */
        .action-section {
            text-align: center;
            margin: 40px 0 30px;
        }

        .action-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            padding: 16px 32px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(5, 150, 105, 0.25);
        }

        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(5, 150, 105, 0.35);
        }

        .secondary-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: white;
            color: #059669;
            padding: 14px 28px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            border: 2px solid #86efac;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-left: 15px;
        }

        .secondary-button:hover {
            background: #f0fdf4;
            border-color: #059669;
        }

        /* Quick Stats */
        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin: 35px 0;
        }

        .stat-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.05);
            border-color: #86efac;
        }

        .stat-icon {
            font-size: 24px;
            margin-bottom: 10px;
            display: block;
            color: #059669;
        }

        .stat-title {
            font-weight: 600;
            color: #1e293b;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #059669;
        }

        /* Submission Info */
        .submission-info {
            background: #f8fafc;
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
            text-align: center;
            border-left: 4px solid #059669;
        }

        .submission-info p {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .submission-time {
            color: #059669;
            font-weight: 600;
            font-size: 16px;
            margin-top: 10px;
        }

        /* Footer */
        .email-footer {
            background: #0f172a;
            color: white;
            padding: 40px 30px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .footer-section h4 {
            color: #f8fafc;
            font-size: 16px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #cbd5e1;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #10b981;
        }

        .contact-info {
            color: #cbd5e1;
            font-size: 14px;
            line-height: 1.6;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 25px;
            margin-top: 25px;
            text-align: center;
        }

        .social-links {
            margin-bottom: 20px;
        }

        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            color: white;
            margin: 0 6px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background: #10b981;
            transform: translateY(-3px);
        }

        .copyright {
            color: #94a3b8;
            font-size: 13px;
            line-height: 1.5;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 6px 15px;
            background: #fef3c7;
            color: #92400e;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-left: 10px;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .email-content {
                padding: 25px 20px;
            }

            .card-header {
                flex-direction: column;
                text-align: center;
            }

            .quick-stats {
                grid-template-columns: 1fr;
            }

            .info-table .info-label {
                width: 40%;
            }

            .action-button, .secondary-button {
                width: 100%;
                margin: 10px 0;
                justify-content: center;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <div class="header-overlay"></div>
            <div class="logo-container">
                <a href="{{ config('app.url') }}" class="logo-text">{{ config('app.name', 'Admission System') }}</a>
                <div class="logo-subtitle">Admissions Department</div>
                <div class="notification-badge">
                    <span class="notification-icon">🎓</span>
                    <span class="badge-text">New Application Received</span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="email-content">
            <!-- Application Header -->
            <div class="application-header">
                <h1 class="application-title">
                    <span>📋</span>
                    New Admission Application
                    <span class="status-badge">New</span>
                </h1>
                <div class="application-id">Application #{{ $admission->id }}</div>
            </div>

            <!-- Intro Message -->
            <p class="intro-message">
                A new admission application has been submitted and requires your review.
                Please process this application promptly.
            </p>

            <!-- Student Card -->
            <div class="student-card">
                <div class="card-header">
                    <div class="student-avatar">
                        {{ substr($admission->full_name, 0, 2) }}
                    </div>
                    <div class="student-basic-info">
                        <h3>{{ $admission->full_name }}</h3>
                        <p>📧 {{ $admission->email }} • 📱 {{ $admission->mobile_1 }}</p>
                    </div>
                </div>

                <!-- Student Information Table -->
                <table class="info-table">
                    <tr>
                        <td class="info-label">Application ID</td>
                        <td class="info-value highlight">#{{ $admission->id }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Full Name</td>
                        <td class="info-value">{{ $admission->full_name }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Date of Birth</td>
                        <td class="info-value">
                            {{ $admission->date_of_birth->format('F j, Y') }}
                            <span style="color: #64748b; margin-left: 10px;">
                                (Age: {{ $admission->age }} years)
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">Email Address</td>
                        <td class="info-value">{{ $admission->email }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Mobile Number</td>
                        <td class="info-value">{{ $admission->mobile_1 }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Desired Class</td>
                        <td class="info-value highlight">{{ $admission->desired_class }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Last School Attended</td>
                        <td class="info-value">{{ $admission->last_school_name ?? 'Not specified' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Father's Name</td>
                        <td class="info-value">{{ $admission->father_name ?? 'Not specified' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Mother's Name</td>
                        <td class="info-value">{{ $admission->mother_name ?? 'Not specified' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Address</td>
                        <td class="info-value">
                            {{ $admission->address ?? 'Not specified' }}<br>
                            {{ $admission->city ?? '' }} {{ $admission->state ?? '' }}
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="stat-card">
                    <span class="stat-icon">🎓</span>
                    <div class="stat-title">Desired Class</div>
                    <div class="stat-value">{{ $admission->desired_class }}</div>
                </div>
                <div class="stat-card">
                    <span class="stat-icon">📅</span>
                    <div class="stat-title">Date of Birth</div>
                    <div class="stat-value">{{ $admission->date_of_birth->format('M j') }}</div>
                </div>
                <div class="stat-card">
                    <span class="stat-icon">👤</span>
                    <div class="stat-title">Age</div>
                    <div class="stat-value">{{ $admission->age }}</div>
                </div>
                <div class="stat-card">
                    <span class="stat-icon">🏫</span>
                    <div class="stat-title">Previous School</div>
                    <div class="stat-value">
                        @if($admission->last_school_name)
                            Yes
                        @else
                            No
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-section">
                <a href="{{ url('/admin/applications/' . $admission->id) }}" class="action-button">
                    <span>👁️</span>
                    View Full Application Details
                </a>
                <a href="{{ url('/admin/applications') }}" class="secondary-button">
                    <span>📋</span>
                    All Applications
                </a>
            </div>

            <!-- Submission Info -->
            <div class="submission-info">
                <p>Application submitted on:</p>
                <div class="submission-time">
                    {{ $admission->submitted_at->format('l, F j, Y') }}<br>
                    at {{ $admission->submitted_at->format('g:i A') }}
                </div>
                <p style="margin-top: 10px; font-size: 13px;">
                    ⏱️ {{ $admission->submitted_at->diffForHumans() }}
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <div class="footer-grid">
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="{{ url('/admin/applications') }}">All Applications</a></li>
                        <li><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ url('/admin/statistics') }}">Statistics</a></li>
                        <li><a href="{{ url('/admin/reports') }}">Reports</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4>Admissions</h4>
                    <ul class="footer-links">
                        <li><a href="{{ url('/admin/applications/pending') }}">Pending Applications</a></li>
                        <li><a href="{{ url('/admin/applications/approved') }}">Approved Applications</a></li>
                        <li><a href="{{ url('/admin/applications/rejected') }}">Rejected Applications</a></li>
                        <li><a href="{{ url('/admin/applications/today') }}">Today's Applications</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4>Contact Information</h4>
                    <div class="contact-info">
                        <p>🏫 {{ config('app.name', 'Admission System') }}</p>
                        <p>📧 admissions@{{ str_replace(['https://', 'http://', 'www.'], '', config('app.url')) }}</p>
                        <p>📞 (555) 123-ADMIT</p>
                        <p>📍 123 Education Lane, Campus City</p>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="social-links">
                    <a href="#" class="social-icon">🎓</a>
                    <a href="#" class="social-icon">📚</a>
                    <a href="#" class="social-icon">🏫</a>
                    <a href="#" class="social-icon">📞</a>
                </div>

                <div class="copyright">
                    © {{ date('Y') }} {{ config('app.name', 'Admission System') }}. All rights reserved.<br>
                    This is an automated notification for administrators only.<br>
                    <small style="color: #94a3b8; font-size: 11px; margin-top: 10px; display: block;">
                        🔒 This email contains confidential student information. Handle with care.
                    </small>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
