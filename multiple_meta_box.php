<?php
    /**
    * Plugin Name:  Wp Multiple Meta Box
    * Plugin URI: http://agileinfoways.com
    * Description: This plugin is used to create Multi Meta Box and display it to frontend.
    * Version: 2.0
    * Author: Agile Infoways
    * Author URI: http://agileinfoways.com
    * License: GPL2
    */
    if(!defined('ABSPATH'))exit;

    //This is table names which are used in Plugin
    global $wpdb;
    global $table_metabox_fields;
    global $table_metabox_metabox;
    global $table_metabox_fieldtype;
    global $table_multi_meta_table;
    global $table_postmeta;

    $table_metabox_fields    = $wpdb->prefix . "multi_metabox_fields";
    $table_metabox_metabox   = $wpdb->prefix . "multi_metabox_metabox";
    $table_metabox_fieldtype = $wpdb->prefix . "multi_metabox_fieldtype";
    $table_multi_meta_table  = $wpdb->prefix . "multi_meta_table";
    $table_postmeta          = $wpdb->prefix . "postmeta";

    //This are the common files which are included for Global Use
    include('common.php');
    include('function.php');

    //This are Hooks which are called when plugin is loaded
    add_action('admin_menu', 'mmb_multi_metabox_menu');    
    register_activation_hook( __FILE__, 'mmb_multi_metabox_install' );
    register_deactivation_hook( __FILE__, 'mmb_multi_metabox_uninstall' );

?>