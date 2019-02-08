<?php
/**
 * @name        Apptha Banner.
 * @version	1.2: apptha_wpdirectory.php 2011-07-18
 * @since       Wordpress 3.2.1
 * @package	apptha
 * @subpackage	apptha-banner
 * @author      saranya
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license	GNU General Public License version 2 or later; see LICENSE.txt
 * @abstract    The db connection and loading file of the plugin
**/
/*The Common load file for the plugin */
if ( !defined('WP_LOAD_PATH') )
{
    /** classic root path if wp-content and plugins is below wp-config.php */
    $classic_root = dirname(dirname(dirname(dirname(__FILE__)))) . '/' ;

    if (file_exists( $classic_root . 'wp-load.php') )
    define( 'WP_LOAD_PATH', $classic_root);
    else
    if (file_exists( $path . 'wp-load.php') )
    define( 'WP_LOAD_PATH', $path);
    else
    exit("Could not find wp-load.php");
}
// let's load WordPress
require_once( WP_LOAD_PATH . 'wp-load.php');
global $wpdb;
?>