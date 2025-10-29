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
                <a href="{{ route('data-nakes.index') }}" class="flex items-center gap-3 px-6 py-3 bg-blue-50 text-blue-600 border-l-4 border-blue-600">
                    <i class="fas fa-user-md w-5"></i><span class="font-medium">Data Nakes</span>
                </a>
                <a href="{{ route('code-stemi.index') }}" class="flex items-center gap-3 px-6 py-3 text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-file-medical-alt w-5"></i><span class="font-medium">Code STEMI</span>
                </a>
                <a href="{{ route('setting.index') }}" class="flex items-center gap-3 px-6 py-3 text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-cog w-5"></i><span class="font-medium">Setting</span>
                </a>
            </nav>
        </aside>

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

            <div class="p-8">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                        <button onclick="this.parentElement.style.display='none'" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                        <button onclick="this.parentElement.style.display='none'" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Data Nakes</h2>
                    <div class="flex gap-3">
                        <button onclick="openModal('add')" class="flex items-center gap-2 px-5 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-medium text-sm">
                            <i class="fas fa-plus"></i>Add Data
                        </button>
                        <button class="flex items-center gap-2 px-5 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm">
                            <i class="fas fa-sliders-h"></i>Filter
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-white">
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">ADMITTED</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">NAMA</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">STATUS</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">CONTACT</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data_nakes as $index => $item)
                                <tr class="border-t border-gray-100 {{ $index % 2 == 0 ? 'bg-cyan-light' : 'bg-white' }}">
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
                                        Tidak ada data nakes
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    @if(is_object($data_nakes) && method_exists($data_nakes, 'lastPage') && $data_nakes->lastPage() > 1)
                        <div class="border-t border-gray-200 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1">
                                    {{-- Previous --}}
                                    @if ($data_nakes->onFirstPage())
                                        <button disabled class="px-3 py-2 text-gray-400 cursor-not-allowed text-sm flex items-center gap-1">
                                            <i class="fas fa-chevron-left"></i>Previous
                                        </button>
                                    @else
                                        <a href="{{ $data_nakes->previousPageUrl() }}" class="px-3 py-2 text-gray-700 hover:bg-gray-100 rounded transition text-sm flex items-center gap-1">
                                            <i class="fas fa-chevron-left"></i>Previous
                                        </a>
                                    @endif

                                    {{-- Page Numbers --}}
                                    @php
                                        $currentPage = $data_nakes->currentPage();
                                        $lastPage = $data_nakes->lastPage();
                                    @endphp

                                    @for ($i = 1; $i <= min(5, $lastPage); $i++)
                                        @if ($i == $currentPage)
                                            <button class="px-3 py-2 bg-blue-500 text-white rounded font-medium text-sm min-w-[40px]">{{ $i }}</button>
                                        @else
                                            <a href="{{ $data_nakes->url($i) }}" class="px-3 py-2 text-gray-700 hover:bg-gray-100 rounded transition text-sm min-w-[40px] text-center">{{ $i }}</a>
                                        @endif
                                    @endfor

                                    @if ($lastPage > 5)
                                        <span class="px-2 text-gray-400 text-sm">...</span>
                                        <a href="{{ $data_nakes->url($lastPage) }}" class="px-3 py-2 text-gray-700 hover:bg-gray-100 rounded transition text-sm">{{ $lastPage }}</a>
                                    @endif

                                    {{-- Next --}}
                                    @if ($data_nakes->hasMorePages())
                                        <a href="{{ $data_nakes->nextPageUrl() }}" class="px-3 py-2 text-gray-700 hover:bg-gray-100 rounded transition text-sm flex items-center gap-1">
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
                                        Page <span class="font-semibold">{{ $data_nakes->currentPage() }}</span> <span class="text-gray-400">of</span> <span class="font-semibold">{{ $data_nakes->lastPage() }}</span>
                                    </span>
                                </div>
                            </div>
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

    {{-- Modal Add/Edit --}}
    <div id="dataModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/Logo.PNG') }}" alt="Fast Track STEMI Pathway" class="h-12 w-12 object-contain">
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
                        <label class="block text-sm text-gray-600 mb-2">Nama <span class="text-red-500">*</span></label>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap"
                            class="w-full px-4 py-3 bg-blue-50 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800" required>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Status <span class="text-red-500">*</span></label>
                        <select id="status" name="status"
                            class="w-full px-4 py-3 bg-blue-50 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-500" required>
                            <option value="" selected disabled>Pilih Status</option>
                            <option value="Dokter">Dokter</option>
                            <option value="Perawat">Perawat</option>
                            <option value="Laboran">Laboran</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Kontak (WhatsApp) <span class="text-red-500">*</span></label>
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
            if (!menu.contains(e.target)) {
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