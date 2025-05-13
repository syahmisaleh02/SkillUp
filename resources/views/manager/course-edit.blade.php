<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Course | SkillUp</title>
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
                        <a href="#" class="block py-2 px-4 hover:bg-green-600 flex items-center">
                            <i class="fas fa-users w-6"></i>
                            <span>Team Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('manager.course') }}" class="block py-2 px-4 bg-green-600 flex items-center">
                            <i class="fas fa-book w-6"></i>
                            <span>Course Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-4 hover:bg-green-600 flex items-center">
                            <i class="fas fa-chart-line w-6"></i>
                            <span>Performance Reports</span>
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
                        <p class="text-sm font-medium">Guest User</p>
                        <p class="text-xs text-green-200">Manager</p>
                    </div>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-6">
            <div class="max-w-4xl mx-auto">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Edit Course</h1>
                    <a href="{{ route('manager.course') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Courses
                    </a>
                </div>

                <!-- Course Form -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <!-- Course Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Course Title</label>
                                <input type="text" id="title" name="title" value="Introduction to Web Development" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>

                            <!-- Course Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea id="description" name="description" rows="4" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">Learn the fundamentals of web development...</textarea>
                            </div>

                            <!-- Course Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                <select id="status" name="status" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    <option value="active">Active</option>
                                    <option value="draft">Draft</option>
                                </select>
                            </div>

                            <!-- Course Materials -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Course Materials</label>
                                <div class="mt-2 space-y-4">
                                    <!-- Existing Materials -->
                                    <div class="border rounded-lg p-4">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Current Materials</h3>
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700 rounded">
                                                <div class="flex items-center">
                                                    <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                                    <span class="text-gray-700 dark:text-gray-300">Course Syllabus.pdf</span>
                                                </div>
                                                <button type="button" class="text-red-500 hover:text-red-700">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700 rounded">
                                                <div class="flex items-center">
                                                    <i class="fas fa-file-word text-blue-500 mr-2"></i>
                                                    <span class="text-gray-700 dark:text-gray-300">Assignment Guidelines.docx</span>
                                                </div>
                                                <button type="button" class="text-red-500 hover:text-red-700">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Upload New Materials -->
                                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center">
                                        <div class="space-y-2">
                                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400"></i>
                                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                                <label for="file-upload" class="relative cursor-pointer">
                                                    <span>Upload new materials</span>
                                                    <input id="file-upload" name="materials[]" type="file" multiple class="sr-only">
                                                </label>
                                                <p class="text-xs">or drag and drop</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 