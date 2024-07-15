<?php

namespace BooksPlugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
class Books_Post_Type {
    public function register_custom_post_type() {
        $labels = array(
            'name'               => _x( 'Books', 'post type general name', 'books-plugin' ),
            'singular_name'      => _x( 'Book', 'post type singular name', 'books-plugin' ),
            'menu_name'          => _x( 'Books', 'admin menu', 'books-plugin' ),
            'name_admin_bar'     => _x( 'Book', 'add new on admin bar', 'books-plugin' ),
            'add_new'            => _x( 'Add New', 'book', 'books-plugin' ),
            'add_new_item'       => __( 'Add New Book', 'books-plugin' ),
            'new_item'           => __( 'New Book', 'books-plugin' ),
            'edit_item'          => __( 'Edit Book', 'books-plugin' ),
            'view_item'          => __( 'View Book', 'books-plugin' ),
            'all_items'          => __( 'All Books', 'books-plugin' ),
            'search_items'       => __( 'Search Books', 'books-plugin' ),
            'parent_item_colon'  => __( 'Parent Books:', 'books-plugin' ),
            'not_found'          => __( 'No books found.', 'books-plugin' ),
            'not_found_in_trash' => __( 'No books found in Trash.', 'books-plugin' )
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'book' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
        );

        register_post_type( 'book', $args );

        // Register Taxonomies
        $this->register_taxonomies();
    }

    private function register_taxonomies() {
        // Publisher Taxonomy
        $labels = array(
            'name'              => _x( 'Publishers', 'taxonomy general name', 'books-plugin' ),
            'singular_name'     => _x( 'Publisher', 'taxonomy singular name', 'books-plugin' ),
            'search_items'      => __( 'Search Publishers', 'books-plugin' ),
            'all_items'         => __( 'All Publishers', 'books-plugin' ),
            'parent_item'       => __( 'Parent Publisher', 'books-plugin' ),
            'parent_item_colon' => __( 'Parent Publisher:', 'books-plugin' ),
            'edit_item'         => __( 'Edit Publisher', 'books-plugin' ),
            'update_item'       => __( 'Update Publisher', 'books-plugin' ),
            'add_new_item'      => __( 'Add New Publisher', 'books-plugin' ),
            'new_item_name'     => __( 'New Publisher Name', 'books-plugin' ),
            'menu_name'         => __( 'Publisher', 'books-plugin' ),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'publisher' ),
        );

        register_taxonomy( 'publisher', array( 'book' ), $args );

        // Authors Taxonomy 
        $labels = array(
            'name'              => _x( 'Authors', 'taxonomy general name', 'books-plugin' ),
            'singular_name'     => _x( 'Author', 'taxonomy singular name', 'books-plugin' ),
            'search_items'      => __( 'Search Authors', 'books-plugin' ),
            'all_items'         => __( 'All Authors', 'books-plugin' ),
            'parent_item'       => __( 'Parent Author', 'books-plugin' ),
            'parent_item_colon' => __( 'Parent Author:', 'books-plugin' ),
            'edit_item'         => __( 'Edit Author', 'books-plugin' ),
            'update_item'       => __( 'Update Author', 'books-plugin' ),
            'add_new_item'      => __( 'Add New Author', 'books-plugin' ),
            'new_item_name'     => __( 'New Author Name', 'books-plugin' ),
            'menu_name'         => __( 'Author', 'books-plugin' ),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'author' ),
        );

        register_taxonomy( 'author', array( 'book' ), $args );
    }
}
