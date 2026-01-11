@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Settings</h1>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="space-y-6">
                <!-- General Settings -->
                <div class="border-b pb-6">
                    <h2 class="text-xl font-semibold mb-4">General Settings</h2>
                    <p class="text-gray-600">Application settings are under development.</p>
                </div>

                <!-- Email Settings -->
                <div class="border-b pb-6">
                    <h2 class="text-xl font-semibold mb-4">Email Settings</h2>
                    <p class="text-gray-600">Email configuration options will be available here.</p>
                </div>

                <!-- Notification Settings -->
                <div class="border-b pb-6">
                    <h2 class="text-xl font-semibold mb-4">Notification Settings</h2>
                    <p class="text-gray-600">Configure how you receive notifications.</p>
                </div>

                <!-- Security Settings -->
                <div>
                    <h2 class="text-xl font-semibold mb-4">Security Settings</h2>
                    <p class="text-gray-600">Manage your security and privacy settings in your profile.</p>
                    <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                        Go to Profile Settings →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
