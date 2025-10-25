{{-- resources/views/data-nakes/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Track STEMI Pathway - Data Nakes</title>
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

            {{-- Data Nakes Content --}}
            <div class="p-8">
                {{-- Title & Actions --}}
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Data Nakes</h2>
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
                                    NAMA</th>
                                <th
                                    class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    STATUS</th>
                                <th
                                    class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    CONTACT</th>
                                <th class="px-6 py-4"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $data = [
                                    [
                                        'date' => '02 Mar, 2023',
                                        'name' => 'dr. Muhammd Zaky, Sp.JP',
                                        'status' => 'Dokter',
                                        'contact' => '08123456789',
                                    ],
                                    [
                                        'date' => '02 Mar, 2023',
                                        'name' => 'dr. John Doe',
                                        'status' => 'Perawat',
                                        'contact' => '081979484909',
                                    ],
                                    [
                                        'date' => '02 Mar, 2023',
                                        'name' => 'Janet',
                                        'status' => 'Laboran',
                                        'contact' => '08123456789',
                                    ],
                                    [
                                        'date' => '02 Mar, 2023',
                                        'name' => 'dr. Jane Doe',
                                        'status' => 'Dokter',
                                        'contact' => '081979484909',
                                    ],
                                    [
                                        'date' => '02 Mar, 2023',
                                        'name' => 'Isabela',
                                        'status' => 'Perawat',
                                        'contact' => '08123456789',
                                    ],
                                    [
                                        'date' => '02 Mar, 2023',
                                        'name' => 'Wahyu',
                                        'status' => 'Laboran',
                                        'contact' => '081979484909',
                                    ],
                                ];
                            @endphp

                            @foreach ($data as $index => $item)
                                <tr
                                    class="border-b border-gray-100 hover:bg-gray-50 transition {{ $index % 2 == 0 ? 'bg-cyan-50' : 'bg-white' }}">
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $item['date'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800 font-medium">{{ $item['name'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $item['status'] }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="inline-flex items-center gap-2 text-sm text-gray-700">
                                                <span class="w-2 h-2 bg-purple-600 rounded-full"></span>
                                                {{ $item['contact'] }}
                                            </span>
                                            <button class="text-gray-400 hover:text-gray-600 transition">
                                                <i class="fas fa-phone-alt"></i>
                                            </button>
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

    {{-- Modal Add Data --}}
    <div id="addDataModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            {{-- Modal Header --}}
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

            {{-- Modal Body --}}
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6">REGISTRASI DATA NAKES</h3>

                <form class="space-y-4">
                    {{-- Nama Field --}}
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Nama</label>
                        <input type="text" placeholder="Mutia Lailani"
                            class="w-full px-4 py-3 bg-blue-50 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800">
                    </div>

                    {{-- Status Field --}}
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Status</label>
                        <select
                            class="w-full px-4 py-3 bg-blue-50 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-500">
                            <option selected disabled>Select Option</option>
                            <option value="dokter">Dokter</option>
                            <option value="perawat">Perawat</option>
                            <option value="laboran">Laboran</option>
                        </select>
                    </div>

                    {{-- Kontak Field --}}
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Kontak (Wajib WhatsApp)</label>
                        <input type="tel" placeholder="081234567890"
                            class="w-full px-4 py-3 bg-blue-50 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800">
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="w-full py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition mt-6">
                        SIMPAN
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            const modal = document.getElementById('addDataModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('addDataModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Close modal when clicking outside
        document.getElementById('addDataModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>

</html>
