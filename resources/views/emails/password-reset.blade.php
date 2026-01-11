<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset - {{ config('app.name', 'Admission System') }}</title>
    <style>
        /* Reset styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f7fa;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        /* Header with logo */
        .email-header {
            background: linear-gradient(135deg, #4a6ee0 0%, #6a11cb 100%);
            padding: 30px 20px;
            text-align: center;
        }

        .logo-container {
            display: inline-block;
            background: white;
            padding: 15px 25px;
            border-radius: 50px;
            margin-bottom: 15px;
        }

        .logo-text {
            font-size: 24px;
            font-weight: 700;
            color: #4a6ee0;
            text-decoration: none;
        }

        .logo-text span {
            color: #6a11cb;
        }

        .email-subject {
            color: white;
            font-size: 18px;
            font-weight: 500;
            margin-top: 10px;
        }

        /* Email content */
        .email-content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #333;
        }

        .message {
            font-size: 16px;
            color: #555;
            margin-bottom: 25px;
            line-height: 1.7;
        }

        /* Reset button */
        .reset-button {
            text-align: center;
            margin: 35px 0;
        }

        .reset-btn {
         display: inline-block;
    background: linear-gradient(135deg, #4a6ee0 0%, #6a11cb 100%);
    color: #ffffff !important;
    padding: 16px 40px;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 600;
    font-size: 16px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(74, 110, 224, 0.3);
}


        .reset-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 110, 224, 0.4);
        }

        /* Expiry notice */
        .expiry-notice {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 25px 0;
            border-left: 4px solid #ffc107;
        }

        .expiry-notice p {
            margin: 0;
            font-size: 14px;
            color: #856404;
        }

        /* Alternate link */
        .alternate-link {
            background: #f1f3f4;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
        }

        .alternate-link p {
            font-size: 13px;
            color: #666;
            margin-bottom: 10px;
        }

        .url-box {
            background: white;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-family: monospace;
            font-size: 13px;
            word-break: break-all;
            color: #4a6ee0;
        }

        /* Footer */
        .email-footer {
            background: #2c3e50;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .footer-logo {
            font-size: 20px;
            font-weight: 700;
            color: #ffffff !important;
            margin-bottom: 15px;
            display: block;
        }

        .footer-info {
            font-size: 14px;
            color: #bdc3c7;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .footer-info p {
            margin: 5px 0;
        }



        .copyright {
            font-size: 12px;
            color: #95a5a6;
            margin-top: 15px;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .email-content {
                padding: 30px 20px;
            }

            .contact-info {
                flex-direction: column;
                gap: 10px;
            }

            .reset-btn {
                padding: 14px 30px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header with Logo -->
        <div class="email-header">
            <div class="logo-container">
                <a href="{{ config('app.url') }}" class="logo-text"><img src="https://yourdomain.com/images/logo.png"
                 alt="{{ config('app.name') }}"
                 width="160"
                 style="display:block;
                        margin:0 auto;
                        max-width:160px;
                        height:auto;
                        border:0;
                        outline:none;
                        text-decoration:none;"></a>
            </div>
            <div class="email-subject">Password Reset Request</div>
        </div>

        <!-- Email Content -->
        <div class="email-content">
            <h2 class="greeting">Hello {{ $user->name ?? 'Valued User' }},</h2>

            <p class="message">
                You are receiving this email because we received a password reset request for your account.
                If you didn't request this, you can safely ignore this email.
            </p>

            <!-- Reset Button -->
            <div class="reset-button">
                <a href="{{ $resetUrl }}" class="reset-btn">Reset My Password</a>
            </div>

            <!-- Expiry Notice -->
            <div class="expiry-notice">
                <p><strong>⚠️ Important:</strong> This password reset link will expire in {{ $expireMinutes }} minutes.</p>
            </div>

            <!-- Alternate Method -->
            <div class="alternate-link">
                <p>If the button above doesn't work, copy and paste this URL into your browser:</p>
                <div class="url-box">{{ $resetUrl }}</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <a href="{{ config('app.url') }}" class="footer-logo">{{ config('app.name', 'Admission System') }}</a>

            <div class="footer-info">
                <p>Admission Management Portal</p>
                <p>Secure platform for managing student admissions</p>
            </div>

            <div class="copyright">
                © {{ $currentYear }} {{ config('app.name', 'Admission System') }}. All rights reserved.<br>
            </div>
        </div>
    </div>
</body>
</html>
