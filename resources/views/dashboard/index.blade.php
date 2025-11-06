<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Track STEMI Pathway - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-weight: 400;
            line-height: 1.5;
            letter-spacing: -0.011em;
        }
        
        .font-semibold { font-weight: 600; }
        .font-bold { font-weight: 700; }
        .font-medium { font-weight: 500; }
        
        .text-xs { font-size: 0.75rem; line-height: 1rem; }
        .text-sm { font-size: 0.875rem; line-height: 1.25rem; }
        .text-lg { font-size: 1.125rem; line-height: 1.75rem; }
        .text-xl { font-size: 1.25rem; line-height: 1.75rem; }
        .text-2xl { font-size: 1.5rem; line-height: 2rem; }
        .text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
        .text-4xl { font-size: 2.25rem; line-height: 2.5rem; }

        /* CALENDAR STYLES */
        .calendar-day {
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        .calendar-day {
            background-color: transparent !important;
            color: #374151 !important;
        }
        
        .calendar-day:hover {
            background-color: #3b82f6 !important;
            color: white !important;
        }
        
        .calendar-day.today {
            background-color: #dbeafe !important;
            color: #1e40af !important;
            font-weight: 600;
        }
        
        .calendar-day.selected {
            background-color: #1d4ed8 !important;
            color: white !important;
            font-weight: 600;
        }
        
        .calendar-day.today.selected {
            background-color: #1d4ed8 !important;
            color: white !important;
        }
        
        .calendar-day.other-month {
            color: #d1d5db !important;
            cursor: default;
        }
        
        .calendar-day.other-month:hover {
            background-color: transparent !important;
            color: #d1d5db !important;
        }

        .sidebar-active {
            background-color: #eff6ff;
            color: #2563eb;
            border-left: 4px solid #2563eb;
        }
        
        .sidebar-item:hover {
            background-color: #f9fafb;
        }

        /* Profile image styling */
        .profile-image {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e5e7eb;
        }

        /* Search input styling untuk placeholder yang panjang */
        .search-input::placeholder {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
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
                <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 px-6 py-3 sidebar-active">
                    <i class="fas fa-th-large w-5"></i><span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('data-nakes.index') }}" class="flex items-center gap-3 px-6 py-3 text-gray-500 sidebar-item">
                    <i class="fas fa-user-md w-5"></i><span class="font-medium">Data Nakes</span>
                </a>
                <a href="{{ route('code-stemi.index') }}" class="flex items-center gap-3 px-6 py-3 text-gray-500 sidebar-item">
                    <i class="fas fa-file-medical-alt w-5"></i><span class="font-medium">Code STEMI</span>
                </a>
                <a href="{{ route('setting.index') }}" class="flex items-center gap-3 px-6 py-3 text-gray-500 sidebar-item">
                    <i class="fas fa-cog w-5"></i><span class="font-medium">Setting</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Header yang SAMA PERSIS dengan halaman Data Nakes -->
            <header class="bg-white shadow-sm px-8 py-4">
                <div class="flex items-center justify-between">
                    <div></div>
                    <div class="flex items-center gap-6">
                        <form id="searchForm" method="GET" action="{{ route('dashboard.index') }}"
                            class="relative flex items-center">
                            <input type="text" name="search" id="searchInput" 
                                placeholder="Search type of keywords"
                                value="{{ request('search') }}"
                                class="w-80 pl-4 pr-10 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent text-sm transition-all duration-200 search-input" />
                            <button type="submit"
                                class="absolute right-3 text-gray-400 hover:text-blue-600 transition-all duration-150">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                        
                        {{-- User Profile dengan Foto --}}
                        <div x-data="{ isOpen: false }" class="relative">
                            <button @click="isOpen = !isOpen" class="flex items-center gap-3 focus:outline-none hover:bg-gray-50 rounded-lg px-3 py-2 transition-all duration-200">
                                {{-- Foto Profil --}}
                                @if(Auth::user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" 
                                         alt="{{ Auth::user()->name }}" 
                                         class="profile-image">
                                @else
                                    {{-- Default avatar dengan inisial --}}
                                    <div class="profile-image bg-blue-500 flex items-center justify-center text-white font-semibold text-sm">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                                
                                <div class="flex flex-col items-start">
                                    <span class="text-gray-700 font-medium text-sm">{{ Auth::user()->name }}</span>
                                    <span class="text-gray-500 text-xs">{{ Auth::user()->role ?? 'Admin' }}</span>
                                </div>
                                <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                            </button>

                            <div x-show="isOpen" @click.away="isOpen = false" x-transition
                                class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl z-50 border border-gray-200 py-2">
                                {{-- Header Profil di Dropdown --}}
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <div class="flex items-center gap-3">
                                        @if(Auth::user()->profile_photo_path)
                                            <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" 
                                                 alt="{{ Auth::user()->name }}" 
                                                 class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                                {{ substr(Auth::user()->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</span>
                                            <span class="text-xs text-gray-500">{{ Auth::user()->email }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <a href="{{ route('setting.index') }}"
                                    class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-user-circle text-gray-400 w-4"></i>
                                    <span>Profil Saya</span>
                                </a>
                                <a href="{{ route('setting.index') }}?tab=password"
                                    class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-key text-gray-400 w-4"></i>
                                    <span>Ubah Password</span>
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center gap-3 w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-sign-out-alt text-gray-400 w-4"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Dashboard Content -->
            <div class="p-8">
                <div class="grid grid-cols-3 gap-6">
                    <!-- Left Section: Stats & Chart -->
                    <div class="col-span-2 space-y-6">
                        <!-- Stats Cards -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white rounded-xl p-6 shadow-sm">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-500 text-sm mb-2 font-medium">Running</p>
                                        <p id="runningCount" class="text-4xl font-bold text-gray-800">{{ $runningCount ?? 0 }}</p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            <span id="dataSource">All time data</span>
                                            <span id="selectedDateInfo" class="hidden text-blue-600 font-medium"></span>
                                        </p>
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
                                        <p id="finishedCount" class="text-4xl font-bold text-gray-800">{{ $finishedCount ?? 0 }}</p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            <span id="dataSourceFinished">All time data</span>
                                            <span id="selectedDateInfoFinished" class="hidden text-blue-600 font-medium"></span>
                                        </p>
                                    </div>
                                    <div class="w-12 h-12 bg-pink-50 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user-check text-pink-500 text-xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chart -->
                        <div class="bg-white rounded-xl p-6 shadow-sm">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2" id="chartTitle">Overview - Monthly Code STEMI Activities</h3>
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
                                <select id="timeRange" class="border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none font-medium">
                                    <option value="monthly">Monthly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                            </div>
                            <div class="relative">
                                <canvas id="overviewChart" height="80"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Right Section: Calendar -->
                    <div class="bg-white rounded-xl p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-800" id="currentMonth">{{ date('F, Y') }}</h3>
                            <div class="flex gap-2">
                                <button id="prevMonth" class="w-8 h-8 flex items-center justify-center hover:bg-gray-100 rounded">
                                    <i class="fas fa-chevron-left text-gray-400"></i>
                                </button>
                                <button id="nextMonth" class="w-8 h-8 flex items-center justify-center hover:bg-gray-100 rounded">
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-7 gap-2 text-center" id="calendarGrid">
                            <!-- Calendar akan di-generate oleh JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // ==================== GLOBAL VARIABLES ====================
        let currentDate = new Date();
        let selectedDate = null;
        let chart = null;
        let currentTimeRange = 'monthly';

        // Data ASLI dari PHP - langsung dari database Code STEMI
        const chartLabels = <?php echo isset($chartData) && !empty($chartData) ? json_encode(array_column($chartData, 'month')) : '["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"]' ?>;
        const chartRunning = <?php echo isset($chartData) && !empty($chartData) ? json_encode(array_column($chartData, 'running')) : '[0,0,0,0,0,0,0,0,0,0,0,0]' ?>;
        const chartFinished = <?php echo isset($chartData) && !empty($chartData) ? json_encode(array_column($chartData, 'finished')) : '[0,0,0,0,0,0,0,0,0,0,0,0]' ?>;

        // ==================== SEARCH FUNCTION ====================

        // Handle search form submission
        document.getElementById('searchForm')?.addEventListener('submit', function(e) {
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

        // Real-time search (opsional)
        let searchTimeout;
        document.getElementById('searchInput')?.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (this.value.length >= 3 || this.value.length === 0) {
                    document.getElementById('searchForm').dispatchEvent(new Event('submit'));
                }
            }, 500);
        });

        // ==================== CHART FUNCTIONS ====================

        /**
         * Initialize chart dengan DATA ASLI dari Code STEMI
         */
        function initializeChart() {
            const ctx = document.getElementById('overviewChart');
            if (!ctx) {
                console.error('Chart canvas element not found!');
                return;
            }

            // Pastikan data valid
            const finalLabels = Array.isArray(chartLabels) && chartLabels.length > 0 ? chartLabels : ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            const finalRunning = Array.isArray(chartRunning) && chartRunning.length > 0 ? chartRunning : [0,0,0,0,0,0,0,0,0,0,0,0];
            const finalFinished = Array.isArray(chartFinished) && chartFinished.length > 0 ? chartFinished : [0,0,0,0,0,0,0,0,0,0,0,0];

            // Hitung max value untuk skala Y
            const maxRunning = Math.max(...finalRunning);
            const maxFinished = Math.max(...finalFinished);
            const maxValue = Math.max(maxRunning, maxFinished, 10) + 2;

            console.log('📊 Initializing chart with REAL DATA from Code STEMI:', {
                labels: finalLabels,
                running: finalRunning,
                finished: finalFinished
            });

            try {
                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: finalLabels,
                        datasets: [{
                            label: 'Finished',
                            data: finalFinished,
                            borderColor: '#EC4899',
                            backgroundColor: 'rgba(236, 72, 153, 0.1)',
                            tension: 0.4,
                            borderWidth: 3,
                            fill: true,
                            pointBackgroundColor: '#EC4899',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }, {
                            label: 'Running',
                            data: finalRunning,
                            borderColor: '#3B82F6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            borderWidth: 3,
                            fill: true,
                            pointBackgroundColor: '#3B82F6',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { 
                            legend: { 
                                display: false 
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                backgroundColor: 'rgba(255, 255, 255, 0.95)',
                                titleColor: '#1f2937',
                                bodyColor: '#1f2937',
                                borderColor: '#e5e7eb',
                                borderWidth: 1,
                                padding: 12,
                                callbacks: {
                                    title: function(tooltipItems) {
                                        return `Month: ${tooltipItems[0].label}`;
                                    },
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        label += context.parsed.y;
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: { 
                                beginAtZero: true,
                                max: maxValue,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)',
                                    drawBorder: false
                                },
                                ticks: {
                                    precision: 0,
                                    stepSize: Math.ceil(maxValue / 5)
                                }
                            },
                            x: { 
                                grid: { 
                                    display: false 
                                },
                                ticks: {
                                    autoSkip: false,
                                    maxRotation: 0
                                }
                            }
                        },
                        interaction: {
                            mode: 'nearest',
                            axis: 'x',
                            intersect: false
                        }
                    }
                });

                console.log('✅ Chart initialized successfully with REAL DATA');

            } catch (error) {
                console.error('Chart initialization error:', error);
            }
        }

        /**
         * Load chart data berdasarkan range (manual - hanya ketika user mengganti filter)
         */
        async function loadChartData(timeRange) {
            try {
                console.log('Loading chart data for:', timeRange);
                
                const response = await fetch(`/dashboard/chart-stats?range=${timeRange}`);
                const data = await response.json();
                
                if (data.success) {
                    // Update chart dengan data baru
                    updateChart(data.labels, data.running, data.finished, timeRange);
                    currentTimeRange = timeRange;
                    
                    // Update chart title
                    updateChartTitle(timeRange);
                }
            } catch (error) {
                console.error('Error loading chart data:', error);
            }
        }

        /**
         * Update chart dengan data baru
         */
        function updateChart(labels, runningData, finishedData, range) {
            if (!chart) return;

            chart.data.labels = labels;
            chart.data.datasets[0].data = finishedData;
            chart.data.datasets[1].data = runningData;
            
            // Update scales jika diperlukan
            const maxRunning = Math.max(...runningData);
            const maxFinished = Math.max(...finishedData);
            const maxValue = Math.max(maxRunning, maxFinished, 10) + 2;
            
            chart.options.scales.y.max = maxValue;
            chart.options.scales.y.ticks.stepSize = Math.ceil(maxValue / 5);
            
            chart.update();
        }

        /**
         * Update chart title berdasarkan range
         */
        function updateChartTitle(range) {
            const chartTitle = document.getElementById('chartTitle');
            if (chartTitle) {
                chartTitle.textContent = range === 'yearly' 
                    ? 'Overview - Yearly Code STEMI Activities' 
                    : 'Overview - Monthly Code STEMI Activities';
            }
        }

        // ==================== CALENDAR FUNCTIONS ====================

        /**
         * Generate calendar
         */
        function generateCalendar(year, month) {
            const calendarGrid = document.getElementById('calendarGrid');
            const currentMonthElement = document.getElementById('currentMonth');
            
            if (!calendarGrid || !currentMonthElement) {
                console.error('Calendar elements not found!');
                return;
            }

            currentMonthElement.textContent = new Date(year, month).toLocaleString('en-US', { 
                month: 'long', 
                year: 'numeric' 
            });

            calendarGrid.innerHTML = '';

            // Header hari
            const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            days.forEach(day => {
                const dayElement = document.createElement('div');
                dayElement.className = 'text-xs font-semibold text-blue-600 mb-2';
                dayElement.textContent = day;
                calendarGrid.appendChild(dayElement);
            });

            // Hitung hari
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const daysInMonth = lastDay.getDate();
            const startingDay = (firstDay.getDay() + 6) % 7;

            const today = new Date();
            const todayFormatted = today.toISOString().split('T')[0];

            // Hari bulan sebelumnya
            const prevMonthLastDay = new Date(year, month, 0).getDate();
            for (let i = 0; i < startingDay; i++) {
                const dayElement = document.createElement('div');
                dayElement.className = 'w-10 h-10 flex items-center justify-center text-gray-300 text-sm font-medium calendar-day other-month';
                dayElement.textContent = prevMonthLastDay - startingDay + i + 1;
                calendarGrid.appendChild(dayElement);
            }

            // Hari bulan ini
            for (let i = 1; i <= daysInMonth; i++) {
                const dayElement = document.createElement('div');
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                const dateFormatted = new Date(dateString).toISOString().split('T')[0];
                
                let className = 'w-10 h-10 flex items-center justify-center rounded-lg text-sm font-medium calendar-day ';
                
                const isToday = dateFormatted === todayFormatted;
                const isSelected = selectedDate === dateFormatted;
                
                if (isSelected) {
                    className += 'selected';
                } else if (isToday) {
                    className += 'today';
                } else {
                    className += 'text-gray-700';
                }

                dayElement.className = className;
                dayElement.textContent = i;
                dayElement.setAttribute('data-date', dateFormatted);
                
                dayElement.addEventListener('click', function() {
                    handleDateClick(dateFormatted);
                });
                
                calendarGrid.appendChild(dayElement);
            }

            // Hari bulan berikutnya
            const totalCells = 42;
            const remainingCells = totalCells - (startingDay + daysInMonth);
            for (let i = 1; i <= remainingCells; i++) {
                const dayElement = document.createElement('div');
                dayElement.className = 'w-10 h-10 flex items-center justify-center text-gray-300 text-sm font-medium calendar-day other-month';
                dayElement.textContent = i;
                calendarGrid.appendChild(dayElement);
            }
        }

        /**
         * Handle klik tanggal
         */
        function handleDateClick(date) {
            console.log('Date clicked:', date);
            
            // Jika mengklik tanggal yang sama, reset selection
            if (selectedDate === date) {
                resetCalendarSelection();
                return;
            }
            
            // Hapus selected class dari semua element
            document.querySelectorAll('.calendar-day').forEach(day => {
                day.classList.remove('selected');
                
                // Kembalikan class today untuk hari ini jika ada
                const dayDate = day.getAttribute('data-date');
                const today = new Date();
                const todayFormatted = today.toISOString().split('T')[0];
                
                if (dayDate === todayFormatted && dayDate !== date) {
                    day.classList.add('today');
                }
            });
            
            // Set selected date baru
            selectedDate = date;
            
            // Tambahkan selected class ke element yang diklik
            const clickedElement = document.querySelector(`[data-date="${date}"]`);
            if (clickedElement) {
                clickedElement.classList.add('selected');
                clickedElement.classList.remove('today');
            }
            
            // Update info tanggal yang dipilih
            updateSelectedDateInfo(date);
            
            // Ambil data untuk tanggal yang dipilih
            fetchDateData(date);
        }

        /**
         * Update info tanggal yang dipilih
         */
        function updateSelectedDateInfo(date) {
            const selectedDateElement = document.getElementById('selectedDateInfo');
            const selectedDateFinishedElement = document.getElementById('selectedDateInfoFinished');
            const dataSourceElement = document.getElementById('dataSource');
            const dataSourceFinishedElement = document.getElementById('dataSourceFinished');
            
            if (date) {
                const formattedDate = new Date(date).toLocaleDateString('en-US', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
                
                if (selectedDateElement) {
                    selectedDateElement.textContent = ` - ${formattedDate}`;
                    selectedDateElement.classList.remove('hidden');
                }
                if (selectedDateFinishedElement) {
                    selectedDateFinishedElement.textContent = ` - ${formattedDate}`;
                    selectedDateFinishedElement.classList.remove('hidden');
                }
                if (dataSourceElement) dataSourceElement.textContent = 'Selected date data';
                if (dataSourceFinishedElement) dataSourceFinishedElement.textContent = 'Selected date data';
            } else {
                if (selectedDateElement) selectedDateElement.classList.add('hidden');
                if (selectedDateFinishedElement) selectedDateFinishedElement.classList.add('hidden');
                if (dataSourceElement) dataSourceElement.textContent = 'All time data';
                if (dataSourceFinishedElement) dataSourceFinishedElement.textContent = 'All time data';
            }
        }

        /**
         * Reset calendar selection
         */
        function resetCalendarSelection() {
            selectedDate = null;
            
            document.querySelectorAll('.calendar-day').forEach(day => {
                day.classList.remove('selected');
                
                // Kembalikan class today untuk hari ini
                const dayDate = day.getAttribute('data-date');
                const today = new Date();
                const todayFormatted = today.toISOString().split('T')[0];
                
                if (dayDate === todayFormatted) {
                    day.classList.add('today');
                }
            });
            
            updateSelectedDateInfo(null);
            
            // Reset ke data awal
            document.getElementById('runningCount').textContent = '{{ $runningCount ?? 0 }}';
            document.getElementById('finishedCount').textContent = '{{ $finishedCount ?? 0 }}';
        }

        /**
         * Ambil data berdasarkan tanggal
         */
        async function fetchDateData(date) {
            try {
                const response = await fetch(`/dashboard/date-data?date=${date}`);
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('runningCount').textContent = data.running_count;
                    document.getElementById('finishedCount').textContent = data.finished_count;
                } else {
                    document.getElementById('runningCount').textContent = '0';
                    document.getElementById('finishedCount').textContent = '0';
                }
            } catch (error) {
                console.error('Error fetching date data:', error);
                document.getElementById('runningCount').textContent = '0';
                document.getElementById('finishedCount').textContent = '0';
            }
        }

        // ==================== INITIALIZATION ====================

        /**
         * Initialize dashboard
         */
        function initializeDashboard() {
            console.log('🚀 Initializing dashboard...');
            
            // Initialize chart dengan DATA ASLI (langsung muncul)
            initializeChart();
            
            // Generate calendar
            generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
            
            // Setup event listeners
            setupEventListeners();
            
            console.log('✅ Dashboard initialized successfully');
        }

        /**
         * Setup event listeners
         */
        function setupEventListeners() {
            // Previous month button
            const prevMonthBtn = document.getElementById('prevMonth');
            if (prevMonthBtn) {
                prevMonthBtn.addEventListener('click', function() {
                    currentDate.setMonth(currentDate.getMonth() - 1);
                    generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
                    resetCalendarSelection();
                });
            }
            
            // Next month button
            const nextMonthBtn = document.getElementById('nextMonth');
            if (nextMonthBtn) {
                nextMonthBtn.addEventListener('click', function() {
                    currentDate.setMonth(currentDate.getMonth() + 1);
                    generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
                    resetCalendarSelection();
                });
            }
            
            // Time range selector - hanya load data ketika user mengganti
            const timeRangeSelect = document.getElementById('timeRange');
            if (timeRangeSelect) {
                timeRangeSelect.addEventListener('change', function(e) {
                    const newRange = e.target.value;
                    console.log('Time range changed to:', newRange);
                    loadChartData(newRange);
                });
            }
        }

        // ==================== START DASHBOARD ====================

        // Initialize ketika DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            initializeDashboard();
        });
    </script>
</body>
</html>