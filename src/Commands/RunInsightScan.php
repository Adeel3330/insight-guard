<?php

namespace Adeel3330\InsightGuard\Commands;

use Illuminate\Console\Command;
use Adeel3330\InsightGuard\Services\SecurityScanner;

class RunInsightScan extends Command
{
    protected $signature = 'insightguard:scan';
    protected $description = 'Run full Laravel InsightGuard scan for security and performance issues';

    public function handle()
    {
        $this->info("Starting InsightGuard scan...");

        // Security Scan
        $securityScanner = new SecurityScanner();
        $securityIssues = $securityScanner->scanControllers();

        // Performance Scan
        $performanceAnalyzer = new PerformanceAnalyzer();
        $performanceReport = $performanceAnalyzer->scanPerformance();

        // Database Scan
        $databaseAnalyzer = new DatabaseAnalyzer();
        $dbIssues = $databaseAnalyzer->scanDatabase();

        // Output Security Issues
        if (!empty($securityIssues)) {
            $this->warn("Security issues found:");
            foreach ($securityIssues as $issue) {
                $this->line(" - {$issue}");
            }
        } else {
            $this->info("No security issues detected.");
        }

        // Output Performance Report
        if (!empty($performanceReport['slow_queries'])) {
            $this->warn("Slow Queries detected:");
            foreach ($performanceReport['slow_queries'] as $q) {
                $this->line(" - {$q['sql']} ({$q['time']}ms)");
            }
        }

        if (!empty($performanceReport['n_plus_one_candidates'])) {
            $this->warn("Potential N+1 Queries:");
            foreach ($performanceReport['n_plus_one_candidates'] as $q) {
                $this->line(" - {$q['query']} executed {$q['executed_times']} times");
            }
        }

        // Output DB Issues
        if (!empty($dbIssues)) {
            $this->warn("Database optimization suggestions:");
            foreach ($dbIssues as $issue) {
                $this->line(" - {$issue}");
            }
        } else {
            $this->info("No database issues detected.");
        }

        $this->info("InsightGuard scan complete!");
    }
}
