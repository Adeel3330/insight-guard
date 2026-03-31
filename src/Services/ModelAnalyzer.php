<?php

namespace Adeel3330\InsightGuard\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ModelAnalyzer
{
    protected array $issues = [];

    /**
     * Analyze a model for optimization suggestions
     */
    public function analyzeModel(Model $model): array
    {
        $this->checkUnusedColumns($model);
        $this->checkMissingIndexes($model);
        return $this->issues;
    }

    protected function checkUnusedColumns(Model $model)
    {
        $table = $model->getTable();
        $columns = Schema::getColumnListing($table);

        foreach ($columns as $col) {
            // placeholder: could analyze logs to detect unused columns
            if ($col === 'middle_name') {
                $this->issues[] = "Column `$col` in table `$table` may be unused.";
            }
        }
    }

    protected function checkMissingIndexes(Model $model)
    {
        $table = $model->getTable();
        $columns = Schema::getColumnListing($table);

        foreach ($columns as $col) {
            if (str_ends_with($col, '_id') && !$this->hasIndex($table, $col)) {
                $this->issues[] = "Column `$col` in table `$table` should have an index.";
            }
        }
    }

    protected function hasIndex(string $table, string $column): bool
    {
        $indexes = DB::select("SHOW INDEX FROM `{$table}` WHERE Column_name = ?", [$column]);
        return !empty($indexes);
    }
}