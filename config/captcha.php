<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google reCAPTCHA Configuration
    |--------------------------------------------------------------------------
    |
    | This file holds the configuration for Google reCAPTCHA integration.
    | You can get your site key and secret key from:
    | https://www.google.com/recaptcha/admin
    |
    */

    // Site key (public key)
    'site_key' => env('RECAPTCHA_SITE_KEY', '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI'),

    // Secret key (private key)
    'secret_key' => env('RECAPTCHA_SECRET_KEY', '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe'),

    // reCAPTCHA version (v2 or v3)
    'version' => env('RECAPTCHA_VERSION', 'v2'),

    // reCAPTCHA v2 size (normal, compact, invisible)
    'size' => env('RECAPTCHA_SIZE', 'normal'),

    // reCAPTCHA theme (light or dark)
    'theme' => env('RECAPTCHA_THEME', 'light'),

    // reCAPTCHA type (image or audio)
    'type' => env('RECAPTCHA_TYPE', 'image'),

    // Score threshold for v3 (0.0 to 1.0)
    'score_threshold' => env('RECAPTCHA_SCORE_THRESHOLD', 0.5),

    // API endpoints
    'verify_url' => 'https://www.google.com/recaptcha/api/siteverify',

    // Enable/disable reCAPTCHA
    'enabled' => env('RECAPTCHA_ENABLED', true),

    // Skip reCAPTCHA for these environments
    'skip_environments' => ['testing'],

    // Bypass key for testing
    'bypass_key' => env('RECAPTCHA_BYPASS_KEY', null),
];
