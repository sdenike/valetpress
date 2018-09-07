<?php
require_once( ABSPATH . "wp-includes/pluggable.php" );

/*include 'sdenike.php';

Plugin Name: Extra functions
Plugin URI: https://systmweb.com
Description: Specific functions to help the site perform better.
Version: 1.0
Author: sdenike
AuthorURI: https://systmweb.com
*/

function sdenike_header_function() {
	echo '<meta http-equiv="x-dns-prefetch-control" content="on"/>
		<link rel="dns-prefetch" href="//www.google-analytics.com"/>
		<link rel="dns-prefetch" href="//fonts.googleapis.com"/>
		<link rel="dns-prefetch" href="//ajax.googleapis.com"/>
		<link rel="dns-prefetch" href="' . get_site_url() . '"/>
		<meta name="robots" content="noodp,noydir"/>
		<link rel="canonical" href="' . get_site_url() . '"/>
		<style>.async-hide { opacity: 0 !important} </style>
';
}

add_action('wp_head','sdenike_header_function');

//* Enable GZIP compression function
function wp_http_compression() {
	// Dont use on Admin HTML editor
	if (stripos($uri, '/js/tinymce') !== false)
		return false;

	// Check if ob_gzhandler already loaded
	if (ini_get('output_handler') == 'ob_gzhandler')
		return false;

	// Load HTTP Compression if correct extension is loaded
	if (extension_loaded('zlib'))
			if(!ob_start("ob_gzhandler")) ob_start();
}
add_action('init', 'wp_http_compression');

//* Remove JS/CSS versions
function remove_cssjs_ver( $src ) {
	if( strpos( $src, '?ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}
add_filter( 'style_loader_src', 'remove_cssjs_ver', 1000 );
add_filter( 'script_loader_src', 'remove_cssjs_ver', 1000 );

//* Remove WP Version from header and feed
function sdenike_remove_version() {
	return '';
}
add_filter('the_generator', 'sdenike_remove_version');

//* Reduce image resolution
add_filter('jpeg_quality', function($arg){return 80;});

// Sharpen resized jpeg images
// http://wpsnipp.com/index.php/functions-php/sharpen-resized-wordpress-uploaded-images-jpg/#

function wps_sharpen_resized_file( $resized_file ) {
    $image = wp_load_image( $resized_file );
    if ( !is_resource( $image ) )
        return new WP_Error( 'error_loading_image', $image, $file );
    $size = @getimagesize( $resized_file );
    if ( !$size )
        return new WP_Error('invalid_image', __('Could not read image size'), $file);
    list($orig_w, $orig_h, $orig_type) = $size;
    switch ( $orig_type ) {
        case IMAGETYPE_JPEG:
            $matrix = array(
                array(-1, -1, -1),
                array(-1, 16, -1),
                array(-1, -1, -1),
            );
            $divisor = array_sum(array_map('array_sum', $matrix));
            $offset   = 0;
            imageconvolution($image, $matrix, $divisor, $offset);
            imagejpeg($image, $resized_file,apply_filters( 'jpeg_quality', 90, 'edit_image' ));
            break;
        case IMAGETYPE_PNG:
            return $resized_file;
        case IMAGETYPE_GIF:
            return $resized_file;
    }
    return $resized_file;
}
add_filter('image_make_intermediate_size', 'wps_sharpen_resized_file',900);

/**
 * Plugin Name: PJ Transient Cleaner
 * Description: Cleans expired transients behind the scenes.
 * Plugin URI: http://pressjitsu.com
*/

class Pj_Transient_Cleaner {
       	public static function load() {
       		add_action( 'init', array( __CLASS__, 'schedule_events' ) );
       	}

       	/**
       	 * Schedule cron events, runs during init.
       	 */
       	public static function schedule_events() {
       		if ( ! wp_next_scheduled( 'pj_transient_cleaner' ) )
       			wp_schedule_event( time(), 'daily', 'pj_transient_cleaner' );

       		add_action( 'pj_transient_cleaner', array( __CLASS__, 'cleaner' ) );
       	}

       	/**
       	 * Runs in a wp-cron intsance.
       	 */
       	public static function cleaner() {
       		global $wpdb;

       		$timestamp = time() - 24 * HOUR_IN_SECONDS; // expired x hours ago.
       		$time_start = time();
       		$time_limit = 30;
       		$batch = 100;

       		// @todo Look at site transients too.
       		// Don't take longer than $time_limit seconds.
       		while ( time() < $time_start + $time_limit ) {
       			$option_names = $wpdb->get_col( "SELECT `option_name` FROM {$wpdb->options} WHERE `option_name` LIKE '\_transient\_timeout\_%'
       				AND CAST(`option_value` AS UNSIGNED) < {$timestamp} LIMIT {$batch};" );

       			if ( empty( $option_names ) )
       				break;

       			// Add transient keys to transient timeout keys.
       			foreach ( $option_names as $key => $option_name )
       				$option_names[] = '_transient_' . substr( $option_name, 19 );

       			// Create a list to use with MySQL IN().
       			$options_in = implode( ', ', array_map( function( $item ) use ( $wpdb ) {
       				return $wpdb->prepare( '%s', $item );
       			}, $option_names ) );

       			// Delete transient and transient timeout fields.
       			$wpdb->query( "DELETE FROM {$wpdb->options} WHERE `option_name` IN ({$options_in});" );

       			// Break if no more deletable options available.
       			if ( count( $option_names ) < $batch * 2 )
       				break;
       		}
       	}
}

Pj_Transient_Cleaner::load();