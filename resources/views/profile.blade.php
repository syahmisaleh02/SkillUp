<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile Management | SkillUp</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-green-700 text-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route(Auth::user()->role . '.dashboard') }}" class="flex items-center">
                            <img src="{{ asset('assets/holistics lab.png') }}" alt="Logo" class="h-8 w-8 rounded">
                            <span class="ml-2 text-lg font-semibold">SkillUp</span>
                        </a>
                    </div>
                    <div class="flex items-center">
                        <a href="{{ route(Auth::user()->role . '.dashboard') }}" class="text-white hover:bg-green-600 px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                    <!-- Profile Header -->
                    <div class="bg-green-700 px-6 py-8">
                        <div class="flex items-center space-x-4">
                            <div class="h-24 w-24 rounded-full bg-white flex items-center justify-center">
                                <i class="fas fa-user text-green-700 text-4xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-white">{{ Auth::user()?->name ?? 'User' }}</h1>
                                <p class="text-green-200">{{ Auth::user()?->role ?? 'User' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Content -->
                    <div class="p-6">
                        <form action="{{ route('profile.update') }}" method="POST" x-data="{ isEditing: false }">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Personal Information -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                    <div class="flex justify-between items-center mb-4">
                                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Personal Information</h2>
                                        <button type="button" @click="isEditing = !isEditing" class="text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300">
                                            <i class="fas" :class="isEditing ? 'fa-times' : 'fa-edit'"></i>
                                            <span x-text="isEditing ? ' Cancel' : ' Edit'"></span>
                                        </button>
                                    </div>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                                            <input type="text" name="name" value="{{ old('name', Auth::user()?->name) }}" 
                                                :disabled="!isEditing"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                                :class="!isEditing ? 'bg-gray-100 dark:bg-gray-600' : ''">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                                            <input type="email" name="email" value="{{ old('email', Auth::user()?->email) }}" 
                                                :disabled="!isEditing"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                                :class="!isEditing ? 'bg-gray-100 dark:bg-gray-600' : ''">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                                            <select name="department" 
                                                :disabled="!isEditing"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                                :class="!isEditing ? 'bg-gray-100 dark:bg-gray-600' : ''">
                                                <option value="">Select your department</option>
                                                <option value="Development" {{ (old('department', Auth::user()?->department) == 'Development') ? 'selected' : '' }}>Development</option>
                                                <option value="Design" {{ (old('department', Auth::user()?->department) == 'Design') ? 'selected' : '' }}>Design</option>
                                                <option value="Marketing" {{ (old('department', Auth::user()?->department) == 'Marketing') ? 'selected' : '' }}>Marketing</option>
                                                <option value="HR" {{ (old('department', Auth::user()?->department) == 'HR') ? 'selected' : '' }}>HR</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Security Settings -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Security Settings</h2>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Password</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <i class="fas fa-lock text-gray-400"></i>
                                                </div>
                                                <input type="password" name="current_password" 
                                                    :disabled="!isEditing"
                                                    class="mt-1 block w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white @error('current_password') border-red-500 @enderror"
                                                    :class="!isEditing ? 'bg-gray-100 dark:bg-gray-600' : ''"
                                                    id="current_password">
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                                    <button type="button" onclick="togglePassword('current_password')">
                                                        <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="current_password_icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @error('current_password')
                                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>
    <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <i class="fas fa-lock text-gray-400"></i>
                                                </div>
                                                <input type="password" name="password" 
                                                    :disabled="!isEditing"
                                                    class="mt-1 block w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white @error('password') border-red-500 @enderror"
                                                    :class="!isEditing ? 'bg-gray-100 dark:bg-gray-600' : ''"
                                                    id="password">
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                                    <button type="button" onclick="togglePassword('password')">
                                                        <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="password_icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @error('password')
                                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                            @enderror
    </div>
    <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm New Password</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <i class="fas fa-lock text-gray-400"></i>
                                                </div>
                                                <input type="password" name="password_confirmation" 
                                                    :disabled="!isEditing"
                                                    class="mt-1 block w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                                    :class="!isEditing ? 'bg-gray-100 dark:bg-gray-600' : ''"
                                                    id="password_confirmation">
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                                    <button type="button" onclick="togglePassword('password_confirmation')">
                                                        <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="password_confirmation_icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 md:col-span-2">
                                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Additional Information</h2>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bio</label>
                                            <textarea name="bio" rows="4" 
                                                :disabled="!isEditing"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                                :class="!isEditing ? 'bg-gray-100 dark:bg-gray-600' : ''">{{ old('bio', Auth::user()?->bio) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-6 flex justify-end space-x-4">
                                <button type="submit" x-show="isEditing" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
    </div>
        </main>
    </div>

    
    <script>
    function togglePassword(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '_icon');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
    </script>
    
</body>
</html>