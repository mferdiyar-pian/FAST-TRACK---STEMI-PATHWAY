<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Track STEMI Pathway - Aktivasi Code STEMI</title>
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
                    <div>
                        <a href="{{ route('code-stemi.index') }}" class="flex items-center gap-2 text-blue-600 hover:text-blue-700 transition">
                            <i class="fas fa-arrow-left"></i>
                            <span class="font-medium">Kembali ke Code STEMI</span>
                        </a>
                    </div>
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

            {{-- Form Content --}}
            <div class="p-8">
                <div class="max-w-2xl mx-auto">
                    {{-- Notifikasi --}}
                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="border-b border-gray-200 px-6 py-4">
                            <h2 class="text-xl font-bold text-gray-800">REGISTRASI CODE STEMI</h2>
                            <p class="text-sm text-gray-600 mt-1">Isi checklist pemeriksaan yang telah dilakukan</p>
                        </div>

                        <form action="{{ route('code-stemi.store') }}" method="POST" class="p-6">
                            @csrf

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-800 mb-3">Checklist Pemeriksaan</label>
                                
                                @error('checklist')
                                    <div class="text-red-600 text-sm mb-3">{{ $message }}</div>
                                @enderror

                                <div class="grid grid-cols-2 gap-4">
                                    @php
                                        $checklistItems = [
                                            'Anamnesis' => 'Pemeriksaan anamnesis pasien',
                                            'EKG' => 'Pemeriksaan EKG',
                                            'Rongten Thorax' => 'Rontgen thorax',
                                            'Pemeriksaan Fisik' => 'Pemeriksaan fisik umum',
                                            'Laboratorium' => 'Pemeriksaan laboratorium',
                                            'Informed Consent' => 'Persetujuan tindakan'
                                        ];
                                    @endphp
                                    
                                    @foreach($checklistItems as $key => $description)
                                        <label class="flex items-start gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                                            <input type="checkbox" name="checklist[]" value="{{ $key }}" 
                                                   class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 mt-1">
                                            <div>
                                                <span class="text-sm font-medium text-gray-700">{{ $key }}</span>
                                                <p class="text-xs text-gray-500 mt-1">{{ $description }}</p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-800 mb-3">Pesan Broadcast</label>
                                <p class="text-xs text-gray-600 mb-2">Fast Track STEMI Pathway</p>

                                <div class="bg-gray-100 rounded-lg p-4 space-y-2">
                                    <p class="text-sm text-gray-700 font-semibold">CODE STEMI AKTIF</p>
                                    <p class="text-xs text-gray-600">Pasien STEMI telah teridentifikasi di IGD RS Otak M Hatta Bukittinggi.</p>
                                    <p class="text-xs text-gray-600">Tim Cath Lab harap bersiaga secara siaga.</p>
                                    <p class="text-xs text-gray-600">Fast Track STEMI Pathway aktif.</p>
                                    <p class="text-xs text-gray-600">Waktu Door-to-Balloon dimulai.</p>
                                </div>

                                <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                                    <div class="flex items-start gap-2">
                                        <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                                        <p class="text-xs text-blue-700">
                                            Pesan ini akan dikirim ke semua staf aktif melalui WhatsApp
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-exclamation-triangle text-yellow-500 mt-0.5"></i>
                                    <div>
                                        <p class="text-sm font-semibold text-yellow-800">Konfirmasi Aktivasi</p>
                                        <p class="text-xs text-yellow-700 mt-1">
                                            Dengan mengklik tombol di bawah, Anda akan:
                                        </p>
                                        <ul class="text-xs text-yellow-700 mt-1 list-disc list-inside space-y-1">
                                            <li>Mengaktifkan Code STEMI</li>
                                            <li>Mengirim broadcast WhatsApp ke semua staf</li>
                                            <li>Memulai penghitungan Door-to-Balloon time</li>
                                            <li>Mencatat waktu mulai aktivasi</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" 
                                    class="w-full py-4 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                    onclick="return confirm('Apakah Anda yakin ingin mengaktifkan Code STEMI?')">
                                AKTIVASI CODE STEMI<br>DIMULAI
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Validasi form - minimal 1 checklist harus dipilih
        document.querySelector('form').addEventListener('submit', function(e) {
            const checkboxes = document.querySelectorAll('input[name="checklist[]"]');
            const checked = Array.from(checkboxes).some(checkbox => checkbox.checked);
            
            if (!checked) {
                e.preventDefault();
                alert('Pilih minimal 1 item checklist sebelum mengaktifkan Code STEMI');
            }
        });
    </script>
</body>
</html>