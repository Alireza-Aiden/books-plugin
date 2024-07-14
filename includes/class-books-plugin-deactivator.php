<?php

namespace BooksPlugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Books_Plugin_Deactivator {
    public static function deactivate() {
        // We do not drop tables on deactivate
    }
}