<?php
$popunder_plugin_name = 'popunder-popup';
$popunder_current_folder = dirname(dirname(__FILE__));
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
if(!defined('popunder-popup')) define('popunder-popup', $popunder_plugin_name);
if(!defined('POPUNDER_PLUGIN_NAME')) define('POPUNDER_PLUGIN_NAME', $popunder_plugin_name);
if(!defined('POPUNDER_PLUGIN_DISPLAY')) define('POPUNDER_PLUGIN_DISPLAY', "Popunder popup");
if(!defined('POPUNDER_DIR')) define('POPUNDER_DIR', $popunder_current_folder.DS);
if(!defined('POPUNDER_URL')) define('POPUNDER_URL',plugins_url().'/'.strtolower('popunder-popup').'/');
define('POPUNDER_FILE',POPUNDER_DIR.'popunder-popup.php');
if(!defined('POPUNDER_FAV')) define('POPUNDER_FAV', 'http://www.gopiplus.com/work/2014/05/13/popunder-popup-wordpress-plugin/');
if(!defined('POPUNDER_ADMINURL')) define('POPUNDER_ADMINURL', get_option('siteurl') . '/wp-admin/options-general.php?page=popunder-popup');
define('POPUNDER_OFFICIAL', 'Check official website for more information <a target="_blank" href="'.POPUNDER_FAV.'">click here</a>');
require_once(POPUNDER_DIR.'classes'.DIRECTORY_SEPARATOR.'popunder-register.php');
require_once(POPUNDER_DIR.'classes'.DIRECTORY_SEPARATOR.'popunder-intermediate.php');
require_once(POPUNDER_DIR.'classes'.DIRECTORY_SEPARATOR.'popunder-loadwidget.php');
require_once(POPUNDER_DIR.'classes'.DIRECTORY_SEPARATOR.'popunder-query.php');
?>