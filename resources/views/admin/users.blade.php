<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Management | SkillUp</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <script>
    function confirmDelete(userId) {
        if (confirm('Are you sure you want to delete this user?')) {
            const form = document.getElementById('delete-form-' + userId);
            if (form) {
                form.submit();
            }
        }
    }

    function openEditModal(userId, name, email, role) {
        document.getElementById('edit-user-id').value = userId;
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-email').value = email;
        document.getElementById('edit-role').value = role;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
    </script>
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
                        <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 hover:bg-green-600 flex items-center">
                            <i class="fas fa-home w-6"></i>
                            <span>Homepage</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users') }}" class="block py-2 px-4 bg-green-600 flex items-center">
                            <i class="fas fa-users w-6"></i>
                            <span>User Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-4 hover:bg-green-600 flex items-center">
                            <i class="fas fa-book w-6"></i>
                            <span>Course Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-4 hover:bg-green-600 flex items-center">
                            <i class="fas fa-chart-bar w-6"></i>
                            <span>Analytics</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-4 hover:bg-green-600 flex items-center">
                            <i class="fas fa-cog w-6"></i>
                            <span>Settings</span>
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
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">User Management</h1>
            </div>

            <!-- User Table -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                            <i class="fas fa-user text-gray-500 dark:text-gray-300"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($user->role === 'admin') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($user->role === 'manager') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @else bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 @endif">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Active
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button onclick="openEditModal('{{ $user->_id }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')" 
                                            class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-200 mr-3">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.users.delete', $user->_id) }}" method="POST" class="inline-block" id="delete-form-{{ $user->_id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                onclick="confirmDelete('{{ $user->_id }}')" 
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Edit User Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" style="z-index: 50;">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Edit User</h3>
                <form action="{{ route('admin.users.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit-user-id" name="user_id">
                    
                    <div class="mb-4">
                        <label for="edit-name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="edit-name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>

                    <div class="mb-4">
                        <label for="edit-email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="edit-email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>

                    <div class="mb-4">
                        <label for="edit-role" class="block text-sm font-medium text-gray-700">Role</label>
                        <select id="edit-role" name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            <option value="admin">Admin</option>
                            <option value="manager">Manager</option>
                            <option value="employee">Employee</option>
                        </select>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">
                            Cancel
                        </button>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="fixed bottom-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="fixed bottom-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        {{ session('error') }}
    </div>
    @endif

    @push('scripts')
    @endpush
</body>
</html> 