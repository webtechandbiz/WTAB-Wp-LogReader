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
        <?php submit_button(); ?>
    </form><?php
}