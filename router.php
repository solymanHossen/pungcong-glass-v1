<?php
/**
 * Router script for the built-in PHP server.
 *
 * This script allows WordPress to work with the built-in PHP server
 * and pretty permalinks.
 */

$root = $_SERVER['DOCUMENT_ROOT'];
$path = '/'.ltrim( parse_url( urldecode( $_SERVER['REQUEST_URI'] ) )['path'], '/' );

if ( file_exists( $root.$path ) ) {
    if ( is_dir( $root.$path ) && substr( $path, -1 ) !== '/' ) {
        header( "Location: $path/" );
        exit;
    }
    if ( strpos( $path, '.php' ) === false ) {
        return false;
    } else {
        chdir( dirname( $root.$path ) );
        require_once $root.$path;
    }
} else {
    include_once 'index.php';
}
