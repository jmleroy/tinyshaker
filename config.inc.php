<?php
/**
 * Configuration loader
 */
$configFileName = __DIR__ . DIRECTORY_SEPARATOR . 'config.json';
if(!file_exists($configFileName)) {
    die('Missing config.json file');
}
include_once('config_default.inc.php');
$rawConfig = file_get_contents($configFileName);
$uncommentedConfig = preg_replace("#// .+$#", '', $rawConfig);
$config = json_decode($uncommentedConfig, true);
$filter = array_flip(array(
    "Title",
    "Url",
    "FacebookImageUrl",
    "Description",
    "UrlRewriting",
    "Preload",
    "ShowTitle",
    "FacebookCommentsAppId",
    "Support",
    "ShowUpdt",
    "Credits",
    "ImageWidth",
    "ImageHeight",
    "BgColor",
    "Color",
    "HlColor",
    "Lang",
    "Languages",
    "LanguageCodes",
    "IDGoogleAnalytics",
));

$filteredConfig = array_intersect_key($config, $filter);
extract($filteredConfig);
unset($filteredConfig);
unset($config);
unset($configFileName);
