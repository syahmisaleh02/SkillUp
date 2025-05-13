<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Manager Dashboard | SkillUp</title>
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
                        <a href="{{ route('manager.team') }}" class="block py-2 px-4 hover:bg-green-600 flex items-center">
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
                        <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-green-200">{{ Auth::user()->role }}</p>
                    </div>
                </a>
            </div>
        </aside>    
        
        <!-- Main Content -->
        <main class="flex-1 ml-64 p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Manager Dashboard</h1>
                <div class="flex items-center space-x-4">
                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        <i class="fas fa-plus mr-2"></i>New Task
                    </button>
                
                    <a href="{{ route('logout') }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md flex items-center">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Team Members</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">12</h3>
                        </div>
                        <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full">
                            <i class="fas fa-users text-blue-600 dark:text-blue-400 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Active Projects</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">8</h3>
                        </div>
                        <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full">
                            <i class="fas fa-project-diagram text-green-600 dark:text-green-400 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Team Performance</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">92%</h3>
                        </div>
                        <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-full">
                            <i class="fas fa-chart-line text-purple-600 dark:text-purple-400 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Pending Tasks</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">5</h3>
                        </div>
                        <div class="bg-yellow-100 dark:bg-yellow-900 p-3 rounded-full">
                            <i class="fas fa-tasks text-yellow-600 dark:text-yellow-400 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team Overview and Tasks -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Team Overview -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Team Overview</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded">
                                    <i class="fas fa-user-circle text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div>
                                    <p class="text-gray-800 dark:text-white">Development Team</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">5 members</p>
                                </div>
                            </div>
                            <div class="bg-green-100 dark:bg-green-900 px-3 py-1 rounded-full">
                                <span class="text-green-600 dark:text-green-400 text-sm">Active</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-purple-100 dark:bg-purple-900 p-2 rounded">
                                    <i class="fas fa-user-circle text-purple-600 dark:text-purple-400"></i>
                                </div>
                                <div>
                                    <p class="text-gray-800 dark:text-white">Design Team</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">3 members</p>
                                </div>
                            </div>
                            <div class="bg-green-100 dark:bg-green-900 px-3 py-1 rounded-full">
                                <span class="text-green-600 dark:text-green-400 text-sm">Active</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Tasks -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Recent Tasks</h2>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4">
                            <div class="bg-yellow-100 dark:bg-yellow-900 p-2 rounded-full">
                                <i class="fas fa-tasks text-yellow-600 dark:text-yellow-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-800 dark:text-white">Review Course Content</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Due in 2 days</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-full">
                                <i class="fas fa-users text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-800 dark:text-white">Team Performance Review</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Due next week</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 