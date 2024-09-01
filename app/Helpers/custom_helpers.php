<?php

if (! function_exists('yesOrNo')) {
    function yesOrNo($value)
    {
        switch ($value) {
            case 1:
                $response = 'Si';
                break;
            case 0:
                if (is_null($value)) {
                    $response = 'N/A';
                } else {
                    $response = 'No';
                }
                break;
            default:
                $response = 'N/A';
                break;
        }
        return $response;
    }
}
