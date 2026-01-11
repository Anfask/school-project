<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $apiUrl;
    protected $instanceId;
    protected $token;

    public function __construct()
    {
        // Configuration from .env
        $this->apiUrl = env('WHATSAPP_API_URL', 'https://api.ultramsg.com');
        $this->instanceId = env('WHATSAPP_INSTANCE_ID', '');
        $this->token = env('WHATSAPP_TOKEN', '');
    }

    /**
     * Send status update notification
     *
     * @param string $phone
     * @param string $status
     * @param string $studentName
     * @return bool
     */
    public function sendStatusUpdate($phone, $status, $studentName)
    {
        try {
            if (empty($phone)) {
                Log::warning('WhatsApp Notification: Phone number is empty for student ' . $studentName);
                return false;
            }

            // Basic phone number cleaning
            $phone = preg_replace('/[^0-9]/', '', $phone);

            // Start of typical logic to handle local numbers (assuming India +91 context from variable names like 'aadhar')
            // If the number is 10 digits, prepend 91. 
            if (strlen($phone) == 10) {
                $phone = '91' . $phone;
            }

            $message = "Dear {$studentName},\n\nYour admission application status has been updated to: *" . ucfirst($status) . "*.\n\nPlease check your email for further instructions.\n\nRegards,\nAdmission Team";

            // If credentials are not set, we log the attempt (Simulation Mode)
            if (empty($this->instanceId) || empty($this->token)) {
                Log::info("WhatsApp Simulation - To: {$phone}, Message: {$message}");
                return true;
            }

            // Send request to WhatsApp API Provider (Example using generic params commonly used by providers like UltraMsg)
            $response = Http::withoutVerifying()->post("{$this->apiUrl}/{$this->instanceId}/messages/chat", [
                'token' => $this->token,
                'to' => $phone,
                'body' => $message,
                'priority' => 10
            ]);

            if ($response->successful()) {
                Log::info("WhatsApp sent successfully to {$phone}");
                return true;
            } else {
                Log::error("WhatsApp API Error: " . $response->body());
                return false;
            }

        } catch (\Exception $e) {
            Log::error("WhatsApp Service Error: " . $e->getMessage());
            return false;
        }
    }
}
