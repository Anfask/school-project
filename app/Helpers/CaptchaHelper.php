<?php

namespace App\Helpers;

class CaptchaHelper
{
    /**
     * Render reCAPTCHA widget
     */
    public static function render()
    {
        if (!config('captcha.enabled')) {
            return '';
        }

        $siteKey = config('captcha.site_key');
        $version = config('captcha.version');
        $size = config('captcha.size');
        $theme = config('captcha.theme');
        $type = config('captcha.type');

        if ($version === 'v3') {
            return '<input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">';
        }

        return '<div class="g-recaptcha"
                    data-sitekey="' . e($siteKey) . '"
                    data-size="' . e($size) . '"
                    data-theme="' . e($theme) . '"
                    data-type="' . e($type) . '"
                    data-callback="onRecaptchaSuccess"
                    data-expired-callback="onRecaptchaExpired"></div>';
    }

    /**
     * Render reCAPTCHA JavaScript
     */
    public static function renderJs()
    {
        if (!config('captcha.enabled')) {
            return '';
        }

        $version = config('captcha.version');
        $siteKey = config('captcha.site_key');

        $js = '<script src="https://www.google.com/recaptcha/api.js' .
              ($version === 'v3' ? '?render=' . e($siteKey) : '') .
              '" async defer></script>';

        if ($version === 'v3') {
            $js .= '
            <script>
                grecaptcha.ready(function() {
                    grecaptcha.execute("' . e($siteKey) . '", {action: "submit"}).then(function(token) {
                        document.getElementById("g-recaptcha-response").value = token;
                    });
                });
            </script>';
        }

        return $js;
    }

    /**
     * Verify reCAPTCHA response
     */
    public static function verify($response, $ip = null)
    {
        if (!config('captcha.enabled')) {
            return true;
        }

        // Check bypass key
        if ($response === config('captcha.bypass_key')) {
            return true;
        }

        // Skip for testing environments
        if (in_array(env('APP_ENV'), config('captcha.skip_environments'))) {
            return true;
        }

        $secretKey = config('captcha.secret_key');
        $url = config('captcha.verify_url');

        $data = [
            'secret' => $secretKey,
            'response' => $response,
            'remoteip' => $ip,
        ];

        $options = [
            'http' => [
                'method' => 'POST',
                'content' => http_build_query($data),
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            ],
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $resultJson = json_decode($result, true);

        if (!isset($resultJson['success']) || !$resultJson['success']) {
            return false;
        }

        // For v3, check score
        if (config('captcha.version') === 'v3') {
            $score = $resultJson['score'] ?? 0;
            $threshold = config('captcha.score_threshold', 0.5);
            return $score >= $threshold;
        }

        return true;
    }
}
