<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Course Detail | SkillUp</title>
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
                        <a href="{{ route('employee.courses') }}" class="block py-2 px-4 bg-green-600 flex items-center">
                            <i class="fas fa-book w-6"></i>
                            <span>My Courses</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('employee.attendance') }}" class="block py-2 px-4 hover:bg-green-600 flex items-center">
                            <i class="fas fa-calendar-check w-6"></i>
                            <span>Attendance</span>
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

            <!-- Course Header -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="mb-6">
                            <a href="{{ route('employee.courses') }}" class="text-green-600 hover:text-green-700 flex items-center">
                                <i class="fas fa-arrow-left mr-2"></i> Back to Courses
                            </a>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">{{ $course->title }}</h1>
                        <p class="text-gray-600 dark:text-gray-300">{{ $course->description }}</p>
                        
                        @php
                            $employeeId = (string)Auth::user()->_id;
                            $completedMaterials = (array) ($course->completed_materials[$employeeId] ?? []);
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
                    <div class="flex items-center space-x-4">
                        @php
                            $assignedEmployees = (array) ($course->assigned_employees ?? []);
                            $isAssigned = in_array((string)Auth::user()->_id, array_map('strval', $assignedEmployees));
                        @endphp
                        @if(!$isAssigned)
                            <form action="{{ route('employee.course.join', $course->_id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">Join Course</button>
                            </form>
                        @else
                            <form action="{{ route('employee.course.unenroll', $course->_id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">Unenroll Course</button>
                            </form>
                        @endif
                        <span class="px-3 py-1 text-sm font-semibold {{ $course->status === 'active' ? 'text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-200' : 'text-yellow-800 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-200' }} rounded-full">
                            {{ ucfirst($course->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Course Materials -->
                <div class="lg:col-span-3">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Course Materials</h2>
                        
                        @if($course->materials && count($course->materials) > 0)
                            @foreach($course->materials as $index => $material)
                            <div class="mb-6">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-lg font-bold text-gray-800 dark:text-white">{{ isset($material['created_at']) ? \Carbon\Carbon::parse($material['created_at'])->format('M d, Y') : 'N/A' }}</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ isset($material['size']) ? number_format($material['size'] / 1024, 2) . ' KB' : 'N/A' }}</span>
                                </div>
                                <h3 class="text-md text-gray-600 dark:text-gray-300 mb-2">{{ $material['description'] ?? 'No description available' }}</h3>
                                <div class="space-y-2">
                                    @if(isset($material['path']))
                                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                            <a href="{{ Storage::url($material['path']) }}"
                                               class="flex items-center hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors flex-1"
                                               target="_blank">
                                                <i class="fas {{ isset($material['type']) && str_contains($material['type'], 'video') ? 'fa-play-circle' : 'fa-file-alt' }} text-green-600 dark:text-green-400 mr-3"></i>
                                                <span class="text-gray-700 dark:text-gray-300">{{ $material['name'] ?? 'Untitled Material' }}</span>
                                                <i class="fas fa-external-link-alt ml-2 text-gray-400"></i>
                                            </a>
                                            @if($isAssigned)
                                                <button 
                                                    onclick="markMaterialCompleted('{{ $course->_id }}', {{ $index }})"
                                                    class="ml-4 px-4 py-2 rounded-lg {{ in_array($index, $completedMaterials) ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200' }} hover:bg-green-200 dark:hover:bg-green-800 transition-colors"
                                                    id="material-{{ $index }}-button">
                                                    {{ in_array($index, $completedMaterials) ? 'Completed' : 'Done' }}
                                                </button>
                                            @endif
                                        </div>
                                    @else
                                        <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                            <i class="fas fa-exclamation-circle text-yellow-500 mr-3"></i>
                                            <span class="text-gray-700 dark:text-gray-300">Material not available</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">No course materials available yet.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Course Info Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Course Information</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400">Instructor</h3>
                                <p class="text-gray-800 dark:text-white">{{ $course->created_by }}</p>
                            </div>
                            
                            <div>
                                <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400">Enrolled Students</h3>
                                <p class="text-gray-800 dark:text-white">{{ $course->enrolled_count }}</p>
                            </div>

                            <div>
                                <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400">Rating</h3>
                                <div class="flex items-center">
                                    <i class="fas fa-star text-yellow-500 mr-1"></i>
                                    <span class="text-gray-800 dark:text-white">{{ $course->rating ? number_format($course->rating, 1) : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    function markMaterialCompleted(courseId, materialIndex) {
        const button = document.getElementById(`material-${materialIndex}-button`);
        const isCompleted = button.textContent.trim() === 'Completed';
        
        // Disable button and show loading state
        button.disabled = true;
        button.textContent = 'Processing...';
        
        const url = `/employee/course/${courseId}/material/${materialIndex}/complete`;
        console.log('Sending request to mark material as completed:', {
            courseId,
            materialIndex,
            url,
            csrfToken: document.querySelector('meta[name="csrf-token"]').content
        });

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(async response => {
            console.log('Response status:', response.status);
            const responseData = await response.text();
            console.log('Raw response:', responseData);
            
            if (!response.ok) {
                throw new Error(`Server responded with ${response.status}: ${responseData}`);
            }
            
            try {
                return JSON.parse(responseData);
            } catch (e) {
                throw new Error('Invalid JSON response from server');
            }
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                // Toggle button state
                if (isCompleted) {
                    button.textContent = 'Done';
                    button.classList.remove('bg-green-100', 'text-green-800', 'dark:bg-green-900', 'dark:text-green-200');
                    button.classList.add('bg-gray-100', 'text-gray-800', 'dark:bg-gray-900', 'dark:text-gray-200');
                } else {
                    button.textContent = 'Completed';
                    button.classList.remove('bg-gray-100', 'text-gray-800', 'dark:bg-gray-900', 'dark:text-gray-200');
                    button.classList.add('bg-green-100', 'text-green-800', 'dark:bg-green-900', 'dark:text-green-200');
                }
                
                // Update progress bar
                const progressBar = document.querySelector('.bg-green-600.h-2\\.5');
                const progressText = document.querySelector('.text-gray-700.dark\\:text-gray-300');
                if (progressBar && progressText) {
                    progressBar.style.width = `${data.progress}%`;
                    progressText.textContent = `${data.progress}% Complete`;
                } else {
                    console.error('Progress bar elements not found');
                }
            } else {
                throw new Error(data.message || 'Failed to mark material as completed');
            }
        })
        .catch(error => {
            console.error('Error details:', error);
            button.textContent = isCompleted ? 'Completed' : 'Done';
            button.disabled = false;
            alert(`Failed to mark material as completed: ${error.message}`);
        })
        .finally(() => {
            button.disabled = false;
        });
    }
    </script>
</body>
</html> 