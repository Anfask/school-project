<?php
// app/Rules/Recaptcha.php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements Rule
{
    public function passes($attribute, $value)
    {
        // For local testing, accept any value (disable recaptcha check)
        if (app()->environment('local')) {
            return true;
        }

        // For production, validate with Google
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('recaptcha.secret_key'),
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        return $response->json()['success'];
    }

    public function message()
    {
        return 'The recaptcha verification failed. Please try again.';
    }
}
