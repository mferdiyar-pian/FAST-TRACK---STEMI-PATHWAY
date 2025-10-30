<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Track STEMI Pathway - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Pusher untuk real-time -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <style>
        /* Font Settings */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-weight: 400;
            line-height: 1.5;
            letter-spacing: -0.011em;
        }
        
        /* Font Weight Adjustments */
        .font-semibold {
            font-weight: 600;
        }
        
        .font-bold {
            font-weight: 700;
        }
        
        .font-medium {
            font-weight: 500;
        }
        
        /* Text Size Adjustments */
        .text-xs {
            font-size: 0.75rem;
            line-height: 1rem;
        }
        
        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }
        
        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }
        
        .text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem;
        }
        
        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem;
        }
        
        .text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }
        
        .text-4xl {
            font-size: 2.25rem;
            line-height: 2.5rem;
        }

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
        
        /* Letter Spacing untuk judul FAST TRACK */
        .tracking-tight {
            letter-spacing: -0.025em;
        }
        
        /* Logo text styling */
        .logo-text {
            font-weight: 700;
            letter-spacing: -0.025em;
        }
        
        /* Button text styling */
        button, .btn {
            font-weight: 500;
        }
        
        /* Chart text styling */
        .chart-container {
            font-family: 'Inter', sans-serif;
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
                        <h1 class="text-blue-600 font-bold text-sm leading-tight logo-text">FAST</h1>
                        <h1 class="text-blue-600 font-bold text-sm leading-tight logo-text">TRACK</h1>
                        <p class="text-teal-600 font-bold text-xs leading-tight logo-text">STEMI</p>
                        <p class="text-teal-600 font-bold text-xs leading-tight logo-text">PATHWAY</p>
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
                                        <p class="text-gray-500 text-sm mb-2 font-medium">Running</p>
                                        {{-- PERBAIKAN: Gunakan null coalescing operator --}}
                                        <p id="runningCount" class="text-4xl font-bold text-gray-800">{{ $runningCount ?? 0 }}</p>
                                    </div>
                                    <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center">
                                        <i class="fas fa-running text-blue-500 text-xl"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-xl p-6 shadow-sm">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-500 text-sm mb-2 font-medium">Finished</p>
                                        {{-- PERBAIKAN: Gunakan null coalescing operator --}}
                                        <p id="finishedCount" class="text-4xl font-bold text-gray-800">{{ $finishedCount ?? 0 }}</p>
                                    </div>
                                    <div class="w-12 h-12 bg-pink-50 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user-check text-pink-500 text-xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Chart --}}
                        <div class="bg-white rounded-xl p-6 shadow-sm chart-container">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Overview</h3>
                                    <div class="flex items-center gap-6 text-sm">
                                        <div class="flex items-center gap-2">
                                            <span class="w-3 h-3 bg-pink-500 rounded-full"></span>
                                            <span class="text-gray-600 font-medium">Finished</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                                            <span class="text-gray-600 font-medium">Running</span>
                                        </div>
                                    </div>
                                </div>
                                <select class="border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none font-medium">
                                    <option>Monthly</option>
                                    <option>Weekly</option>
                                    <option>Yearly</option>
                                </select>
                            </div>
                            <div class="relative">
                                <canvas id="overviewChart" height="80"></canvas>
                            </div>
                        </div>
                    </div>

                    {{-- Right Section: Calendar --}}
                    <div class="bg-white rounded-xl p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            {{-- PERBAIKAN: Update bulan ke bulan saat ini --}}
                            <h3 class="text-xl font-bold text-gray-800" id="currentMonth">{{ date('F, Y') }}</h3>
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
                                // PERBAIKAN: Generate tanggal dinamis berdasarkan bulan saat ini
                                $firstDayOfMonth = date('N', strtotime(date('Y-m-01')));
                                $daysInMonth = date('t');
                                $dates = [];
                                
                                // Hari dari bulan sebelumnya
                                $prevMonthDays = $firstDayOfMonth - 1;
                                if ($prevMonthDays > 0) {
                                    $prevMonthLastDay = date('t', strtotime('-1 month'));
                                    for ($i = $prevMonthLastDay - $prevMonthDays + 1; $i <= $prevMonthLastDay; $i++) {
                                        $dates[] = ['day' => $i, 'current' => false];
                                    }
                                }
                                
                                // Hari bulan ini
                                for ($i = 1; $i <= $daysInMonth; $i++) {
                                    $dates[] = ['day' => $i, 'current' => true];
                                }
                                
                                // Hari dari bulan berikutnya
                                $totalCells = 42; // 6 rows x 7 days
                                $nextMonthDays = $totalCells - count($dates);
                                for ($i = 1; $i <= $nextMonthDays; $i++) {
                                    $dates[] = ['day' => $i, 'current' => false];
                                }
                            @endphp

                            @foreach($dates as $date)
                                @if($date['current'])
                                    @if($date['day'] == date('j'))
                                        <div class="w-10 h-10 flex items-center justify-center bg-blue-600 text-white rounded-lg font-medium text-sm">{{ $date['day'] }}</div>
                                    @else
                                        <div class="w-10 h-10 flex items-center justify-center hover:bg-gray-100 rounded-lg text-gray-700 text-sm cursor-pointer font-medium">{{ $date['day'] }}</div>
                                    @endif
                                @else
                                    <div class="w-10 h-10 flex items-center justify-center text-gray-300 text-sm font-medium">{{ $date['day'] }}</div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // PERBAIKAN: Handle kasus ketika variabel tidak terdefinisi
        let currentRunningCount = {{ $runningCount ?? 0 }};
        let currentFinishedCount = {{ $finishedCount ?? 0 }};

        // Chart.js Configuration
        const ctx = document.getElementById('overviewChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Finished',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, currentFinishedCount],
                    borderColor: '#EC4899',
                    backgroundColor: 'transparent',
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#EC4899'
                }, {
                    label: 'Running',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, currentRunningCount],
                    borderColor: '#3B82F6',
                    backgroundColor: 'transparent',
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#3B82F6'
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
                        boxHeight: 8,
                        titleFont: {
                            family: 'Inter',
                            size: 12,
                            weight: '500'
                        },
                        bodyFont: {
                            family: 'Inter',
                            size: 11,
                            weight: '400'
                        },
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += context.parsed.y;
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: Math.max(currentRunningCount, currentFinishedCount, 10) + 10,
                        ticks: {
                            stepSize: Math.ceil(Math.max(currentRunningCount, currentFinishedCount, 10) / 5),
                            color: '#9CA3AF',
                            font: {
                                family: 'Inter',
                                size: 11,
                                weight: '400'
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
                                family: 'Inter',
                                size: 11,
                                weight: '400'
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Function untuk update chart data
        function updateChartData(runningCount, finishedCount) {
            // PERBAIKAN: Validasi input
            runningCount = runningCount || 0;
            finishedCount = finishedCount || 0;
            
            // Update data untuk semua bulan dengan data terbaru
            chart.data.datasets[0].data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, finishedCount];
            chart.data.datasets[1].data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, runningCount];
            
            // Update skala Y axis
            const maxValue = Math.max(runningCount, finishedCount, 10) + 10;
            chart.options.scales.y.max = maxValue;
            chart.options.scales.y.ticks.stepSize = Math.ceil(maxValue / 5);
            
            // Update chart
            chart.update();
            
            // Simpan nilai terbaru
            currentRunningCount = runningCount;
            currentFinishedCount = finishedCount;
        }

        // Real-time functionality untuk update status Running dan Finished
        try {
            const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key', 'local') }}', {
                cluster: '{{ config('broadcasting.connections.pusher.options.cluster', 'mt1') }}',
                encrypted: true
            });

            const channel = pusher.subscribe('code-stemi-dashboard');

            // Listen for real-time updates
            channel.bind('status.updated', function(data) {
                // PERBAIKAN: Validasi data sebelum update
                if (data && typeof data.runningCount !== 'undefined' && typeof data.finishedCount !== 'undefined') {
                    // Update running count
                    document.getElementById('runningCount').textContent = data.runningCount;
                    
                    // Update finished count
                    document.getElementById('finishedCount').textContent = data.finishedCount;
                    
                    // Update chart dengan data real-time
                    updateChartData(data.runningCount, data.finishedCount);
                    
                    console.log('Real-time update received:', data);
                }
            });

        } catch (error) {
            console.log('Pusher not configured or error:', error);
        }

        // Initial chart update dengan data saat ini
        updateChartData(currentRunningCount, currentFinishedCount);

        // PERBAIKAN: Fallback untuk kasus variabel tidak terdefinisi
        document.addEventListener('DOMContentLoaded', function() {
            // Pastikan elemen ada sebelum memanipulasi
            const runningCountEl = document.getElementById('runningCount');
            const finishedCountEl = document.getElementById('finishedCount');
            
            if (runningCountEl && runningCountEl.textContent === '') {
                runningCountEl.textContent = '0';
            }
            if (finishedCountEl && finishedCountEl.textContent === '') {
                finishedCountEl.textContent = '0';
            }
        });
    </script>
</body>
</html>