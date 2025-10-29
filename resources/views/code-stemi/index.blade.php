<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Track STEMI Pathway - Code STEMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <a href="{{ route('code-stemi.index') }}" class="flex items-center gap-3 px-6 py-3 bg-blue-50 text-blue-600 border-l-4 border-blue-600">
                    <i class="fas fa-file-medical-alt w-5"></i><span class="font-medium">Code STEMI</span>
                </a>
                <a href="{{ route('setting.index') }}" class="flex items-center gap-3 px-6 py-3 text-gray-500 hover:bg-gray-50">
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
                        <form id="searchForm" method="GET" action="{{ route('data-nakes.index') }}"
                            class="relative flex items-center">
                            <input type="text" name="search" id="searchInput" placeholder="Search type of keywords"
                                value="{{ request('search') }}"
                                class="w-80 pl-4 pr-10 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent text-sm transition-all duration-200" />
                            <button type="submit"
                                class="absolute right-3 text-gray-400 hover:text-blue-600 transition-all duration-150">
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

            {{-- Code STEMI Content --}}
            <div class="p-8">
                {{-- Notifikasi --}}
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Code STEMI</h2>
                    <div class="flex gap-3">
                        <button onclick="openAddModal()" class="flex items-center gap-2 px-5 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-medium text-sm">
                            <i class="fas fa-plus"></i>Add Data
                        </button>
                        
                        <!-- Tombol Filter dengan Dropdown -->
                        <div class="relative">
                            <button onclick="toggleFilterDropdown()" class="flex items-center gap-2 px-5 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm">
                                <i class="fas fa-sliders-h"></i>Filter
                                <i class="fas fa-chevron-down text-xs ml-1"></i>
                            </button>
                            
                            <!-- Dropdown Filter -->
                            <div id="filterDropdown" class="filter-dropdown absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 z-10">
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Code STEMI</h3>
                                    
                                    <form id="filterForm" class="space-y-4">
                                        <!-- Status Filter -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                            <select name="status" id="filterStatus" 
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                                <option value="">Semua Status</option>
                                                <option value="Running" {{ request('status') == 'Running' ? 'selected' : '' }}>Running</option>
                                                <option value="Finished" {{ request('status') == 'Finished' ? 'selected' : '' }}>Finished</option>
                                            </select>
                                        </div>
                                        
                                        <!-- Date Range Filter -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Rentang Tanggal</label>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div>
                                                    <input type="date" name="start_date" id="filterStartDate" 
                                                        value="{{ request('start_date') }}"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                                    <label class="text-xs text-gray-500 mt-1">Dari Tanggal</label>
                                                </div>
                                                <div>
                                                    <input type="date" name="end_date" id="filterEndDate" 
                                                        value="{{ request('end_date') }}"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                                    <label class="text-xs text-gray-500 mt-1">Sampai Tanggal</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Search Filter -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                                            <input type="text" name="search" id="filterSearch" 
                                                value="{{ request('search') }}"
                                                placeholder="Cari berdasarkan data..."
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                        </div>
                                        
                                        <!-- Action Buttons -->
                                        <div class="flex gap-2 pt-2">
                                            <button type="button" onclick="applyFilter()" 
                                                class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition font-medium text-sm">
                                                Terapkan Filter
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

                <!-- Filter Active Badges -->
                <div id="activeFilters" class="mb-6 flex flex-wrap gap-2">
                    @if(request('status'))
                        <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full flex items-center gap-1">
                            Status: {{ request('status') }}
                            <button onclick="removeFilter('status')" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </span>
                    @endif
                    @if(request('start_date'))
                        <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full flex items-center gap-1">
                            Dari: {{ request('start_date') }}
                            <button onclick="removeFilter('start_date')" class="text-green-600 hover:text-green-800">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </span>
                    @endif
                    @if(request('end_date'))
                        <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full flex items-center gap-1">
                            Sampai: {{ request('end_date') }}
                            <button onclick="removeFilter('end_date')" class="text-green-600 hover:text-green-800">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </span>
                    @endif
                    @if(request('search'))
                        <span class="bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full flex items-center gap-1">
                            Pencarian: "{{ request('search') }}"
                            <button onclick="removeFilter('search')" class="text-purple-600 hover:text-purple-800">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </span>
                    @endif
                </div>

                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    @if(isset($data) && $data->count() > 0)
                        <table class="w-full">
                            <thead>
                                <tr class="bg-white">
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">ADMITTED</th>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">STATUS</th>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">DOOR TO BALLOON TIME</th>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">ACTION</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody id="codeStemiTableBody">
                                @foreach ($data as $index => $item)
                                    <tr class="border-t border-gray-100 {{ $index % 2 == 0 ? 'bg-cyan-light' : 'bg-white' }}" 
                                        data-id="{{ $item->id }}" 
                                        data-start-time="{{ $item->start_time->toISOString() }}" 
                                        data-status="{{ $item->status }}" 
                                        data-end-time="{{ $item->end_time ? $item->end_time->toISOString() : '' }}">
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $item->formatted_date }}</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $item->status === 'Running' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span id="time-{{ $item->id }}" class="text-sm font-semibold {{ $item->status === 'Finished' ? 'text-red-600' : 'text-blue-600' }}">
                                                {{ $item->door_to_balloon_time }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <button onclick="openDetailModal({{ $item->id }})" class="px-3 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600 transition font-medium">Detail</button>
                                                @if ($item->status === 'Running')
                                                    <form action="{{ route('code-stemi.finish', $item->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition font-medium whitespace-nowrap" 
                                                                onclick="return confirm('Apakah Anda yakin ingin menyelesaikan Code STEMI ini?')">
                                                            Aktivasi Code Stemi Selesai
                                                        </button>
                                                    </form>
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
                            $currentPage = request('page', 1);
                            $totalItems = $data->total();
                            $perPage = $data->perPage();
                            $totalPages = $data->lastPage();
                            $prevPage = $data->currentPage() > 1 ? $data->currentPage() - 1 : null;
                            $nextPage = $data->currentPage() < $totalPages ? $data->currentPage() + 1 : null;
                            
                            // Build URL dengan parameter yang ada
                            $baseUrl = request()->url();
                            $queryParams = request()->except('page');
                        @endphp

                        <div class="border-t border-gray-200 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1">
                                    {{-- Previous Button --}}
                                    <a href="{{ $prevPage ? $baseUrl . '?' . http_build_query(array_merge($queryParams, ['page' => $prevPage])) : '#' }}" 
                                       class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded transition text-sm flex items-center gap-2 {{ !$prevPage ? 'pagination-disabled' : '' }}">
                                        <i class="fas fa-chevron-left text-xs"></i>Previous
                                    </a>

                                    {{-- Page Numbers --}}
                                    @php
                                        $startPage = max($currentPage - 2, 1);
                                        $endPage = min($currentPage + 2, $totalPages);
                                        
                                        // Adjust start and end if we're near the beginning or end
                                        if ($endPage - $startPage < 4) {
                                            if ($startPage == 1) {
                                                $endPage = min($startPage + 4, $totalPages);
                                            } else if ($endPage == $totalPages) {
                                                $startPage = max($endPage - 4, 1);
                                            }
                                        }
                                    @endphp
                                    
                                    @if($startPage > 1)
                                        <a href="{{ $baseUrl . '?' . http_build_query(array_merge($queryParams, ['page' => 1])) }}" 
                                           class="px-3 py-2 text-gray-700 hover:bg-gray-100 rounded transition text-sm min-w-[40px] text-center">1</a>
                                        @if($startPage > 2)
                                            <span class="px-2 text-gray-400 text-sm">...</span>
                                        @endif
                                    @endif
                                    
                                    @for ($i = $startPage; $i <= $endPage; $i++)
                                        <a href="{{ $baseUrl . '?' . http_build_query(array_merge($queryParams, ['page' => $i])) }}" 
                                           class="px-3 py-2 rounded font-medium text-sm min-w-[40px] text-center {{ $i == $currentPage ? 'bg-blue-500 text-white pagination-active' : 'text-gray-700 hover:bg-gray-100' }}">
                                            {{ $i }}
                                        </a>
                                    @endfor
                                    
                                    @if($endPage < $totalPages)
                                        @if($endPage < $totalPages - 1)
                                            <span class="px-2 text-gray-400 text-sm">...</span>
                                        @endif
                                        <a href="{{ $baseUrl . '?' . http_build_query(array_merge($queryParams, ['page' => $totalPages])) }}" 
                                           class="px-3 py-2 text-gray-700 hover:bg-gray-100 rounded transition text-sm min-w-[40px] text-center">{{ $totalPages }}</a>
                                    @endif

                                    {{-- Next Button --}}
                                    <a href="{{ $nextPage ? $baseUrl . '?' . http_build_query(array_merge($queryParams, ['page' => $nextPage])) : '#' }}" 
                                       class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded transition text-sm flex items-center gap-2 {{ !$nextPage ? 'pagination-disabled' : '' }}">
                                        Next<i class="fas fa-chevron-right text-xs"></i>
                                    </a>
                                </div>

                                {{-- Right: Export and Page Info --}}
                                <div class="flex items-center gap-4">
                                    {{-- Export Button --}}
                                    <button class="flex items-center gap-2 px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700 transition font-medium text-sm">
                                        <i class="fas fa-download"></i>Export
                                    </button>
                                    
                                    {{-- Page Info --}}
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <span>Page</span>
                                        <div class="relative">
                                            <select id="pageSelect" class="appearance-none bg-white border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:border-blue-500">
                                                @for($i = 1; $i <= $totalPages; $i++)
                                                    <option value="{{ $i }}" {{ $i == $currentPage ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                                <i class="fas fa-chevron-down text-xs"></i>
                                            </div>
                                        </div>
                                        <span>of {{ $totalPages }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-file-alt text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg">Belum ada data Code STEMI</p>
                            @if(request()->anyFilled(['status', 'start_date', 'end_date', 'search']))
                                <p class="text-gray-400 text-sm mt-2">Tidak ada data yang sesuai dengan filter</p>
                                <button onclick="resetFilter()" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    Reset Filter
                                </button>
                            @else
                                <button onclick="openAddModal()" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    <i class="fas fa-plus"></i> Aktivasi Code STEMI Pertama
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    {{-- Context Menu --}}
    <div id="contextMenu" class="fixed hidden bg-white shadow-lg rounded-lg py-2 z-50 border border-gray-200" style="min-width: 140px;">
        <button onclick="editFromMenu()" class="w-full text-left px-4 py-2 hover:bg-gray-50 text-sm text-gray-700 flex items-center gap-2">
            <i class="fas fa-edit text-blue-500 w-4"></i>Edit
        </button>
        <button onclick="deleteFromMenu()" class="w-full text-left px-4 py-2 hover:bg-gray-50 text-sm text-gray-700 flex items-center gap-2">
            <i class="fas fa-trash-alt text-red-500 w-4"></i>Hapus
        </button>
    </div>

    {{-- Modal Add Data --}}
    <div id="addCodeStemiModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all">
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-800">REGISTRASI CODE STEMI</h3>
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/Logo.PNG') }}" alt="Fast Track STEMI Pathway" class="h-10 object-contain">
                    <div>
                        <h1 class="text-blue-600 font-bold text-sm leading-tight">FAST</h1>
                        <h1 class="text-blue-600 font-bold text-sm leading-tight">TRACK</h1>
                        <p class="text-teal-600 font-bold text-xs leading-tight">STEMI</p>
                        <p class="text-teal-600 font-bold text-xs leading-tight">PATHWAY</p>
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
                            @php
                                $checklistItems = [
                                    'Anamnesis' => 'Anamnesis',
                                    'EKG' => 'EKG', 
                                    'Rongten Thorax' => 'Rongten Thorax',
                                    'Pemeriksaan Fisik' => 'Pemeriksaan Fisik',
                                    'Laboratorium' => 'Laboratorium',
                                    'Informed Consent' => 'Informed Consent'
                                ];
                            @endphp
                            
                            @foreach($checklistItems as $key => $label)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="checklist[]" value="{{ $key }}" 
                                           class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Custom Message Section --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Pesan Custom Broadcast</label>
                        <p class="text-xs text-gray-600 mb-2">Fast Track STEMI Pathway</p>

                        <div class="bg-gray-100 rounded-lg p-3 space-y-1 mb-2">
                            <p class="text-xs text-gray-700 font-semibold">CODE STEMI AKTIF</p>
                            <p class="text-xs text-gray-600">Pasien STEMI telah berada di IGD RS Otak M Hatta Bukittinggi.</p>
                            <p class="text-xs text-gray-600">Seluruh unit terkait dimohon segera siaga.</p>
                            <p class="text-xs text-gray-600">Fast Track STEMI Pathway aktif.</p>
                            <p class="text-xs text-gray-600">Waktu Door-to-balloon dimulai.</p>
                        </div>

                        <textarea name="custom_message" 
                                  placeholder="Tambahkan pesan custom disini (opsional)"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm"
                                  rows="2"></textarea>
                        <p class="text-xs text-gray-400 italic mt-1">Pesan ini akan ditambahkan di akhir broadcast</p>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" 
                            class="w-full py-2.5 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition text-sm"
                            onclick="return confirm('Apakah Anda yakin ingin mengaktifkan Code STEMI?')">
                        AKTIVASI CODE STEMI DIMULAI
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit Data --}}
    <div id="editCodeStemiModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all">
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-800">EDIT CODE STEMI</h3>
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/Logo.PNG') }}" alt="Fast Track STEMI Pathway" class="h-10 object-contain">
                   <div>
                        <h1 class="text-blue-600 font-bold text-sm leading-tight">FAST</h1>
                        <h1 class="text-blue-600 font-bold text-sm leading-tight">TRACK</h1>
                        <p class="text-teal-600 font-bold text-xs leading-tight">STEMI</p>
                        <p class="text-teal-600 font-bold text-xs leading-tight">PATHWAY</p>
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
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Checklist Registrasi</label>
                        <div class="grid grid-cols-2 gap-2" id="editChecklistContainer">
                            @php
                                $checklistItems = [
                                    'Anamnesis' => 'Anamnesis',
                                    'EKG' => 'EKG', 
                                    'Rongten Thorax' => 'Rongten Thorax',
                                    'Pemeriksaan Fisik' => 'Pemeriksaan Fisik',
                                    'Laboratorium' => 'Laboratorium',
                                    'Informed Consent' => 'Informed Consent'
                                ];
                            @endphp
                            
                            @foreach($checklistItems as $key => $label)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="checklist[]" value="{{ $key }}" 
                                           class="edit-checklist w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Custom Message Section --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Pesan Custom Broadcast</label>
                        <p class="text-xs text-gray-600 mb-2">Fast Track STEMI Pathway</p>

                        <div class="bg-gray-100 rounded-lg p-3 space-y-1 mb-2">
                            <p class="text-xs text-gray-700 font-semibold">CODE STEMI AKTIF</p>
                            <p class="text-xs text-gray-600">Pasien STEMI telah berada di IGD RS Otak M Hatta Bukittinggi.</p>
                            <p class="text-xs text-gray-600">Seluruh unit terkait dimohon segera siaga.</p>
                            <p class="text-xs text-gray-600">Fast Track STEMI Pathway aktif.</p>
                            <p class="text-xs text-gray-600">Waktu Door-to-balloon dimulai.</p>
                        </div>

                        <textarea name="custom_message" id="editCustomMessage" 
                                  placeholder="Tambahkan pesan custom disini (opsional)"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm"
                                  rows="2"></textarea>
                        <p class="text-xs text-gray-400 italic mt-1">Pesan ini akan ditambahkan di akhir broadcast</p>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" 
                            class="w-full py-2.5 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition text-sm">
                        UPDATE CODE STEMI
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Detail Data --}}
    <div id="detailCodeStemiModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all">
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-800">DETAIL CODE STEMI</h3>
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/Logo.PNG') }}" alt="Fast Track STEMI Pathway" class="h-10 object-contain">
                     <div>
                        <h1 class="text-blue-600 font-bold text-sm leading-tight">FAST</h1>
                        <h1 class="text-blue-600 font-bold text-sm leading-tight">TRACK</h1>
                        <p class="text-teal-600 font-bold text-xs leading-tight">STEMI</p>
                        <p class="text-teal-600 font-bold text-xs leading-tight">PATHWAY</p>
                    </div>
                    <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>
            <div id="detailContent" class="p-5 space-y-4">
                {{-- Content akan diisi via JavaScript --}}
            </div>
        </div>
    </div>

    <script>
        let timers = new Map();
        let detailTimers = new Map();
        let contextMenuItemId = null;

        document.addEventListener('DOMContentLoaded', function() {
            initializeTimers();

            // ==================== PAGINATION FUNCTIONS ====================
            
            // Handle page select change
            document.getElementById('pageSelect').addEventListener('change', function() {
                const page = this.value;
                const url = new URL(window.location.href);
                url.searchParams.set('page', page);
                window.location.href = url.toString();
            });

            // ==================== SEARCH FUNCTION ====================
            
            // Handle search form submission
            document.getElementById('searchForm').addEventListener('submit', function(e) {
                e.preventDefault();
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
            });

            // Handle form submission edit
            document.getElementById('editCodeStemiForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const form = this;
                const formData = new FormData(form);
                const url = form.action;
                
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
                        alert(result.message);
                        closeEditModal();
                        location.reload();
                    } else {
                        alert(result.message);
                    }
                    
                } catch (error) {
                    console.error('Error updating data:', error);
                    alert('Terjadi kesalahan saat mengupdate data');
                }
            });
        });

        // ==================== FILTER FUNCTIONS ====================
        
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
                    params.append(key, value);
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
            // Reset form
            document.getElementById('filterForm').reset();
            // Redirect without parameters
            window.location.href = '{{ route('code-stemi.index') }}';
        }

        function removeFilter(filterName) {
            const url = new URL(window.location.href);
            url.searchParams.delete(filterName);
            // Reset to page 1 when removing filters
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
                
                const timeString = `${hours.toString().padStart(2, '0')}h : ${minutes.toString().padStart(2, '0')}m : ${seconds.toString().padStart(2, '0')}s`;
                
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

        // FUNGSI CONTEXT MENU
        function openContextMenu(event, id) {
            event.stopPropagation();
            const menu = document.getElementById('contextMenu');
            contextMenuItemId = id;
            
            // Position menu at button
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
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/code-stemi/${id}`;
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]') || 
                                 document.querySelector('input[name="_token"]');
                const tokenValue = csrfToken ? csrfToken.content || csrfToken.value : '';
                
                form.innerHTML = `
                    <input type="hidden" name="_token" value="${tokenValue}">
                    <input type="hidden" name="_method" value="DELETE">
                `;
                
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Close context menu when clicking outside
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('contextMenu');
            if (menu && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        // FUNGSI MODAL ADD
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

        // FUNGSI MODAL EDIT
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

        // FUNGSI MODAL DETAIL
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

        // LOAD DATA UNTUK EDIT
        async function loadEditData(id) {
            try {
                const response = await fetch(`/code-stemi/${id}/edit`);
                const data = await response.json();
                
                // Set form action
                document.getElementById('editCodeStemiForm').action = `/code-stemi/${id}`;
                
                // Set checklist
                const checkboxes = document.querySelectorAll('.edit-checklist');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = data.checklist && data.checklist.includes(checkbox.value);
                });
                
                // Set custom message
                document.getElementById('editCustomMessage').value = data.custom_message || '';
                
            } catch (error) {
                console.error('Error loading edit data:', error);
                alert('Gagal memuat data untuk edit');
            }
        }

        // LOAD DATA UNTUK DETAIL
        async function loadDetailData(id) {
            try {
                const response = await fetch(`/code-stemi/${id}`);
                const data = await response.json();
                
                const checklistItems = ['Anamnesis', 'EKG', 'Rongten Thorax', 'Pemeriksaan Fisik', 'Laboratorium', 'Informed Consent'];
                let checklistHTML = '';
                
                checklistItems.forEach(item => {
                    const isChecked = data.checklist && data.checklist.includes(item);
                    checklistHTML += `
                        <label class="flex items-center gap-2">
                            <input type="checkbox" ${isChecked ? 'checked' : ''} disabled class="w-4 h-4 text-blue-600 rounded border-gray-300">
                            <span class="text-sm text-gray-700 ${isChecked ? 'font-medium' : 'text-gray-400'}">${item}</span>
                        </label>
                    `;
                });

                document.getElementById('detailContent').innerHTML = `
                    <div class="grid grid-cols-2 gap-2">
                        ${checklistHTML}
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Pesan Broadcast</label>
                        <p class="text-xs text-gray-600 mb-2">Fast Track STEMI Pathway</p>
                        <div class="bg-blue-50 rounded-lg p-3 space-y-1">
                            <p class="text-xs text-blue-900 font-semibold">CODE STEMI AKTIF</p>
                            <p class="text-xs text-blue-800">Pasien STEMI telah berada di IGD RS Otak M Hatta Bukittinggi.</p>
                            <p class="text-xs text-blue-800">Seluruh unit terkait dimohon segera siaga.</p>
                            <p class="text-xs text-blue-800">Fast Track STEMI Pathway aktif.</p>
                            <p class="text-xs text-blue-800">Waktu Door-to-balloon dimulai.</p>
                            ${data.custom_message ? `<p class="text-xs text-blue-800 mt-2 font-semibold">Pesan Tambahan:</p><p class="text-xs text-blue-800">${data.custom_message}</p>` : ''}
                        </div>
                        <p class="text-xs text-gray-400 italic mt-1">Dapat menambahkan custom messages disini</p>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg p-4 text-center">
                        <p class="text-sm font-semibold text-gray-800 mb-2">DOOR TO BALLOON TIME</p>
                        <div id="detail-time-${data.id}" class="text-3xl font-bold text-blue-600 tracking-wider">${data.door_to_balloon_time}</div>
                    </div>

                    ${data.status === 'Running' ? `
                    <form action="/code-stemi/${id}/finish" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <button type="submit" class="w-full py-2.5 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition text-sm" 
                                onclick="return confirm('Apakah Anda yakin ingin menyelesaikan Code STEMI ini?')">
                            AKTIVASI CODE STEMI SELESAI
                        </button>
                    </form>
                    ` : ''}
                `;

                if (data.status === 'Running') {
                    startDetailTimer(data.id, data.start_time);
                }

            } catch (error) {
                console.error('Error loading detail:', error);
                alert('Gagal memuat detail data');
            }
        }

        function startDetailTimer(id, startTime) {
            const start = new Date(startTime);
            
            function updateDetailTimer() {
                const now = new Date();
                const diff = Math.max(0, now - start);
                
                const hours = Math.floor(diff / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                
                const timeString = `${hours.toString().padStart(2, '0')}h : ${minutes.toString().padStart(2, '0')}m : ${seconds.toString().padStart(2, '0')}s`;
                
                const detailTimeElement = document.getElementById(`detail-time-${id}`);
                if (detailTimeElement) {
                    detailTimeElement.textContent = timeString;
                }
            }
            
            updateDetailTimer();
            const timerId = setInterval(updateDetailTimer, 1000);
            detailTimers.set(id, timerId);
        }

        // EVENT LISTENER UNTUK CLOSE MODAL
        document.addEventListener('click', function(e) {
            const addModal = document.getElementById('addCodeStemiModal');
            if (e.target === addModal) {
                closeAddModal();
            }
            
            const editModal = document.getElementById('editCodeStemiModal');
            if (e.target === editModal) {
                closeEditModal();
            }
            
            const detailModal = document.getElementById('detailCodeStemiModal');
            if (e.target === detailModal) {
                closeDetailModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAddModal();
                closeEditModal();
                closeDetailModal();
                document.getElementById('contextMenu').classList.add('hidden');
                document.getElementById('filterDropdown').classList.remove('show');
            }
        });
    </script>
</body>
</html>