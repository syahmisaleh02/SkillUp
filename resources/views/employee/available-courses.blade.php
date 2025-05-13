<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Courses - SkillUp</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-center h-16 bg-green-600">
                    <span class="text-white text-xl font-bold">SkillUp</span>
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 px-4 py-4 space-y-2">
                    <a href="{{ route('employee.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 rounded-lg">
                        <i class="bi bi-house-door mr-3"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('employee.attendance') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 rounded-lg">
                        <i class="bi bi-calendar-check mr-3"></i>
                        Attendance
                    </a>
                    <a href="{{ route('employee.courses') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 rounded-lg">
                        <i class="bi bi-book mr-3"></i>
                        My Courses
                    </a>
                    <a href="{{ route('employee.available-courses') }}" class="flex items-center px-4 py-2 text-white bg-green-600 rounded-lg">
                        <i class="bi bi-plus-circle mr-3"></i>
                        Available Courses
                    </a>
                </nav>

                <!-- Profile Section at Bottom -->
                <div class="p-4 border-t border-gray-200">
                    <a href="{{ route('profile') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 rounded-lg">
                        <i class="bi bi-person mr-3"></i>
                        Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="ml-64">
            <!-- Header -->
            <header class="bg-white shadow">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-semibold text-gray-800">Available Courses</h1>
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
                <!-- Course Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Course Card 1 -->
                    <a href="{{ route('employee.course-detail', ['id' => 1]) }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <span class="px-3 py-1 text-xs font-semibold text-green-600 bg-green-100 rounded-full">Available</span>
                                <span class="text-sm text-gray-500">Duration: 4 weeks</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Web Development Fundamentals</h3>
                            <p class="text-gray-600 mb-4">Learn the basics of HTML, CSS, and JavaScript to build modern web applications.</p>
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <i class="bi bi-people text-gray-500 mr-2"></i>
                                    <span class="text-sm text-gray-600">24 enrolled</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="bi bi-star-fill text-yellow-400 mr-1"></i>
                                    <span class="text-sm text-gray-600">4.8</span>
                                </div>
                            </div>
                            <button class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                View Course
                            </button>
                        </div>
                    </a>

                    <!-- Course Card 2 -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <span class="px-3 py-1 text-xs font-semibold text-green-600 bg-green-100 rounded-full">Available</span>
                                <span class="text-sm text-gray-500">Duration: 6 weeks</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Data Analysis with Python</h3>
                            <p class="text-gray-600 mb-4">Master data analysis techniques using Python, Pandas, and NumPy.</p>
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <i class="bi bi-people text-gray-500 mr-2"></i>
                                    <span class="text-sm text-gray-600">18 enrolled</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="bi bi-star-fill text-yellow-400 mr-1"></i>
                                    <span class="text-sm text-gray-600">4.6</span>
                                </div>
                            </div>
                            <button class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                Join Course
                            </button>
                        </div>
                    </div>

                    <!-- Course Card 3 -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <span class="px-3 py-1 text-xs font-semibold text-green-600 bg-green-100 rounded-full">Available</span>
                                <span class="text-sm text-gray-500">Duration: 8 weeks</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Project Management Essentials</h3>
                            <p class="text-gray-600 mb-4">Learn project management methodologies and tools for successful project delivery.</p>
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <i class="bi bi-people text-gray-500 mr-2"></i>
                                    <span class="text-sm text-gray-600">32 enrolled</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="bi bi-star-fill text-yellow-400 mr-1"></i>
                                    <span class="text-sm text-gray-600">4.9</span>
                                </div>
                            </div>
                            <button class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                Join Course
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html> 