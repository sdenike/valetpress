<?php
/**
 * Plugin Name: Auto Login
 * Plugin URI: https://shelbydenike.com
 * Description: Auto Login plugin for local dev sites using ValetPress (Original code adapted from @AaronRutley)
 * Version: 2018.08.02
 * Author: @sdenike
 * Author URI: https://shelbydenike.com
 *
 * License: GPL 2.0+
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 */

// Auto login function
function vp_auto_login() {
	if ( $GLOBALS['pagenow'] === 'wp-login.php' && $_REQUEST['loggedout'] != 'true' ) {
		$creds = array(
			'user_login'    => 'admin',
			'user_password' => 'password',
			'remember'      => true
		);
		$user = wp_signon( $creds, false );
		if( $_REQUEST['redirect_to'] ) {$redirect_url = $_REQUEST['redirect_to']; } else { $redirect_url = get_bloginfo('url').'/wp-admin/';}
		wp_redirect( $redirect_url );
	}
}
add_action( 'after_setup_theme', 'vp_auto_login', 10, 2 );