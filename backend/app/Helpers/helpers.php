<?php

if (!function_exists('notFoundJsonResponse')) {
    function notFoundJsonResponse()
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
