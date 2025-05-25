<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Courses | SkillUp</title>
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
                        <a href="{{ route('employee.dashboard') }}" class="block py-2 px-4 hover:bg-green-600 flex items-center">
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
                        <a href="{{ route('employee.courses') }}" class="block py-2 px-4 bg-green-600 flex items-center">
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
                        <p class="text-xs text-green-200">{{ ucfirst(Auth::user()->role) }}</p>
                    </div>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-6">
            <!-- Success Message -->
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif

            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">My Courses</h1>
            </div>

            <!-- Assigned Courses Section -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">My Assigned Courses</h2>
                @if($assignedCourses->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($assignedCourses as $course)
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <span class="px-3 py-1 text-sm font-semibold {{ $course->status === 'active' ? 'text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-200' : 'text-yellow-800 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-200' }} rounded-full">
                                            {{ ucfirst($course->status) }}
                                        </span>
                                    </div>
                                    <a href="{{ route('employee.course.view', $course->_id) }}" class="block">
                                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2 hover:text-green-600 transition">{{ $course->title }}</h3>
                                        <p class="text-gray-600 dark:text-gray-300 mb-4">{{ Str::limit($course->description, 100) }}</p>
                                    </a>
                                    
                                    @php
                                        $employeeId = (string)Auth::user()->_id;
                                        $completedMaterials = $course->completed_materials[$employeeId] ?? [];
                                        $totalMaterials = count($course->materials ?? []);
                                        $progress = $totalMaterials > 0 ? round((count($completedMaterials) / $totalMaterials) * 100) : 0;
                                    @endphp
                                    
                                    <div class="mt-4">
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                                <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
                                            </div>
                                            <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $progress }}% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 text-center">
                        <p class="text-gray-500 dark:text-gray-400">You haven't been assigned to any courses yet.</p>
                    </div>
                @endif
            </div>

            <!-- Available Courses Section -->
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Available Courses</h2>
                @if($unassignedCourses->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($unassignedCourses as $course)
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <span class="px-3 py-1 text-sm font-semibold {{ $course->status === 'active' ? 'text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-200' : 'text-yellow-800 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-200' }} rounded-full">
                                            {{ ucfirst($course->status) }}
                                        </span>
                                    </div>
                                    <a href="{{ route('employee.course.view', $course->_id) }}" class="block">
                                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2 hover:text-green-600 transition">{{ $course->title }}</h3>
                                        <p class="text-gray-600 dark:text-gray-300 mb-4">{{ Str::limit($course->description, 100) }}</p>
                                    </a>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <i class="fas fa-users text-gray-500 dark:text-gray-400 mr-2"></i>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $course->enrolled_count }} Enrolled</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-star text-yellow-500 mr-1"></i>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $course->rating ? number_format($course->rating, 1) : '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 text-center">
                        <p class="text-gray-500 dark:text-gray-400">No additional courses are available at the moment.</p>
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html> 