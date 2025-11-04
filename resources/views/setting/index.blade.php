<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Track STEMI Pathway - Setting</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Font Settings */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-weight: 400;
            line-height: 1.5;
            letter-spacing: -0.011em;
        }
        
        /* Font Weight Adjustments */
        .font-semibold {
            font-weight: 600;
        }
        
        .font-bold {
            font-weight: 700;
        }
        
        .font-medium {
            font-weight: 500;
        }
        
        /* Text Size Adjustments */
        .text-xs {
            font-size: 0.75rem;
            line-height: 1rem;
        }
        
        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }
        
        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }
        
        .text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem;
        }
        
        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem;
        }
        
        .text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }
        
        .text-4xl {
            font-size: 2.25rem;
            line-height: 2.5rem;
        }

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
        
        /* Letter Spacing untuk judul FAST TRACK */
        .tracking-tight {
            letter-spacing: -0.025em;
        }
        
        /* Logo text styling */
        .logo-text {
            font-weight: 700;
            letter-spacing: -0.025em;
        }
        
        /* Button text styling */
        button, .btn {
            font-weight: 500;
        }
        
        /* Form styling */
        input, select, textarea {
            font-family: 'Inter', sans-serif;
        }
        
        /* Toggle switch styling */
        .toggle-checkbox:checked {
            right: 0;
            border-color: #3b82f6;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #3b82f6;
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
                        <h1 class="text-blue-600 font-bold text-sm leading-tight logo-text">FAST</h1>
                        <h1 class="text-blue-600 font-bold text-sm leading-tight logo-text">TRACK</h1>
                        <p class="text-teal-600 font-bold text-xs leading-tight logo-text">STEMI</p>
                        <p class="text-teal-600 font-bold text-xs leading-tight logo-text">PATHWAY</p>
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

                        <button class="relative">
                            <i class="fas fa-bell text-gray-500 text-xl"></i>
                            <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        <div x-data="{ isOpen: false }" class="relative">
                            <button @click="isOpen = !isOpen" class="flex items-center gap-3 focus:outline-none">
                                <span class="text-gray-700 font-medium text-sm">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                            </button>

                            <div x-show="isOpen" @click.away="isOpen = false"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-10">
                                <a href="{{ route('setting.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mx-8 mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mx-8 mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

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
                            
                            <form action="{{ route('setting.update-profile') }}" method="POST">
                                @csrf
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 text-sm">
                                            @error('name')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 text-sm">
                                            @error('email')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                            <input type="tel" name="phone_number" value="{{ old('phone_number', $user->phone_number ?? '') }}"
                                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                            <select name="role"
                                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 text-sm">
                                                <option value="">Select Role</option>
                                                <option value="Dokter Spesialis" {{ old('role', $settings['role'] ?? '') == 'Dokter Spesialis' ? 'selected' : '' }}>Dokter Spesialis</option>
                                                <option value="Dokter Umum" {{ old('role', $settings['role'] ?? '') == 'Dokter Umum' ? 'selected' : '' }}>Dokter Umum</option>
                                                <option value="Perawat" {{ old('role', $settings['role'] ?? '') == 'Perawat' ? 'selected' : '' }}>Perawat</option>
                                                <option value="Admin" {{ old('role', $settings['role'] ?? '') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Hospital</label>
                                        <input type="text" name="hospital" value="{{ old('hospital', $settings['hospital'] ?? '') }}"
                                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 text-sm">
                                    </div>
                                </div>

                                <div class="flex justify-end mt-6">
                                    <button type="submit"
                                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-sm">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Change Password --}}
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6">Change Password</h3>

                            <form action="{{ route('setting.update-password') }}" method="POST">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                        <input type="password" name="current_password" placeholder="Enter current password"
                                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 text-sm">
                                        @error('current_password')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                            <input type="password" name="new_password" placeholder="Enter new password"
                                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 text-sm">
                                            @error('new_password')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                                            <input type="password" name="new_password_confirmation" placeholder="Confirm new password"
                                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 text-sm">
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end mt-6">
                                    <button type="submit"
                                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-sm">
                                        Update Password
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Notification Settings --}}
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6">Notification Settings</h3>

                            <form action="{{ route('setting.update-notifications') }}" method="POST">
                                @csrf
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                        <div>
                                            <p class="font-medium text-gray-800 text-sm">Email Notifications</p>
                                            <p class="text-xs text-gray-500">Receive notifications via email</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="email_notifications" value="1" 
                                                {{ ($settings['email_notifications'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                            </div>
                                        </label>
                                    </div>

                                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                        <div>
                                            <p class="font-medium text-gray-800 text-sm">SMS Notifications</p>
                                            <p class="text-xs text-gray-500">Receive notifications via SMS</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="sms_notifications" value="1"
                                                {{ ($settings['sms_notifications'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                            </div>
                                        </label>
                                    </div>

                                    <div class="flex items-center justify-between py-3">
                                        <div>
                                            <p class="font-medium text-gray-800 text-sm">Emergency Alerts</p>
                                            <p class="text-xs text-gray-500">Receive critical emergency notifications</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="emergency_alerts" value="1"
                                                {{ ($settings['emergency_alerts'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex justify-end mt-6">
                                    <button type="submit"
                                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-sm">
                                        Save Notification Settings
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Right Side --}}
                    <div class="space-y-6">
                        {{-- Profile Picture --}}
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6">Profile Picture</h3>

                            <div class="flex flex-col items-center">
                                @if($user->profile_photo)
                                    <img src="{{ asset('storage/profile-photos/' . $user->profile_photo) }}" 
                                         alt="Profile Photo" 
                                         class="w-32 h-32 rounded-full object-cover mb-4">
                                @else
                                    <div class="w-32 h-32 bg-gradient-to-br from-blue-500 to-teal-500 rounded-full flex items-center justify-center text-white text-4xl font-bold mb-4">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                @endif

                                <form action="{{ route('setting.update-profile-photo') }}" method="POST" enctype="multipart/form-data" class="text-center">
                                    @csrf
                                    <input type="file" name="profile_photo" id="profile_photo" accept="image/*" class="hidden" onchange="this.form.submit()">
                                    <button type="button" onclick="document.getElementById('profile_photo').click()"
                                        class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition font-medium mb-2">
                                        Upload Photo
                                    </button>
                                </form>

                                @if($user->profile_photo)
                                    <form action="{{ route('setting.remove-profile-photo') }}" method="POST" class="text-center">
                                        @csrf
                                        <button type="submit" 
                                            class="px-4 py-2 text-red-600 text-sm hover:bg-red-50 rounded-lg transition font-medium">
                                            Remove Photo
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        {{-- Quick Stats --}}
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6">Account Stats</h3>

                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 font-medium">Cases Handled</span>
                                    <span class="font-semibold text-gray-800">375</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 font-medium">Active Cases</span>
                                    <span class="font-semibold text-gray-800">20</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 font-medium">Success Rate</span>
                                    <span class="font-semibold text-green-600">98.5%</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 font-medium">Member Since</span>
                                    <span class="font-semibold text-gray-800">{{ $user->created_at->format('M Y') }}</span>
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

    <script>
        // Danger zone buttons
        const deactivateButton = document.querySelector('button:contains("Deactivate Account")');
        if (deactivateButton) {
            deactivateButton.addEventListener('click', function() {
                if (confirm('Are you sure you want to deactivate your account? This action can be reversed.')) {
                    // Deactivate account logic
                    alert('Account deactivated!');
                }
            });
        }

        const deleteButton = document.querySelector('button:contains("Delete Account")');
        if (deleteButton) {
            deleteButton.addEventListener('click', function() {
                if (confirm('WARNING: This will permanently delete your account and all associated data. This action cannot be undone. Are you sure?')) {
                    // Delete account logic
                    alert('Account deleted!');
                }
            });
        }
    </script>
</body>

</html>