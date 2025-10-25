{{-- resources/views/code-stemi/index.blade.php --}}
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
                    {{-- Logo Image (tanpa text) --}}
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
                <a href="{{ route('dashboard.index') }}"
                    class="flex items-center gap-3 px-6 py-3 text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-th-large"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('data-nakes.index') }}"
                    class="flex items-center gap-3 px-6 py-3 text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-briefcase"></i>
                    <span class="font-medium">Data Nakes</span>
                </a>
                <a href="{{ route('code-stemi.index') }}"
                    class="flex items-center gap-3 px-6 py-3 bg-blue-50 text-blue-600 border-l-4 border-blue-600">
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

        {{-- Main Content --}}
        <main class="flex-1 overflow-y-auto">
            {{-- Header --}}
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

            {{-- Code STEMI Content --}}
            <div class="p-8">
                {{-- Title & Actions --}}
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Code STEMI</h2>
                    <div class="flex gap-3">
                        <button onclick="openModal()"
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

                {{-- Table --}}
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th
                                    class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    ADMITTED</th>
                                <th
                                    class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    STATUS</th>
                                <th
                                    class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    DOOR TO BALLOON TIME</th>
                                <th
                                    class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    ACTION</th>
                                <th class="px-6 py-4"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $data = [
                                    [
                                        'date' => '02 Oct, 2025',
                                        'status' => 'Running',
                                        'time' => '00h : 30m : 15s',
                                        'finished' => false,
                                    ],
                                    [
                                        'date' => '02 Oct, 2025',
                                        'status' => 'Running',
                                        'time' => '00h : 45m : 27s',
                                        'finished' => false,
                                    ],
                                    [
                                        'date' => '02 Oct, 2025',
                                        'status' => 'Running',
                                        'time' => '00h : 30m : 15s',
                                        'finished' => false,
                                    ],
                                    [
                                        'date' => '02 Oct, 2025',
                                        'status' => 'Finished',
                                        'time' => '00h : 45m : 27s',
                                        'finished' => true,
                                    ],
                                ];
                            @endphp

                            @foreach ($data as $index => $item)
                                <tr
                                    class="border-b border-gray-100 hover:bg-gray-50 transition {{ $index % 2 == 1 ? 'bg-cyan-50' : 'bg-white' }}">
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $item['date'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $item['status'] }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="text-sm font-semibold {{ $item['finished'] ? 'text-red-600' : 'text-gray-800' }}">
                                            {{ $item['time'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <button onclick="openDetailModal()"
                                                class="px-4 py-1.5 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition font-medium">
                                                Detail
                                            </button>
                                            @if (!$item['finished'])
                                                <button
                                                    class="px-4 py-1.5 bg-red-600 text-white text-sm rounded-md hover:bg-red-700 transition font-medium whitespace-nowrap">
                                                    Aktivasi Code Stemi Selesai
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button class="text-gray-400 hover:text-gray-600 transition">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    {{-- Modal Registrasi Code STEMI (Add Data) --}}
    <div id="addCodeStemiModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform transition-all">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-800">REGISTRASI CODE STEMI</h3>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-teal-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-heartbeat text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-teal-600 font-bold text-xs">FAST TRACK</h1>
                            <p class="text-teal-600 text-xs">STEMI PATHWAY</p>
                        </div>
                    </div>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            {{-- Modal Body --}}
            <div class="p-6">
                <form class="space-y-6">
                    {{-- Checklist Section --}}
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox"
                                class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Anamnesis</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox"
                                class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">EKG</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox"
                                class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Rongten Thorax</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox"
                                class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Pemeriksaan Fisik</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox"
                                class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Laboratorium</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox"
                                class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Informed Consent</span>
                        </label>
                    </div>

                    {{-- Pesan Broadcast Section --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-3">Pesan Broadcast</label>
                        <p class="text-xs text-gray-600 mb-2">Fast Track STEMI Pathway</p>

                        <div class="bg-gray-100 rounded-lg p-4 space-y-2">
                            <p class="text-sm text-gray-700 font-semibold">CODE STEMI AKTIF</p>
                            <p class="text-xs text-gray-600">Pasien STEMI telah teriada di IGD RS Otak M Hatta
                                Bukittinggi.</p>
                            <p class="text-xs text-gray-600">Tim Cath Lab harap bersiaga secara siaga.</p>
                            <p class="text-xs text-gray-600">Fast Track STEMI Pathway aktif.</p>
                            <p class="text-xs text-gray-600">Waktu Door-to-Balloon dimulai.</p>
                        </div>

                        <p class="text-xs text-gray-400 italic mt-2">Dapat menambahkan custom messages disini</p>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="w-full py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition">
                        AKTIVASI CODE STEMI<br />DIMULAI
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Detail Code STEMI (with Timer) --}}
    <div id="detailCodeStemiModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform transition-all">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-800">REGISTRASI CODE STEMI</h3>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-teal-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-heartbeat text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-teal-600 font-bold text-xs">FAST TRACK</h1>
                            <p class="text-teal-600 text-xs">STEMI PATHWAY</p>
                        </div>
                    </div>
                    <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            {{-- Modal Body --}}
            <div class="p-6">
                <div class="space-y-6">
                    {{-- Checklist Section (Checked) --}}
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" checked
                                class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Anamnesis</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" checked
                                class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">EKG</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox"
                                class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Rongten Thorax</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox"
                                class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Pemeriksaan Fisik</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox"
                                class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Laboratorium</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" checked
                                class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Informed Consent</span>
                        </label>
                    </div>

                    {{-- Pesan Broadcast Section --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-3">Pesan Broadcast</label>
                        <p class="text-xs text-gray-600 mb-2">Fast Track STEMI Pathway</p>

                        <div class="bg-blue-50 rounded-lg p-4 space-y-2">
                            <p class="text-sm text-blue-900 font-semibold">CODE STEMI AKTIF</p>
                            <p class="text-xs text-blue-800">Pasien STEMI telah teriada di IGD RS Otak M Hatta
                                Bukittinggi.</p>
                            <p class="text-xs text-blue-800">Seluruh unit terkait dimohon segera siaga.</p>
                            <p class="text-xs text-blue-800">Fast Track STEMI Pathway aktif.</p>
                            <p class="text-xs text-blue-800">Waktu Door-to-balloon dimulai.</p>
                        </div>

                        <p class="text-xs text-gray-400 italic mt-2">Dapat menambahkan custom messages disini</p>
                    </div>

                    {{-- Door to Balloon Time Counter --}}
                    <div class="bg-white border-2 border-gray-200 rounded-xl p-6 text-center">
                        <p class="text-sm font-semibold text-gray-800 mb-3">DOOR TO BALLOON TIME</p>
                        <div class="text-6xl font-bold text-blue-600 tracking-wider">
                            00 : 12 : 34
                        </div>
                    </div>

                    {{-- Finish Button --}}
                    <button type="button"
                        class="w-full py-3 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition">
                        AKTIVASI CODE STEMI<br />SELESAI
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            const modal = document.getElementById('addCodeStemiModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('addCodeStemiModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function openDetailModal() {
            const modal = document.getElementById('detailCodeStemiModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDetailModal() {
            const modal = document.getElementById('detailCodeStemiModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Close modals when clicking outside
        document.getElementById('addCodeStemiModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        document.getElementById('detailCodeStemiModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailModal();
            }
        });

        // Close modals with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
                closeDetailModal();
            }
        });
    </script>
</body>

</html>
