<?php
if (isset($_GET['lang'])) {
    $Lang = $_GET['lang'];
}

$LLang = !empty($LanguageCodes) && array_key_exists($Lang, $LanguageCodes) ? $LanguageCodes[$Lang] : $Lang;
$translationMap = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . $LLang . '.json');
$translations = json_decode($translationMap, true);

function _($key) {
    global $translations;
    $args = func_get_args();
    array_shift($args);
    return array_key_exists($key, $translations) ? vsprintf($translations[$key], $args) : $key;
}

unset($translationMap);
