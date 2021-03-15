<?php
function drefregech_settings_page() { ?>
    <div class="wrap">
        <h1>Read PHP logs in the website</h1>
        <p>
            <?php
            $error_log_file_found = false;
            $_get_error_log_files_from_website = get_choosen_error_log_files(ABSPATH);
            foreach ($_get_error_log_files_from_website as $file){
                echo '<h2>'.$file.'</h2>';
                echo nl2br(wp_strip_all_tags(file_get_contents($file)));
                echo '--------------'.PHP_EOL;
                $error_log_file_found = true;
            }
            if(!$error_log_file_found){
                echo 'I can\'t find any error log file. Try to click on "WTAB Log Reader form" e type the error log filename.';
            }
            ?>
        </p>
    </div>
    <?php
}

function get_choosen_error_log_files($dir, &$results = array()) {
    $files = scandir($dir);
    foreach ($files as $k => $v) {
        $path = realpath($dir . '/' . $v);
        if ( is_dir($path) && $v != '.' && $v != '..'){
            get_choosen_error_log_files($path, $results);
        }

        $_field_ErrorFileName_slugs = explode('|', get_option('choosenfile'));
        foreach ($_field_ErrorFileName_slugs as $__field_ErrorFileName_slug){
            if ($__field_ErrorFileName_slug === $path) {
                $results[] = $path;
            }
        }
    }

    return $results;
}
