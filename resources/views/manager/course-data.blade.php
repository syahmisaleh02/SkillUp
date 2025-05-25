<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Course Data | SkillUp</title>
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
                        <a href="{{ route('manager.course.data') }}" class="block py-2 px-4 bg-green-600 flex items-center">
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
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Course Data</h1>
            </div>

            <!-- Search Bar -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Search courses..." class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white pl-10">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <!-- Course Data Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="courseGrid">
                @forelse($courses as $course)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden course-card" data-title="{{ strtolower($course->title) }}">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 text-sm font-semibold {{ $course->status === 'active' ? 'text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-200' : 'text-yellow-800 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-200' }} rounded-full">
                                {{ ucfirst($course->status) }}
                            </span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">{{ $course->title }}</h3>
                        
                        <!-- Course Statistics -->
                        <div class="space-y-3 mb-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Total Enrolled</span>
                                <span class="text-sm font-medium text-gray-800 dark:text-white">{{ $course->enrolled_count }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Completed</span>
                                <span class="text-sm font-medium text-gray-800 dark:text-white">{{ $course->completed_count }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">In Progress</span>
                                <span class="text-sm font-medium text-gray-800 dark:text-white">{{ $course->in_progress_count }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Average Progress</span>
                                <span class="text-sm font-medium text-gray-800 dark:text-white">{{ $course->average_progress }}%</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-2">
                            <a href="{{ route('manager.course.data.details', ['id' => $course->_id]) }}" class="block w-full bg-green-600 text-white text-center px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                <i class="fas fa-chart-bar mr-2"></i>View Detailed Data
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-8">
                    <p class="text-gray-500 dark:text-gray-400">No courses found.</p>
                </div>
                @endforelse
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const searchInput = document.getElementById('searchInput');
                    const courseCards = document.querySelectorAll('.course-card');

                    function filterCourses() {
                        const searchTerm = searchInput.value.toLowerCase();
                        let hasVisibleCards = false;

                        courseCards.forEach(card => {
                            const title = card.dataset.title;
                            const matchesSearch = title.includes(searchTerm);

                            if (matchesSearch) {
                                card.style.display = '';
                                hasVisibleCards = true;
                            } else {
                                card.style.display = 'none';
                            }
                        });

                        // Show/hide no results message
                        const noResultsMessage = document.querySelector('.no-results-message');
                        if (!hasVisibleCards) {
                            if (!noResultsMessage) {
                                const message = document.createElement('div');
                                message.className = 'col-span-3 text-center py-8 text-gray-500 dark:text-gray-400 no-results-message';
                                message.textContent = 'No courses found matching your search.';
                                document.getElementById('courseGrid').appendChild(message);
                            }
                        } else {
                            const existingMessage = document.querySelector('.no-results-message');
                            if (existingMessage) {
                                existingMessage.remove();
                            }
                        }
                    }

                    searchInput.addEventListener('input', filterCourses);
                });
            </script>
        </main>
    </div>
</body>
</html> 