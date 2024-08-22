<?php

if (!function_exists('get_status')) {
    function get_status($status)
    {
        // Use a switch case to map integer status to the corresponding string value
        switch ($status) {
            case 0:
                $statusValue = 'new';
                break;
            case 1:
                $statusValue = 'inprogress';
                break;
            case 2:
                $statusValue = 'positive_resolved';
                break;
            case 3:
                $statusValue = 'negative_resolved';
                break;
            case 4:
                $statusValue = 'positive_verified';
                break;
            case 5:
                $statusValue = 'negative_verified';
                break;
            case 6:
                $statusValue = 'hold';
                break;
            case 7:
                $statusValue = 'close';
                break;
            default:
                throw new Exception("Invalid status provided.");
        }

        return $statusValue;
    }
}
