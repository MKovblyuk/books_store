<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('resourceNotFoundJsonResponse')) {
    function resourceNotFoundJsonResponse()
    {
        return response()->json(['message' => 'Not Found Resource'], 404);
    }
}

if (!function_exists('getVariableMemoryUsage')) {
    function getVariableMemoryUsage($var)
    {
        $startMemory = memory_get_usage();
        $tmp = unserialize(serialize($var)); 
        return memory_get_usage() - $startMemory;
    }
}

if (!function_exists('logExecutionTimeAfterStart')) {
    function logExecutionTimeAfterStart(string $title = '') {
        Log::channel('execution_time')->info("$title: " . microtime(true) - LARAVEL_START . ' seconds');
    }
}
