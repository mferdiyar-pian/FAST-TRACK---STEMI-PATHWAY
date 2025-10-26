{{-- resources/views/data-nakes/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Track STEMI Pathway - Data Nakes</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        .bg-cyan-50 {
            background-color: #ecfeff;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-sm">
            <div class="p-6">
                <div class="flex items-center gap-3">
                    <!-- Logo placeholder -->
                    <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-heartbeat text-blue-600 text-2xl"></i>
                    </div>
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
                    <i class="fas fa-th-large"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('data-nakes.index') }}"
                    class="flex items-center gap-3 px-6 py-3 bg-blue-50 text-blue-600 border-l-4 border-blue-600">
                    <i class="fas fa-briefcase"></i>
                    <span class="font-medium">Data Nakes</span>
                </a>
                <a href="{{ route('code-stemi.index') }}"
                    class="flex items-center gap-3 px-6 py-3 text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-file-alt"></i>
                    <span class="font-medium">Code STEMI</span>
                </a>
                <a href="{{ route('setting.index') }}"
                    class="flex items-center gap-3 px-6 py-3 text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-cog"></i>
                    <span class="font-medium">Setting</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Header -->
            <header class="bg-white shadow-sm px-8 py-4">
                <div class="flex items-center justify-between">
                    <div></div>

                    <div class="flex items-center gap-6">
                        <div class="relative">
                            <input type="text" placeholder="Search type of keywords"
                                class="w-80 pl-4 pr-10 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500">
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

            <!-- Data Nakes Content -->
            <div class="p-8">
                <!-- Flash Messages -->
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

                <!-- Title & Actions -->
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Data Nakes</h2>
                    <div class="flex gap-3">
                        <button onclick="openModal('add')"
                            class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            <i class="fas fa-plus"></i>
                            Add Data
                        </button>
                        <button
                            class="flex items-center gap-2 px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            <i class="fas fa-sliders-h"></i>
                            Filter
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    ADMITTED
                                </th>
                                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    NAMA
                                </th>
                                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    STATUS
                                </th>
                                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    CONTACT
                                </th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    ACTIONS
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data_nakes as $index => $item)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition {{ $index % 2 == 0 ? 'bg-cyan-50' : 'bg-white' }}">
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ \Carbon\Carbon::parse($item->admitted_date)->format('d M, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-800 font-medium">{{ $item->nama }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $item->status }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="inline-flex items-center gap-2 text-sm text-gray-700">
                                                <span class="w-2 h-2 bg-purple-600 rounded-full"></span>
                                                {{ $item->contact }}
                                            </span>
                                            <a href="https://wa.me/62{{ substr($item->contact, 1) }}" target="_blank" 
                                               class="text-green-500 hover:text-green-700 transition">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <button onclick="openModal('edit', {{ $item->id }})" 
                                                class="text-blue-500 hover:text-blue-700 transition p-2"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="confirmDelete({{ $item->id }})" 
                                                class="text-red-500 hover:text-red-700 transition p-2"
                                                title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
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
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Add/Edit Data -->
    <div id="dataModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-teal-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-heartbeat text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-teal-600 font-bold text-sm">FAST TRACK</h1>
                        <p class="text-teal-600 text-xs">STEMI PATHWAY</p>
                    </div>
                </div>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <h3 id="modalTitle" class="text-xl font-bold text-gray-800 mb-6">REGISTRASI DATA NAKES</h3>

                <form id="dataNakesForm" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" id="formMethod" name="_method" value="POST">
                    <input type="hidden" id="dataNakesId" name="id">
                    
                    <!-- Nama Field -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Nama <span class="text-red-500">*</span></label>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap"
                            class="w-full px-4 py-3 bg-blue-50 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800"
                            required>
                        @error('nama')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Status Field -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Status <span class="text-red-500">*</span></label>
                        <select id="status" name="status"
                            class="w-full px-4 py-3 bg-blue-50 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-500"
                            required>
                            <option value="" selected disabled>Pilih Status</option>
                            <option value="Dokter">Dokter</option>
                            <option value="Perawat">Perawat</option>
                            <option value="Laboran">Laboran</option>
                        </select>
                        @error('status')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Kontak Field -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Kontak (WhatsApp) <span class="text-red-500">*</span></label>
                        <input type="tel" id="contact" name="contact" placeholder="081234567890"
                            class="w-full px-4 py-3 bg-blue-50 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800"
                            required pattern="[0-9]{10,13}">
                        <p class="text-xs text-gray-500 mt-1">Format: 08xxxxxxxxxx</p>
                        @error('contact')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition mt-6">
                        <i class="fas fa-save mr-2"></i>SIMPAN
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 text-center mb-2">Konfirmasi Hapus</h3>
                <p class="text-gray-600 text-center mb-6">Apakah Anda yakin ingin menghapus data nakes ini? Tindakan ini tidak dapat dibatalkan.</p>
                
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

        // Modal functions
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
                
                // Reset validation errors
                document.querySelectorAll('.text-red-500.text-xs').forEach(el => el.remove());
            } else if (action === 'edit' && id) {
                title.textContent = 'EDIT DATA NAKES';
                
                // Show loading state
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Loading...';
                submitBtn.disabled = true;
                
                // Fetch data via AJAX
                fetch(`/data-nakes/${id}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
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
                        
                        // Restore button state
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal memuat data nakes',
                            confirmButtonColor: '#3b82f6'
                        });
                        closeModal();
                    });
            }
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('dataModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function confirmDelete(id) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            
            form.action = `/data-nakes/${id}`;
            currentDataNakesId = id;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Close modals when clicking outside
        document.getElementById('dataModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close modals with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
                closeDeleteModal();
            }
        });

        // Form submission handling
        document.getElementById('dataNakesForm').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
            submitBtn.disabled = true;
        });

        // Auto-hide flash messages after 5 seconds
        setTimeout(() => {
            const flashMessages = document.querySelectorAll('[role="alert"]');
            flashMessages.forEach(message => {
                message.style.display = 'none';
            });
        }, 5000);

        // Phone number formatting
        document.getElementById('contact').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>