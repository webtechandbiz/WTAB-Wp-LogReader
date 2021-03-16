<?php
//# Panel form sections
function _getSectionsLogReaderFields(){
    $ary_ = array(
        'Log reader setup' => 
            array(
                'section_slug' => 'section_LogReaderSetup_slug',
                'fields' => array(
                    'Error filename' => 
                        array(
                            'field_slug' => 'field_ErrorFileName_slug',
                            'field_type' => 'text' //# It could be: text, textarea, select, checkbox
                        )
                    ,
                )
            ),
    );
    return $ary_;
}

//# Panel form register
function register_pnl_form_drefregech_settings() {
    $ary = _getSectionsLogReaderFields();
    foreach ($ary as $section_label => $section_conf){
        $section_slug = $section_conf['section_slug'];
        $fields = $section_conf['fields'];

        foreach ($fields as $field_label => $field_conf){
            if($field_label !== '-'){
                register_setting( 'drefregech_pnl_form_settings_page', $field_conf['field_slug'] );
            }
        }
    }
    
    register_setting( 'drefregech_pnl_form_settings_page', 'choosenfile' );
    register_setting( 'drefregech_pnl_form_settings_page', 'wpdebugactive' );
}

//# Panel form page
function drefregech_pnl_form_settings_page() {?>
    <div class="wrap">
        <h1>Panel form</h1>
    </div>
    <form class="admin_drefregech_pnl_form_settings_page_table" method="post" action="options.php">
        <?php settings_fields( 'drefregech_pnl_form_settings_page' ); ?>
        <?php do_settings_sections( 'drefregech_pnl_form_settings_page' ); ?>
        <table><?php
            $ary = _getSectionsLogReaderFields();
            foreach ($ary as $section_label => $section_conf){
                $section_slug = $section_conf['section_slug'];
                $fields = $section_conf['fields'];

                echo '<tr><td colspan="2"><b>'.$section_label.'</b></td></tr>';
                foreach ($fields as $field_label => $field_conf){
                    if($field_label !== '-'){
                        switch ($field_conf['field_type']) {
                            case 'text':
                                echo '
                                    <tr>
                                        <td>'.$field_label.'</td><td><input type="text" name="'.$field_conf['field_slug'].'" value="'.get_option($field_conf['field_slug']).'"/></td>
                                    </tr>';
                                break;

                            case 'textarea':
                                echo '
                                    <tr>
                                        <td>'.$field_label.'</td><td><textarea name="'.$field_conf['field_slug'].'">'.get_option($field_conf['field_slug']).'</textarea></td>
                                    </tr>';
                                break;

                            case 'select':
                                if(isset($field_conf['options']) && is_array($field_conf['options'])){
                                    $_options = '';
                                    $_option_selected = false;
                                    foreach ($field_conf['options'] as $_option_value => $option_label){
                                        if(intval(get_option($field_conf['field_slug'])) === intval($_option_value)){
                                            $_options .= '<option selected="selected" value="'.$_option_value.'">'.$option_label.'</option>';
                                        }else{
                                            $_options .= '<option value="'.$_option_value.'">'.$option_label.'</option>';
                                        }
                                    }
                                    if(!$_option_selected){
                                        $_options = '<option value="">-</option>'.$_options;
                                    }
                                    echo '
                                        <tr>
                                            <td>'.$field_label.'</td><td><select id="'.$field_conf['field_slug'].'" name="'.$field_conf['field_slug'].'">'.$_options.'</select></td>
                                        </tr>';
                                }
                                break;

                            case 'checkbox':
                                $_options = '';
                                $_option_selected = false;

                                if(intval(get_option($field_conf['field_slug'])) == 1){
                                    $_option_selected = true;
                                }
                                echo '<input type="hidden" id="'.$field_conf['field_slug'].'" name="'.$field_conf['field_slug'].'" value="'.get_option($field_conf['field_slug']).'"/></td>';
                                if($_option_selected){
                                    echo '
                                        <tr>
                                            <td>'.$field_label.'</td><td><input class="wtab_chk" checked="checked" type="checkbox" id="chk_'.$field_conf['field_slug'].'" name="chk_'.$field_conf['field_slug'].'" value="1"/></td>
                                        </tr>';
                                }else{
                                    echo '
                                        <tr>
                                            <td>'.$field_label.'</td><td><input class="wtab_chk" type="checkbox" id="chk_'.$field_conf['field_slug'].'" name="chk_'.$field_conf['field_slug'].'" value="0"/></td>
                                        </tr>';
                                }
                                break;

                            default:
                                break;
                        }
                    }
                }
            }
            ?>
        </table>

        <?php
        echo '<h2>(most likely) Error filenames in the website:</h2>';
        echo '<input type="hidden" id="choosenfile" name="choosenfile" value="'.get_option('choosenfile').'"/></td>';
        echo '<table>';

        $error_log_file_found = false;
        $_get_error_log_files_from_website = get_error_log_files_from_website(ABSPATH);
        $_field_ErrorFileName_slugs = explode('|', get_option('choosenfile'));
        foreach ($_get_error_log_files_from_website as $file){
            $_options = '';
            $_option_selected = false;
            foreach ($_field_ErrorFileName_slugs as $__field_ErrorFileName_slug){
                if($__field_ErrorFileName_slug === $file){
                    $_option_selected = true;
                }
            }
            if($_option_selected){
                echo '
                    <tr>
                        <td>'.$file.'</td><td><input data-filename="'.$file.'" class="wtab_chk_choosenfile" checked="checked" type="checkbox" name="chk_choosenfile" value="1"/></td>
                    </tr>';
            }else{
                echo '
                    <tr>
                        <td>'.$file.'</td><td><input data-filename="'.$file.'" class="wtab_chk_choosenfile" type="checkbox" name="chk_choosenfile" value="0"/></td>
                    </tr>';
            }

            $error_log_file_found = true;
        }
        if(!$error_log_file_found){
            echo 'I can\'t find any error log file. Try to click on "WTAB Log Reader form" e type the error log filename.';
        }
        echo '</table>';

        //# WP Debug
        if(intval(get_option('wpdebugactive')) > 0){
            $_wpdebugactive_selected = true;
        }else{
            $_wpdebugactive_selected = false;
        }
        echo '<h2>Debug mode</h2>';
        echo '<input type="hidden" id="wpdebugactive" name="wpdebugactive" value="'.get_option('wpdebugactive').'"/></td>';
        echo '<table>';
            if($_wpdebugactive_selected){
                echo '
                    <tr>
                        <td>WP_DEBUG state (is active?)</td><td><input class="wtab_chk_wpdebugactive" checked="checked" type="checkbox" name="chk_wpdebugactive" value="1"/></td>
                    </tr>';

                if (!defined('WP_DEBUG')){
                    define( 'WP_DEBUG', true );
                }

                if (!defined('WP_DEBUG_LOG')){
                    define( 'WP_DEBUG_LOG', true );
                }

                if (!defined('SCRIPT_DEBUG')){
                    define( 'SCRIPT_DEBUG', true );
                }
            }else{
                echo '
                    <tr>
                        <td>WP_DEBUG</td><td><input class="wtab_chk_wpdebugactive" type="checkbox" name="chk_wpdebugactive" value="0"/></td>
                    </tr>';
            }
        echo '</table>';

        //# Show PHP messages
        if(intval(get_option('wpshowphpmsgactive')) > 0){
            $_wpshowphpmsgactive_selected = true;
        }else{
            $_wpshowphpmsgactive_selected = false;
        }
        echo '<h2>View PHP message mode</h2>';
        echo '<input type="hidden" id="wpshowphpmsgactive" name="wpshowphpmsgactive" value="'.get_option('wpshowphpmsgactive').'"/></td>';
        echo '<table>';
            if($_wpshowphpmsgactive_selected){
                echo '
                    <tr>
                        <td>Show PHP messages ?</td><td><input class="wtab_chk_wpshowphpmsgactive" checked="checked" type="checkbox" name="chk_wpshowphpmsgactive" value="1"/></td>
                    </tr>';

                if (!defined('WP_DEBUG_DISPLAY')){
                    define( 'WP_DEBUG_DISPLAY', true );
                    @ini_set( 'display_errors', 1 );
                }

            }else{
                echo '
                    <tr>
                        <td>WP_DEBUG_DISPLAY</td><td><input class="wtab_chk_wpshowphpmsgactive" type="checkbox" name="chk_wpshowphpmsgactive" value="0"/></td>
                    </tr>';

                if (!defined('WP_DEBUG_DISPLAY')){
                    define( 'WP_DEBUG_DISPLAY', false );
                    @ini_set( 'display_errors', 0 );
                }
            }
        echo '</table>';

        submit_button(); ?>
    </form>
    <?php
}
