<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Progress | SkillUp</title>
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
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Employee Progress</h1>
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

                <!-- Progress Overview -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Overall Progress</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-green-800 dark:text-green-200">Completed Courses</span>
                                <span class="text-2xl font-bold text-green-600 dark:text-green-400">3</span>
                            </div>
                        </div>
                        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-blue-800 dark:text-blue-200">In Progress</span>
                                <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">2</span>
                            </div>
                        </div>
                        <div class="bg-yellow-50 dark:bg-yellow-900 p-4 rounded-lg">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Average Score</span>
                                <span class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">85%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course Progress Details -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Course Progress</h3>
                    <div class="space-y-4">
                        <!-- Course 1 -->
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-gray-800 dark:text-white">Web Development Fundamentals</h4>
                                <span class="text-sm font-medium text-green-600">75% Complete</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-green-500 h-2.5 rounded-full" style="width: 75%"></div>
                            </div>
                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                <p>Last Activity: 2 days ago</p>
                                <p>Time Spent: 12 hours</p>
                            </div>
                        </div>

                        <!-- Course 2 -->
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-gray-800 dark:text-white">Advanced UI/UX Design</h4>
                                <span class="text-sm font-medium text-blue-600">45% Complete</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-500 h-2.5 rounded-full" style="width: 45%"></div>
                            </div>
                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                <p>Last Activity: 1 day ago</p>
                                <p>Time Spent: 8 hours</p>
                            </div>
                        </div>

                        <!-- Course 3 -->
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-gray-800 dark:text-white">Project Management Essentials</h4>
                                <span class="text-sm font-medium text-green-600">100% Complete</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-green-500 h-2.5 rounded-full" style="width: 100%"></div>
                            </div>
                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                <p>Completed: 1 week ago</p>
                                <p>Final Score: 92%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 