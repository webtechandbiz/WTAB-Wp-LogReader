<?php

function get_error_log_files_from_website($dir, &$results = array()) {
    $files = scandir($dir);
    $_field_ErrorFileName_slug = get_option('field_ErrorFileName_slug');
    
    foreach ($files as $k => $v) {
        $path = realpath($dir . '/' . $v);
        if ( is_dir($path) && $v != '.' && $v != '..'){
            get_error_log_files_from_website($path, $results);
        }

        $_field_ErrorFileName_slugs = explode(',', $_field_ErrorFileName_slug);
        foreach ($_field_ErrorFileName_slugs as $__field_ErrorFileName_slug){
            $__field_ErrorFileName_slug = trim($__field_ErrorFileName_slug);
            $pos = strpos($v, $__field_ErrorFileName_slug);
            if ($pos === 0) {
                $results[] = $path;
            }
        }
    }

    return $results;
}
