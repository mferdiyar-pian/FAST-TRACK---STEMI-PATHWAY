<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Track STEMI Pathway - Code STEMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Font Settings */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-weight: 400;
            line-height: 1.5;
            letter-spacing: -0.011em;
            overflow: hidden;
            /* Prevent whole page scrolling */
        }

        .font-semibold {
            font-weight: 600;
        }

        .font-bold {
            font-weight: 700;
        }

        .font-medium {
            font-weight: 500;
        }

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

        .tracking-tight {
            letter-spacing: -0.025em;
        }

        .text-micro {
            font-size: 0.6875rem;
            line-height: 0.875rem;
        }

        table {
            font-size: 0.875rem;
            font-weight: 400;
        }

        th {
            font-weight: 600;
            font-size: 0.75rem;
        }

        .logo-text {
            font-weight: 700;
            letter-spacing: -0.025em;
        }

        button,
        .btn {
            font-weight: 500;
        }

        .status-badge {
            font-weight: 500;
            font-size: 0.75rem;
        }

        .timer-text {
            font-weight: 600;
            letter-spacing: 0.025em;
        }

        /* Profile image styling */
        .profile-image {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e5e7eb;
        }

        /* Search input styling for long placeholder */
        .search-input::placeholder {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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
    </style>
</head>

<body class="bg-gray-50">
    <div class="flex h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white shadow-sm">
            <div class="p-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/Logo.PNG') }}" alt="Fast Track STEMI Pathway"
                        class="h-14 w-14 object-contain">
                    <div>
                        <h1 class="text-blue-600 font-bold text-sm leading-tight logo-text">FAST</h1>
                        <h1 class="text-blue-600 font-bold text-sm leading-tight logo-text">TRACK</h1>
                        <p class="text-teal-600 font-bold text-xs leading-tight logo-text">STEMI</p>
                        <p class="text-teal-600 font-bold text-xs leading-tight logo-text">PATHWAY</p>
                    </div>
                </div>
            </div>

            <nav class="mt-8">
                <a href="{{ route('dashboard.index') }}"
                    class="flex items-center gap-3 px-6 py-3 text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-th-large w-5"></i><span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('data-nakes.index') }}"
                    class="flex items-center gap-3 px-6 py-3 text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-user-md w-5"></i><span class="font-medium">Data Nakes</span>
                </a>
                <a href="{{ route('code-stemi.index') }}"
                    class="flex items-center gap-3 px-6 py-3 bg-blue-50 text-blue-600 border-l-4 border-blue-600">
                    <i class="fas fa-file-medical-alt w-5"></i><span class="font-medium">Code STEMI</span>
                </a>
                <a href="{{ route('setting.index') }}"
                    class="flex items-center gap-3 px-6 py-3 text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-cog w-5"></i><span class="font-medium">Settings</span>
                </a>
            </nav>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 flex flex-col">
            <header class="bg-white shadow-sm px-8 py-4 flex-shrink-0">
                <div class="flex items-center justify-between">
                    <div></div>
                    <div class="flex items-center gap-6">
                        <!-- PERBAIKAN: Search Form dengan real-time search -->
                        <form id="searchForm" method="GET" action="{{ route('code-stemi.index') }}"
                            class="relative flex items-center">
                            <input type="text" name="search" id="searchInput" placeholder="Search type of keywords"
                                value="{{ request('search') }}"
                                class="w-80 pl-4 pr-10 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent text-sm transition-all duration-200 search-input" />
                            <button type="submit"
                                class="absolute right-3 text-gray-400 hover:text-blue-600 transition-all duration-150">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>

                        {{-- User Profile with Photo --}}
                        <div x-data="{ isOpen: false }" class="relative">
                            <button @click="isOpen = !isOpen"
                                class="flex items-center gap-3 focus:outline-none hover:bg-gray-50 rounded-lg px-3 py-2 transition-all duration-200">
                                {{-- Profile Photo --}}
                                @if (Auth::user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}"
                                        alt="{{ Auth::user()->name }}" class="profile-image">
                                @else
                                    {{-- Default avatar with initial --}}
                                    <div
                                        class="profile-image bg-blue-500 flex items-center justify-center text-white font-semibold text-sm">
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
                                {{-- Profile Header in Dropdown --}}
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <div class="flex items-center gap-3">
                                        @if (Auth::user()->profile_photo_path)
                                            <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}"
                                                alt="{{ Auth::user()->name }}"
                                                class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div
                                                class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                                {{ substr(Auth::user()->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</span>
                                            <span class="text-xs text-gray-500">{{ Auth::user()->email }}</span>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('setting.index') }}"
                                    class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-user-circle text-gray-400 w-4"></i>
                                    <span>My Profile</span>
                                </a>
                                <a href="{{ route('setting.index') }}?tab=password"
                                    class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-key text-gray-400 w-4"></i>
                                    <span>Change Password</span>
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

            {{-- Code STEMI Content --}}
            <div class="p-8 flex-1 data-scroll-container">
                {{-- Notifications --}}
                @if (session('success'))
                    <div
                        class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm auto-remove-notification">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm auto-remove-notification">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Code STEMI</h2>
                    <div class="flex gap-3">
                        <button onclick="openAddModal()"
                            class="flex items-center gap-2 px-5 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-medium text-sm">
                            <i class="fas fa-plus"></i>Add Data
                        </button>

                        {{-- Delete All Button --}}
                        @if ($data->count() > 0)
                            <button onclick="confirmDeleteAll()"
                                class="flex items-center gap-2 px-5 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-medium text-sm">
                                <i class="fas fa-trash-alt"></i>Delete All
                            </button>
                        @endif

                        <!-- Filter Button with Dropdown -->
                        <div class="relative">
                            <button onclick="toggleFilterDropdown()"
                                class="flex items-center gap-2 px-5 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm">
                                <i class="fas fa-sliders-h"></i>Filter
                                <i class="fas fa-chevron-down text-xs ml-1"></i>
                            </button>

                            <!-- Filter Dropdown -->
                            <div id="filterDropdown"
                                class="filter-dropdown absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 z-50">
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Code STEMI</h3>

                                    <form id="filterForm" class="space-y-4">
                                        <!-- Status Filter -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                            <select name="status" id="filterStatus"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                                <option value="">All Status</option>
                                                <option value="Running"
                                                    {{ request('status') == 'Running' ? 'selected' : '' }}>Running
                                                </option>
                                                <option value="Finished"
                                                    {{ request('status') == 'Finished' ? 'selected' : '' }}>Finished
                                                </option>
                                            </select>
                                        </div>

                                        <!-- Date Filter -->
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 mb-2">Admitted</label>
                                            <input type="date" name="date" id="filterDate"
                                                value="{{ request('date') }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                            <label class="text-xs text-gray-500 mt-1">Select specific date</label>
                                        </div>

                                        <!-- Checklist Filter -->
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 mb-2">Checklist</label>
                                            <div class="space-y-2 max-h-40 overflow-y-auto">
                                                @php
                                                    $checklistItems = [
                                                        'Anamnesis',
                                                        'Rongten Thorax',
                                                        'Laboratorium',
                                                        'EKG',
                                                        'Pemeriksaan Fisik',
                                                        'Informed Consent',
                                                    ];
                                                @endphp

                                                @foreach ($checklistItems as $key => $label)
                                                    <label class="flex items-center gap-2 cursor-pointer">
                                                        <input type="checkbox" name="checklist_filter[]"
                                                            value="{{ $key }}"
                                                            class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                                            {{ in_array($key, request('checklist_filter', [])) ? 'checked' : '' }}>
                                                        <span class="text-sm text-gray-700">{{ $label }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                            <label class="text-xs text-gray-500 mt-1">Filter by checked checklist
                                                items</label>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex gap-2 pt-2">
                                            <button type="button" onclick="applyFilter()"
                                                class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition font-medium text-sm">
                                                Apply Filter
                                            </button>
                                            <button type="button" onclick="resetFilter()"
                                                class="flex-1 bg-gray-200 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-300 transition font-medium text-sm">
                                                Reset
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Filter Badges -->
                <div id="activeFilters" class="mb-6 flex flex-wrap gap-2">
                    @if (request('status'))
                        <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full flex items-center gap-1">
                            Status: {{ request('status') }}
                            <button onclick="removeFilter('status')" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </span>
                    @endif
                    @if (request('date'))
                        <span
                            class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full flex items-center gap-1">
                            Date: {{ request('date') }}
                            <button onclick="removeFilter('date')" class="text-green-600 hover:text-green-800">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </span>
                    @endif
                    @if (request('checklist_filter'))
                        @php
                            $checklistLabels = [
                                'Anamnesis',
                                'Rongten Thorax',
                                'Laboratorium',
                                'EKG',
                                'Pemeriksaan Fisik',
                                'Informed Consent',
                            ];
                        @endphp
                        @foreach (request('checklist_filter') as $checklistItem)
                            <span
                                class="bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full flex items-center gap-1">
                                Checklist: {{ $checklistLabels[$checklistItem] ?? $checklistItem }}
                                <button onclick="removeChecklistFilter('{{ $checklistItem }}')"
                                    class="text-purple-600 hover:text-purple-800">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </span>
                        @endforeach
                    @endif
                    @if (request('search'))
                        <span
                            class="bg-indigo-100 text-indigo-800 text-xs px-3 py-1 rounded-full flex items-center gap-1">
                            Search: "{{ request('search') }}"
                            <button onclick="removeFilter('search')" class="text-indigo-600 hover:text-indigo-800">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </span>
                    @endif
                </div>

                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    @if ($data->count() > 0)
                        <table class="w-full">
                            <thead>
                                <tr class="bg-white">
                                    <th
                                        class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        ADMITTTED</th>
                                    <th
                                        class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        STATUS</th>
                                    <th
                                        class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        DOOR TO BALLOON TIME</th>
                                    <th
                                        class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        ACTIONS</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody id="codeStemiTableBody">
                                @foreach ($data as $index => $item)
                                    <tr class="border-t border-gray-100 {{ $index % 2 == 0 ? 'bg-cyan-light' : 'bg-white' }}"
                                        data-id="{{ $item->id }}"
                                        data-start-time="{{ $item->start_time->toISOString() }}"
                                        data-status="{{ $item->status }}"
                                        data-end-time="{{ $item->end_time ? $item->end_time->toISOString() : '' }}"
                                        data-date="{{ $item->start_time->format('Y-m-d') }}"
                                        data-checklist="{{ json_encode($item->checklist ?? []) }}">
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $item->formatted_date }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium status-badge
                                                {{ $item->status === 'Running' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span id="time-{{ $item->id }}"
                                                class="text-sm font-semibold timer-text {{ $item->status === 'Finished' ? 'text-red-600' : 'text-blue-600' }}">
                                                {{ $item->door_to_balloon_time }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <button onclick="openDetailModal({{ $item->id }})"
                                                    class="px-3 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600 transition font-medium">Details</button>
                                                @if ($item->status === 'Running')
                                                    <button onclick="confirmFinish({{ $item->id }})"
                                                        class="px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition font-medium whitespace-nowrap">
                                                        Complete Code
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-end">
                                                <button onclick="openContextMenu(event, {{ $item->id }})"
                                                    class="text-gray-400 hover:text-gray-600 transition p-2">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        @php
                            $currentPage = $data->currentPage();
                            $totalPages = $data->lastPage();
                            $prevPage = $data->currentPage() > 1 ? $data->currentPage() - 1 : null;
                            $nextPage = $data->currentPage() < $totalPages ? $data->currentPage() + 1 : null;
                        @endphp

                        <div class="border-t border-gray-200 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1">
                                    {{-- Previous Button --}}
                                    @if ($prevPage)
                                        <a href="{{ $data->previousPageUrl() }}"
                                            class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded transition text-sm flex items-center gap-2">
                                            <i class="fas fa-chevron-left text-xs"></i>Previous
                                        </a>
                                    @else
                                        <span
                                            class="px-4 py-2 text-gray-400 rounded transition text-sm flex items-center gap-2 pagination-disabled">
                                            <i class="fas fa-chevron-left text-xs"></i>Previous
                                        </span>
                                    @endif

                                    {{-- Page Numbers --}}
                                    @php
                                        $startPage = max($currentPage - 2, 1);
                                        $endPage = min($currentPage + 2, $totalPages);

                                        if ($endPage - $startPage < 4) {
                                            if ($startPage == 1) {
                                                $endPage = min($startPage + 4, $totalPages);
                                            } elseif ($endPage == $totalPages) {
                                                $startPage = max($endPage - 4, 1);
                                            }
                                        }
                                    @endphp

                                    @if ($startPage > 1)
                                        <a href="{{ $data->url(1) }}"
                                            class="px-3 py-2 text-gray-700 hover:bg-gray-100 rounded transition text-sm min-w-[40px] text-center">1</a>
                                        @if ($startPage > 2)
                                            <span class="px-2 text-gray-400 text-sm">...</span>
                                        @endif
                                    @endif

                                    @for ($i = $startPage; $i <= $endPage; $i++)
                                        <a href="{{ $data->url($i) }}"
                                            class="px-3 py-2 rounded font-medium text-sm min-w-[40px] text-center {{ $i == $currentPage ? 'bg-blue-500 text-white pagination-active' : 'text-gray-700 hover:bg-gray-100' }}">
                                            {{ $i }}
                                        </a>
                                    @endfor

                                    @if ($endPage < $totalPages)
                                        @if ($endPage < $totalPages - 1)
                                            <span class="px-2 text-gray-400 text-sm">...</span>
                                        @endif
                                        <a href="{{ $data->url($totalPages) }}"
                                            class="px-3 py-2 text-gray-700 hover:bg-gray-100 rounded transition text-sm min-w-[40px] text-center">{{ $totalPages }}</a>
                                    @endif

                                    {{-- Next Button --}}
                                    @if ($nextPage)
                                        <a href="{{ $data->nextPageUrl() }}"
                                            class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded transition text-sm flex items-center gap-2">
                                            Next<i class="fas fa-chevron-right text-xs"></i>
                                        </a>
                                    @else
                                        <span
                                            class="px-4 py-2 text-gray-400 rounded transition text-sm flex items-center gap-2 pagination-disabled">
                                            Next<i class="fas fa-chevron-right text-xs"></i>
                                        </span>
                                    @endif
                                </div>

                                {{-- Right: Export and Page Info --}}
                                <div class="flex items-center gap-4">
                                    <button type="button"
                                        onclick="window.location.href='{{ route('code-stemi.export') }}'"
                                        class="flex items-center gap-2 px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700 transition font-medium text-sm">
                                        <i class="fas fa-download"></i> Export
                                    </button>

                                    <div class="flex items-center gap-3 text-sm text-gray-600">
                                        <span class="font-medium text-gray-700">Page</span>
                                        <div class="relative">
                                            <select id="pageSelect"
                                                class="appearance-none bg-white border border-gray-300 rounded-lg px-3 py-1.5 pr-8 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200">
                                                @for ($i = 1; $i <= $totalPages; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ $i == $currentPage ? 'selected' : '' }}>{{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-gray-500">
                                                <i class="fas fa-chevron-down text-xs"></i>
                                            </div>
                                        </div>
                                        <span>of <span
                                                class="font-medium text-gray-800">{{ $totalPages }}</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <table class="w-full">
                            <thead>
                                <tr class="bg-white">
                                    <th
                                        class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        DATE</th>
                                    <th
                                        class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        STATUS</th>
                                    <th
                                        class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        DOOR TO BALLOON TIME</th>
                                    <th
                                        class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        ACTIONS</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-2 block"></i>
                                        @if (request()->anyFilled(['status', 'date', 'checklist_filter', 'search']))
                                            No data matching the filter criteria
                                        @else
                                            No Code STEMI data available
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        {{-- Pagination for no data condition --}}
                        <div class="border-t border-gray-200 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1">
                                    <span
                                        class="px-4 py-2 text-gray-400 rounded transition text-sm flex items-center gap-2 pagination-disabled">
                                        <i class="fas fa-chevron-left text-xs"></i>Previous
                                    </span>

                                    <span
                                        class="px-3 py-2 rounded font-medium text-sm min-w-[40px] text-center bg-blue-500 text-white pagination-active">
                                        1
                                    </span>

                                    <span
                                        class="px-4 py-2 text-gray-400 rounded transition text-sm flex items-center gap-2 pagination-disabled">
                                        Next<i class="fas fa-chevron-right text-xs"></i>
                                    </span>
                                </div>

                                <div class="flex items-center gap-4">
                                    <button type="button"
                                        class="flex items-center gap-2 px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700 transition font-medium text-sm">
                                        <i class="fas fa-download"></i> Export
                                    </button>

                                    <div class="flex items-center gap-3 text-sm text-gray-600">
                                        <span class="font-medium text-gray-700">Page</span>
                                        <div class="relative">
                                            <select
                                                class="appearance-none bg-white border border-gray-300 rounded-lg px-3 py-1.5 pr-8 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200">
                                                <option value="1" selected>1</option>
                                            </select>
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-gray-500">
                                                <i class="fas fa-chevron-down text-xs"></i>
                                            </div>
                                        </div>
                                        <span>of <span class="font-medium text-gray-800">1</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    {{-- Context Menu --}}
    <div id="contextMenu" class="fixed hidden bg-white shadow-lg rounded-lg py-2 z-50 border border-gray-200"
        style="min-width: 140px;">
        <button onclick="editFromMenu()"
            class="w-full text-left px-4 py-2 hover:bg-gray-50 text-sm text-gray-700 flex items-center gap-2">
            <i class="fas fa-edit text-blue-500 w-4"></i>Edit
        </button>
        <button onclick="deleteFromMenu()"
            class="w-full text-left px-4 py-2 hover:bg-gray-50 text-sm text-gray-700 flex items-center gap-2">
            <i class="fas fa-trash-alt text-red-500 w-4"></i>Delete
        </button>
    </div>

    {{-- Add Data Modal --}}
    <div id="addCodeStemiModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all">
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-800">REGISTRASI CODE STEMI</h3>
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/Logo.PNG') }}" alt="Fast Track STEMI Pathway"
                        class="h-10 object-contain">
                    <div>
                        <h1 class="text-blue-600 font-bold text-sm leading-tight logo-text">FAST</h1>
                        <h1 class="text-blue-600 font-bold text-sm leading-tight logo-text">TRACK</h1>
                        <p class="text-teal-600 font-bold text-xs leading-tight logo-text">STEMI</p>
                        <p class="text-teal-600 font-bold text-xs leading-tight logo-text">PATHWAY</p>
                    </div>
                    <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>

            <form action="{{ route('code-stemi.store') }}" method="POST" id="activationForm">
                @csrf
                <div class="p-5 space-y-4">
                    {{-- Checklist Section --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Checklist Registrasi</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="checklist[]" value="Anamnesis"
                                    class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                <span class="text-sm text-gray-700">Anamnesis</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="checklist[]" value="EKG"
                                    class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                <span class="text-sm text-gray-700">EKG</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="checklist[]" value="Rongten Thorax"
                                    class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                <span class="text-sm text-gray-700">Rongten Thorax</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="checklist[]" value="Pemeriksaan Fisik"
                                    class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                <span class="text-sm text-gray-700">Pemeriksaan Fisik</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="checklist[]" value="Laboratorium"
                                    class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                <span class="text-sm text-gray-700">Laboratorium</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="checklist[]" value="Informed Consent"
                                    class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                <span class="text-sm text-gray-700">Informed Consent</span>
                            </label>
                        </div>
                    </div>

                    {{-- Custom Message Section --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Pesan Custom Broadcast</label>
                        <p class="text-xs text-gray-600 mb-2">Fast Track STEMI Pathway</p>

                        <div class="bg-gray-100 rounded-lg p-3 space-y-1 mb-2">
                            <p class="text-xs text-gray-700 font-semibold">CODE STEMI AKTIF</p>
                            <p class="text-xs text-gray-600">Pasien STEMI telah berada di IGD RS Otak M Hatta
                                Bukittinggi.</p>
                            <p class="text-xs text-gray-600">Seluruh unit terkait dimohon segera siaga.</p>
                            <p class="text-xs text-gray-600">Fast Track STEMI Pathway aktif.</p>
                            <p class="text-xs text-gray-600">Waktu Door-to-balloon dimulai.</p>
                        </div>

                        <textarea name="custom_message" placeholder="Tambahkan pesan custom disini (opsional)"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm"
                            rows="2"></textarea>
                        <p class="text-xs text-gray-400 italic mt-1">Pesan ini akan ditambahkan di akhir broadcast</p>
                    </div>

                    {{-- Submit Button --}}
                    <button type="button" onclick="confirmActivation()"
                        class="w-full py-2.5 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition text-sm">
                        AKTIVASI Code STEMI DIMULAI
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Activation Confirmation Modal --}}
    <div id="activationConfirmModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-center w-16 h-16 mx-auto bg-blue-100 rounded-full mb-4">
                    <i class="fas fa-question-circle text-blue-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 text-center mb-2">Activation Confirmation</h3>
                <p class="text-gray-600 text-center mb-6">Are you sure you want to activate Code STEMI?</p>

                <div class="flex gap-3">
                    <button onclick="closeActivationConfirmModal()"
                        class="flex-1 py-3 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-times mr-2"></i>CANCEL
                    </button>
                    <button onclick="submitActivationForm()"
                        class="flex-1 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-check mr-2"></i>ACTIVATE
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Completion Confirmation Modal --}}
    <div id="finishConfirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-center w-16 h-16 mx-auto bg-orange-100 rounded-full mb-4">
                    <i class="fas fa-exclamation-circle text-orange-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 text-center mb-2">Completion Confirmation</h3>
                <p class="text-gray-600 text-center mb-6">Are you sure you want to complete this Code STEMI?</p>

                <div class="flex gap-3">
                    <button onclick="closeFinishConfirmModal()"
                        class="flex-1 py-3 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-times mr-2"></i>CANCEL
                    </button>
                    <form id="finishForm" method="POST" class="flex-1">
                        @csrf
                        @method('PATCH')
                        <button type="button" onclick="handleFinishSubmit()"
                            class="w-full py-3 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition">
                            <i class="fas fa-check mr-2"></i>COMPLETE
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete All Modal --}}
    <div id="deleteAllModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 text-center mb-2">Delete All Confirmation</h3>
                <p class="text-gray-600 text-center mb-6">Are you sure you want to delete <span
                        class="font-bold text-red-600">ALL</span> Code STEMI data? This action cannot be undone!</p>

                <div class="flex gap-3">
                    <button onclick="closeDeleteAllModal()"
                        class="flex-1 py-3 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-times mr-2"></i>CANCEL
                    </button>
                    <form id="deleteAllForm" method="POST" action="{{ route('code-stemi.delete-all') }}"
                        class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="handleDeleteAllSubmit()"
                            class="w-full py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                            <i class="fas fa-trash mr-2"></i>DELETE ALL
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Data Modal --}}
    <div id="editCodeStemiModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all">
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-800">EDIT CODE STEMI</h3>
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/Logo.PNG') }}" alt="Fast Track STEMI Pathway"
                        class="h-10 object-contain">
                    <div>
                        <h1 class="text-blue-600 font-bold text-sm leading-tight logo-text">FAST</h1>
                        <h1 class="text-blue-600 font-bold text-sm leading-tight logo-text">TRACK</h1>
                        <p class="text-teal-600 font-bold text-xs leading-tight logo-text">STEMI</p>
                        <p class="text-teal-600 font-bold text-xs leading-tight logo-text">PATHWAY</p>
                    </div>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>

            <form id="editCodeStemiForm" method="POST">
                @csrf
                @method('PUT')
                <div class="p-5 space-y-4">
                    {{-- Checklist Section --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Registration Checklist</label>
                        <div class="grid grid-cols-2 gap-2" id="editChecklistContainer">
                            @php
                                $checklistItems = [
                                    'Anamnesis',
                                    'Rongten Thorax',
                                    'Laboratorium',
                                    'EKG',
                                    'Pemeriksaan Fisik',
                                    'Informed Consent',
                                ];
                            @endphp

                            @foreach ($checklistItems as $item)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="checklist[]" value="{{ $item }}"
                                        class="edit-checklist w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700">{{ $item }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Custom Message Section --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Custom Broadcast Message</label>
                        <p class="text-xs text-gray-600 mb-2">Fast Track STEMI Pathway</p>

                        <div class="bg-gray-100 rounded-lg p-3 space-y-1 mb-2">
                            <p class="text-xs text-gray-700 font-semibold">CODE STEMI AKTIF</p>
                            <p class="text-xs text-gray-600">Pasien STEMI telah berada di IGD RS Otak M Hatta
                                Bukittinggi.</p>
                            <p class="text-xs text-gray-600">Seluruh unit terkait dimohon segera siaga.</p>
                            <p class="text-xs text-gray-600">Fast Track STEMI Pathway aktif.</p>
                            <p class="text-xs text-gray-600">Waktu Door-to-balloon dimulai.</p>
                        </div>

                        <textarea name="custom_message" id="editCustomMessage" placeholder="Add custom message here (optional)"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm"
                            rows="2"></textarea>
                        <p class="text-xs text-gray-400 italic mt-1">This message will be added at the end of the
                            broadcast</p>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="w-full py-2.5 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition text-sm">
                        UPDATE Code STEMI
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Detail Data Modal --}}
    <div id="detailCodeStemiModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all">
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-800">DETAIL CODE STEMI</h3>
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/Logo.PNG') }}" alt="Fast Track STEMI Pathway"
                        class="h-10 object-contain">
                    <div>
                        <h1 class="text-blue-600 font-bold text-sm leading-tight logo-text">FAST</h1>
                        <h1 class="text-blue-600 font-bold text-sm leading-tight logo-text">TRACK</h1>
                        <p class="text-teal-600 font-bold text-xs leading-tight logo-text">STEMI</p>
                        <p class="text-teal-600 font-bold text-xs leading-tight logo-text">PATHWAY</p>
                    </div>
                    <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>
            <div id="detailContent" class="p-5 space-y-4">
                {{-- Content will be filled via JavaScript --}}
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 text-center mb-2">Delete Confirmation</h3>
                <p class="text-gray-600 text-center mb-6">Are you sure you want to delete this Code STEMI data?</p>

                <div class="flex gap-3">
                    <button onclick="closeDeleteModal()"
                        class="flex-1 py-3 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-times mr-2"></i>CANCEL
                    </button>
                    <form id="deleteForm" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="handleDeleteSubmit()"
                            class="w-full py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                            <i class="fas fa-trash mr-2"></i>DELETE
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let timers = new Map();
        let detailTimers = new Map();
        let contextMenuItemId = null;
        let autoRefreshInterval = null;
        let searchTimeout;

        document.addEventListener('DOMContentLoaded', function() {
            initializeTimers();
            startAutoRefresh();

            // ==================== PAGINATION FUNCTIONS ====================
            document.getElementById('pageSelect')?.addEventListener('change', function() {
                const page = this.value;
                const url = new URL(window.location.href);
                url.searchParams.set('page', page);
                window.location.href = url.toString();
            });

            // ==================== SEARCH FUNCTION - DIPERBAIKI ====================
            document.getElementById('searchForm').addEventListener('submit', function(e) {
                e.preventDefault();
                performSearch();
            });

            // Real-time search (opsional)
            document.getElementById('searchInput').addEventListener('input', function(e) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    if (this.value.length >= 3 || this.value.length === 0) {
                        performSearch();
                    }
                }, 500);
            });

            // Handle form submission edit
            document.getElementById('editCodeStemiForm')?.addEventListener('submit', async function(e) {
                e.preventDefault();

                const form = this;
                const formData = new FormData(form);
                const url = form.action;

                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')
                                .value,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        showSuccessNotification('Code STEMI data updated successfully');
                        closeEditModal();
                        // Auto refresh after 2 seconds
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    } else {
                        showErrorModal(result.message || 'Error occurred while updating data');
                    }

                } catch (error) {
                    console.error('Error updating data:', error);
                    showErrorModal('Error occurred while updating data');
                }
            });

            // Auto remove notifications after 5 seconds
            setTimeout(() => {
                document.querySelectorAll('.auto-remove-notification').forEach(notification => {
                    notification.remove();
                });
            }, 5000);
        });

        // ==================== SEARCH FUNCTION - DIPERBAIKI ====================
        function performSearch() {
            const searchValue = document.getElementById('searchInput').value;
            const url = new URL(window.location.href);

            if (searchValue) {
                url.searchParams.set('search', searchValue);
            } else {
                url.searchParams.delete('search');
            }

            // Reset to page 1 when searching
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }

        // ==================== FILTER FUNCTIONS - DIPERBAIKI ====================
        function toggleFilterDropdown() {
            const dropdown = document.getElementById('filterDropdown');
            dropdown.classList.toggle('show');
        }

        function applyFilter() {
            const form = document.getElementById('filterForm');
            const formData = new FormData(form);
            const params = new URLSearchParams();

            for (let [key, value] of formData) {
                if (value) {
                    if (key === 'checklist_filter') {
                        // For checklist, add all selected values
                        params.append(key, value);
                    } else {
                        params.append(key, value);
                    }
                }
            }

            // Reset to page 1 when applying filters
            params.append('page', 1);

            // Close filter dropdown
            document.getElementById('filterDropdown').classList.remove('show');

            // Redirect with filter parameters
            window.location.href = '{{ route('code-stemi.index') }}?' + params.toString();
        }

        function resetFilter() {
            document.getElementById('filterForm').reset();
            window.location.href = '{{ route('code-stemi.index') }}';
        }

        function removeFilter(filterName) {
            const url = new URL(window.location.href);
            url.searchParams.delete(filterName);
            // Reset to page 1 when removing filters
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }

        function removeChecklistFilter(checklistItem) {
            const url = new URL(window.location.href);
            const currentChecklist = url.searchParams.getAll('checklist_filter[]');
            const newChecklist = currentChecklist.filter(item => item !== checklistItem);

            url.searchParams.delete('checklist_filter[]');
            newChecklist.forEach(item => {
                url.searchParams.append('checklist_filter[]', item);
            });

            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }

        // Close filter dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const filterBtn = document.querySelector('button[onclick="toggleFilterDropdown()"]');
            const dropdown = document.getElementById('filterDropdown');

            if (filterBtn && dropdown && !filterBtn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });

        // ==================== AUTO REFRESH FUNCTIONS ====================
        function startAutoRefresh() {
            // Refresh every 30 seconds for real-time updates
            autoRefreshInterval = setInterval(() => {
                checkForUpdates();
            }, 30000); // 30 seconds
        }

        function stopAutoRefresh() {
            if (autoRefreshInterval) {
                clearInterval(autoRefreshInterval);
                autoRefreshInterval = null;
            }
        }

        async function checkForUpdates() {
            try {
                const response = await fetch('/code-stemi/stats');
                const result = await response.json();

                if (result.success) {
                    // If there are changes, refresh the page
                    const currentUrl = new URL(window.location.href);
                    if (!currentUrl.searchParams.get('page')) {
                        location.reload();
                    }
                }
            } catch (error) {
                console.log('Auto-refresh check failed:', error);
            }
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
            Swal.fire({
                icon: 'error',
                title: 'Error Occurred',
                text: message,
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'OK'
            });
        }

        // ==================== ACTIVATION CONFIRMATION FUNCTIONS ====================
        function confirmActivation() {
            document.getElementById('activationConfirmModal').classList.remove('hidden');
            document.getElementById('activationConfirmModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeActivationConfirmModal() {
            document.getElementById('activationConfirmModal').classList.add('hidden');
            document.getElementById('activationConfirmModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        function submitActivationForm() {
            document.getElementById('activationForm').submit();
        }

        // ==================== FINISH CONFIRMATION FUNCTIONS ====================
        function confirmFinish(id) {
            document.getElementById('finishForm').action = `/code-stemi/${id}/finish`;
            document.getElementById('finishConfirmModal').classList.remove('hidden');
            document.getElementById('finishConfirmModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeFinishConfirmModal() {
            document.getElementById('finishConfirmModal').classList.add('hidden');
            document.getElementById('finishConfirmModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        async function handleFinishSubmit() {
            const form = document.getElementById('finishForm');
            const formData = new FormData(form);
            const url = form.action;
            const itemId = url.split('/').filter(Boolean).pop();

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    closeFinishConfirmModal();
                    updateTableAfterFinish(itemId);
                    showSuccessNotification(
                        'Code STEMI activation has been successfully completed. Door-to-balloon time has been recorded.'
                    );

                    // Auto refresh after 2 seconds
                    setTimeout(() => {
                        location.reload();
                    }, 2000);

                } else {
                    showErrorModal(result.message || 'Error occurred while completing Code STEMI');
                    closeFinishConfirmModal();
                }
            } catch (error) {
                console.error('Error:', error);
                showErrorModal('Error occurred while completing Code STEMI');
                closeFinishConfirmModal();
            }
        }

        // ==================== DELETE ALL FUNCTIONS ====================
        function confirmDeleteAll() {
            document.getElementById('deleteAllModal').classList.remove('hidden');
            document.getElementById('deleteAllModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteAllModal() {
            document.getElementById('deleteAllModal').classList.add('hidden');
            document.getElementById('deleteAllModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        async function handleDeleteAllSubmit() {
            const form = document.getElementById('deleteAllForm');
            const url = form.action;

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new FormData(form)
                });

                const result = await response.json();

                if (result.success) {
                    closeDeleteAllModal();
                    showSuccessNotification('All Code STEMI data deleted successfully!');

                    // Auto refresh after 1 second
                    setTimeout(() => {
                        location.reload();
                    }, 1000);

                } else {
                    showErrorModal(result.message || 'Error occurred while deleting all data');
                    closeDeleteAllModal();
                }
            } catch (error) {
                console.error('Error:', error);
                showErrorModal('Error occurred while deleting all data');
                closeDeleteAllModal();
            }
        }

        // FUNCTION TO UPDATE TABLE AFTER FINISH
        function updateTableAfterFinish(itemId) {
            const statusBadge = document.querySelector(`tr[data-id="${itemId}"] .status-badge`);
            if (statusBadge) {
                statusBadge.textContent = 'Finished';
                statusBadge.className =
                    'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium status-badge bg-gray-100 text-gray-800';
            }

            const timeElement = document.getElementById(`time-${itemId}`);
            if (timeElement) {
                timeElement.className = 'text-sm font-semibold timer-text text-red-600';
                if (timers.has(itemId)) {
                    clearInterval(timers.get(itemId));
                    timers.delete(itemId);
                }
            }

            const finishButton = document.querySelector(`tr[data-id="${itemId}"] button[onclick*="confirmFinish"]`);
            if (finishButton) {
                finishButton.remove();
            }

            const row = document.querySelector(`tr[data-id="${itemId}"]`);
            if (row) {
                row.setAttribute('data-status', 'Finished');
                row.setAttribute('data-end-time', new Date().toISOString());
            }
        }

        // ==================== DELETE FUNCTIONS ====================
        async function handleDeleteSubmit() {
            const form = document.getElementById('deleteForm');
            const url = form.action;

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new FormData(form)
                });

                const result = await response.json();

                if (result.success) {
                    closeDeleteModal();
                    showSuccessNotification('Code STEMI data deleted successfully!');

                    // Auto refresh after 1 second
                    setTimeout(() => {
                        location.reload();
                    }, 1000);

                } else {
                    showErrorModal(result.message || 'Error occurred while deleting data');
                    closeDeleteModal();
                }
            } catch (error) {
                console.error('Error:', error);
                showErrorModal('Error occurred while deleting data');
                closeDeleteModal();
            }
        }

        // ==================== CONTEXT MENU FUNCTIONS ====================
        function openContextMenu(event, id) {
            event.stopPropagation();
            const menu = document.getElementById('contextMenu');
            contextMenuItemId = id;

            const rect = event.currentTarget.getBoundingClientRect();
            menu.style.left = (rect.left - 120) + 'px';
            menu.style.top = (rect.bottom + 5) + 'px';
            menu.classList.remove('hidden');
        }

        function editFromMenu() {
            const id = contextMenuItemId;
            document.getElementById('contextMenu').classList.add('hidden');
            openEditModal(id);
        }

        function deleteFromMenu() {
            const id = contextMenuItemId;
            document.getElementById('contextMenu').classList.add('hidden');
            confirmDelete(id);
        }

        // ==================== DELETE MODAL FUNCTIONS ====================
        function confirmDelete(id) {
            document.getElementById('deleteForm').action = `/code-stemi/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // ==================== MODAL FUNCTIONS ====================
        function openAddModal() {
            const modal = document.getElementById('addCodeStemiModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeAddModal() {
            const modal = document.getElementById('addCodeStemiModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        function openEditModal(id) {
            loadEditData(id);
            const modal = document.getElementById('editCodeStemiModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            const modal = document.getElementById('editCodeStemiModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        function openDetailModal(id) {
            loadDetailData(id);
            const modal = document.getElementById('detailCodeStemiModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeDetailModal() {
            const modal = document.getElementById('detailCodeStemiModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';

            detailTimers.forEach((timerId) => {
                clearInterval(timerId);
            });
            detailTimers.clear();
        }

        // ==================== TIMER FUNCTIONS ====================
        function initializeTimers() {
            const rows = document.querySelectorAll('tr[data-start-time]');
            rows.forEach(row => {
                const id = row.getAttribute('data-id');
                const startTime = row.getAttribute('data-start-time');
                const status = row.getAttribute('data-status');

                if (status === 'Running') {
                    startTimer(id, startTime);
                }
            });
        }

        function startTimer(id, startTime) {
            const start = new Date(startTime);

            function updateTimer() {
                const now = new Date();
                const diff = Math.max(0, now - start);

                const hours = Math.floor(diff / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                const timeString =
                    `${hours.toString().padStart(2, '0')}h : ${minutes.toString().padStart(2, '0')}m : ${seconds.toString().padStart(2, '0')}s`;

                const timeElement = document.getElementById(`time-${id}`);
                if (timeElement) {
                    timeElement.textContent = timeString;
                }

                if (detailTimers.has(id)) {
                    const detailTimeElement = document.getElementById(`detail-time-${id}`);
                    if (detailTimeElement) {
                        detailTimeElement.textContent = timeString;
                    }
                }
            }

            updateTimer();
            const timerId = setInterval(updateTimer, 1000);
            timers.set(id, timerId);
        }

        function startDetailTimer(id, startTime) {
            const start = new Date(startTime);

            function updateDetailTimer() {
                const now = new Date();
                const diff = Math.max(0, now - start);

                const hours = Math.floor(diff / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                const timeString =
                    `${hours.toString().padStart(2, '0')}h : ${minutes.toString().padStart(2, '0')}m : ${seconds.toString().padStart(2, '0')}s`;

                const detailTimeElement = document.getElementById(`detail-time-${id}`);
                if (detailTimeElement) {
                    detailTimeElement.textContent = timeString;
                }
            }

            updateDetailTimer();
            const timerId = setInterval(updateDetailTimer, 1000);
            detailTimers.set(id, timerId);
        }

        // ==================== DATA LOADING FUNCTIONS ====================
        async function loadEditData(id) {
            try {
                const response = await fetch(`/code-stemi/${id}/edit`);
                const data = await response.json();

                document.getElementById('editCodeStemiForm').action = `/code-stemi/${id}`;

                const checkboxes = document.querySelectorAll('.edit-checklist');

                console.log('Data dari server:', data);
                console.log('Checklist data:', data.checklist);

                // Reset semua checkbox terlebih dahulu
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });

                // Centang checkbox yang sesuai dengan data
                if (data.checklist && Array.isArray(data.checklist)) {
                    checkboxes.forEach(checkbox => {
                        // Cek apakah value checkbox ada dalam data checklist
                        if (data.checklist.includes(checkbox.value)) {
                            checkbox.checked = true;
                            console.log('Checked checkbox with value:', checkbox.value);
                        }
                    });
                }

                document.getElementById('editCustomMessage').value = data.custom_message || '';

            } catch (error) {
                console.error('Error loading edit data:', error);
                showErrorModal('Failed to load data for editing');
            }
        }

        async function loadDetailData(id) {
            try {
                const response = await fetch(`/code-stemi/${id}`);
                const data = await response.json();

                // Format checklist items - SEMUA 6 ITEM
                const checklistItems = ['Anamnesis', 'Rongten Thorax', 'Laboratorium', 'EKG', 'Pemeriksaan Fisik',
                    'Informed Consent'
                ];

                let checklistHTML = '';
                checklistItems.forEach(item => {
                    const isChecked = data.checklist && data.checklist.includes(item);
                    checklistHTML += `
                    <label class="flex items-center gap-2">
                        <input type="checkbox" ${isChecked ? 'checked' : ''} disabled 
                            class="w-4 h-4 text-blue-600 rounded border-gray-300">
                        <span class="text-sm text-gray-700 ${isChecked ? 'font-medium' : 'text-gray-400'}">
                            ${item}
                        </span>
                    </label>
                `;
                });

                // Format waktu
                const doorToBalloonTime = data.door_to_balloon_time || '00h : 00m : 00s';

                document.getElementById('detailContent').innerHTML = `
                <div class="space-y-4">
                    <!-- Checklist Section -->
                    <div>
                        <h4 class="text-sm font-semibold text-gray-800 mb-3">Checklist Registrasi</h4>
                        <div class="grid grid-cols-2 gap-2">
                            ${checklistHTML}
                        </div>
                    </div>

                    <!-- Broadcast Message Section -->
                    <div class="border-t pt-4">
                        <h4 class="text-sm font-semibold text-gray-800 mb-2">Pesan Broadcast</h4>
                        <p class="text-xs text-gray-600 mb-2">Fast Track STEMI Pathway</p>
                        <div class="bg-blue-50 rounded-lg p-3 space-y-1 border border-blue-200">
                            <p class="text-xs text-blue-900 font-semibold">CODE STEMI AKTIF</p>
                            <p class="text-xs text-blue-800">Pasien STEMI telah berada di IGD RS Otak M Hatta Bukittinggi.</p>
                            <p class="text-xs text-blue-800">Seluruh unit terkait dimohon segera siaga.</p>
                            <p class="text-xs text-blue-800">Fast Track STEMI Pathway aktif.</p>
                            <p class="text-xs text-blue-800">Waktu Door-to-balloon dimulai.</p>
                            ${data.custom_message ? `
                                    <div class="mt-2 pt-2 border-t border-blue-200">
                                        <p class="text-xs text-blue-900 font-semibold">Pesan Tambahan:</p>
                                        <p class="text-xs text-blue-800">${data.custom_message}</p>
                                    </div>
                                ` : ''}
                        </div>
                    </div>

                    <!-- Door-to-Balloon Time Section -->
                    <div class="bg-white border border-gray-200 rounded-lg p-4 text-center">
                        <p class="text-sm font-semibold text-gray-800 mb-2">DOOR TO BALLOON TIME</p>
                        <div id="detail-time-${data.id}" class="text-3xl font-bold text-blue-600 tracking-wider timer-text">
                            ${doorToBalloonTime}
                        </div>
                    </div>

                    <!-- Complete Button untuk status Running -->
                    ${data.status === 'Running' ? `
                            <button onclick="confirmFinish(${data.id})" 
                                class="w-full py-2.5 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition text-sm">
                                COMPLETE CODE STEMI ACTIVATION
                            </button>
                        ` : ''}
                </div>
            `;

                // Jika status Running, mulai timer
                if (data.status === 'Running') {
                    startDetailTimer(data.id, data.start_time);
                }

            } catch (error) {
                console.error('Error loading detail:', error);
                showErrorModal('Gagal memuat data detail');
            }
        }

        // ==================== EVENT LISTENERS ====================
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('contextMenu');
            if (menu && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }

            const modals = [
                'addCodeStemiModal', 'activationConfirmModal', 'finishConfirmModal',
                'editCodeStemiModal', 'detailCodeStemiModal', 'deleteModal', 'deleteAllModal'
            ];

            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (modal && e.target === modal) {
                    closeAllModals();
                }
            });
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAllModals();
                document.getElementById('contextMenu').classList.add('hidden');
                document.getElementById('filterDropdown').classList.remove('show');
            }
        });

        function closeAllModals() {
            const modals = [
                'addCodeStemiModal', 'activationConfirmModal', 'finishConfirmModal',
                'editCodeStemiModal', 'detailCodeStemiModal', 'deleteModal', 'deleteAllModal'
            ];

            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            });
            document.body.style.overflow = 'auto';
        }

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            stopAutoRefresh();
            timers.forEach((timerId) => {
                clearInterval(timerId);
            });
            detailTimers.forEach((timerId) => {
                clearInterval(timerId);
            });
        });
    </script>
</body>

</html>
