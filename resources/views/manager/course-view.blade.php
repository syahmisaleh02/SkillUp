<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $course->title }} | SkillUp</title>
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
                            <span>Team Performance</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('manager.course') }}" class="block py-2 px-4 bg-green-600 flex items-center">
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

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('manager.course') }}" class="text-green-600 hover:text-green-700 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Courses
                </a>
            </div>

            <!-- Course Header -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">{{ $course->title }}</h1>
                        <div class="flex items-center space-x-4 mb-4">
                            <span class="px-3 py-1 text-sm font-semibold {{ $course->status === 'active' ? 'text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-200' : 'text-yellow-800 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-200' }} rounded-full">
                                {{ ucfirst($course->status) }}
                            </span>
                            <span class="text-gray-500 dark:text-gray-400">
                                <i class="fas fa-users mr-1"></i> {{ $course->enrolled_count }} Enrolled
                            </span>
                            <span class="text-gray-500 dark:text-gray-400">
                                <i class="fas fa-star text-yellow-500 mr-1"></i> {{ $course->rating ? number_format($course->rating, 1) : '-' }}
                            </span>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('manager.course.edit', ['id' => $course->_id]) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-edit mr-2"></i>Edit Course
                        </a>
                        <form action="{{ route('manager.course.destroy', ['id' => $course->_id]) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition" onclick="return confirm('Are you sure you want to delete this course?')">
                                <i class="fas fa-trash mr-2"></i>Delete Course
                            </button>
                        </form>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mt-4 mb-6">{{ $course->description }}</p>

                <!-- Course Information -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Category</h3>
                        <p class="mt-1 text-gray-900 dark:text-white">{{ ucfirst($course->category) }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Created By</h3>
                        <p class="mt-1 text-gray-900 dark:text-white">{{ $course->created_by }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</h3>
                        <p class="mt-1 text-gray-900 dark:text-white">{{ $course->updated_at ? $course->updated_at->format('M d, Y') : 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Course Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Materials Section -->
                <div class="lg:col-span-3">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Course Materials</h2>
                            <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition" onclick="document.getElementById('uploadMaterial').click()">
                                <i class="fas fa-upload mr-2"></i>Upload Material
                            </button>
                            <input type="file" id="uploadMaterial" class="hidden" multiple>
                        </div>

                        <!-- Upload Modal -->
                        <div id="uploadModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
                            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
                                <div class="mt-3">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Upload Material</h3>
                                    <form id="materialUploadForm" class="space-y-4" enctype="multipart/form-data">
                                        @csrf
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">File</label>
                                            <input type="file" name="file" required class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                                                file:mr-4 file:py-2 file:px-4
                                                file:rounded-full file:border-0
                                                file:text-sm file:font-semibold
                                                file:bg-green-50 file:text-green-700
                                                hover:file:bg-green-100
                                                dark:file:bg-green-900 dark:file:text-green-300">
                                        </div>
                                        <div>
                                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                            <textarea id="description" name="description" rows="3" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                placeholder="Enter a description for this material"></textarea>
                                        </div>
                                        <div class="flex justify-end space-x-3">
                                            <button type="button" onclick="closeUploadModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                                Cancel
                                            </button>
                                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                                Upload
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Materials Grid -->
                        <div class="space-y-6">
                            @php
                                $groupedMaterials = collect($course->materials ?? [])->groupBy(function($material) {
                                    return isset($material['created_at']) 
                                        ? \Carbon\Carbon::parse($material['created_at'])->format('F d, Y')
                                        : 'No Date';
                                });
                            @endphp

                            @forelse($groupedMaterials as $date => $materials)
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3">{{ $date }}</h3>
                                    <div class="grid grid-cols-1 gap-4">
                                        @foreach($materials as $index => $material)
                                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 flex items-start space-x-4 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                            <a href="{{ Storage::url($material['path']) }}" target="_blank" class="flex-1 flex items-start space-x-4">
                                                <div class="flex-shrink-0">
                                                    @php
                                                        $extension = pathinfo($material['name'], PATHINFO_EXTENSION);
                                                        $icon = match(strtolower($extension)) {
                                                            'pdf' => 'fa-file-pdf',
                                                            'doc', 'docx' => 'fa-file-word',
                                                            'xls', 'xlsx' => 'fa-file-excel',
                                                            'ppt', 'pptx' => 'fa-file-powerpoint',
                                                            'jpg', 'jpeg', 'png', 'gif' => 'fa-file-image',
                                                            default => 'fa-file'
                                                        };
                                                    @endphp
                                                    <i class="fas {{ $icon }} text-2xl text-gray-500 dark:text-gray-400"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                                        {{ $material['name'] }}
                                                    </p>
                                                    @if(isset($material['description']))
                                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                        {{ $material['description'] }}
                                                    </p>
                                                    @endif
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ number_format($material['size'] / 1024, 2) }} KB
                                                    </p>
                                                </div>
                                            </a>
                                            <button onclick="deleteMaterial('{{ $course->_id }}', {{ $index }})" class="text-red-500 hover:text-red-700 p-2">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            @empty
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">No materials uploaded yet.</p>
                            </div>
                            @endforelse
                        </div>

                        <script>
                            // Handle file upload
                            document.getElementById('uploadMaterial').addEventListener('change', function(e) {
                                if (e.target.files.length > 0) {
                                    document.getElementById('uploadModal').classList.remove('hidden');
                                }
                            });

                            function closeUploadModal() {
                                document.getElementById('uploadModal').classList.add('hidden');
                                document.getElementById('materialUploadForm').reset();
                            }

                            document.getElementById('materialUploadForm').addEventListener('submit', function(e) {
                                e.preventDefault();
                                const formData = new FormData(this);
                                
                                // Add the course ID to the form data
                                formData.append('course_id', '{{ $course->_id }}');

                                // Show loading state
                                const submitButton = this.querySelector('button[type="submit"]');
                                const originalText = submitButton.innerHTML;
                                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Uploading...';
                                submitButton.disabled = true;

                                fetch('{{ route("manager.course.material.store") }}', {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        window.location.reload();
                                    } else {
                                        alert(data.message || 'Error uploading material');
                                        // Reset button state
                                        submitButton.innerHTML = originalText;
                                        submitButton.disabled = false;
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Error uploading material');
                                    // Reset button state
                                    submitButton.innerHTML = originalText;
                                    submitButton.disabled = false;
                                });
                            });

                            function deleteMaterial(courseId, materialIndex) {
                                if (!confirm('Are you sure you want to delete this material?')) {
                                    return;
                                }

                                // Show loading state
                                const deleteButton = event.target.closest('button');
                                const originalHTML = deleteButton.innerHTML;
                                deleteButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                                deleteButton.disabled = true;

                                fetch(`{{ route('manager.course.material.delete', ['courseId' => ':courseId', 'materialIndex' => ':materialIndex']) }}`
                                    .replace(':courseId', courseId)
                                    .replace(':materialIndex', materialIndex), {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    if (data.success) {
                                        window.location.reload();
                                    } else {
                                        throw new Error(data.message || 'Error deleting material');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert(error.message || 'Error deleting material');
                                    // Reset button state
                                    deleteButton.innerHTML = originalHTML;
                                    deleteButton.disabled = false;
                                });
                            }
                        </script>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 