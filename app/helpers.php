<?php

if (!function_exists('ddf')) {
    /**
     * adds file name and line location to dd()
     *
     * @return arrayProductController
     */
    function ddf()
    {
        if (request()->ajax() && !app()->environment('testing')) {
            header("HTTP/1.0 500 Internal Server Error");
        }

        $args = func_get_args();

        array_unshift($args, basename(debug_backtrace()[0]['file']) . ' line ' . debug_backtrace()[0]['line']);

        array_map(function ($value) {
            dump($value);
        }, $args);
        die(1);
    }
}


if (!function_exists('ddq')) {
    /**
     * Debug query by outputing sql + bindings
     *
     * @return void
     */
    function ddq($query)
    {
        $sql = explode('?', $query->toSql());
        $bindings = $query->getBindings();
        $fullString = '';

        foreach ($sql as $key => $parameter) {
            $fullString .= $parameter . (array_key_exists($key, $bindings) ? '\'' . $bindings[$key] . '\'' : '');
        }

        return dd(
            $query->toSql(),
            $query->getBindings(),
            $fullString
        );
    }
}
