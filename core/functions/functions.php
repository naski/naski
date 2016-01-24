<?php

function loadJSONConfig($filename) {
    $config_file = file_get_contents(ROOT_SYSTEM . 'app/config/' . $filename);
    $config_json = json_decode($config_file, $assoc = true);
    return $config_json;
}
