<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Track STEMI Pathway - Setting</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<style>
        .bg-cyan-light {
            background-color: #E0F7FA;
        }
        .filter-dropdown {
            display: none;
        }
        .filter-dropdown.show {
            display: block;
        }
        .pagination-active {
            background-color: #3b82f6;
            color: white;
        }
        .pagination-disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="flex h-screen">
       {{-- Sidebar --}}
        <aside class="w-64 bg-white shadow-sm">
            <div class="p-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/Logo.PNG') }}" alt="Fast Track STEMI Pathway" class="h-14 w-14 object-contain">
                    <div>
                        <h1 class="text-blue-600 font-bold text-sm leading-tight">FAST</h1>
                        <h1 class="text-blue-600 font-bold text-sm leading-tight">TRACK</h1>
                        <p class="text-teal-600 font-bold text-xs leading-tight">STEMI</p>
                        <p class="text-teal-600 font-bold text-xs leading-tight">PATHWAY</p>
                    </div>
                </div>
            </div>

            <nav class="mt-8">
                <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 px-6 py-3 text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-th-large w-5"></i><span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('data-nakes.index') }}" class="flex items-center gap-3 px-6 py-3 text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-user-md w-5"></i><span class="font-medium">Data Nakes</span>
                </a>
                <a href="{{ route('code-stemi.index') }}" class="flex items-center gap-3 px-6 py-3 text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-file-medical-alt w-5"></i><span class="font-medium">Code STEMI</span>
                </a>
                <a href="{{ route('setting.index') }}" class="flex items-center gap-3 px-6 py-3 bg-blue-50 text-blue-600 border-l-4 border-blue-600">
                    <i class="fas fa-cog w-5"></i><span class="font-medium">Setting</span>
                </a>
            </nav>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 overflow-y-auto">
            <header class="bg-white shadow-sm px-8 py-4">
                <div class="flex items-center justify-between">
                    <div></div>
                    <div class="flex items-center gap-6">
                        <form id="searchForm" method="GET" action="{{ route('code-stemi.index') }}" class="relative">
                            <input type="text" name="search" id="searchInput" placeholder="Search type of keywords" 
                                value="{{ request('search') }}"
                                class="w-80 pl-4 pr-10 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 text-sm">
                            <button type="submit" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                        <button class="relative">
                            <i class="fas fa-bell text-gray-500 text-xl"></i>
                            <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        <div class="flex items-center gap-3">
                            <span class="text-gray-700 font-medium text-sm">dr. Muhammad Zaky, Sp.JP</span>
                            <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Setting Content --}}
            <div class="p-8">
                {{-- Title --}}
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Setting</h2>
                </div>

                <div class="grid grid-cols-3 gap-6">
                    {{-- Profile Section --}}
                    <div class="col-span-2 space-y-6">
                        {{-- Profile Information --}}
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6">Profile Information</h3>

                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                        <input type="text" value="dr. Muhammad Zaky, Sp.JP"
                                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                        <input type="email" value="mzaky@hospital.com"
                                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                        <input type="tel" value="+62 812 3456 7890"
                                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                        <select
                                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500">
                                            <option>Dokter Spesialis</option>
                                            <option>Dokter Umum</option>
                                            <option>Perawat</option>
                                            <option>Admin</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Hospital</label>
                                    <input type="text" value="Rumah Sakit Umum Pusat Nasional"
                                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500">
                                </div>
                            </div>

                            <div class="flex justify-end mt-6">
                                <button
                                    class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                                    Save Changes
                                </button>
                            </div>
                        </div>

                        {{-- Change Password --}}
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6">Change Password</h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                    <input type="password" placeholder="Enter current password"
                                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                        <input type="password" placeholder="Enter new password"
                                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirm
                                            Password</label>
                                        <input type="password" placeholder="Confirm new password"
                                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500">
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end mt-6">
                                <button
                                    class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                                    Update Password
                                </button>
                            </div>
                        </div>

                        {{-- Notification Settings --}}
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6">Notification Settings</h3>

                            <div class="space-y-4">
                                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                    <div>
                                        <p class="font-medium text-gray-800">Email Notifications</p>
                                        <p class="text-sm text-gray-500">Receive notifications via email</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                        </div>
                                    </label>
                                </div>

                                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                    <div>
                                        <p class="font-medium text-gray-800">SMS Notifications</p>
                                        <p class="text-sm text-gray-500">Receive notifications via SMS</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                        </div>
                                    </label>
                                </div>

                                <div class="flex items-center justify-between py-3">
                                    <div>
                                        <p class="font-medium text-gray-800">Emergency Alerts</p>
                                        <p class="text-sm text-gray-500">Receive critical emergency notifications</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Side --}}
                    <div class="space-y-6">
                        {{-- Profile Picture --}}
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6">Profile Picture</h3>

                            <div class="flex flex-col items-center">
                                <div
                                    class="w-32 h-32 bg-gradient-to-br from-blue-500 to-teal-500 rounded-full flex items-center justify-center text-white text-4xl font-bold mb-4">
                                    MZ
                                </div>
                                <button
                                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition font-medium mb-2">
                                    Upload Photo
                                </button>
                                <button class="px-4 py-2 text-red-600 text-sm hover:bg-red-50 rounded-lg transition">
                                    Remove Photo
                                </button>
                            </div>
                        </div>

                        {{-- Quick Stats --}}
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6">Account Stats</h3>

                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Cases Handled</span>
                                    <span class="font-semibold text-gray-800">375</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Active Cases</span>
                                    <span class="font-semibold text-gray-800">20</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Success Rate</span>
                                    <span class="font-semibold text-green-600">98.5%</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Member Since</span>
                                    <span class="font-semibold text-gray-800">Jan 2023</span>
                                </div>
                            </div>
                        </div>

                        {{-- Danger Zone --}}
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-red-200">
                            <h3 class="text-lg font-semibold text-red-600 mb-4">Danger Zone</h3>

                            <div class="space-y-3">
                                <button
                                    class="w-full px-4 py-2 bg-red-50 text-red-600 text-sm rounded-lg hover:bg-red-100 transition font-medium">
                                    Deactivate Account
                                </button>
                                <button
                                    class="w-full px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition font-medium">
                                    Delete Account
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
