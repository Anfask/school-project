<h2>Hello {{ $admission->first_name }},</h2>

<p>Thank you for submitting your admission application to <strong>P.A. Inamdar English Medium School</strong>.</p>

<h3>Application Summary</h3>
<table style="width:100%; border-collapse: collapse;">
    <tr>
        <td style="padding: 8px; border: 1px solid #ddd;"><strong>Application ID</strong></td>
        <td style="padding: 8px; border: 1px solid #ddd;">#{{ $admission->id }}</td>
    </tr>
    <tr>
        <td style="padding: 8px; border: 1px solid #ddd;"><strong>Student Name</strong></td>
        <td style="padding: 8px; border: 1px solid #ddd;">{{ $admission->full_name }}</td>
    </tr>
    <tr>
        <td style="padding: 8px; border: 1px solid #ddd;"><strong>Desired Class</strong></td>
        <td style="padding: 8px; border: 1px solid #ddd;">{{ $admission->desired_class }}</td>
    </tr>
    <tr>
        <td style="padding: 8px; border: 1px solid #ddd;"><strong>Submitted Date</strong></td>
        <td style="padding: 8px; border: 1px solid #ddd;">{{ $admission->submitted_at->format('d/m/Y H:i') }}</td>
    </tr>
</table>

<h3>What's Next?</h3>
<ol>
    <li>Our admission team will review your application</li>
    <li>You'll be notified via email about interview dates</li>
    <li>Keep your Application ID for future reference</li>
    <li>Your complete application PDF is attached to this email</li>
</ol>

<p>If you have any questions, please contact us at <strong>admin@yourdomain.com</strong></p>

<p>Best regards,<br>
<strong>P.A. Inamdar English Medium School</strong><br>
Iqra Campus, Govindpura, Ahmednagar</p>
