<?php

namespace BooksPlugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Books_Plugin {

    public function __construct() {
        $this->load_dependencies();
        $this->define_admin_hooks();
    }
    private function load_dependencies() {
        require_once plugin_dir_path( __FILE__ ) . 'class-books-plugin-activator.php';
        require_once plugin_dir_path( __FILE__ ) . 'class-books-plugin-deactivator.php';
        require_once plugin_dir_path( __FILE__ ) . 'class-books-post-type.php';
        require_once plugin_dir_path( __FILE__ ) . 'class-books-meta-box.php';
        require_once plugin_dir_path( __FILE__ ) . 'class-books-admin-display.php';
    }
    private function define_admin_hooks() {
        $post_type = new Books_Post_Type();
        $meta_box = new Books_Meta_Box();
        $admin_display = new Books_Admin_Display();

        add_action( 'init', array( $post_type, 'register_custom_post_type' ) );
        add_action( 'add_meta_boxes', array( $meta_box, 'add_meta_box' ) );
        add_action( 'save_post', array( $meta_box, 'save_meta_box_data' ) );
        add_action( 'admin_menu', array( $admin_display, 'add_admin_menu' ) );
        add_action( 'admin_enqueue_scripts', array( $admin_display, 'enqueue_scripts' ) );
    }
    public function run() {
        register_activation_hook( __FILE__, array( 'BooksPlugin\Books_Plugin_Activator', 'activate' ) );
        register_deactivation_hook( __FILE__, array( 'BooksPlugin\Books_Plugin_Deactivator', 'deactivate' ) );
    }
}
