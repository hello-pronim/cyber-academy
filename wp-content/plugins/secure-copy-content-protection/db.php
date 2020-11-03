<?php
global $wpdb;
if (!defined('SCCP_DB_VERSION')) {
	define('SCCP_DB_VERSION', '1.6.1');
}

if (!defined('SCCP_TABLE')) {
	define('SCCP_TABLE', $wpdb->prefix . 'ays_sccp');
}

if(!defined( 'SCCP_BLOCK_CONTENT')) {
    define( 'SCCP_BLOCK_CONTENT', $wpdb->prefix . 'ays_sccp_block_content' );
}

if (!defined('SCCP_CHARSET')) {
	define('SCCP_CHARSET', $wpdb->get_charset_collate());
}