<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;

// CSRF Token management routes (must be before any other routes)
Route::get('/refresh-csrf', function () {
    return response()->json([
        'csrf_token' => csrf_token(),
        'timestamp' => now()->toISOString()
    ]);
})->name('csrf.refresh');

Route::post('/validate-csrf', function (Request $request) {
    $request->validate([
        '_token' => 'required|string'
    ]);

    $isValid = hash_equals(session()->token(), $request->input('_token'));

    return response()->json([
        'valid' => $isValid,
        'message' => $isValid ? 'Token is valid' : 'Token is invalid'
    ]);
})->name('csrf.validate');

// Home Page Route
Route::get('/', [HomeController::class, 'home'])->name('home');

// Form Selection Routes
Route::get('/admission/select-form', [AdmissionController::class, 'showFormSelection'])->name('admission.select');
Route::post('/admission/select-form', [AdmissionController::class, 'processFormSelection'])->name('admission.select.post');

// Form 1 Routes (Pre-primary to Class 2)
Route::get('/admission/form1', [AdmissionController::class, 'showForm1'])->name('admission.form1');
Route::post('/admission/form1', [AdmissionController::class, 'submitForm1'])->name('admission.form1.submit');

// Form 2 Routes (Class 3 to 10)
Route::get('/admission/form2', [AdmissionController::class, 'showForm2'])->name('admission.form2');
Route::post('/admission/form2', [AdmissionController::class, 'submitForm2'])->name('admission.form2.submit');

// Form 3 Routes (Higher Secondary - 11th only)
Route::get('/admission/form3', [AdmissionController::class, 'showForm3'])->name('admission.form3');
Route::post('/admission/form3', [AdmissionController::class, 'submitForm3'])->name('admission.form3.submit');

// Success & Download Routes
Route::get('/admission/success/{id}', [AdmissionController::class, 'showSuccess'])->name('admission.success');
Route::get('/admission/download-pdf/{id}', [AdmissionController::class, 'downloadPDF'])->name('admission.download');


// Admin Authentication Routes
Route::prefix('admin')->group(function () {
    // Show login form (only for guests)
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('admin.login')
        ->middleware('guest');

    // Handle login submission
    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Update last login
            $user = Auth::user();
            $user->last_login_at = now();
            $user->last_login_ip = $request->ip();
            $user->save();

            return redirect()->route('admin.dashboard')->with('success', 'Login successful!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    })->name('admin.login.post');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    // Password Reset Routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Password Confirmation Routes (PROTECTED - requires auth)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/confirm-password', [AuthController::class, 'showConfirmPassword'])->name('password.confirm');
    Route::post('/confirm-password', [AuthController::class, 'confirmPassword'])->name('password.confirm.post');
});

