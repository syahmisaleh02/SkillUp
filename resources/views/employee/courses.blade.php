<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses - SkillUp</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>
<body class="bg-gray-100">
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
                            <i class="bi bi-calendar-check mr-3"></i>
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
                    <img src="{{ asset('assets/profile.png') }}" alt="Profile" class="h-10 w-10 rounded-full">
                    <div>
                        <p class="text-sm font-medium">John Doe</p>
                        <p class="text-xs text-green-200">Employee</p>
                    </div>
                </a>
            </div>
        </aside>  

        <!-- Main Content -->
        <div class="ml-64">
            <!-- Header -->
            <header class="bg-white shadow">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-semibold text-gray-800">My Courses</h1>
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <input type="text" placeholder="Search courses..." class="w-64 px-4 py-2 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                <i class="bi bi-search absolute right-3 top-2.5 text-gray-400"></i>
                            </div>
                            <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                Filter
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Course Content -->
            <main class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <!-- Course List -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Enrolled Courses</h2>
                            <div class="space-y-4">
                                <!-- Course Item 1 -->
                                <a href="#" class="block p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-300">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="font-semibold text-gray-800">Web Development Fundamentals</h3>
                                        <span class="text-sm text-green-600">In Progress</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-600 h-2 rounded-full" style="width: 60%"></div>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-2">60% Complete</p>
                                </a>

                                <!-- Course Item 2 -->
                                <a href="#" class="block p-4 bg-white rounded-lg hover:bg-green-50 transition-colors duration-300">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="font-semibold text-gray-800">Data Analysis with Python</h3>
                                        <span class="text-sm text-gray-500">Not Started</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-600 h-2 rounded-full" style="width: 0%"></div>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-2">0% Complete</p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Course Materials -->
                    <div class="lg:col-span-3">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Course Materials</h2>
                            
                            <!-- Module 1 -->
                            <div class="mb-6">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-lg font-semibold text-gray-800">Module 1: Introduction to Web Development</h3>
                                    <span class="text-sm text-gray-500">2 hours</span>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <i class="bi bi-play-circle text-green-600 mr-3"></i>
                                        <span class="text-gray-700">Introduction to HTML</span>
                                        <span class="ml-auto text-sm text-gray-500">30 min</span>
                                    </div>
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <i class="bi bi-play-circle text-green-600 mr-3"></i>
                                        <span class="text-gray-700">Basic CSS Styling</span>
                                        <span class="ml-auto text-sm text-gray-500">45 min</span>
                                    </div>
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <i class="bi bi-file-earmark-text text-green-600 mr-3"></i>
                                        <span class="text-gray-700">HTML & CSS Quiz</span>
                                        <span class="ml-auto text-sm text-gray-500">15 min</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Module 2 -->
                            <div class="mb-6">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-lg font-semibold text-gray-800">Module 2: JavaScript Basics</h3>
                                    <span class="text-sm text-gray-500">3 hours</span>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <i class="bi bi-play-circle text-green-600 mr-3"></i>
                                        <span class="text-gray-700">JavaScript Fundamentals</span>
                                        <span class="ml-auto text-sm text-gray-500">1 hour</span>
                                    </div>
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <i class="bi bi-play-circle text-green-600 mr-3"></i>
                                        <span class="text-gray-700">DOM Manipulation</span>
                                        <span class="ml-auto text-sm text-gray-500">1 hour</span>
                                    </div>
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <i class="bi bi-file-earmark-text text-green-600 mr-3"></i>
                                        <span class="text-gray-700">JavaScript Quiz</span>
                                        <span class="ml-auto text-sm text-gray-500">30 min</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html> 