<?php

if (!function_exists('is_past')) {
    /**
     * @throws Exception
     */
    function is_past($date): bool {
        $date = new DateTime($date);
        $now = new DateTime();
        if($date < $now) {
            return true;
        } else {
            return false;
        }
    }
}
