<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance - SkillUp</title>
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
                    <a href="{{ route('employee.attendance') }}" class="flex items-center px-4 py-2 text-white bg-green-600 rounded-lg">
                        <i class="bi bi-calendar-check mr-3"></i>
                        Attendance
                    </a>
                    <a href="{{ route('employee.courses') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 rounded-lg">
                        <i class="bi bi-book mr-3"></i>
                        My Courses
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
                        <h1 class="text-2xl font-semibold text-gray-800">Attendance</h1>
                        <div class="flex items-center space-x-4">
                            <button onclick="openSignAttendanceModal()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 flex items-center">
                                <i class="bi bi-pencil-square mr-2"></i>
                                Sign Attendance
                            </button>
                            <div class="relative">
                                <input type="text" placeholder="Search attendance..." class="w-64 px-4 py-2 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                <i class="bi bi-search absolute right-3 top-2.5 text-gray-400"></i>
                            </div>
                            <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                Filter
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Sign Attendance Modal -->
            <div id="signAttendanceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Sign Attendance</h3>
                            <button onclick="closeSignAttendanceModal()" class="text-gray-400 hover:text-gray-500">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="mt-2">
                            <form id="attendanceForm">
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="date">
                                        Date
                                    </label>
                                    <input type="date" id="date" name="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="time">
                                        Time
                                    </label>
                                    <input type="time" id="time" name="time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="type">
                                        Type
                                    </label>
                                    <select id="type" name="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                        <option value="check_in">Check In</option>
                                        <option value="check_out">Check Out</option>
                                    </select>
                                </div>
                                <div class="flex items-center justify-end">
                                    <button type="button" onclick="closeSignAttendanceModal()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg mr-2 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                        Cancel
                                    </button>
                                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance Content -->
            <main class="p-6">
                <!-- Current Month Summary -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Current Month Summary</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-green-50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Present Days</p>
                                    <p class="text-2xl font-bold text-gray-800">18</p>
                                </div>
                                <div class="p-3 bg-green-100 rounded-full">
                                    <i class="bi bi-check-circle text-green-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-yellow-50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Absent Days</p>
                                    <p class="text-2xl font-bold text-gray-800">2</p>
                                </div>
                                <div class="p-3 bg-yellow-100 rounded-full">
                                    <i class="bi bi-x-circle text-yellow-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Attendance Rate</p>
                                    <p class="text-2xl font-bold text-gray-800">90%</p>
                                </div>
                                <div class="p-3 bg-blue-100 rounded-full">
                                    <i class="bi bi-graph-up text-blue-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Attendance Records -->
                <div class="mt-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Records</h2>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2024-03-15</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold text-green-600 bg-green-100 rounded-full">Present</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">09:00 AM</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">06:00 PM</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2024-03-14</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold text-green-600 bg-green-100 rounded-full">Present</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">09:15 AM</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">05:45 PM</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2024-03-13</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold text-red-600 bg-red-100 rounded-full">Absent</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">-</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function openSignAttendanceModal() {
            document.getElementById('signAttendanceModal').classList.remove('hidden');
        }

        function closeSignAttendanceModal() {
            document.getElementById('signAttendanceModal').classList.add('hidden');
        }

        document.getElementById('attendanceForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Here you would typically send the form data to your backend
            // For now, we'll just close the modal
            closeSignAttendanceModal();
            // You can add a success message or update the attendance records here
        });
    </script>
</body>
</html> 