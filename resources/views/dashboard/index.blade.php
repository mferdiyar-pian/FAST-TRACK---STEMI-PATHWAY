{{-- resources/views/dashboard/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Track STEMI Pathway - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
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
                <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 px-6 py-3 bg-blue-50 text-blue-600 border-l-4 border-blue-600">
                    <i class="fas fa-th-large w-5"></i><span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('data-nakes.index') }}" class="flex items-center gap-3 px-6 py-3 text-gray-500 hover:bg-gray-50">
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

        {{-- Main Content --}}
        <main class="flex-1 overflow-y-auto">
            <header class="bg-white shadow-sm px-8 py-4">
                <div class="flex items-center justify-between">
                    <div></div>
                    <div class="flex items-center gap-6">
                        <form id="searchForm" method="GET" action="{{ route('code-stemi.index') }}" class="relative">
                            <input type="text" name="search" id="searchInput" placeholder="Search type of keywords" 
                                value="{{ request('search') }}"
                                class="w-80 pl-4 pr-10 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 text-sm">
                            <button type="submit" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
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

            {{-- Dashboard Content --}}
            <div class="p-8">
                <div class="grid grid-cols-3 gap-6">
                    {{-- Left Section: Stats & Chart --}}
                    <div class="col-span-2 space-y-6">
                        {{-- Stats Cards --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white rounded-xl p-6 shadow-sm">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-500 text-sm mb-2">Running</p>
                                        <p class="text-4xl font-bold text-gray-800">20</p>
                                    </div>
                                    <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center">
                                        <i class="fas fa-running text-blue-500 text-xl"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-xl p-6 shadow-sm">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-500 text-sm mb-2">Finished</p>
                                        <p class="text-4xl font-bold text-gray-800">375</p>
                                    </div>
                                    <div class="w-12 h-12 bg-pink-50 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user-check text-pink-500 text-xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Chart --}}
                        <div class="bg-white rounded-xl p-6 shadow-sm">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Overview</h3>
                                    <div class="flex items-center gap-6 text-sm">
                                        <div class="flex items-center gap-2">
                                            <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                                            <span class="text-gray-600">Finished</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="w-3 h-3 bg-pink-300 rounded-full"></span>
                                            <span class="text-gray-600">Unfinish</span>
                                        </div>
                                    </div>
                                </div>
                                <select class="border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none">
                                    <option>Monthly</option>
                                    <option>Weekly</option>
                                    <option>Yearly</option>
                                </select>
                            </div>
                            <div class="relative">
                                <div class="absolute top-0 left-0 text-xs text-gray-400">
                                    <div class="mb-8">Finished</div>
                                    <div>375</div>
                                </div>
                                <canvas id="overviewChart" height="80"></canvas>
                            </div>
                        </div>
                    </div>

                    {{-- Right Section: Calendar --}}
                    <div class="bg-white rounded-xl p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-800">July, 2022</h3>
                            <div class="flex gap-2">
                                <button class="w-8 h-8 flex items-center justify-center hover:bg-gray-100 rounded">
                                    <i class="fas fa-chevron-left text-gray-400"></i>
                                </button>
                                <button class="w-8 h-8 flex items-center justify-center hover:bg-gray-100 rounded">
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-7 gap-2 text-center">
                            <div class="text-xs font-semibold text-blue-600 mb-2">Mon</div>
                            <div class="text-xs font-semibold text-blue-600 mb-2">Tue</div>
                            <div class="text-xs font-semibold text-blue-600 mb-2">Wed</div>
                            <div class="text-xs font-semibold text-blue-600 mb-2">Thu</div>
                            <div class="text-xs font-semibold text-blue-600 mb-2">Fri</div>
                            <div class="text-xs font-semibold text-blue-600 mb-2">Sat</div>
                            <div class="text-xs font-semibold text-blue-600 mb-2">Sun</div>

                            @php
                                $dates = [26, 27, 28, 29, 30, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23];
                            @endphp

                            @foreach($dates as $index => $date)
                                @if($date == 6)
                                    <div class="w-10 h-10 flex items-center justify-center bg-blue-600 text-white rounded-lg font-medium text-sm">{{ $date }}</div>
                                @elseif($index < 5)
                                    <div class="w-10 h-10 flex items-center justify-center text-gray-300 text-sm">{{ $date }}</div>
                                @else
                                    <div class="w-10 h-10 flex items-center justify-center hover:bg-gray-100 rounded-lg text-gray-700 text-sm cursor-pointer">{{ $date }}</div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Chart.js Configuration
        const ctx = document.getElementById('overviewChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Finished',
                    data: [50, 180, 130, 100, 150, 120, 160, 375, 280, 320, 250, 300],
                    borderColor: '#3B82F6',
                    backgroundColor: 'transparent',
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#3B82F6'
                }, {
                    label: 'Unfinish',
                    data: [80, 200, 150, 180, 250, 200, 280, 220, 240, 200, 180, 160],
                    borderColor: '#F9A8D4',
                    backgroundColor: 'transparent',
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#F9A8D4'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'white',
                        titleColor: '#374151',
                        bodyColor: '#374151',
                        borderColor: '#E5E7EB',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: true,
                        boxWidth: 8,
                        boxHeight: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 400,
                        ticks: {
                            stepSize: 100,
                            color: '#9CA3AF',
                            font: {
                                size: 11
                            }
                        },
                        grid: {
                            color: '#F3F4F6',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            color: '#9CA3AF',
                            font: {
                                size: 11
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>