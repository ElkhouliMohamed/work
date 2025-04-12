<?php
//
if (!function_exists('initials')) {
    function initials($name)
    {
        $names = explode(' ', $name);
        $initials = '';

        foreach ($names as $n) {
            $initials .= strtoupper(substr($n, 0, 1));
            if (strlen($initials) >= 2) break;
        }

        return $initials;
    }
}
