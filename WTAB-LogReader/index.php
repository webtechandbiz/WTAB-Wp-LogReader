<?php
/**
 * @package WTAB-LogReader
 */
/*
Plugin Name: WTAB-LogReader
Plugin URI: https://github.com/webtechandbiz/WTAB-Wp-Pnl
Description: Plugin for a WordPress web site to read in a panel the error_log files automatically created by apache when a PHP exception occurs
Version: 0.1
Author: https://github.com/webtechandbiz
Author URI: https://github.com/webtechandbiz
License: MIT - https://opensource.org/licenses/mit-license.php
*/

error_reporting(E_ALL);
ini_set('display_errors', 1);

//# Setup
$wtab_pnl_admin_folder_salt = 'brorepricl';
$wtab_pnl_admin_functions_folder_salt = 'huswakirun';

//# Paths
$admin__folder_path = plugin_dir_path( __FILE__ ).'admin-'.$wtab_pnl_admin_folder_salt.'/';
$admin_functions__folder_path = $admin__folder_path.'-functions-'.$wtab_pnl_admin_functions_folder_salt.'/';

// # URLs
$wtab_pnl__url = plugin_dir_url(__FILE__);
$wtab_pnl_admin__url = $wtab_pnl__url.'admin-'.$wtab_pnl_admin_folder_salt.'/';
$wtab_pnl_admin_public_html__url = $wtab_pnl_admin__url.'public_html/';
$wtab_pnl__css_url = $wtab_pnl_admin_public_html__url.'css/wtab_pnl_css.css';
$wtab_pnl__js_url = $wtab_pnl_admin_public_html__url.'js/wtab_pnl_js.js';

//#Includes
include($admin_functions__folder_path.'-functions.php');
include($admin_functions__folder_path.'-functions-menu.php');
include($admin_functions__folder_path.'-functions-menu-panel-cover.php');
include($admin_functions__folder_path.'-functions-menu-panel-form.php');

//# Admin style + js
//# https://developer.wordpress.org/themes/basics/including-css-javascript/
add_action(
    'admin_enqueue_scripts', function() use ($wtab_pnl__css_url, $wtab_pnl__js_url) {
        wp_enqueue_style( 'wtab_pnl_url', $wtab_pnl__css_url );
        wp_enqueue_script( 'wtab_pnl_js_url', $wtab_pnl__js_url);
    }
);

//# Add the menu
add_action('admin_menu', 'drefregech_create_menu');
