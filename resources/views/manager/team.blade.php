<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Team Management | SkillUp</title>
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
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Team Management</h1>
                <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-user-plus mr-2"></i>Add New Employee
                </button>
            </div>

            <!-- Search and Filter -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" placeholder="Search employees..." class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white pl-10">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <select class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                            <option value="">All Departments</option>
                            <option value="development">Development</option>
                            <option value="design">Design</option>
                            <option value="marketing">Marketing</option>
                        </select>
                        <select class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="on-leave">On Leave</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Team Members Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Team Member Card 1 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-600"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">John Doe</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Software Developer</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-sm font-semibold text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-200 rounded-full">
                                Active
                            </span>
                        </div>
                        
                        <!-- Assigned Courses -->
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Assigned Courses</h4>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700 rounded">
                                    <div class="flex items-center">
                                        <i class="fas fa-book text-blue-500 mr-2"></i>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Web Development Fundamentals</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-xs text-gray-500 dark:text-gray-400 mr-2">Progress: 75%</span>
                                        <div class="w-16 bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full" style="width: 75%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-between">
                            <a href="{{ route('manager.team.assign-course', ['id' => 1]) }}" class="text-blue-500 hover:text-blue-700 flex items-center">
                                <i class="fas fa-plus-circle mr-1"></i>
                                <span>Assign Course</span>
                            </a>
                            <a href="{{ route('manager.team.progress', ['id' => 1]) }}" class="text-green-500 hover:text-green-700 flex items-center">
                                <i class="fas fa-chart-line mr-1"></i>
                                <span>View Progress</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Team Member Card 2 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-600"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Jane Smith</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">UI/UX Designer</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-sm font-semibold text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-200 rounded-full">
                                Active
                            </span>
                        </div>
                        
                        <!-- Assigned Courses -->
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Assigned Courses</h4>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700 rounded">
                                    <div class="flex items-center">
                                        <i class="fas fa-book text-blue-500 mr-2"></i>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Advanced UI/UX Design</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-xs text-gray-500 dark:text-gray-400 mr-2">Progress: 45%</span>
                                        <div class="w-16 bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full" style="width: 45%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-between">
                            <a href="{{ route('manager.team.assign-course', ['id' => 2]) }}" class="text-blue-500 hover:text-blue-700 flex items-center">
                                <i class="fas fa-plus-circle mr-1"></i>
                                <span>Assign Course</span>
                            </a>
                            <a href="{{ route('manager.team.progress', ['id' => 2]) }}" class="text-green-500 hover:text-green-700 flex items-center">
                                <i class="fas fa-chart-line mr-1"></i>
                                <span>View Progress</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Team Member Card 3 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-600"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Mike Johnson</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Project Manager</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-sm font-semibold text-yellow-800 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-200 rounded-full">
                                On Leave
                            </span>
                        </div>
                        
                        <!-- Assigned Courses -->
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Assigned Courses</h4>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700 rounded">
                                    <div class="flex items-center">
                                        <i class="fas fa-book text-blue-500 mr-2"></i>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Project Management Essentials</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-xs text-gray-500 dark:text-gray-400 mr-2">Progress: 90%</span>
                                        <div class="w-16 bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full" style="width: 90%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-between">
                            <a href="{{ route('manager.team.assign-course', ['id' => 3]) }}" class="text-blue-500 hover:text-blue-700 flex items-center">
                                <i class="fas fa-plus-circle mr-1"></i>
                                <span>Assign Course</span>
                            </a>
                            <a href="{{ route('manager.team.progress', ['id' => 3]) }}" class="text-green-500 hover:text-green-700 flex items-center">
                                <i class="fas fa-chart-line mr-1"></i>
                                <span>View Progress</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 