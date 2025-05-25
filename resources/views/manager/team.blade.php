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
                            <span>Team Performance</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('manager.course') }}" class="block py-2 px-4 hover:bg-green-600 flex items-center">
                            <i class="fas fa-book w-6"></i>
                            <span>Course Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('manager.course.data') }}" class="block py-2 px-4 hover:bg-green-600 flex items-center">
                            <i class="fas fa-chart-line w-6"></i>
                            <span>Course Data</span>
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
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Team Performance</h1>
            </div>

            <!-- Team Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Employees</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalEmployees }}</p>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 dark:text-blue-400"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Active Courses</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalActiveCourses }}</p>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                            <i class="fas fa-book text-green-600 dark:text-green-400"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Average Completion</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ round($averageCompletion) }}%</p>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center">
                            <i class="fas fa-chart-line text-yellow-600 dark:text-yellow-400"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Completed Courses</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalCompletedCourses }}</p>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center">
                            <i class="fas fa-check-circle text-purple-600 dark:text-purple-400"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Search employees..." class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white pl-10">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <select id="departmentFilter" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                            <option value="">All Departments</option>
                            <option value="development">Development</option>
                            <option value="design">Design</option>
                            <option value="marketing">Marketing</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Team Members Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="employeeGrid">
                @forelse($processedEmployees as $employee)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden employee-card" 
                     data-name="{{ strtolower($employee['name']) }}"
                     data-department="{{ strtolower($employee['department']) }}">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-600"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $employee['name'] }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $employee['department'] }}</p>
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
                                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $employee['active_courses_count'] }} Active Courses</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-xs text-gray-500 dark:text-gray-400 mr-2">Progress: {{ $employee['progress'] }}%</span>
                                        <div class="w-16 bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $employee['progress'] }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-between">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('manager.employee.progress', ['id' => $employee['id']]) }}" class="text-blue-500 hover:text-blue-700 flex items-center">
                                    <i class="fas fa-chart-line mr-1"></i>View Progress
                                </a>
                            </td>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-8 text-gray-500 dark:text-gray-400">
                    No employees found.
                </div>
                @endforelse
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const searchInput = document.getElementById('searchInput');
                    const departmentFilter = document.getElementById('departmentFilter');
                    const employeeCards = document.querySelectorAll('.employee-card');

                    function filterEmployees() {
                        const searchTerm = searchInput.value.toLowerCase();
                        const departmentValue = departmentFilter.value.toLowerCase();

                        employeeCards.forEach(card => {
                            const name = card.dataset.name;
                            const department = card.dataset.department;
                            
                            const matchesSearch = name.includes(searchTerm);
                            const matchesDepartment = !departmentValue || department === departmentValue;

                            if (matchesSearch && matchesDepartment) {
                                card.style.display = '';
                            } else {
                                card.style.display = 'none';
                            }
                        });

                        // Check if any cards are visible
                        const visibleCards = document.querySelectorAll('.employee-card[style=""]');
                        const noResultsMessage = document.querySelector('.no-results-message');
                        
                        if (visibleCards.length === 0) {
                            if (!noResultsMessage) {
                                const message = document.createElement('div');
                                message.className = 'col-span-3 text-center py-8 text-gray-500 dark:text-gray-400 no-results-message';
                                message.textContent = 'No employees found matching the criteria.';
                                document.getElementById('employeeGrid').appendChild(message);
                            }
                        } else {
                            const existingMessage = document.querySelector('.no-results-message');
                            if (existingMessage) {
                                existingMessage.remove();
                            }
                        }
                    }

                    searchInput.addEventListener('input', filterEmployees);
                    departmentFilter.addEventListener('change', filterEmployees);
                });
            </script>
        </main>
    </div>
</body>
</html> 