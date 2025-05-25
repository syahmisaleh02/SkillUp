<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Dashboard | SkillUp</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
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
                        <a href="{{ route('employee.dashboard') }}" class="block py-2 px-4 bg-green-600 flex items-center">
                            <i class="fas fa-home w-6"></i>
                            <span>Homepage</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('employee.attendance') }}" class="block py-2 px-4 hover:bg-green-600 flex items-center">
                            <i class="fas fa-calendar-check w-6"></i>
                            <span>Attendance</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('employee.courses') }}" class="block py-2 px-4 hover:bg-green-600 flex items-center">
                            <i class="fas fa-book w-6"></i>
                            <span>Courses</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-4 hover:bg-green-600 flex items-center">
                            <i class="fas fa-lightbulb w-6"></i>
                            <span>Course Recommendations</span>
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
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Welcome, {{ Auth::user()->name }}!</h1>
                <div class="flex items-center space-x-4">
                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        <i class="fas fa-play mr-2"></i>Start Learning
                    </button>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('employee.courses') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center">
                            <i class="fas fa-book mr-2"></i> My Courses
                        </a>
                        <a href="{{ route('logout') }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                    </div>
                </div>
            </div>

            <!-- Progress Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Courses in Progress</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">3</h3>
                        </div>
                        <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full">
                            <i class="fas fa-book-open text-blue-600 dark:text-blue-400 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Completed Courses</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">12</h3>
                        </div>
                        <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full">
                            <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Certificates Earned</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">8</h3>
                        </div>
                        <div class="bg-yellow-100 dark:bg-yellow-900 p-3 rounded-full">
                            <i class="fas fa-certificate text-yellow-600 dark:text-yellow-400 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Courses -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Current Courses</h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex items-center space-x-4">
                            <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded">
                                <i class="fas fa-code text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-800 dark:text-white">Web Development Fundamentals</h3>
                                <div class="flex items-center mt-1">
                                    <div class="w-48 h-2 bg-gray-200 rounded-full mr-2">
                                        <div class="w-2/3 h-full bg-green-500 rounded-full"></div>
                                    </div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">65%</span>
                                </div>
                            </div>
                        </div>
                        <button class="text-green-600 hover:text-green-700">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex items-center space-x-4">
                            <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded">
                                <i class="fas fa-database text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-800 dark:text-white">Database Management</h3>
                                <div class="flex items-center mt-1">
                                    <div class="w-48 h-2 bg-gray-200 rounded-full mr-2">
                                        <div class="w-1/3 h-full bg-green-500 rounded-full"></div>
                                    </div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">35%</span>
                                </div>
                            </div>
                        </div>
                        <button class="text-green-600 hover:text-green-700">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Recommended Courses -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Recommended for You</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="bg-red-100 dark:bg-red-900 p-3 rounded">
                                    <i class="fas fa-mobile-alt text-red-600 dark:text-red-400"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-800 dark:text-white">Mobile App Development</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Learn to build mobile apps</p>
                                </div>
                            </div>
                            <button class="text-green-600 hover:text-green-700">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="bg-indigo-100 dark:bg-indigo-900 p-3 rounded">
                                    <i class="fas fa-cloud text-indigo-600 dark:text-indigo-400"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-800 dark:text-white">Cloud Computing</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Master cloud technologies</p>
                                </div>
                            </div>
                            <button class="text-green-600 hover:text-green-700">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 