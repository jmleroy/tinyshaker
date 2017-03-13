<?php
header("Content-type: text/css; charset=UTF-8");
require_once('..' . DIRECTORY_SEPARATOR . 'config.inc.php');
//header('Cache-Control: max-age=3600, must-revalidate');

/**
 * get color with difference
 * @param string $hexStr hexadecimal string
 * @param int $diff
 * @return array|bool
 */
function getColor($hexStr, $diff = 0) {
    if($diff > 255) {
        $diff = 255;
    }
    $color = preg_replace('/[^0-9A-Fa-f]/', '', $hexStr);

    if (strlen($color) == 3) {
        $color = $color[0].$color[0].$color[1].$color[1].$color[2].$color[2];
    }

    if (strlen($color) == 6) {
        $rgb = str_split($color, 2);
        $ret = 0;
        foreach($rgb as $i => $c) {
            $c = hexdec($c) + $diff;
            if($c > 255) {
                $c = 255;
            } elseif($c < 1) {
                $c = 0;
            }
            $ret += $c * pow(256, (2 - $i));
        }

        return sprintf("#%'06X", $ret);
    }

    return '#000000';
}