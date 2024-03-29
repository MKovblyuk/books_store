<?php

if (!function_exists('notFoundJsonResponse')) {
    function notFoundJsonResponse()
    {
        return response()->json(['message' => 'Not Found Resource'], 404);
    }
}
