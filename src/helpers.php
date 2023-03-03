<?php

if (!function_exists('str_contains')) {
    /**
     * Polyfills the str_contains function for earlier versions of PHP
     *
     * @param  [type] $haystack
     * @param  [type] $needle
     * @return void
     */
    function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}
