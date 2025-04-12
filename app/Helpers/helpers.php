<?php

namespace App\Helpers;

class AppHelper
{
    public static function initials(string $name): string
    {
        $names = explode(' ', $name);
        $initials = '';

        foreach ($names as $n) {
            $initials .= strtoupper(substr($n, 0, 1));
            if (strlen($initials) >= 2) break;
        }

        return $initials;
    }

    public static function formatDate(\DateTimeInterface $date, string $format = 'l, F j, Y \a\t g:i A'): string
    {
        return $date->format($format);
    }
}
