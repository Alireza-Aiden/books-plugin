<?php

namespace BooksPlugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Books_Plugin_Deactivator {
    public static function deactivate() {
        // We typically do not drop tables on deactivate to avoid data loss.
    }
}