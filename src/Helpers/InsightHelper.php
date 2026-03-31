<?php

namespace Adeel3330\InsightGuard\Helpers;

class InsightHelper
{
    /**
     * Format a standard InsightGuard response
     */
    public static function response(array $data, string $message = "Success", bool $status = true): array
    {
        return [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];
    }

    /**
     * Color-code status
     */
    public static function statusColor(bool $status): string
    {
        return $status ? 'green' : 'red';
    }
}