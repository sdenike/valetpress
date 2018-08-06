<?php
/**
 * Plugin Name: Livereload
 * Plugin URI: https://shelbydenike.com
 * Description: Adds livereload.js to WordPress header for local development
 * Version: 2018.08.06
 * Author: @sdenike
 * Author URI: https://shelbydenike.com
 *
 * License: GPL 2.0+
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 */

// Add Livereload.js to header function
function livereload_add() {
?>
	<script src="<?php echo get_site_url();?>:35729/livereload.js?snipver=2" type="text/javascript" defer=""></script>
<?php
}
add_action('wp_head', 'livereload_add');