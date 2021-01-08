<?php
function drefregech_create_menu() {
    add_menu_page('WTAB Log Reader', 'WTAB Log Reader', 'administrator', __FILE__, 'drefregech_settings_page' , plugins_url('/images/icon.png', __FILE__) );

    add_submenu_page(__FILE__, 'WTAB Log Reader form', 'WTAB Log Reader form', 'administrator', 'WTAB Log Reader form', 'drefregech_pnl_form_settings_page');
    add_action( 'admin_init', 'register_pnl_form_drefregech_settings' );
}