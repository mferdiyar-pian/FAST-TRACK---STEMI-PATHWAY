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
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
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
        
        /* State default untuk semua tanggal */
        .calendar-day {
            background-color: transparent !important;
            color: #374151 !important;
        }
        
        /* Hover state */
        .calendar-day:hover {
            background-color: #3b82f6 !important;
            color: white !important;
        }
        
        /* Hari ini - hanya background biru muda */
        .calendar-day.today {
            background-color: #dbeafe !important;
            color: #1e40af !important;
            font-weight: 600;
        }
        
        /* Tanggal yang dipilih - background biru tua */
        .calendar-day.selected {
            background-color: #1d4ed8 !important;
            color: white !important;
            font-weight: 600;
        }
        
        /* Hari ini yang dipilih - tetap biru tua */
        .calendar-day.today.selected {
            background-color: #1d4ed8 !important;
            color: white !important;
        }
        
        /* Non-interactive days (bulan lain) */
        .calendar-day.other-month {
            color: #d1d5db !important;
            cursor: default;
        }
        
        .calendar-day.other-month:hover {
            background-color: transparent !important;
            color: #d1d5db !important;
        }

        .loading-spinner {
            border: 2px solid #f3f4f6;
            border-top: 2px solid #3b82f6;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

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
                        <div class="flex items-center gap-3">
                            <span class="text-gray-700 font-medium text-sm">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
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
                        <div class="bg-white rounded-xl p-6 shadow-sm chart-container">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Overview - Code STEMI Activities</h3>
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
        // Variabel global
        let currentDate = new Date();
        let selectedDate = null;
        let chart = null;
        let realTimeInterval = null;
        let chartInterval = null;
        let currentTimeRange = 'monthly';

        // Data chart dari PHP (default)
        const chartLabels = <?php echo isset($chartData) ? json_encode(array_column($chartData, 'month')) : '[]' ?>;
        const chartRunning = <?php echo isset($chartData) ? json_encode(array_column($chartData, 'running')) : '[]' ?>;
        const chartFinished = <?php echo isset($chartData) ? json_encode(array_column($chartData, 'finished')) : '[]' ?>;

        // Initialize Chart
        function initializeChart(labels = null, runningData = null, finishedData = null) {
            const ctx = document.getElementById('overviewChart').getContext('2d');
            
            // Gunakan data yang diberikan atau data default
            const finalLabels = labels || chartLabels;
            const finalRunning = runningData || chartRunning;
            const finalFinished = finishedData || chartFinished;
            
            const maxRunning = Math.max(...finalRunning);
            const maxFinished = Math.max(...finalFinished);
            const maxValue = Math.max(maxRunning, maxFinished, 10) + 2;

            // Hancurkan chart yang ada jika ada
            if (chart) {
                chart.destroy();
            }

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
                        fill: true
                    }, {
                        label: 'Running',
                        data: finalRunning,
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        borderWidth: 3,
                        fill: true
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
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            max: maxValue,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                stepSize: Math.ceil(maxValue / 5)
                            }
                        },
                        x: { 
                            grid: { 
                                display: false 
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
        }

        // Function untuk memuat data chart berdasarkan time range
        async function loadChartData(timeRange) {
            try {
                console.log('Loading chart data for:', timeRange);
                
                // Tampilkan loading state
                const chartContainer = document.querySelector('.chart-container');
                chartContainer.classList.add('opacity-50');
                
                const response = await fetch(`/dashboard/chart-stats?range=${timeRange}`);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                console.log('Chart data response:', data);
                
                if (data.success) {
                    // Update chart dengan data baru
                    initializeChart(data.labels, data.running, data.finished);
                } else {
                    console.error('Failed to load chart data:', data.message);
                    // Fallback ke data default
                    initializeChart();
                }
            } catch (error) {
                console.error('Error loading chart data:', error);
                // Fallback ke data default
                initializeChart();
            } finally {
                // Hilangkan loading state
                chartContainer.classList.remove('opacity-50');
            }
        }

        // Function untuk generate kalender
        function generateCalendar(year, month) {
            const calendarGrid = document.getElementById('calendarGrid');
            const currentMonthElement = document.getElementById('currentMonth');
            
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
                
                // Base class untuk semua tanggal
                let className = 'w-10 h-10 flex items-center justify-center rounded-lg text-sm font-medium calendar-day ';
                
                // Cek jika hari ini
                const isToday = dateFormatted === todayFormatted;
                
                // Cek jika selected
                const isSelected = selectedDate === dateFormatted;
                
                // APPLY LOGIC: selected > today > normal
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
                
                // Tambahkan event listener untuk semua tanggal di bulan yang ditampilkan
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

        // Function untuk handle klik tanggal
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
                // Hapus today class jika yang diklik adalah hari ini
                clickedElement.classList.remove('today');
            }
            
            // Update info tanggal yang dipilih
            updateSelectedDateInfo(date);
            
            // Ambil data untuk tanggal yang dipilih
            fetchDateData(date);
        }

        // Function untuk update info tanggal yang dipilih
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
                
                selectedDateElement.textContent = ` - ${formattedDate}`;
                selectedDateFinishedElement.textContent = ` - ${formattedDate}`;
                selectedDateElement.classList.remove('hidden');
                selectedDateFinishedElement.classList.remove('hidden');
                dataSourceElement.textContent = 'Selected date data';
                dataSourceFinishedElement.textContent = 'Selected date data';
            } else {
                selectedDateElement.classList.add('hidden');
                selectedDateFinishedElement.classList.add('hidden');
                dataSourceElement.textContent = 'All time data';
                dataSourceFinishedElement.textContent = 'All time data';
            }
        }

        // Function untuk reset selection
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
            
            // Update info
            updateSelectedDateInfo(null);
            
            // Reset ke data real-time (ALL TIME DATA)
            fetchRealTimeStats();
        }

        // Function untuk ambil data berdasarkan tanggal
        async function fetchDateData(date) {
            try {
                console.log('Fetching data for date:', date);
                
                document.getElementById('runningCount').innerHTML = '<div class="loading-spinner inline-block"></div>';
                document.getElementById('finishedCount').innerHTML = '<div class="loading-spinner inline-block"></div>';

                const response = await fetch(`/dashboard/date-data?date=${date}`);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                console.log('API Response:', data);
                
                if (data.success) {
                    document.getElementById('runningCount').textContent = data.running_count;
                    document.getElementById('finishedCount').textContent = data.finished_count;
                    
                    console.log(`Data for ${date}: Running=${data.running_count}, Finished=${data.finished_count}`);
                } else {
                    console.error('API returned error:', data.message);
                    // Fallback: set ke 0 jika tidak ada data
                    document.getElementById('runningCount').textContent = 0;
                    document.getElementById('finishedCount').textContent = 0;
                }
            } catch (error) {
                console.error('Error fetching date data:', error);
                // Fallback: set ke 0 jika error
                document.getElementById('runningCount').textContent = 0;
                document.getElementById('finishedCount').textContent = 0;
            }
        }

        // Function untuk ambil data real-time stats (ALL TIME DATA)
        async function fetchRealTimeStats() {
            try {
                const response = await fetch('/dashboard/dashboard-stats');
                const data = await response.json();
                
                if (data.success) {
                    // HANYA update jika tidak ada tanggal yang dipilih
                    if (!selectedDate) {
                        document.getElementById('runningCount').textContent = data.stats.total_running;
                        document.getElementById('finishedCount').textContent = data.stats.total_finished;
                        updateSelectedDateInfo(null);
                    }
                }
            } catch (error) {
                console.error('Error fetching real-time stats:', error);
            }
        }

        // Function untuk setup intervals
        function setupIntervals() {
            // Clear existing intervals
            if (realTimeInterval) clearInterval(realTimeInterval);
            if (chartInterval) clearInterval(chartInterval);
            
            // Real-time stats interval - hanya update jika tidak ada selected date
            realTimeInterval = setInterval(() => {
                if (!selectedDate) {
                    fetchRealTimeStats();
                }
            }, 30000);
        }

        // Event Listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize chart dengan data default
            initializeChart();
            
            // Generate calendar
            const currentYear = currentDate.getFullYear();
            const currentMonth = currentDate.getMonth();
            generateCalendar(currentYear, currentMonth);
            
            // Event listener untuk prev/next month
            document.getElementById('prevMonth').addEventListener('click', function() {
                currentDate.setMonth(currentDate.getMonth() - 1);
                generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
                resetCalendarSelection();
            });
            
            document.getElementById('nextMonth').addEventListener('click', function() {
                currentDate.setMonth(currentDate.getMonth() + 1);
                generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
                resetCalendarSelection();
            });
            
            // Event listener untuk time range selector
            document.getElementById('timeRange').addEventListener('change', function(e) {
                currentTimeRange = e.target.value;
                loadChartData(currentTimeRange);
            });
            
            // Setup intervals
            setupIntervals();
            
            // Load initial data
            fetchRealTimeStats();
        });

        // Real-time functionality dengan Pusher
        try {
            const pusher = new Pusher('{{ config("broadcasting.connections.pusher.key", "local") }}', {
                cluster: '{{ config("broadcasting.connections.pusher.options.cluster", "mt1") }}',
                encrypted: true
            });

            const channel = pusher.subscribe('code-stemi');
            channel.bind('CodeStemiStatusUpdated', function(data) {
                console.log('Real-time update received');
                
                // Jika ada tanggal yang dipilih, refresh data tanggal tersebut
                // Jika tidak ada tanggal yang dipilih, refresh data real-time
                if (selectedDate) {
                    console.log('Refreshing selected date data:', selectedDate);
                    fetchDateData(selectedDate);
                } else {
                    console.log('Refreshing all-time data');
                    fetchRealTimeStats();
                }
                
                // Refresh chart data juga
                loadChartData(currentTimeRange);
            });

        } catch (error) {
            console.log('Pusher initialization error:', error);
        }
    </script>
</body>
</html>