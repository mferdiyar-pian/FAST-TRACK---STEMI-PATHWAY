<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Track STEMI Pathway - Code STEMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-cyan-light {
            background-color: #E0F7FA;
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
                        <div class="relative">
                            <input type="text" placeholder="Search type of keywords" class="w-80 pl-4 pr-10 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 text-sm">
                            <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                        </div>
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
                        <button class="flex items-center gap-2 px-5 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm">
                            <i class="fas fa-sliders-h"></i>Filter
                        </button>
                    </div>
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
                        @if(isset($data) && method_exists($data, 'lastPage') && $data->lastPage() > 1)
                            <div class="border-t border-gray-200 px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1">
                                        {{-- Previous --}}
                                        @if ($data->onFirstPage())
                                            <button disabled class="px-3 py-2 text-gray-400 cursor-not-allowed text-sm flex items-center gap-1">
                                                <i class="fas fa-chevron-left"></i>Previous
                                            </button>
                                        @else
                                            <a href="{{ $data->previousPageUrl() }}" class="px-3 py-2 text-gray-700 hover:bg-gray-100 rounded transition text-sm flex items-center gap-1">
                                                <i class="fas fa-chevron-left"></i>Previous
                                            </a>
                                        @endif

                                        {{-- Page Numbers --}}
                                        @php
                                            $currentPage = $data->currentPage();
                                            $lastPage = $data->lastPage();
                                        @endphp

                                        @for ($i = 1; $i <= min(5, $lastPage); $i++)
                                            @if ($i == $currentPage)
                                                <button class="px-3 py-2 bg-blue-500 text-white rounded font-medium text-sm min-w-[40px]">{{ $i }}</button>
                                            @else
                                                <a href="{{ $data->url($i) }}" class="px-3 py-2 text-gray-700 hover:bg-gray-100 rounded transition text-sm min-w-[40px] text-center">{{ $i }}</a>
                                            @endif
                                        @endfor

                                        @if ($lastPage > 5)
                                            <span class="px-2 text-gray-400 text-sm">...</span>
                                            <a href="{{ $data->url($lastPage) }}" class="px-3 py-2 text-gray-700 hover:bg-gray-100 rounded transition text-sm">{{ $lastPage }}</a>
                                        @endif

                                        {{-- Next --}}
                                        @if ($data->hasMorePages())
                                            <a href="{{ $data->nextPageUrl() }}" class="px-3 py-2 text-gray-700 hover:bg-gray-100 rounded transition text-sm flex items-center gap-1">
                                                Next<i class="fas fa-chevron-right"></i>
                                            </a>
                                        @else
                                            <button disabled class="px-3 py-2 text-gray-400 cursor-not-allowed text-sm flex items-center gap-1">
                                                Next<i class="fas fa-chevron-right"></i>
                                            </button>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <button class="flex items-center gap-2 px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700 transition font-medium text-sm">
                                            <i class="fas fa-download"></i>Export
                                        </button>
                                        <span class="text-sm text-gray-600">
                                            Page <span class="font-semibold">{{ $data->currentPage() }}</span> <span class="text-gray-400">of</span> <span class="font-semibold">{{ $data->lastPage() }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-file-alt text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg">Belum ada data Code STEMI</p>
                            <button onclick="openAddModal()" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <i class="fas fa-plus"></i> Aktivasi Code STEMI Pertama
                            </button>
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
            if (!menu.contains(e.target)) {
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
            }
        });
    </script>
</body>
</html>