<?php
require_once( ABSPATH . "wp-includes/pluggable.php" );

/*
Plugin Name: ValetPress Auto-login function
Plugin URI: https://systmweb.com
Description: Function used by ValetPress to log in automatically after installation, <b>DO NOT use this in production</b>.
Version: 1.3
Author: sdenike
AuthorURI: https://systmweb.com
*/

// Auto login function
function vp_auto_login() {
	if ( $GLOBALS['pagenow'] === 'wp-login.php' && $_REQUEST['loggedout'] != 'true' ) {
		$creds = array(
			'user_login'    => 'admin',
			'user_password' => 'password',
			'remember'      => true
		);
		$user = wp_signon( $creds );
		if ( is_wp_error( $user ) )
			echo $user->get_error_message();
		wp_redirect( esc_url( get_admin_url() ) ); exit;
	}
}
add_action( 'after_setup_theme', 'vp_auto_login', 10, 2 );