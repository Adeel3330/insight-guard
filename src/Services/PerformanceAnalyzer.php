<?php

namespace Adeel3330\InsightGuard\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PerformanceAnalyzer
{
    protected array $queries = [];
    protected array $nPlusOneCandidates = [];

    public function __construct()
    {
        $this->listenToQueries();
    }

    protected function listenToQueries(): void
    {
        DB::listen(function ($query) {
            $this->queries[] = [
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'time' => $query->time,
            ];
        });
    }

    /**
     * Detect slow queries
     */
    public function getSlowQueries(float $thresholdMs = 100): array
    {
        $slow = [];
        foreach ($this->queries as $q) {
            if ($q['time'] > $thresholdMs) {
                $slow[] = $q;
            }
        }
        return $slow;
    }

    /**
     * Detect potential N+1 queries (simplified heuristic)
     */
    public function detectNPlusOne(): array
    {
        $counts = [];
        foreach ($this->queries as $q) {
            $sql = preg_replace('/\s+/', ' ', $q['sql']);
            $counts[$sql] = ($counts[$sql] ?? 0) + 1;
        }

        foreach ($counts as $sql => $count) {
            if ($count > 1) {
                $this->nPlusOneCandidates[] = [
                    'query' => $sql,
                    'executed_times' => $count
                ];
            }
        }

        return $this->nPlusOneCandidates;
    }

    /**
     * Full performance report
     */
    public function scanPerformance(): array
    {
        return [
            'slow_queries' => $this->getSlowQueries(),
            'n_plus_one_candidates' => $this->detectNPlusOne(),
        ];
    }
}