<?php

namespace BooksPlugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;}
class Books_Meta_Box {
    public function add_meta_box() {
        add_meta_box(
            'books_meta_box',
            __( 'Book Details', 'books-plugin' ),
            array( $this, 'render_meta_box' ),
            'book',
            'side',
            'default'
        );
    }
    public function render_meta_box( $post ) {
        wp_nonce_field( 'save_books_meta_box_data', 'books_meta_box_nonce' );

        $isbn = get_post_meta( $post->ID, '_books_isbn', true );

        echo '<label for="books_isbn">';
        _e( 'ISBN', 'books-plugin' );
        echo '</label> ';
        echo '<input type="text" id="books_isbn" name="books_isbn" value="' . esc_attr( $isbn ) . '" size="25" />';
    }

    public function save_meta_box_data( $post_id ) {
        if ( ! isset( $_POST['books_meta_box_nonce'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['books_meta_box_nonce'], 'save_books_meta_box_data' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        if ( ! isset( $_POST['books_isbn'] ) ) {
            return;
        }
        $isbn = sanitize_text_field( $_POST['books_isbn'] );

        update_post_meta( $post_id, '_books_isbn', $isbn );

        // Save to custom table
        global $wpdb;
        $table_name = $wpdb->prefix . 'books_info';
        $exists = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table_name WHERE post_id = %d", $post_id ) );

        if ( $exists ) {
            $wpdb->update(
                $table_name,
                array( 'isbn' => $isbn ),
                array( 'post_id' => $post_id ),
                array( '%s' ),
                array( '%d' )
            );
        } else {
            $wpdb->insert(
                $table_name,
                array(
                    'post_id' => $post_id,
                    'isbn' => $isbn,
                ),
                array(
                    '%d',
                    '%s',
                )
            );
        }
    }
}    