// Protected Admin Routes (require authentication)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Dashboard - Main landing page after login
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Application Management
    Route::get('/applications', [AdminController::class, 'applications'])->name('admin.applications');
    Route::get('/application/{id}', [AdminController::class, 'viewApplication'])->name('admin.application.view');
    Route::post('/application/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.application.status');
    Route::post('/application/{id}/update', [AdminController::class, 'updateApplication'])->name('admin.application.update');
    Route::get('/application/{id}/download', [AdminController::class, 'downloadApplication'])->name('admin.application.download');

    // Email Sending Routes
    Route::get('/application/{id}/send-email', [AdminController::class, 'showSendEmail'])->name('admin.application.send-email.show');
    Route::post('/application/{id}/send-email', [AdminController::class, 'sendApplicationEmail'])->name('admin.application.send-email');

    // Bulk Actions
    Route::post('/applications/bulk-update', [AdminController::class, 'bulkUpdateStatus'])->name('admin.applications.bulk-update');
    Route::delete('/application/{id}', [AdminController::class, 'deleteApplication'])->name('admin.application.delete');

    // Statistics
    Route::get('/statistics', [AdminController::class, 'getStatistics'])->name('admin.statistics');

    // Serve uploaded files securely
    Route::get('/file/{path}', [AdminController::class, 'serveFile'])->name('admin.file.serve');

    // Export
    Route::post('/applications/export', [AdminController::class, 'exportApplications'])->name('admin.applications.export');

    // Notifications Management
    Route::prefix('notifications')->name('admin.notifications.')->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.dashboard')->with('info', 'Notifications page is under development.');
        })->name('index');

        Route::post('/{notification}/read', function ($notificationId) {
            $notification = auth()->user()->notifications()->findOrFail($notificationId);
            $notification->markAsRead();
            return response()->json(['success' => true]);
        })->name('read');

        Route::post('/mark-all-read', function () {
            auth()->user()->unreadNotifications->markAsRead();
            return response()->json(['success' => true]);
        })->name('mark-all-read');

        Route::delete('/{notification}', function ($notificationId) {
            auth()->user()->notifications()->where('id', $notificationId)->delete();
            return response()->json(['success' => true]);
        })->name('delete');

        Route::get('/count/unread', function () {
            $count = auth()->user()->unreadNotifications()->count();
            return response()->json(['count' => $count]);
        })->name('count.unread');
    });

    // Applications Count API
    Route::get('/applications/count/pending', function () {
        $count = \App\Models\AdmissionQuery::where('status', 'pending')->count();
        return response()->json(['count' => $count]);
    })->name('admin.applications.count.pending');

    Route::get('/settings', function () {
        return redirect()->route('admin.dashboard')->with('info', 'Settings page is under development.');
    })->name('admin.settings');

    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::post('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        Route::post('/photo', [ProfileController::class, 'uploadPhoto'])->name('photo.upload');
        Route::delete('/photo', [ProfileController::class, 'removePhoto'])->name('photo.remove');
        Route::post('/two-factor/enable', [ProfileController::class, 'enableTwoFactor'])->name('two-factor.enable');
        Route::post('/two-factor/confirm', [ProfileController::class, 'confirmTwoFactor'])->name('two-factor.confirm');
        Route::post('/two-factor/disable', [ProfileController::class, 'disableTwoFactor'])->name('two-factor.disable');
        Route::post('/two-factor/regenerate-backup-codes', [ProfileController::class, 'regenerateBackupCodes'])->name('two-factor.regenerate-backup');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Legacy Profile Routes (for compatibility)
    Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Additional redirect routes for better UX
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login');
    });

    Route::get('', function () {
        return redirect()->route('admin.login');
    });
});

// Fallback route for any 'login' route references
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('admin.login');
})->name('login');

// Redirect root /admin to appropriate page
Route::get('/admin', function () {
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('admin.login');
});




// API Routes for real-time features
Route::middleware(['auth'])->prefix('api/admin')->group(function () {
    Route::get('/notifications/unread', function () {
        $notifications = auth()->user()->unreadNotifications()->latest()->take(10)->get();
        return response()->json($notifications);
    });

    Route::get('/stats/quick', function () {
        $stats = [
            'pending' => \App\Models\AdmissionQuery::where('status', 'pending')->count(),
            'reviewed' => \App\Models\AdmissionQuery::where('status', 'reviewed')->count(),
            'accepted' => \App\Models\AdmissionQuery::where('status', 'accepted')->count(),
            'rejected' => \App\Models\AdmissionQuery::where('status', 'rejected')->count(),
            'total' => \App\Models\AdmissionQuery::count(),
            'today' => \App\Models\AdmissionQuery::whereDate('created_at', today())->count(),
        ];
        return response()->json($stats);
    });
});

// WebSocket/Pusher auth endpoint
Route::middleware(['auth'])->post('/broadcasting/auth', function () {
    if (!class_exists('Pusher\Pusher')) {
        return response('Pusher not configured', 503);
    }
    $pusher = new \Pusher\Pusher(
        config('broadcasting.connections.pusher.key'),
        config('broadcasting.connections.pusher.secret'),
        config('broadcasting.connections.pusher.app_id'),
        [
            'cluster' => config('broadcasting.connections.pusher.options.cluster'),
            'encrypted' => true
        ]
    );

    $channelName = \Illuminate\Support\Facades\Request::input('channel_name');
    $socketId = \Illuminate\Support\Facades\Request::input('socket_id');

    if (str_starts_with($channelName, 'private-user.')) {
        $userId = str_replace('private-user.', '', $channelName);
        if ($userId == auth()->id()) {
            $auth = $pusher->authorizeChannel($channelName, $socketId);
            return response($auth);
        }
    }

    return response('Forbidden', 403);
});

// Catch-all route for 404
Route::fallback(function () {
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('admin.login');
});
