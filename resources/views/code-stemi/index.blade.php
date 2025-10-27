<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Track STEMI Pathway - Code STEMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <div class="flex h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white shadow-sm">
            <div class="p-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/Logo.PNG') }}" alt="Fast Track STEMI Pathway" class="h-16 w-16 object-contain">
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
                    <i class="fas fa-th-large"></i><span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('data-nakes.index') }}" class="flex items-center gap-3 px-6 py-3 text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-briefcase"></i><span class="font-medium">Data Nakes</span>
                </a>
                <a href="{{ route('code-stemi.index') }}" class="flex items-center gap-3 px-6 py-3 bg-blue-50 text-blue-600 border-l-4 border-blue-600">
                    <i class="fas fa-file-alt"></i><span class="font-medium">Code STEMI</span>
                </a>
                <a href="{{ route('setting.index') }}" class="flex items-center gap-3 px-6 py-3 text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-cog"></i><span class="font-medium">Setting</span>
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
                            <input type="text" placeholder="Search type of keywords" class="w-80 pl-4 pr-10 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500">
                            <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                        </div>
                        <button class="relative">
                            <i class="fas fa-bell text-gray-500 text-xl"></i>
                            <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        <div class="flex items-center gap-3">
                            <span class="text-gray-700 font-medium">dr. Muhammad Zaky, Sp.JP</span>
                            <i class="fas fa-chevron-down text-gray-400"></i>
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

                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Code STEMI</h2>
                    <div class="flex gap-3">
                        <button onclick="openAddModal()" class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            <i class="fas fa-plus"></i>Add Data
                        </button>
                        <button class="flex items-center gap-2 px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            <i class="fas fa-sliders-h"></i>Filter
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    @if($data->count() > 0)
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">ADMITTED</th>
                                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">STATUS</th>
                                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">DOOR TO BALLOON TIME</th>
                                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">ACTION</th>
                                    <th class="px-6 py-4"></th>
                                </tr>
                            </thead>
                            <tbody id="codeStemiTableBody">
                                @foreach ($data as $index => $item)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition {{ $index % 2 == 1 ? 'bg-cyan-50' : 'bg-white' }}" 
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
                                                <button onclick="openDetailModal({{ $item->id }})" class="px-4 py-1.5 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition font-medium">Detail</button>
                                                @if ($item->status === 'Running')
                                                    <form action="{{ route('code-stemi.finish', $item->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="px-4 py-1.5 bg-red-600 text-white text-sm rounded-md hover:bg-red-700 transition font-medium whitespace-nowrap" 
                                                                onclick="return confirm('Apakah Anda yakin ingin menyelesaikan Code STEMI ini?')">
                                                            Aktivasi Code Stemi Selesai
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="relative">
                                                <button class="text-gray-400 hover:text-gray-600 transition" onclick="toggleDropdown({{ $item->id }})">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div id="dropdown-{{ $item->id }}" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden z-10">
                                                    <form action="{{ route('code-stemi.destroy', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50" 
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                            Hapus Data
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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

    {{-- Modal Add Data --}}
    <div id="addCodeStemiModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md transform transition-all">
            <div class="flex items-center justify-between p-5 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-800">REGISTRASI CODE STEMI</h3>
                <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form action="{{ route('code-stemi.store') }}" method="POST" id="activationForm">
                @csrf
                <div class="p-6 space-y-6">
                    {{-- Checklist Section --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-3">Checklist Pemeriksaan (Opsional)</label>
                        <p class="text-xs text-gray-500 mb-3">Pilih checklist yang sudah dilakukan, atau lanjutkan tanpa checklist</p>
                        
                        <div class="grid grid-cols-2 gap-3">
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
                                <label class="flex items-center gap-2 cursor-pointer p-2 rounded hover:bg-gray-50 transition">
                                    <input type="checkbox" name="checklist[]" value="{{ $key }}" 
                                           class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-gray-200"></div>

                    {{-- Broadcast Message Section --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-3">Pesan Broadcast</label>
                        <p class="text-xs text-gray-600 mb-2">Fast Track STEMI Pathway</p>

                        <div class="bg-gray-100 rounded-lg p-4 space-y-2 text-sm">
                            <p class="text-gray-700 font-semibold">CODE STEMI AKTIF</p>
                            <p class="text-gray-600">Pasien STEMI telah berada di IGD RS Otak M Hatta Bukittinggi.</p>
                            <p class="text-gray-600">Seluruh unit terkait dimohon segera siaga.</p>
                            <p class="text-gray-600">Fast Track STEMI Pathway aktif.</p>
                            <p class="text-gray-600">Waktu Door-to-balloon dimulai.</p>
                        </div>

                        {{-- Custom Message Input --}}
                        <div class="mt-4">
                            <textarea 
                                name="custom_message" 
                                placeholder="Dapat menambahkan custom messages disini (opsional)"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                rows="3"
                            ></textarea>
                        </div>
                    </div>

                    {{-- Activation Button --}}
                    <button type="submit" 
                            class="w-full py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            onclick="return confirm('Apakah Anda yakin ingin mengaktifkan Code STEMI?')">
                        AKTIVASI CODE STEMI DIMULAI
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Detail Data --}}
    <div id="detailCodeStemiModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-sm transform transition-all">
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h3 class="text-base font-bold text-gray-800">DETAIL CODE STEMI</h3>
                <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="detailContent" class="p-4 space-y-4">
                {{-- Content akan diisi via JavaScript --}}
            </div>
        </div>
    </div>

    <script>
        // Timer management
        let timers = new Map();
        let detailTimers = new Map();

        // Initialize timers when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeTimers();
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
                const diff = now - start;
                
                // Pastikan tidak negatif
                const safeDiff = Math.max(0, diff);
                
                const hours = Math.floor(safeDiff / (1000 * 60 * 60));
                const minutes = Math.floor((safeDiff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((safeDiff % (1000 * 60)) / 1000);
                
                const timeString = `${hours.toString().padStart(2, '0')}h : ${minutes.toString().padStart(2, '0')}m : ${seconds.toString().padStart(2, '0')}s`;
                
                // Update table
                const timeElement = document.getElementById(`time-${id}`);
                if (timeElement) {
                    timeElement.textContent = timeString;
                }
                
                // Update detail modal if open
                if (detailTimers.has(id)) {
                    const detailTimeElement = document.getElementById(`detail-time-${id}`);
                    if (detailTimeElement) {
                        detailTimeElement.textContent = timeString;
                    }
                }
            }
            
            // Update immediately
            updateTimer();
            
            // Update every second
            const timerId = setInterval(updateTimer, 1000);
            timers.set(id, timerId);
        }

        function stopTimer(id) {
            if (timers.has(id)) {
                clearInterval(timers.get(id));
                timers.delete(id);
            }
            if (detailTimers.has(id)) {
                clearInterval(detailTimers.get(id));
                detailTimers.delete(id);
            }
        }

        // Modal Functions
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
            
            // Stop all detail timers
            detailTimers.forEach((timerId, id) => {
                clearInterval(timerId);
            });
            detailTimers.clear();
        }

        // Form Validation - Checklist sekarang opsional
        function validateForm() {
            return confirm('Apakah Anda yakin ingin mengaktifkan Code STEMI?');
        }

        // Dropdown Functions
        function toggleDropdown(id) {
            const dropdown = document.getElementById('dropdown-' + id);
            dropdown.classList.toggle('hidden');
            
            document.querySelectorAll('[id^="dropdown-"]').forEach(otherDropdown => {
                if (otherDropdown.id !== 'dropdown-' + id) {
                    otherDropdown.classList.add('hidden');
                }
            });
        }

        // Close modals when clicking outside
        document.addEventListener('click', function(e) {
            // Close dropdowns
            if (!e.target.closest('[id^="dropdown-"]') && !e.target.closest('[onclick*="toggleDropdown"]')) {
                document.querySelectorAll('[id^="dropdown-"]').forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });
            }
            
            // Close add modal
            const addModal = document.getElementById('addCodeStemiModal');
            if (e.target === addModal) {
                closeAddModal();
            }
            
            // Close detail modal
            const detailModal = document.getElementById('detailCodeStemiModal');
            if (e.target === detailModal) {
                closeDetailModal();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAddModal();
                closeDetailModal();
            }
        });

        // Load detail data for modal
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
                            <input type="checkbox" ${isChecked ? 'checked' : ''} disabled class="w-3 h-3 text-blue-600 rounded border-gray-300">
                            <span class="text-gray-700 text-xs ${isChecked ? 'font-medium' : 'text-gray-400'}">${item}</span>
                        </label>
                    `;
                });

                document.getElementById('detailContent').innerHTML = `
                    <div>
                        <label class="block text-xs font-semibold text-gray-800 mb-2">Checklist Pemeriksaan</label>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            ${checklistHTML}
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-800 mb-2">Pesan Broadcast</label>
                        <div class="bg-blue-50 rounded p-3 space-y-1 text-xs">
                            <p class="text-blue-900 font-semibold">CODE STEMI AKTIF</p>
                            <p class="text-blue-800">Pasien STEMI telah teriada di IGD RS Otak M Hatta Bukittinggi.</p>
                            <p class="text-blue-800">Seluruh unit terkait dimohon segera siaga.</p>
                            <p class="text-blue-800">Fast Track STEMI Pathway aktif.</p>
                            <p class="text-blue-800">Waktu Door-to-balloon dimulai.</p>
                            ${data.custom_message ? `<p class="text-blue-800 mt-2 font-semibold">Pesan Tambahan:</p><p class="text-blue-800">${data.custom_message}</p>` : ''}
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg p-4 text-center">
                        <p class="text-xs font-semibold text-gray-800 mb-2">DOOR TO BALLOON TIME</p>
                        <div id="detail-time-${data.id}" class="text-2xl font-bold text-blue-600 tracking-wider">${data.door_to_balloon_time}</div>
                    </div>

                    ${data.status === 'Running' ? `
                    <form action="/code-stemi/${id}/finish" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <button type="submit" class="w-full py-2 bg-red-600 text-white text-sm font-bold rounded-lg hover:bg-red-700 transition" 
                                onclick="return confirm('Apakah Anda yakin ingin menyelesaikan Code STEMI ini?')">
                            AKTIVASI CODE STEMI SELESAI
                        </button>
                    </form>
                    ` : ''}
                `;

                // Start real-time timer for detail modal if status is Running
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
                const diff = now - start;
                
                const hours = Math.floor(diff / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                
                const timeString = `${hours.toString().padStart(2, '0')}h : ${minutes.toString().padStart(2, '0')}m : ${seconds.toString().padStart(2, '0')}s`;
                
                const detailTimeElement = document.getElementById(`detail-time-${id}`);
                if (detailTimeElement) {
                    detailTimeElement.textContent = timeString;
                }
            }
            
            // Update immediately
            updateDetailTimer();
            
            // Update every second
            const timerId = setInterval(updateDetailTimer, 1000);
            detailTimers.set(id, timerId);
        }

        // Handle form submission to refresh page and restart timers
        document.getElementById('activationForm')?.addEventListener('submit', function() {
            // Timers will be reinitialized when page reloads after form submission
        });

        // Auto-refresh the page every 30 seconds to sync with server
        setInterval(() => {
            // Only refresh if no modals are open
            const addModal = document.getElementById('addCodeStemiModal');
            const detailModal = document.getElementById('detailCodeStemiModal');
            
            if (addModal.classList.contains('hidden') && detailModal.classList.contains('hidden')) {
                window.location.reload();
            }
        }, 30000); // 30 seconds
    </script>
</body>
</html>