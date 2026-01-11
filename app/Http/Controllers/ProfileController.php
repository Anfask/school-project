<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use PragmaRX\Google2FA\Google2FA;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('admin.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Add phone and timezone to the update
        $additionalData = $request->only(['phone', 'timezone']);

        $request->user()->fill(array_merge($validated, $additionalData));

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
            'password_changed_at' => now(),
        ]);

        return back()->with('status', 'password-updated');
    }

    /**
     * Upload profile photo.
     */
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $user = $request->user();

        // Delete old photo if exists
        if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // Store new photo
        $path = $request->file('profile_photo')->store('profile-photos', 'public');

        $user->profile_photo_path = $path;
        $user->save();

        return response()->json([
            'success' => true,
            'photo_url' => Storage::url($path),
            'message' => 'Profile photo updated successfully!'
        ]);
    }

    /**
     * Remove profile photo.
     */
    public function removePhoto(Request $request)
    {
        $user = $request->user();

        if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $user->profile_photo_path = null;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile photo removed successfully.',
            'initials' => $user->initials
        ]);
    }

    /**
     * Enable two-factor authentication.
     */
    public function enableTwoFactor(Request $request)
    {
        $validated = $request->validate([
            'method' => ['required', 'in:app,sms'],
        ]);

        $user = $request->user();

        if ($validated['method'] === 'app') {
            try {
                // Generate secret for authenticator app
                $google2fa = new Google2FA();
                $secret = $google2fa->generateSecretKey();

                $user->two_factor_method = 'app';
                $user->two_factor_secret = encrypt($secret);
                $user->save();

                // Generate QR code URL
                $qrCodeUrl = $google2fa->getQRCodeUrl(
                    config('app.name', 'Laravel'),
                    $user->email,
                    $secret
                );

                return response()->json([
                    'success' => true,
                    'method' => 'app',
                    'secret' => $secret,
                    'qr_code_url' => $qrCodeUrl,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate 2FA secret. Please try again.',
                ], 500);
            }
        } else {
            // For SMS, you'd send a verification code
            // This is a placeholder - implement your SMS service
            $user->two_factor_method = 'sms';
            $user->save();

            return response()->json([
                'success' => true,
                'method' => 'sms',
                'message' => 'Verification code would be sent via SMS.',
            ]);
        }
    }

    /**
     * Verify and confirm two-factor authentication.
     */
    public function confirmTwoFactor(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'min:6', 'max:6'],
        ]);

        $user = $request->user();

        if ($user->two_factor_method === 'app' && $user->two_factor_secret) {
            try {
                $google2fa = new Google2FA();
                $secret = decrypt($user->two_factor_secret);

                $valid = $google2fa->verifyKey($secret, $validated['code']);

                if ($valid) {
                    $user->two_factor_enabled = true;
                    $user->two_factor_confirmed_at = now();
                    $user->save();

                    // Generate backup codes
                    $backupCodes = $this->generateBackupCodes($user);

                    return response()->json([
                        'success' => true,
                        'backup_codes' => $backupCodes,
                        'message' => 'Two-factor authentication enabled successfully!'
                    ]);
                }
            } catch (\Exception $e) {
                // Log error if needed
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid verification code.',
        ], 422);
    }

    /**
     * Generate backup codes for user.
     */
    private function generateBackupCodes($user): array
    {
        $codes = [];
        for ($i = 0; $i < 8; $i++) {
            $codes[] = strtoupper(bin2hex(random_bytes(3))); // 6 character codes
        }

        $user->two_factor_backup_codes = $codes;
        $user->save();

        return $codes;
    }

    /**
     * Disable two-factor authentication.
     */
    public function disableTwoFactor(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        $user->two_factor_enabled = false;
        $user->two_factor_method = null;
        $user->two_factor_secret = null;
        $user->two_factor_backup_codes = null;
        $user->two_factor_confirmed_at = null;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Two-factor authentication disabled.'
        ]);
    }

    /**
     * Regenerate backup codes.
     */
    public function regenerateBackupCodes(Request $request)
    {
        $user = $request->user();

        if (!$user->two_factor_enabled || !$user->two_factor_confirmed_at) {
            return response()->json([
                'success' => false,
                'message' => 'Two-factor authentication is not enabled.',
            ], 400);
        }

        $backupCodes = $this->generateBackupCodes($user);

        return response()->json([
            'success' => true,
            'backup_codes' => $backupCodes,
            'message' => 'Backup codes regenerated successfully.'
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'confirm' => ['required', 'string'],
        ]);

        $user = $request->user();

        // Verify confirmation text
        if ($request->confirm !== "DELETE {$user->email}") {
            return back()->withErrors(['confirm' => 'Confirmation text does not match.']);
        }

        // Delete profile photo if exists
        if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // Logout user
        Auth::logout();

        // Delete user
        $user->delete();

        // Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('success', 'Your account has been deleted.');
    }
}
