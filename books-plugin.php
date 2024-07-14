<?php
/*
Plugin Name: Books Plugin
Description: A plugin that manages books, including a custom post type, taxonomies, and a meta box for ISBN.
Version: 1.0
Author: Alireza Abedi
Text Domain: books-plugin
Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

require_once plugin_dir_path( __FILE__ ) . 'includes/class-books-plugin.php';

function run_books_plugin() {
    $plugin = new BooksPlugin\Books_Plugin();
    $plugin->run();
}
run_books_plugin();

register_activation_hook( __FILE__, 'books_plugin_activate' );

function books_plugin_activate() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'books_info';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        ID bigint(20) NOT NULL AUTO_INCREMENT,
        post_id bigint(20) NOT NULL,
        isbn varchar(255) DEFAULT '' NOT NULL,
        PRIMARY KEY (ID),
        UNIQUE KEY post_id (post_id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );
}