<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard | SkillUp</title>
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
                        <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 bg-green-600 flex items-center">
                            <i class="fas fa-home w-6"></i>
                            <span>Homepage</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users') }}" class="block py-2 px-4 hover:bg-green-600 flex items-center">
                            <i class="fas fa-users w-6"></i>
                            <span>User Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-4 hover:bg-green-600 flex items-center">
                            <i class="fas fa-book w-6"></i>
                            <span>Course Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-4 hover:bg-green-600 flex items-center">
                            <i class="fas fa-chart-bar w-6"></i>
                            <span>Analytics</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-4 hover:bg-green-600 flex items-center">
                            <i class="fas fa-cog w-6"></i>
                            <span>Settings</span>
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
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Admin Dashboard</h1>
                <div class="flex items-center space-x-4">
                   
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
                            <p class="text-gray-500 dark:text-gray-400">Total Users</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">1,234</h3>
                            <p class="text-sm text-green-500">+12% from last month</p>
                        </div>
                        <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full">
                            <i class="fas fa-users text-blue-600 dark:text-blue-400 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Active Courses</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">45</h3>
                            <p class="text-sm text-green-500">+5 new this month</p>
                        </div>
                        <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full">
                            <i class="fas fa-book text-green-600 dark:text-green-400 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Completion Rate</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">85%</h3>
                            <p class="text-sm text-green-500">+2% from last month</p>
                        </div>
                        <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-full">
                            <i class="fas fa-chart-line text-purple-600 dark:text-purple-400 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Total Revenue</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">$12.5k</h3>
                            <p class="text-sm text-green-500">+8% from last month</p>
                        </div>
                        <div class="bg-yellow-100 dark:bg-yellow-900 p-3 rounded-full">
                            <i class="fas fa-dollar-sign text-yellow-600 dark:text-yellow-400 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Recent Activity</h2>
                <div class="space-y-4">
                    <div class="flex items-start space-x-4">
                        <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-full">
                            <i class="fas fa-user-plus text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-800 dark:text-white">New user registration</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Jane Smith joined the platform</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">2 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="bg-green-100 dark:bg-green-900 p-2 rounded-full">
                            <i class="fas fa-book text-green-600 dark:text-green-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-800 dark:text-white">New course added</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Advanced Web Development Course</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">5 hours ago</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Popular Courses -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Popular Courses</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <th class="px-6 py-3">Course Name</th>
                                <th class="px-6 py-3">Enrolled</th>
                                <th class="px-6 py-3">Rating</th>
                                <th class="px-6 py-3">Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded mr-3">
                                            <i class="fas fa-code text-blue-600 dark:text-blue-400"></i>
                                        </div>
                                        <span class="text-gray-800 dark:text-white">Web Development</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">256</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center text-yellow-500">
                                        <i class="fas fa-star"></i>
                                        <span class="ml-1">4.8</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">$4,256</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="bg-purple-100 dark:bg-purple-900 p-2 rounded mr-3">
                                            <i class="fas fa-mobile-alt text-purple-600 dark:text-purple-400"></i>
                                        </div>
                                        <span class="text-gray-800 dark:text-white">Mobile Development</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">198</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center text-yellow-500">
                                        <i class="fas fa-star"></i>
                                        <span class="ml-1">4.6</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">$3,854</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 