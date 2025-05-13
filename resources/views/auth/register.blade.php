<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | SkillUp</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50 dark:bg-gray-900">
    <section class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow dark:bg-gray-800">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('assets/holistics_lab_logo.png') }}" alt="Logo" class="h-16">
            </div>
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-6">Create Account</h1>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
                    <strong class="font-bold">Error!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.save') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block mb-1 text-sm font-medium text-gray-700 dark:text-white">Full
                        Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        required>
                </div>

                <div class="mb-4">
                    <label for="email"
                        class="block mb-1 text-sm font-medium text-gray-700 dark:text-white">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        required>
                </div>

                <div class="mb-4">
                    <label for="role" class="block mb-1 text-sm font-medium text-gray-700 dark:text-white">Role</label>
                    <select id="role" name="role"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        required>
                        <option value="">Select Role</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="password"
                        class="block mb-1 text-sm font-medium text-gray-700 dark:text-white">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white pr-10"
                            required>
                        <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3"
                            onclick="togglePassword('password')">
                            <i class="fas fa-eye text-gray-500 hover:text-gray-700"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="password_confirmation"
                        class="block mb-1 text-sm font-medium text-gray-700 dark:text-white">Confirm Password</label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white pr-10"
                            required>
                        <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3"
                            onclick="togglePassword('password_confirmation')">
                            <i class="fas fa-eye text-gray-500 hover:text-gray-700"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Create Account
                </button>

                <p class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
                    Already have an account? <a href="{{ route('login') }}"
                        class="text-indigo-600 hover:underline dark:text-indigo-400">Sign in</a>
                </p>
            </form>
        </div>
    </section>

    <script>
        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const icon = passwordField.nextElementSibling.querySelector('i');

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

</body>

</html>