<?php

function get_error_log_files_from_website($dir, &$results = array()) {
    $files = scandir($dir);
    $_field_ErrorFileName_slug = get_option('field_ErrorFileName_slug');
    
    foreach ($files as $k => $v) {
        $path = realpath($dir . '/' . $v);
        if ( is_dir($path) && $v != '.' && $v != '..'){
            get_error_log_files_from_website($path, $results);
        }

        if($v === $_field_ErrorFileName_slug){
            $results[] = $path;
        }
    }

    return $results;
}
