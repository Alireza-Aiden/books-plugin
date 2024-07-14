<?php

namespace BooksPlugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Books_Admin_Display {

    public function add_admin_menu() {
        add_menu_page(
            __( 'Books Info', 'books-plugin' ),
            __( 'Books Info', 'books-plugin' ),
            'manage_options',
            'books-info',
            array( $this, 'display_books_info' ),
            'dashicons-book',
            6
        );
    }

    public function display_books_info() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'books_info';
        $books_info = $wpdb->get_results( "SELECT * FROM $table_name" );

        if ( ! class_exists( 'WP_List_Table' ) ) {
            require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
        }

        class Books_Info_List_Table extends \WP_List_Table {

            private $data;

            public function __construct( $data ) {
                parent::__construct( array(
                    'singular' => __( 'Book Info', 'books-plugin' ),
                    'plural'   => __( 'Books Info', 'books-plugin' ),
                    'ajax'     => false,
                ) );

                $this->data = $data;
            }

            public function get_columns() {
                return array(
                    'ID'      => __( 'ID', 'books-plugin' ),
                    'post_id' => __( 'Post ID', 'books-plugin' ),
                    'isbn'    => __( 'ISBN', 'books-plugin' ),
                );
            }

            public function prepare_items() {
                $columns  = $this->get_columns();
                $hidden   = array();
                $sortable = array();
                $this->_column_headers = array( $columns, $hidden, $sortable );

                $this->items = $this->data;
            }

            public function column_default( $item, $column_name ) {
                switch ( $column_name ) {
                    case 'ID':
                    case 'post_id':
                    case 'isbn':
                        return $item->$column_name;
                    default:
                        return print_r( $item, true );
                }
            }
        }

        $list_table = new Books_Info_List_Table( $books_info );
        $list_table->prepare_items();
        ?>
        <div class="wrap">
            <h2><?php _e( 'Books Info', 'books-plugin' ); ?></h2>
            <form method="post">
                <?php
                $list_table->display();
                ?>
            </form>
        </div>
        <?php
    }

    public function enqueue_scripts() {
        wp_enqueue_style( 'books-plugin-admin', plugin_dir_url( __FILE__ ) . '../css/admin.css', array(), '1.0.0', 'all' );
    }
}
