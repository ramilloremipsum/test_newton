<?php


namespace core\Helpers;


use DateTime;

class NewtonHelper
{
    public static function debug($value)
    {
        echo '<pre>';
        print_r($value);
        echo '</pre>';
    }

    public static function pseudoRandomTimestamp($seconds_diff_for_pseudo_random)
    {
        $now = time();
        return rand($now - $seconds_diff_for_pseudo_random, $now);
    }

    public static function timeBetween($from, $to)
    {
        if ($from > $to) {
            throw new \Exception('"To" must be higher then "From"');
        }
        $diff = $to - $from;
        $hoursVal = floor($diff / 3600);
        $hours = $hoursVal >= 10 ? $hoursVal : '0' . $hoursVal;
        $rest = ($diff - $hoursVal * 3600);
        $minutesVal = floor($rest / 60);
        $minutes = $minutesVal >= 10 ? $minutesVal : '0' . $minutesVal;
        $rest = $rest - $minutes * 60;
        $seconds = $rest >= 10 ? $rest : '0' . $rest;

        return $hours . ':' . $minutes . ':' . $seconds;


    }
}