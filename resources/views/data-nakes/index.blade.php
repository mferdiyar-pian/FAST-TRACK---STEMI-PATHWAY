{{-- resources/views/data-nakes/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Track STEMI Pathway - Data Nakes</title>

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
                    <img src="{{ asset('images/Logo.PNG') }}" alt="Fast Track STEMI Pathway"
                        class="h-14 w-14 object-contain">
                    <div>
                        <h1 class="text-blue-600 font-bold text-sm leading-tight">FAST</h1>
                        <h1 class="text-blue-600 font-bold text-sm leading-tight">TRACK</h1>
                        <p class="text-teal-600 font-bold text-xs leading-tight">STEMI</p>
                        <p class="text-teal-600 font-bold text-xs leading-tight">PATHWAY</p>
                    </div>
                </div>
            </div>

            <nav class="mt-8">
                <a href="{{ route('dashboard.index') }}"
                    class="flex items-center gap-3 px-6 py-3 text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-th-large w-5"></i><span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('data-nakes.index') }}"
                    class="flex items-center gap-3 px-6 py-3 bg-blue-50 text-blue-600 border-l-4 border-blue-600">
                    <i class="fas fa-user-md w-5"></i><span class="font-medium">Data Nakes</span>
                </a>
                <a href="{{ route('code-stemi.index') }}"
                    class="flex items-center gap-3 px-6 py-3 text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-file-medical-alt w-5"></i><span class="font-medium">Code STEMI</span>
                </a>
                <a href="{{ route('setting.index') }}"
                    class="flex items-center gap-3 px-6 py-3 text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-cog w-5"></i><span class="font-medium">Setting</span>
                </a>
            </nav>
        </aside>

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

            <div class="p-8">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                        <button onclick="this.parentElement.style.display='none'"
                            class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6"
                        role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                        <button onclick="this.parentElement.style.display='none'"
                            class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Data Nakes</h2>
                    <div class="flex gap-3">
                        <button onclick="openModal('add')"
                            class="flex items-center gap-2 px-5 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-medium text-sm">
                            <i class="fas fa-plus"></i>Add Data
                        </button>

                        <!-- Tombol Filter dengan Dropdown -->
                        <div class="relative">
                            <button onclick="toggleFilterDropdown()"
                                class="flex items-center gap-2 px-5 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm">
                                <i class="fas fa-sliders-h"></i>Filter
                                <i class="fas fa-chevron-down text-xs ml-1"></i>
                            </button>

                            <!-- Dropdown Filter -->
                            <div id="filterDropdown"
                                class="filter-dropdown absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 z-10">
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Data Nakes</h3>

                                    <form id="filterForm" class="space-y-4">
                                        <!-- Status Filter -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                            <select name="status" id="filterStatus"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                                <option value="">Semua Status</option>
                                                <option value="Dokter"
                                                    {{ request('status') == 'Dokter' ? 'selected' : '' }}>Dokter
                                                </option>
                                                <option value="Perawat"
                                                    {{ request('status') == 'Perawat' ? 'selected' : '' }}>Perawat
                                                </option>
                                                <option value="Laboran"
                                                    {{ request('status') == 'Laboran' ? 'selected' : '' }}>Laboran
                                                </option>
                                            </select>
                                        </div>

                                        <!-- Date Range Filter -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Rentang
                                                Tanggal</label>
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
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian
                                                Nama</label>
                                            <input type="text" name="search" id="filterSearch"
                                                value="{{ request('search') }}"
                                                placeholder="Cari berdasarkan nama..."
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
                    @if (request('status'))
                        <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full flex items-center gap-1">
                            Status: {{ request('status') }}
                            <button onclick="removeFilter('status')" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </span>
                    @endif
                    @if (request('start_date'))
                        <span
                            class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full flex items-center gap-1">
                            Dari: {{ request('start_date') }}
                            <button onclick="removeFilter('start_date')" class="text-green-600 hover:text-green-800">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </span>
                    @endif
                    @if (request('end_date'))
                        <span
                            class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full flex items-center gap-1">
                            Sampai: {{ request('end_date') }}
                            <button onclick="removeFilter('end_date')" class="text-green-600 hover:text-green-800">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </span>
                    @endif
                    @if (request('search'))
                        <span
                            class="bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full flex items-center gap-1">
                            Pencarian: "{{ request('search') }}"
                            <button onclick="removeFilter('search')" class="text-purple-600 hover:text-purple-800">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </span>
                    @endif
                </div>

                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-white">
                                <th
                                    class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    ADMITTED</th>
                                <th
                                    class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    NAMA</th>
                                <th
                                    class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    STATUS</th>
                                <th
                                    class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    CONTACT</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data_nakes as $index => $item)
                                <tr
                                    class="border-t border-gray-100 {{ $index % 2 == 0 ? 'bg-cyan-light' : 'bg-white' }}">
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ \Carbon\Carbon::parse($item->admitted_date)->format('d M, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $item->nama }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $item->status }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="inline-flex items-center gap-2 text-sm text-gray-700">
                                                <span class="w-2 h-2 bg-purple-600 rounded-full"></span>
                                                {{ $item->contact }}
                                            </span>
                                            <a href="https://wa.me/62{{ substr($item->contact, 1) }}" target="_blank"
                                                class="text-gray-400 hover:text-green-600 transition">
                                                <i class="fas fa-phone-alt text-base"></i>
                                            </a>
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
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-2 block"></i>
                                        @if (request()->anyFilled(['status', 'start_date', 'end_date', 'search']))
                                            Tidak ada data yang sesuai dengan filter
                                        @else
                                            Tidak ada data nakes
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <div class="border-t border-gray-200 px-6 py-4">
                        <div class="flex items-center justify-between">
                            {{-- Left: Pagination Navigation --}}
                            <div class="flex items-center gap-1">
                                {{-- Previous Button --}}
                                @php
                                    $currentPage = request('page', 1);
                                    $totalItems = count($data_nakes);
                                    $perPage = 10; // Sesuaikan dengan jumlah item per halaman
                                    $totalPages = ceil($totalItems / $perPage);
                                    $prevPage = $currentPage > 1 ? $currentPage - 1 : null;
                                    $nextPage = $currentPage < $totalPages ? $currentPage + 1 : null;

                                    // Build URL dengan parameter yang ada
                                    $baseUrl = request()->url();
                                    $queryParams = request()->except('page');
                                @endphp

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
                                        } elseif ($endPage == $totalPages) {
                                            $startPage = max($endPage - 4, 1);
                                        }
                                    }
                                @endphp

                                @if ($startPage > 1)
                                    <a href="{{ $baseUrl . '?' . http_build_query(array_merge($queryParams, ['page' => 1])) }}"
                                        class="px-3 py-2 text-gray-700 hover:bg-gray-100 rounded transition text-sm min-w-[40px] text-center">1</a>
                                    @if ($startPage > 2)
                                        <span class="px-2 text-gray-400 text-sm">...</span>
                                    @endif
                                @endif

                                @for ($i = $startPage; $i <= $endPage; $i++)
                                    <a href="{{ $baseUrl . '?' . http_build_query(array_merge($queryParams, ['page' => $i])) }}"
                                        class="px-3 py-2 rounded font-medium text-sm min-w-[40px] text-center {{ $i == $currentPage ? 'bg-blue-500 text-white pagination-active' : 'text-gray-700 hover:bg-gray-100' }}">
                                        {{ $i }}
                                    </a>
                                @endfor

                                @if ($endPage < $totalPages)
                                    @if ($endPage < $totalPages - 1)
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
                                <button
                                    class="flex items-center gap-2 px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700 transition font-medium text-sm">
                                    <i class="fas fa-download"></i>Export
                                </button>

                                {{-- Page Info --}}
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <span>Page</span>
                                    <div class="relative">
                                        <select id="pageSelect"
                                            class="appearance-none bg-white border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:border-blue-500">
                                            @for ($i = 1; $i <= $totalPages; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $i == $currentPage ? 'selected' : '' }}>{{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                    <span>of {{ $totalPages }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
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
            <i class="fas fa-trash-alt text-red-500 w-4"></i>Hapus
        </button>
    </div>

    {{-- Modal Add/Edit --}}
    <div id="dataModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/Logo.PNG') }}" alt="Fast Track STEMI Pathway"
                        class="h-12 w-12 object-contain">
                    <div>
                        <h1 class="text-blue-600 font-bold text-sm leading-tight">FAST</h1>
                        <h1 class="text-blue-600 font-bold text-sm leading-tight">TRACK</h1>
                        <p class="text-teal-600 font-bold text-xs leading-tight">STEMI</p>
                        <p class="text-teal-600 font-bold text-xs leading-tight">PATHWAY</p>
                    </div>
                </div>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="p-6">
                <h3 id="modalTitle" class="text-xl font-bold text-gray-800 mb-6">REGISTRASI DATA NAKES</h3>

                <form id="dataNakesForm" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" id="formMethod" name="_method" value="POST">
                    <input type="hidden" id="dataNakesId" name="id">

                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Nama <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap"
                            class="w-full px-4 py-3 bg-blue-50 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Status <span
                                class="text-red-500">*</span></label>
                        <select id="status" name="status"
                            class="w-full px-4 py-3 bg-blue-50 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-500"
                            required>
                            <option value="" selected disabled>Pilih Status</option>
                            <option value="Dokter">Dokter</option>
                            <option value="Perawat">Perawat</option>
                            <option value="Laboran">Laboran</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Kontak (WhatsApp) <span
                                class="text-red-500">*</span></label>
                        <input type="tel" id="contact" name="contact" placeholder="081234567890"
                            class="w-full px-4 py-3 bg-blue-50 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800"
                            required pattern="[0-9]{10,13}">
                        <p class="text-xs text-gray-500 mt-1">Format: 08xxxxxxxxxx</p>
                    </div>

                    <button type="submit"
                        class="w-full py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition mt-6">
                        <i class="fas fa-save mr-2"></i>SIMPAN
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Delete --}}
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 text-center mb-2">Konfirmasi Hapus</h3>
                <p class="text-gray-600 text-center mb-6">Apakah Anda yakin ingin menghapus data nakes ini?</p>

                <div class="flex gap-3">
                    <button onclick="closeDeleteModal()"
                        class="flex-1 py-3 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-times mr-2"></i>BATAL
                    </button>
                    <form id="deleteForm" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                            <i class="fas fa-trash mr-2"></i>HAPUS
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentDataNakesId = null;
        let contextMenuItemId = null;

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
            window.location.href = '{{ route('data-nakes.index') }}?' + params.toString();
        }

        function resetFilter() {
            // Reset form
            document.getElementById('filterForm').reset();
            // Redirect without parameters
            window.location.href = '{{ route('data-nakes.index') }}';
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

        // ==================== CONTEXT MENU FUNCTIONS ====================

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
            confirmDelete(id);
        }

        // ==================== MODAL FUNCTIONS ====================

        function openModal(action, id = null) {
            const modal = document.getElementById('dataModal');
            const title = document.getElementById('modalTitle');
            const form = document.getElementById('dataNakesForm');
            const methodInput = document.getElementById('formMethod');

            if (action === 'add') {
                title.textContent = 'REGISTRASI DATA NAKES';
                form.reset();
                form.action = "{{ route('data-nakes.store') }}";
                methodInput.value = 'POST';
                currentDataNakesId = null;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function openEditModal(id) {
            const modal = document.getElementById('dataModal');
            const title = document.getElementById('modalTitle');
            const form = document.getElementById('dataNakesForm');
            const methodInput = document.getElementById('formMethod');

            title.textContent = 'EDIT DATA NAKES';

            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Loading...';
            submitBtn.disabled = true;

            fetch(`/data-nakes/${id}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    document.getElementById('dataNakesId').value = data.id;
                    document.getElementById('nama').value = data.nama;
                    document.getElementById('status').value = data.status;
                    document.getElementById('contact').value = data.contact;

                    form.action = `/data-nakes/${data.id}`;
                    methodInput.value = 'PUT';
                    currentDataNakesId = data.id;

                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;

                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal memuat data nakes',
                        confirmButtonColor: '#3b82f6'
                    });
                });
        }

        function closeModal() {
            document.getElementById('dataModal').classList.add('hidden');
            document.getElementById('dataModal').classList.remove('flex');
        }

        function confirmDelete(id) {
            document.getElementById('deleteForm').action = `/data-nakes/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
        }

        // Close context menu when clicking outside
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('contextMenu');
            if (menu && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        document.getElementById('dataModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
                closeDeleteModal();
                document.getElementById('contextMenu').classList.add('hidden');
                document.getElementById('filterDropdown').classList.remove('show');
            }
        });

        document.getElementById('dataNakesForm').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
            submitBtn.disabled = true;
        });

        setTimeout(() => {
            document.querySelectorAll('[role="alert"]').forEach(message => {
                message.style.display = 'none';
            });
        }, 5000);

        document.getElementById('contact').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>

</html>
