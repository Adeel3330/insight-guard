<!DOCTYPE html>
<html>
<head>
    <title>InsightGuard Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1, h2, h3 { color: #333; }
        .red { color: #e3342f; }
        .orange { color: #f6993f; }
        .blue { color: #3490dc; }
    </style>
</head>
<body>
    <h1>Laravel InsightGuard Report</h1>

    <h2 class="red">Security Issues</h2>
    @if(count($security))
        <ul>
            @foreach($security as $issue)
                <li>{{ $issue }}</li>
            @endforeach
        </ul>
    @else
        <p>No security issues detected</p>
    @endif

    <h2 class="orange">Performance Report</h2>
    <h3>Slow Queries</h3>
    @if(count($performance['slow_queries']))
        <ul>
            @foreach($performance['slow_queries'] as $query)
                <li>{{ $query['sql'] }} ({{ $query['time'] }}ms)</li>
            @endforeach
        </ul>
    @else
        <p>No slow queries detected</p>
    @endif

    <h3>Potential N+1 Queries</h3>
    @if(count($performance['n_plus_one_candidates']))
        <ul>
            @foreach($performance['n_plus_one_candidates'] as $q)
                <li>{{ $q['query'] }} executed {{ $q['executed_times'] }} times</li>
            @endforeach
        </ul>
    @else
        <p>No potential N+1 queries detected</p>
    @endif

    <h2 class="blue">Database Suggestions</h2>
    @if(count($database))
        <ul>
            @foreach($database as $issue)
                <li>{{ $issue }}</li>
            @endforeach
        </ul>
    @else
        <p>No database issues detected</p>
    @endif
</body>
</html>