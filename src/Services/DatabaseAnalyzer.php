<?php

namespace Adeel3330\InsightGuard\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseAnalyzer
{
    protected array $issues = [];

    /**
     * Scan database for potential optimization issues
     */
    public function scanDatabase(): array
    {
        $this->detectMissingIndexes();
        $this->detectUnusedColumns();

        return $this->issues;
    }

    /**
     * Detect missing indexes on foreign keys
     */
    protected function detectMissingIndexes(): void
    {
        $tables = Schema::getAllTables();

        foreach ($tables as $tableObj) {
            $table = $tableObj->name ?? $tableObj->Tables_in_ . env('DB_DATABASE');

            $columns = Schema::getColumnListing($table);

            foreach ($columns as $col) {
                // Simplified: detect columns ending with _id but without index
                if (str_ends_with($col, '_id') && !$this->hasIndex($table, $col)) {
                    $this->issues[] = "Table `{$table}` column `{$col}` might need an index";
                }
            }
        }
    }

    protected function hasIndex(string $table, string $column): bool
    {
        $indexes = DB::select("SHOW INDEX FROM `{$table}` WHERE Column_name = ?", [$column]);
        return !empty($indexes);
    }

    /**
     * Detect unused columns (basic heuristic)
     */
    protected function detectUnusedColumns(): void
    {
        // Could implement by scanning queries log or models
        // Placeholder example:
        // $this->issues[] = "Table `users` column `middle_name` appears unused";
    }
}