<?php
/*
Plugin Name: Require Login
Description: Require users to login to view the web site, e.g., for a staging server.
Version: 1.0
Author: Brainstorm Media
Author URI: http://brainstormmedia.com/ 
*/

/**
 * Copyright (c) 2012 Your Name. All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * **********************************************************************
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
add_action('init', create_function('', 'new StormStagingSubdomainExceptions();') );