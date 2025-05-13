<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Detail - SkillUp</title>
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
                    <a href="{{ route('employee.available-courses') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 rounded-lg">
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
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-800">Web Development Fundamentals</h1>
                            <p class="text-gray-600">Learn the basics of HTML, CSS, and JavaScript</p>
                        </div>
                        <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Join Course
                        </button>
                    </div>
                </div>
            </header>

            <!-- Course Content -->
            <main class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
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

                    <!-- Course Info Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Course Information</h2>
                            
                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-600">Instructor</h3>
                                    <p class="text-gray-800">John Doe</p>
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-600">Duration</h3>
                                    <p class="text-gray-800">4 weeks</p>
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-600">Level</h3>
                                    <p class="text-gray-800">Beginner</p>
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-600">Prerequisites</h3>
                                    <p class="text-gray-800">None</p>
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-600">Enrolled Students</h3>
                                    <p class="text-gray-800">24</p>
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-600">Rating</h3>
                                    <div class="flex items-center">
                                        <i class="bi bi-star-fill text-yellow-400 mr-1"></i>
                                        <span class="text-gray-800">4.8 (120 reviews)</span>
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