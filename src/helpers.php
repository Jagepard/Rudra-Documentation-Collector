<?php

if (!function_exists('str_contains')) {
    /**
     * Polyfills the str_contains function for earlier versions of PHP
     *
     * @param  $haystack
     * @param  $needle
     * @return void
     */
    function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}
