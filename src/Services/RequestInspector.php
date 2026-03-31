<?php

namespace Adeel3330\InsightGuard\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RequestInspector
{
    protected array $issues = [];

    /**
     * Inspect request for security issues
     */
    public function inspect(Request $request): array
    {
        // Example: Detect missing validation keys
        $requiredFields = ['email', 'password'];
        foreach ($requiredFields as $field) {
            if (!$request->has($field) || empty($request->input($field))) {
                $this->issues[] = "Request is missing required field: $field";
            }
        }

        // Example: Detect sensitive fields in GET query
        foreach ($request->query() as $key => $value) {
            if (in_array($key, ['password', 'token', 'secret'])) {
                $this->issues[] = "Sensitive data `$key` detected in query string!";
            }
        }

        return $this->issues;
    }
}