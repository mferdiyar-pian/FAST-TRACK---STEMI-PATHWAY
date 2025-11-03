<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Track STEMI Pathway - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
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
        
        /* Calendar Styles */
        .calendar-day {
            transition: all 0.2s ease;
        }
        
        .calendar-day:hover {
            background-color: #3b82f6 !important;
            color: white !important;
        }
        
        .calendar-day.selected {
            background-color: #1d4ed8 !important;
            color: white !important;
        }
        
        .calendar-day.has-events {
            position: relative;
        }
        
        .calendar-day.has-events::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            background-color: #3b82f6;
            border-radius: 50%;
        }
        
        .calendar-day.has-events.selected::after {
            background-color: white;
        }
        
        /* Sidebar active state */
        .sidebar-active {
            background-color: #eff6ff;
            color: #2563eb;
            border-left: 4px solid #2563eb;
        }
        
        .sidebar-item:hover {
            background-color: #f9fafb;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-sm">
            <div class="p-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/Logo.PNG') }}" alt="Fast Track STEMI Pathway"
                        class="h-14 w-14 object-contain">
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
            <header class="bg-white shadow-sm px-8 py-4">
                <div class="flex items-center justify-between">
                    <div></div>
                    <div class="flex items-center gap-6">
                        <form class="relative flex items-center">
                            <input type="text" placeholder="Search type of keywords"
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
                        <div x-data="{ isOpen: false }" class="relative">
                            <button @click="isOpen = !isOpen" class="flex items-center gap-3 focus:outline-none">
                                <span class="text-gray-700 font-medium text-sm">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                            </button>

                            <div x-show="isOpen" @click.away="isOpen = false"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-10">
                                <a href="{{ route('setting.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
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
                                        <p id="runningCount" class="text-4xl font-bold text-gray-800">0</p>
                                        <p id="dateIndicator" class="text-xs text-gray-400 mt-1">All time data</p>
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
                                        <p id="finishedCount" class="text-4xl font-bold text-gray-800">0</p>
                                        <p id="dateIndicatorFinished" class="text-xs text-gray-400 mt-1">All time data</p>
                                    </div>
                                    <div class="w-12 h-12 bg-pink-50 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user-check text-pink-500 text-xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chart -->
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
                                <div class="flex items-center gap-2">
                                    <button id="resetFilter" class="bg-blue-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-600 transition-colors hidden">
                                        Reset Filter
                                    </button>
                                    <select id="timeRange" class="border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none font-medium">
                                        <option value="monthly">Monthly</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="yearly">Yearly</option>
                                    </select>
                                </div>
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
                        
                        <div class="mt-4 p-3 bg-blue-50 rounded-lg hidden" id="selectedDateInfo">
                            <p class="text-sm text-blue-700 font-medium">
                                <i class="fas fa-calendar-day mr-2"></i>
                                <span id="selectedDateText"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Variabel global
        let currentDate = new Date();
        let selectedDate = null;
        let monthEvents = {};
        let currentRunningCount = 0;
        let currentFinishedCount = 0;

        // Chart.js Configuration
        const ctx = document.getElementById('overviewChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Finished',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    borderColor: '#EC4899',
                    backgroundColor: 'transparent',
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#EC4899'
                }, {
                    label: 'Running',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
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
                        max: 10,
                        ticks: {
                            stepSize: 2,
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

        // Function untuk generate kalender
        function generateCalendar(year, month) {
            const calendarGrid = document.getElementById('calendarGrid');
            const currentMonthElement = document.getElementById('currentMonth');
            
            // Update judul bulan
            currentMonthElement.textContent = new Date(year, month).toLocaleString('en-US', { 
                month: 'long', 
                year: 'numeric' 
            });

            // Kosongkan grid
            calendarGrid.innerHTML = '';

            // Tambahkan header hari
            const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            days.forEach(day => {
                const dayElement = document.createElement('div');
                dayElement.className = 'text-xs font-semibold text-blue-600 mb-2';
                dayElement.textContent = day;
                calendarGrid.appendChild(dayElement);
            });

            // Hitung hari dalam bulan
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const daysInMonth = lastDay.getDate();
            const startingDay = (firstDay.getDay() + 6) % 7; // Adjust for Monday start

            // Tambahkan hari dari bulan sebelumnya
            const prevMonthLastDay = new Date(year, month, 0).getDate();
            for (let i = 0; i < startingDay; i++) {
                const dayElement = document.createElement('div');
                dayElement.className = 'w-10 h-10 flex items-center justify-center text-gray-300 text-sm font-medium';
                dayElement.textContent = prevMonthLastDay - startingDay + i + 1;
                calendarGrid.appendChild(dayElement);
            }

            // Tambahkan hari bulan ini
            const today = new Date();
            const todayFormatted = today.toISOString().split('T')[0];
            
            for (let i = 1; i <= daysInMonth; i++) {
                const dayElement = document.createElement('div');
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                const dateFormatted = new Date(dateString).toISOString().split('T')[0];
                
                let className = 'w-10 h-10 flex items-center justify-center rounded-lg text-sm cursor-pointer font-medium calendar-day ';
                
                // Cek jika hari ini
                if (dateFormatted === todayFormatted) {
                    className += 'bg-blue-600 text-white ';
                } else {
                    className += 'hover:bg-gray-100 text-gray-700 ';
                }
                
                // Cek jika ada events (simulasi data acak untuk demo)
                const hasEvents = Math.random() > 0.7; // 30% kemungkinan ada event
                if (hasEvents) {
                    className += 'has-events ';
                }
                
                // Cek jika selected
                if (selectedDate === dateFormatted) {
                    className += 'selected';
                }

                dayElement.className = className;
                dayElement.textContent = i;
                dayElement.setAttribute('data-date', dateFormatted);
                
                dayElement.addEventListener('click', function() {
                    handleDateClick(dateFormatted);
                });
                
                calendarGrid.appendChild(dayElement);
            }

            // Tambahkan hari dari bulan berikutnya
            const totalCells = 42; // 6 rows
            const remainingCells = totalCells - (startingDay + daysInMonth);
            for (let i = 1; i <= remainingCells; i++) {
                const dayElement = document.createElement('div');
                dayElement.className = 'w-10 h-10 flex items-center justify-center text-gray-300 text-sm font-medium';
                dayElement.textContent = i;
                calendarGrid.appendChild(dayElement);
            }
        }

        // Function untuk handle klik tanggal
        function handleDateClick(date) {
            selectedDate = date;
            
            // Update tampilan kalender
            document.querySelectorAll('.calendar-day').forEach(day => {
                day.classList.remove('selected');
                if (day.getAttribute('data-date') === date) {
                    day.classList.add('selected');
                }
            });
            
            // Tampilkan info tanggal yang dipilih
            const selectedDateInfo = document.getElementById('selectedDateInfo');
            const selectedDateText = document.getElementById('selectedDateText');
            const resetButton = document.getElementById('resetFilter');
            
            selectedDateText.textContent = `Selected: ${new Date(date).toLocaleDateString('en-US', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            })}`;
            
            selectedDateInfo.classList.remove('hidden');
            resetButton.classList.remove('hidden');
            
            // Ambil data untuk tanggal yang dipilih (simulasi)
            fetchDateData(date);
        }

        // Function untuk ambil data berdasarkan tanggal (simulasi)
        function fetchDateData(date) {
            // Simulasi data berdasarkan tanggal
            const dateObj = new Date(date);
            const dayOfMonth = dateObj.getDate();
            
            // Data acak untuk demo
            const runningCount = Math.floor(Math.random() * 10) + 1;
            const finishedCount = Math.floor(Math.random() * 5) + 1;
            
            // Update running count
            document.getElementById('runningCount').textContent = runningCount;
            document.getElementById('finishedCount').textContent = finishedCount;
            
            // Update date indicator
            document.getElementById('dateIndicator').textContent = `Data for ${new Date(date).toLocaleDateString()}`;
            document.getElementById('dateIndicatorFinished').textContent = `Data for ${new Date(date).toLocaleDateString()}`;
            
            // Update chart dengan data baru
            updateChartData(runningCount, finishedCount);
        }

        // Function untuk reset filter
        function resetFilter() {
            selectedDate = null;
            
            // Reset tampilan kalender
            document.querySelectorAll('.calendar-day').forEach(day => {
                day.classList.remove('selected');
            });
            
            // Sembunyikan info tanggal
            document.getElementById('selectedDateInfo').classList.add('hidden');
            document.getElementById('resetFilter').classList.add('hidden');
            
            // Reset ke data semua waktu
            document.getElementById('runningCount').textContent = currentRunningCount;
            document.getElementById('finishedCount').textContent = currentFinishedCount;
            
            document.getElementById('dateIndicator').textContent = 'All time data';
            document.getElementById('dateIndicatorFinished').textContent = 'All time data';
            
            // Reset chart
            updateChartData(currentRunningCount, currentFinishedCount);
        }

        // Function untuk update chart data
        function updateChartData(runningCount, finishedCount) {
            runningCount = runningCount || 0;
            finishedCount = finishedCount || 0;
            
            // Update data chart untuk bulan Desember saja (untuk demo)
            chart.data.datasets[0].data[11] = finishedCount;
            chart.data.datasets[1].data[11] = runningCount;
            
            const maxValue = Math.max(runningCount, finishedCount, 10) + 10;
            chart.options.scales.y.max = maxValue;
            chart.options.scales.y.ticks.stepSize = Math.ceil(maxValue / 5);
            
            chart.update();
            
            currentRunningCount = runningCount;
            currentFinishedCount = finishedCount;
        }

        // Function untuk ambil data events bulanan (simulasi)
        function fetchMonthData(year, month) {
            // Simulasi data bulanan
            monthEvents = {};
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            
            for (let i = 1; i <= daysInMonth; i++) {
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                // 30% kemungkinan ada event
                if (Math.random() > 0.7) {
                    monthEvents[dateString] = {
                        running: Math.floor(Math.random() * 5),
                        finished: Math.floor(Math.random() * 3)
                    };
                }
            }
            
            generateCalendar(year, month);
        }

        // Event Listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Generate kalender awal
            const currentYear = currentDate.getFullYear();
            const currentMonth = currentDate.getMonth();
            fetchMonthData(currentYear, currentMonth);
            
            // Navigation bulan
            document.getElementById('prevMonth').addEventListener('click', function() {
                currentDate.setMonth(currentDate.getMonth() - 1);
                fetchMonthData(currentDate.getFullYear(), currentDate.getMonth());
            });
            
            document.getElementById('nextMonth').addEventListener('click', function() {
                currentDate.setMonth(currentDate.getMonth() + 1);
                fetchMonthData(currentDate.getFullYear(), currentDate.getMonth());
            });
            
            // Reset filter
            document.getElementById('resetFilter').addEventListener('click', resetFilter);
            
            // Time range selector
            document.getElementById('timeRange').addEventListener('change', function() {
                // Update chart berdasarkan time range yang dipilih
                const timeRange = this.value;
                // Implementasi update chart berdasarkan time range
                console.log('Time range changed to:', timeRange);
            });
            
            // HAPUS: JavaScript yang mencegah navigasi sidebar
            // Kode berikut dihapus karena mencegah link bekerja:
            /*
            document.querySelectorAll('.sidebar-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault(); // INI YANG MENYEBABKAN MASALAH
                    
                    // Remove active class from all items
                    document.querySelectorAll('nav a').forEach(link => {
                        link.classList.remove('sidebar-active');
                        link.classList.remove('bg-blue-50');
                        link.classList.remove('text-blue-600');
                        link.classList.remove('border-l-4');
                        link.classList.remove('border-blue-600');
                        link.classList.add('text-gray-500');
                    });
                    
                    // Add active class to clicked item
                    this.classList.add('sidebar-active');
                    this.classList.add('bg-blue-50');
                    this.classList.add('text-blue-600');
                    this.classList.add('border-l-4');
                    this.classList.add('border-blue-600');
                    this.classList.remove('text-gray-500');
                });
            });
            */
            
            // Initialize with some data
            currentRunningCount = 8;
            currentFinishedCount = 5;
            document.getElementById('runningCount').textContent = currentRunningCount;
            document.getElementById('finishedCount').textContent = currentFinishedCount;
            updateChartData(currentRunningCount, currentFinishedCount);
        });

        // Real-time functionality (opsional - untuk demo)
        try {
            // Simulasi real-time updates
            setInterval(() => {
                // Randomly update counts for demo
                if (Math.random() > 0.7) {
                    const change = Math.random() > 0.5 ? 1 : -1;
                    currentRunningCount = Math.max(0, currentRunningCount + change);
                    document.getElementById('runningCount').textContent = currentRunningCount;
                    
                    if (!selectedDate) {
                        updateChartData(currentRunningCount, currentFinishedCount);
                    }
                }
                
                if (Math.random() > 0.8) {
                    const change = Math.random() > 0.5 ? 1 : -1;
                    currentFinishedCount = Math.max(0, currentFinishedCount + change);
                    document.getElementById('finishedCount').textContent = currentFinishedCount;
                    
                    if (!selectedDate) {
                        updateChartData(currentRunningCount, currentFinishedCount);
                    }
                }
            }, 5000); // Update every 5 seconds
        } catch (error) {
            console.log('Real-time simulation error:', error);
        }
    </script>
</body>
</html>