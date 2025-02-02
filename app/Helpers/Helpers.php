<?php

if (!function_exists('formatVisits')) {
    function formatVisits($number)
    {
        if ($number >= 1000000) {
            return round($number / 1000000, 1) . 'jt'; // Contoh: 1.2jt
        } elseif ($number >= 1000) {
            return round($number / 1000, 1) . 'rb'; // Contoh: 1.1rb
        }
        return $number; // Jika di bawah 1000, tampilkan biasa
    }
}
