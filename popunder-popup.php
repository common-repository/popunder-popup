<?php
/*
Plugin Name: Popunder Popup
Plugin URI: http://www.gopiplus.com/work/2014/05/13/popunder-popup-wordpress-plugin/
Description: Popunder popup is a plugin to load window behind the browser window of your website. or second smaller browser window upon clicking your website. This is a best plugin to show ad that is automatically displayed in a second smaller browser window upon clicking your website.
Version: 3.1
Author: Gopi Ramasamy
Donate link: http://www.gopiplus.com/work/2014/05/13/popunder-popup-wordpress-plugin/
Author URI: http://www.gopiplus.com/work/2014/05/13/popunder-popup-wordpress-plugin/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: popunder-popup
Domain Path: /languages
*/

/*  
Copyright 2022 Popunder Popup (www.gopiplus.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

if (!session_id()) { session_start(); }

require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'popunder-stater.php');
add_action('admin_menu', array( 'popunderpopup_cls_registerhook', 'popunderpopup_adminmenu' ));
register_activation_hook(POPUNDER_FILE, array( 'popunderpopup_cls_registerhook', 'popunderpopup_activation' ));
register_deactivation_hook(POPUNDER_FILE, array( 'popunderpopup_cls_registerhook', 'popunderpopup_deactivation' ));
add_shortcode( 'popunder-popup', 'popunderpopup_shortcode' );
add_action('wp_enqueue_scripts', 'popunderpopup_add_javascript_files');
add_action( 'admin_enqueue_scripts', array( 'popunderpopup_cls_registerhook', 'popunderpopup_load_adminscripts' ) );

function popunderpopup_textdomain() 
{
	  load_plugin_textdomain( 'popunder-popup' , false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action('plugins_loaded', 'popunderpopup_textdomain');
?>