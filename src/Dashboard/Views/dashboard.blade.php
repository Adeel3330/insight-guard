<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InsightGuard Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Fade-in and slide-up animation */
        .fade-in {
            opacity: 0;
            transform: translateY(10px);
            animation: fadeInUp 0.6s forwards;
        }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animated counter */
        .counter {
            font-variant-numeric: tabular-nums;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800">

    <div class="container mx-auto p-6">

        <!-- Header -->
        <h1 class="text-4xl font-bold mb-8 text-gray-900 animate-pulse">InsightGuard Dashboard</h1>

        <!-- Counters -->
        <div class="grid gap-6 md:grid-cols-3 mb-8">
            <div class="fade-in bg-white shadow-md rounded-xl p-6 flex flex-col items-center border-l-4 border-red-500 hover:scale-105 transition transform">
                <p class="text-gray-500">Security Issues</p>
                <p class="text-3xl font-bold counter" data-target="{{ count($security) ?? 0 }}">0</p>
            </div>
            <div class="fade-in bg-white shadow-md rounded-xl p-6 flex flex-col items-center border-l-4 border-orange-500 hover:scale-105 transition transform">
                <p class="text-gray-500">Slow Queries</p>
                <p class="text-3xl font-bold counter" data-target="{{ count($performance['slow_queries']) ?? 0 }}">0</p>
            </div>
            <div class="fade-in bg-white shadow-md rounded-xl p-6 flex flex-col items-center border-l-4 border-blue-500 hover:scale-105 transition transform">
                <p class="text-gray-500">Database Issues</p>
                <p class="text-3xl font-bold counter" data-target="{{ count($database) ?? 0 }}">0</p>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid gap-6 md:grid-cols-2 mb-8">
            <div class="fade-in bg-white shadow-md rounded-xl p-6 border-l-4 border-orange-400 hover:scale-105 transition transform">
                <h2 class="text-xl font-semibold mb-4">Performance Overview</h2>
                <canvas id="performanceChart" height="200"></canvas>
            </div>
            <div class="fade-in bg-white shadow-md rounded-xl p-6 border-l-4 border-red-500 hover:scale-105 transition transform">
                <h2 class="text-xl font-semibold mb-4">Security Overview</h2>
                <canvas id="securityChart" height="200"></canvas>
            </div>
        </div>

        <!-- Sections -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <!-- Model Suggestions -->
            <div class="fade-in bg-white shadow-md rounded-xl p-6 border-l-4 border-purple-500 hover:scale-105 transition transform">
                <h2 class="text-xl font-semibold mb-4">Model Suggestions</h2>
                @if(count($modelIssues))
                    <ul class="list-disc pl-5 text-purple-600 space-y-1">
                        @foreach($modelIssues as $issue)
                            <li>{{ $issue }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-green-600 font-medium">No model issues detected</p>
                @endif
            </div>

            <!-- Code Optimizer -->
            <div class="fade-in bg-white shadow-md rounded-xl p-6 border-l-4 border-yellow-500 hover:scale-105 transition transform">
                <h2 class="text-xl font-semibold mb-4">Code Optimizer</h2>
                @if(count($codeIssues))
                    <ul class="list-disc pl-5 text-yellow-600 space-y-1">
                        @foreach($codeIssues as $issue)
                            <li>{{ $issue }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-green-600 font-medium">No code issues detected</p>
                @endif
            </div>

            <!-- Request Analysis -->
            <div class="fade-in bg-white shadow-md rounded-xl p-6 border-l-4 border-pink-500 hover:scale-105 transition transform">
                <h2 class="text-xl font-semibold mb-4">Request Analysis</h2>
                @if(count($requestIssues))
                    <ul class="list-disc pl-5 text-pink-600 space-y-1">
                        @foreach($requestIssues as $issue)
                            <li>{{ $issue }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-green-600 font-medium">No request issues detected</p>
                @endif
            </div>
        </div>

        <!-- Export Buttons -->
        <div class="mt-8 flex gap-4">
            <a href="{{ route('insightguard.export.pdf') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-md transition transform hover:scale-105">Export PDF</a>
            <a href="{{ route('insightguard.export.json') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg shadow-md transition transform hover:scale-105">Export JSON</a>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <script>
        // Animate counters
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            let count = 0;
            const increment = Math.ceil(target / 100);
            const updateCounter = () => {
                count += increment;
                if (count > target) count = target;
                counter.textContent = count;
                if (count < target) requestAnimationFrame(updateCounter);
            };
            requestAnimationFrame(updateCounter);
        });

        // Chart.js Performance Chart
        const performanceCtx = document.getElementById('performanceChart').getContext('2d');
        const performanceChart = new Chart(performanceCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_map(fn($q) => $q['sql'], $performance['slow_queries'])) !!},
                datasets: [{
                    label: 'Execution Time (ms)',
                    data: {!! json_encode(array_map(fn($q) => $q['time'], $performance['slow_queries'])) !!},
                    backgroundColor: 'rgba(255, 159, 64, 0.7)',
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Security Chart
        const securityCtx = document.getElementById('securityChart').getContext('2d');
        new Chart(securityCtx, {
            type: 'doughnut',
            data: {
                labels: ['Issues', 'No Issues'],
                datasets: [{
                    data: [{{ count($security) ?? 0 }}, {{ count($security) ? 0 : 1 }}],
                    backgroundColor: ['#f87171', '#34d399'],
                }]
            },
            options: { responsive: true }
        });
    </script>
</body>
</html>