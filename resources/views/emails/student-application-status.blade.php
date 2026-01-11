<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status Update - {{ config('app.name', 'Admission System') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 20px;
            min-height: 100vh;
        }

        .email-container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        /* HEADER SECTION */
        .email-header {
            background: linear-gradient(135deg, #1a3a52 0%, #2d5a7b 100%);
            padding: 50px 40px;
            color: white;
            text-align: center;
            position: relative;
        }

        .header-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 200"><path fill="rgba(255,255,255,0.05)" d="M0,200 Q250,100 500,200 T1000,200 L1000,0 L0,0 Z"/></svg>') bottom center no-repeat;
            background-size: cover;
        }

        .logo-container {
            position: relative;
            z-index: 2;
        }

        .logo-text {
            font-size: 32px;
            font-weight: 700;
            letter-spacing: -1px;
            color: white;
            text-decoration: none;
        }

        .logo-subtitle {
            color: rgba(255, 255, 255, 0.85);
            font-size: 14px;
            margin-top: 8px;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .notification-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.15);
            padding: 10px 24px;
            border-radius: 50px;
            margin-top: 20px;
            backdrop-filter: blur(10px);
            font-weight: 600;
            font-size: 14px;
            color: white;
        }

        /* STATUS SECTION */
        .status-banner {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 35px 40px;
            text-align: center;
            position: relative;
        }

        .status-banner.accepted {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .status-banner.rejected {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }

        .status-banner.reviewed {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .status-banner.pending {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }

        .status-title {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .status-subtitle {
            font-size: 16px;
            opacity: 0.9;
            line-height: 1.5;
        }

        /* CONTENT */
        .email-content {
            padding: 45px 40px;
        }

        .greeting {
            font-size: 16px;
            color: #2c3e50;
            margin-bottom: 30px;
            line-height: 1.8;
        }

        /* APPLICATION SUMMARY */
        .application-summary {
            background: #f8f9fa;
            border-left: 4px solid #2d5a7b;
            padding: 30px;
            margin: 30px 0;
            border-radius: 4px;
        }

        .application-summary h3 {
            color: #2c3e50;
            font-size: 16px;
            margin-bottom: 25px;
            font-weight: 700;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .summary-item h4 {
            color: #7f8c8d;
            font-size: 12px;
            margin-bottom: 8px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .summary-item p {
            color: #2c3e50;
            font-size: 16px;
            font-weight: 500;
        }

        /* IMPORTANT INFO */
        .important-info {
            background: #d4edda;
            border-left: 4px solid #28a745;
            padding: 30px;
            margin: 30px 0;
            border-radius: 4px;
        }

        .important-info.accepted {
            background: #d4edda;
            border-left-color: #28a745;
        }

        .important-info.rejected {
            background: #f8d7da;
            border-left-color: #dc3545;
        }

        .important-info.reviewed {
            background: #fff3cd;
            border-left-color: #ff9800;
        }

        .important-info.pending {
            background: #d1ecf1;
            border-left-color: #17a2b8;
        }

        .important-info h3 {
            color: #2c3e50;
            font-size: 16px;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .important-info ul {
            list-style: none;
            padding: 0;
        }

        .important-info li {
            color: #333;
            font-size: 14px;
            padding: 10px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            line-height: 1.6;
        }

        .important-info li:last-child {
            border-bottom: none;
        }

        /* NEXT STEPS */
        .next-steps {
            margin: 35px 0;
        }

        .next-steps h3 {
            color: #2c3e50;
            font-size: 18px;
            margin-bottom: 25px;
            font-weight: 700;
        }

        .steps-list {
            counter-reset: step-counter;
        }

        .step-item {
            display: grid;
            grid-template-columns: 50px 1fr;
            gap: 20px;
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid #e9ecef;
        }

        .step-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
            margin-bottom: 0;
        }

        .step-number {
            width: 50px;
            height: 50px;
            background: #2d5a7b;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 18px;
            flex-shrink: 0;
        }

        .step-content h4 {
            color: #2c3e50;
            font-size: 15px;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .step-content p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }

        /* CONTACT SECTION */
        .contact-section {
            background: #f8f9fa;
            border-radius: 4px;
            padding: 30px;
            margin-top: 30px;
            text-align: center;
        }

        .contact-section h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 16px;
            font-weight: 700;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            margin-top: 20px;
        }

        .contact-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding: 15px;
            background: white;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
        }

        /* FOOTER */
        .email-footer {
            background: #2c3e50;
            color: white;
            padding: 40px 30px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 25px;
            margin-top: 25px;
            text-align: center;
        }

        .copyright {
            color: #cbd5e1;
            font-size: 13px;
            line-height: 1.8;
        }

        .copyright small {
            color: #94a3b8;
            font-size: 11px;
            margin-top: 10px;
            display: block;
        }

        /* DIVIDER */
        .divider {
            height: 1px;
            background: #e9ecef;
            margin: 35px 0;
        }

        /* RESPONSIVE */
        @media (max-width: 640px) {
            .email-header {
                padding: 35px 25px;
            }

            .email-content {
                padding: 30px 25px;
            }

            .status-banner {
                padding: 25px 20px;
            }

            .logo-text {
                font-size: 24px;
            }

            .status-title {
                font-size: 22px;
            }

            .summary-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .email-footer {
                padding: 30px 25px;
            }

            .application-summary,
            .important-info,
            .contact-section {
                padding: 20px;
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
                <div class="logo-subtitle">Application Status Update</div>
                <div class="notification-badge">
                    Application #{{ $application->id }}
                </div>
            </div>
        </div>

        <!-- Status Banner -->
        <div class="status-banner {{ strtolower($application->status) }}">
            <div class="status-title">
                @if($application->status == 'accepted')
                    Congratulations!
                @elseif($application->status == 'rejected')
                    Application Update
                @elseif($application->status == 'reviewed')
                    Application Under Review
                @else
                    Application Pending
                @endif
            </div>
            <div class="status-subtitle">
                Your application status has been updated to:<br>
                <strong style="font-size: 18px;">{{ ucfirst($application->status) }}</strong>
            </div>
        </div>

        <!-- Content -->
        <div class="email-content">
            <!-- Greeting -->
            <p class="greeting">
                Dear {{ $application->first_name }} {{ $application->surname }},<br><br>
                Thank you for applying to our institution. We have reviewed your application and here is the current status of your submission.
            </p>

            <!-- Application Summary -->
            <div class="application-summary">
                <h3>Application Summary</h3>
                <div class="summary-grid">
                    <div class="summary-item">
                        <h4>Application ID</h4>
                        <p>#{{ $application->id }}</p>
                    </div>
                    <div class="summary-item">
                        <h4>Student Name</h4>
                        <p>{{ $application->first_name }} {{ $application->surname }}</p>
                    </div>
                    <div class="summary-item">
                        <h4>Class Applied For</h4>
                        <p>{{ $application->admission_sought_for_class ?? 'N/A' }}</p>
                    </div>
                    <div class="summary-item">
                        <h4>Application Date</h4>
                        <p>{{ $application->created_at->format('F d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Status Specific Information -->
            @if($application->status == 'accepted')
            <div class="important-info accepted">
                <h3>Congratulations on Your Acceptance!</h3>
                <ul>
                    <li>Your application has been approved for admission</li>
                    <li>Please complete the next steps to secure your seat</li>
                    <li>Make sure to pay the admission fee before the deadline</li>
                    <li>Submit any pending documents as soon as possible</li>
                </ul>
            </div>
            @elseif($application->status == 'rejected')
            <div class="important-info rejected">
                <h3>Application Status</h3>
                <ul>
                    <li>Your application has been reviewed and was not approved at this time</li>
                    <li>You may apply again in the next academic year</li>
                    <li>Contact the admissions office for feedback on your application</li>
                </ul>
            </div>
            @elseif($application->status == 'reviewed')
            <div class="important-info reviewed">
                <h3>Application Under Review</h3>
                <ul>
                    <li>Your application is currently being reviewed by our admissions team</li>
                    <li>We may contact you for additional information if needed</li>
                    <li>Please check your email regularly for updates</li>
                </ul>
            </div>
            @else
            <div class="important-info pending">
                <h3>Application Status</h3>
                <ul>
                    <li>Your application is pending initial review</li>
                    <li>We will update you once the review process begins</li>
                    <li>Please be patient as we process all applications thoroughly</li>
                </ul>
            </div>
            @endif

            <div class="divider"></div>

            <!-- Next Steps -->
            <div class="next-steps">
                <h3>Next Steps</h3>
                <div class="steps-list">
                    @if($application->status == 'accepted')
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h4>Complete Your Enrollment</h4>
                            <p>Log into your account and complete the enrollment process. Ensure all personal information is accurate and up-to-date.</p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h4>Submit Required Documents</h4>
                            <p>Upload all necessary documents including certificates, transcripts, and identification. All documents must be verified copies.</p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h4>Pay Admission Fee</h4>
                            <p>Complete the payment of your admission fee through the online portal. Multiple payment methods are available for your convenience.</p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <h4>Receive Your Confirmation</h4>
                            <p>Once all requirements are met, you will receive a confirmation letter with complete details about your admission and orientation schedule.</p>
                        </div>
                    </div>
                    @elseif($application->status == 'rejected')
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h4>Review Your Application</h4>
                            <p>Review your submitted application to understand what areas could be strengthened for future applications.</p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h4>Contact Admissions Office</h4>
                            <p>Reach out to our admissions team for feedback and suggestions on improving your application for next year.</p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h4>Plan for Next Year</h4>
                            <p>Begin preparing for your next application. Focus on academic excellence and community involvement.</p>
                        </div>
                    </div>
                    @else
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h4>Monitor Your Email</h4>
                            <p>Keep checking your email regularly for any updates regarding your application status.</p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h4>Prepare Documents</h4>
                            <p>Have all required documents ready in case we need to request additional information from you.</p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h4>Check Your Account</h4>
                            <p>Log into your application portal regularly to check for any messages or announcements from the admissions office.</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Contact Section -->
            <div class="contact-section">
                <h3>Questions or Need Assistance?</h3>
                <div class="contact-grid">
                    <div class="contact-item">
                        <strong>Email:</strong>
                        <a href="mailto:admissions@institution.edu" style="color: #2d5a7b; text-decoration: none;">admissions@institution.edu</a>
                    </div>
                    <div class="contact-item">
                        <strong>Phone:</strong>
                        <span style="color: #666;">+1 (555) 123-4567</span>
                    </div>
                    <div class="contact-item">
                        <strong>Office Hours:</strong>
                        <span style="color: #666;">Monday - Friday, 9:00 AM - 5:00 PM</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <div class="footer-bottom">
                <div class="copyright">
                    © {{ date('Y') }} {{ config('app.name', 'Admission System') }}. All rights reserved.<br>
                    This is an automated email sent to {{ $application->email }}<br>
                    <small>Please do not reply directly to this email. Contact the admissions office for inquiries.</small>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
