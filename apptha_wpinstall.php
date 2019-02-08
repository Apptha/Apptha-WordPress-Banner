<?php
/**
 * @name        Apptha Banner
 * @version	1.2: apptha_wpinstall.php 2011-07-18
 * @since       Wordpress 3.2.1
 * @package	apptha
 * @subpackage	apptha-banner
 * @author      saranya
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license	GNU General Public License version 2 or later; see LICENSE.txt
 * @abstract    The first loading page of the Banner these contain admin setting too.
**/
function banner_install()
{
    global $wpdb;
    // set tablename
    $table_images   = $wpdb->prefix . 'bannerimages';
    $table_styles    = $wpdb->prefix . 'bannerstyles';
      
    $images_found   = false;
    $styles_found    = false;
  
    $found          = true;
    $settingsFound  = false;

     foreach ($wpdb->get_results("SHOW TABLES;", ARRAY_N) as $row)
    {
        if ($row[0] == $table_images) 	$images_found = true;
        if ($row[0] == $table_pages)    $styles_found = true;
    }
    // add charset & collate like wp core
    $charset_collate = '';
    if ( version_compare(mysql_get_server_info(), '4.1.0', '>=') )
    {
        if ( ! empty($wpdb->charset) )
        $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
        if ( ! empty($wpdb->collate) )
        $charset_collate .= " COLLATE $wpdb->collate";
    }

    if (!$images_found)
    {
       $sql = "CREATE TABLE IF NOT EXISTS $table_images (
      `bann_imgid` int(25) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `bann_img` varchar(50) NOT NULL,
      `bann_imgname` varchar(100) NOT NULL,
      `bann_imgdesc` text NOT NULL,
      `bann_imgurl` varchar(100) NOT NULL,
      `bann_imgstatus` tinyint(1) NOT NULL,
      `bann_imgsort` bigint(10) NOT NULL) $charset_collate;";
       $result = $wpdb->get_results($sql);
    }

     if (!$styles_found)
     {
      $sql = "CREATE TABLE IF NOT EXISTS $table_styles (
  `bann_tempid` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `bann_tempname` varchar(25) NOT NULL,
  `bann_tempimg` varchar(25) NOT NULL,
  `bann_bgcolor` varchar(100) NOT NULL,
  `bann_border` varchar(100) NOT NULL,
  `bann_borsize` int(25) NOT NULL,
  `bann_fontcolor` varchar(100) NOT NULL,
  `bann_hover` varchar(25) NOT NULL,
  `bann_corner` int(25) NOT NULL,
  `bann_fontfamily` varchar(50) NOT NULL,
  `bann_fontsize` int(2) NOT NULL,
  `bann_width` varchar(5) NOT NULL,
  `bann_height` bigint(5) NOT NULL,
  `bann_status` varchar(10) NOT NULL,
  `bann_caption` varchar(6) NOT NULL,
  `bann_spacing` int(5) NOT NULL,
  `bann_timing` float NOT NULL)  $charset_collate;";
       $result = $wpdb->get_results($sql);
    }
 }
?>