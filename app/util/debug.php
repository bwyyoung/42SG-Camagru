<?php

namespace util;

include dirname(__FILE__)."/../../config/config.php";
use const config\DEBUG_MODE;


class Debug
{
    private static bool $First_Use = false;

    private static function check_first() {
        if (self::$First_Use || !DEBUG_MODE)
            return;
        $name = $_GET['name'] ?? 'CAMAGRU';
        header('Content-Type: text/html; charset=utf-8');
        self::$First_Use = true;
    }
    public static function print_string(string $a) {
        self::check_first();
        if (DEBUG_MODE)
            print '<p>'.$a.'</p>';
    }

    public static function console_log(string $a) {
        if (!DEBUG_MODE)
            return;
        $output = 'console.log(' . json_encode($a) . ');';
        $output  = sprintf('<script>%s</script>', $output);
        echo $output;
    }

    public static function print_array(array $a) {
        self::check_first();
        if (DEBUG_MODE)
            print '<p>'.print_r($a, true).'</p>';
    }
    public static function echo_return (string $a) :bool{
        echo $a;
        return true;
    }
}