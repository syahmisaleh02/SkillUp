<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Assign Course | SkillUp</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <div class="flex min-h-screen">
        <!-- Side Navigation -->
        <aside class="w-64 bg-green-700 text-white shadow-md flex flex-col h-screen fixed">
            <!-- Top Section: Logo + Menu -->
            <div class="flex-1">
                <div class="p-4 border-b border-green-600">
                    <img src="{{ asset('assets/holistics lab.png') }}" alt="Logo" class="h-20 w-20 rounded">
                    <h2 class="text-sm font-semibold leading-tight mt-2">Holistics Lab Sdn. Bhd.</h2>
                </div>
                <ul class="mt-4">
                    <li>
                        <a href="{{ route('manager.dashboard') }}" class="block py-2 px-4 hover:bg-green-600 flex items-center">
                            <i class="fas fa-home w-6"></i>
                            <span>Homepage</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('manager.team') }}" class="block py-2 px-4 bg-green-600 flex items-center">
                            <i class="fas fa-users w-6"></i>
                            <span>Team Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('manager.course') }}" class="block py-2 px-4 hover:bg-green-600 flex items-center">
                            <i class="fas fa-book w-6"></i>
                            <span>Course Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-4 hover:bg-green-600 flex items-center">
                            <i class="fas fa-chart-line w-6"></i>
                            <span>Performance Reports</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Bottom Profile Section -->
            <div class="p-4 border-t border-green-600">
                <a href="{{ route('profile') }}" class="flex items-center space-x-3 hover:bg-green-600 p-2 rounded-lg transition">
                    <div class="h-10 w-10 rounded-full bg-white flex items-center justify-center">
                        <i class="fas fa-user text-green-700"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium">Guest User</p>
                        <p class="text-xs text-green-200">Manager</p>
                    </div>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-6">
            <div class="max-w-4xl mx-auto">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Assign Course</h1>
                    <a href="{{ route('manager.team') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Team
                    </a>
                </div>

                <!-- Employee Info -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
                    <div class="flex items-center space-x-4">
                        <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-user text-gray-600 text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">John Doe</h2>
                            <p class="text-gray-500 dark:text-gray-400">Software Developer</p>
                        </div>
                    </div>
                </div>

                <!-- Course Assignment Form -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                    <form action="#" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <!-- Course Selection -->
                            <div>
                                <label for="course" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Course</label>
                                <select id="course" name="course" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    <option value="">Choose a course...</option>
                                    <option value="1">Web Development Fundamentals</option>
                                    <option value="2">Advanced UI/UX Design</option>
                                    <option value="3">Project Management Essentials</option>
                                    <option value="4">Data Science Basics</option>
                                    <option value="5">Cloud Computing</option>
                                </select>
                            </div>

                            <!-- Start Date -->
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                                <input type="date" id="start_date" name="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>

                            <!-- Due Date -->
                            <div>
                                <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Due Date</label>
                                <input type="date" id="due_date" name="due_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>

                            <!-- Additional Notes -->
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Additional Notes</label>
                                <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Add any specific instructions or requirements..."></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                                    Assign Course
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 