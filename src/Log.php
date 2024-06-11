<?php

class Log
{
    /**
     * Log debug messages with timestamps
     *
     */
    public static function debug($message)
    {
        $timestamp = date('Y-m-d H:i:s');
        error_log("\n [$timestamp] [DEBUG] " . $message, 3, __DIR__ . '/../logs/logs.log');
    }

    /**
     * Log error messages with timestamps
     *
     */
    public static function error($message)
    {
        $timestamp = date('Y-m-d H:i:s');
        error_log("\n [$timestamp] [ERROR] " . $message, 3, __DIR__ . '/../logs/logs.log');
    }
}
