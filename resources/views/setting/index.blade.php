<!DOCTYPE html>
<html lang="id">

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
            overflow: hidden; /* Prevent whole page scrolling */
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

        /* Profile image styling */
        .profile-image {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e5e7eb;
        }

        /* Custom scrollbar for data area only */
        .data-scroll-container {
            height: calc(100vh - 200px);
            overflow-y: auto;
        }

        .data-scroll-container::-webkit-scrollbar {
            width: 6px;
        }

        .data-scroll-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .data-scroll-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .data-scroll-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Auto remove notification styling */
        .auto-remove-notification {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
        <main class="flex-1 flex flex-col">
            <header class="bg-white shadow-sm px-8 py-4 flex-shrink-0">
                <div class="flex items-center justify-between">
                    <div></div>
                    <div class="flex items-center gap-6">
                        {{-- User Profile dengan Foto --}}
                        <div x-data="{ isOpen: false }" class="relative">
                            <button @click="isOpen = !isOpen" class="flex items-center gap-3 focus:outline-none hover:bg-gray-50 rounded-lg px-3 py-2 transition-all duration-200">
                                {{-- Foto Profil --}}
                                @if(Auth::user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" 
                                         alt="{{ Auth::user()->name }}" 
                                         class="profile-image">
                                @else
                                    {{-- Default avatar dengan inisial --}}
                                    <div class="profile-image bg-blue-500 flex items-center justify-center text-white font-semibold text-sm">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                                
                                <div class="flex flex-col items-start">
                                    <span class="text-gray-700 font-medium text-sm">{{ Auth::user()->name }}</span>
                                    <span class="text-gray-500 text-xs">{{ Auth::user()->role ?? 'Admin' }}</span>
                                </div>
                                <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                            </button>

                            <div x-show="isOpen" @click.away="isOpen = false" x-transition
                                class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl z-50 border border-gray-200 py-2">
                                {{-- Header Profil di Dropdown --}}
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <div class="flex items-center gap-3">
                                        @if(Auth::user()->profile_photo_path)
                                            <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" 
                                                 alt="{{ Auth::user()->name }}" 
                                                 class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                                {{ substr(Auth::user()->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</span>
                                            <span class="text-xs text-gray-500">{{ Auth::user()->email }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <a href="{{ route('setting.index') }}"
                                    class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-user-circle text-gray-400 w-4"></i>
                                    <span>Profil Saya</span>
                                </a>
                                <a href="{{ route('setting.index') }}?tab=password"
                                    class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-key text-gray-400 w-4"></i>
                                    <span>Ubah Password</span>
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center gap-3 w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-sign-out-alt text-gray-400 w-4"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Setting Content --}}
            <div class="p-8 flex-1 data-scroll-container">
                {{-- Notifications --}}
                @if (session('success'))
                    <div
                        class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm auto-remove-notification">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                            <button onclick="this.parentElement.parentElement.remove()" class="text-green-600 hover:text-green-800">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm auto-remove-notification">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span>{{ session('error') }}</span>
                            </div>
                            <button onclick="this.parentElement.parentElement.remove()" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif

                {{-- Title --}}
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Setting</h2>
                    
                    <!-- Active Filter Badges -->
                    <div id="activeFilters" class="flex flex-wrap gap-2">
                        @if (request('search'))
                            <span class="bg-indigo-100 text-indigo-800 text-xs px-3 py-1 rounded-full flex items-center gap-1">
                                Search: "{{ request('search') }}"
                                <button onclick="removeFilter('search')" class="text-indigo-600 hover:text-indigo-800">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </span>
                        @endif
                    </div>
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
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
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


                    </div>

                    {{-- Right Side --}}
                    <div class="space-y-6">

                        {{-- Quick Stats --}}
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6">Account Stats</h3>

                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 font-medium">Cases Handled</span>
                                    <span class="font-semibold text-gray-800">{{ $totalCases }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 font-medium">Active Cases</span>
                                    <span class="font-semibold text-gray-800">{{ $activeCases }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 font-medium">Success Rate</span>
                                    <span class="font-semibold text-green-600">{{ $successRate }}%</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 font-medium">Member Since</span>
                                    <span class="font-semibold text-gray-800">{{ $user->created_at->format('M Y') }}</span>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto remove notifications after 5 seconds
            setTimeout(() => {
                document.querySelectorAll('.auto-remove-notification').forEach(notification => {
                    notification.remove();
                });
            }, 5000);
        });

        // ==================== FILTER FUNCTIONS ====================
        function removeFilter(filterName) {
            const url = new URL(window.location.href);
            url.searchParams.delete(filterName);
            window.location.href = url.toString();
        }

        // ==================== NOTIFICATION FUNCTIONS ====================
        function showSuccessNotification(message) {
            // Remove old notifications if any
            const oldNotifications = document.querySelectorAll('.auto-remove-notification');
            oldNotifications.forEach(notification => notification.remove());

            // Create new notification
            const notification = document.createElement('div');
            notification.className =
                'auto-remove-notification mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm';
            notification.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>${message}</span>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-green-600 hover:text-green-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;

            // Insert notification above content
            const content = document.querySelector('.p-8');
            content.insertBefore(notification, content.firstChild);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }

        // ==================== ERROR MODAL FUNCTIONS ====================
        function showErrorModal(message) {
            // You can implement SweetAlert2 here if needed
            console.error('Error:', message);
            alert('Error: ' + message);
        }
    </script>
</body>

</html>