<?php
/*
Plugin Name: Require Login
Description: Require users to login to view the web site, e.g., for a staging server.
Plugin URI: https://github.com/brainstormmedia/require-login
Author: Paul Clark, 10up
Author URI: http://pdclark.com
Version: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/**
 * Modification for issues with staging server having different domain than live
 * 
 * @author Paul Clark pdclark@brainstormmedia.com
 */
class StormRequireLogin {
	
	function __construct() {
		add_action('template_redirect', array($this, 'redirect_development_server'));
		add_filter('login_message',     array($this, 'custom_login_message'));
		
		// Disable DB backup notices
		remove_action('admin_notices', 'dbmanager_admin_notices');
		// Disable XML Sitemap Generator
		remove_action("init",array("GoogleSitemapGeneratorLoader","Enable"),1000,0);
	}
	
	function redirect_development_server() {
		if ( !is_user_logged_in() ) {
			wp_redirect('/wp-login.php');
		}
	}

	function custom_login_message() {
		return '<p class="message">Welcome to the staging server. To prevent this test content from appearing in search engines, only logged-in users may view the site.</p><br />';
	}
	
}
add_action('init', create_function('', 'new StormRequireLogin();') );
