<!DOCTYPE html>
<html>
<head>
    <title>InsightGuard Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
    <h1 class="text-3xl font-bold mb-6">Laravel InsightGuard Dashboard</h1>

    <!-- Security -->
    <section class="mb-6">
        <h2 class="text-2xl font-semibold mb-2">Security Issues</h2>
        @if(count($security))
            <ul class="list-disc pl-6 text-red-600">
                @foreach($security as $issue)
                    <li>{{ $issue }}</li>
                @endforeach
            </ul>
        @else
            <p class="text-green-600">No security issues detected</p>
        @endif
    </section>

    <!-- Performance -->
    <section class="mb-6">
        <h2 class="text-2xl font-semibold mb-2">Performance Report</h2>

        <h3 class="font-semibold">Slow Queries</h3>
        @if(count($performance['slow_queries']))
            <ul class="list-disc pl-6 text-orange-600">
                @foreach($performance['slow_queries'] as $query)
                    <li>{{ $query['sql'] }} ({{ $query['time'] }}ms)</li>
                @endforeach
            </ul>
        @else
            <p class="text-green-600">No slow queries detected</p>
        @endif

        <h3 class="font-semibold mt-4">Potential N+1 Queries</h3>
        @if(count($performance['n_plus_one_candidates']))
            <ul class="list-disc pl-6 text-orange-600">
                @foreach($performance['n_plus_one_candidates'] as $q)
                    <li>{{ $q['query'] }} executed {{ $q['executed_times'] }} times</li>
                @endforeach
            </ul>
        @else
            <p class="text-green-600">No potential N+1 queries detected</p>
        @endif
    </section>

    <!-- Database -->
    <section class="mb-6">
        <h2 class="text-2xl font-semibold mb-2">Database Suggestions</h2>
        @if(count($database))
            <ul class="list-disc pl-6 text-blue-600">
                @foreach($database as $issue)
                    <li>{{ $issue }}</li>
                @endforeach
            </ul>
        @else
            <p class="text-green-600">No database issues detected</p>
        @endif
    </section>

    <!-- Model -->
    <section class="mb-6">
        <h2 class="text-2xl font-semibold mb-2">Model Suggestions</h2>
        @if(count($modelIssues))
            <ul class="list-disc pl-6 text-purple-600">
                @foreach($modelIssues as $issue)
                    <li>{{ $issue }}</li>
                @endforeach
            </ul>
        @else
            <p class="text-green-600">No model issues detected</p>
        @endif
    </section>

    <!-- Code Optimizer -->
    <section class="mb-6">
        <h2 class="text-2xl font-semibold mb-2">Code Optimizer Suggestions</h2>
        @if(count($codeIssues))
            <ul class="list-disc pl-6 text-yellow-600">
                @foreach($codeIssues as $issue)
                    <li>{{ $issue }}</li>
                @endforeach
            </ul>
        @else
            <p class="text-green-600">No code issues detected</p>
        @endif

        <h3 class="font-semibold mt-4">Cache Suggestions</h3>
        @if(count($cacheSuggestions))
            <ul class="list-disc pl-6 text-yellow-600">
                @foreach($cacheSuggestions as $suggestion)
                    <li>{{ $suggestion }}</li>
                @endforeach
            </ul>
        @else
            <p class="text-green-600">Caching is optimized</p>
        @endif
    </section>

    <!-- Request -->
    <section class="mb-6">
        <h2 class="text-2xl font-semibold mb-2">Request Analysis</h2>
        @if(count($requestIssues))
            <ul class="list-disc pl-6 text-pink-600">
                @foreach($requestIssues as $issue)
                    <li>{{ $issue }}</li>
                @endforeach
            </ul>
        @else
            <p class="text-green-600">No request issues detected</p>
        @endif
    </section>

    <div class="mt-6">
        <a href="{{ route('insightguard.export.pdf') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Export PDF</a>
        <a href="{{ route('insightguard.export.json') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Export JSON</a>
    </div>
</body>
</html>