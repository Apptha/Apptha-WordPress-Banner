<?php
/**
 * @name        Apptha Banner.
 * @version	1.0:banner_temp_ajax.php 2011-07-18
 * @since       Wordpress 3.2.1
 * @package	contus
 * @subpackage	apptha-banner
 * @author      saranya
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license	GNU General Public License version 2 or later; see LICENSE.txt
 * @abstract    Ajax Datas Getting and Retreving page.
**/

// UPDATING THE PAGES OF STYLES FOR THE BANNER

require_once('..\apptha_wpdirectory.php');  // Load file for the plugin
global $wpdb;
$site_url = get_bloginfo('url');

  $bann_style  = $_REQUEST['bann_style'];
  $bgcolor     = '#'.$_REQUEST['bgcolor'];
  $bordercolor = '#'.$_REQUEST['bordercolor'];
  
  $fontcolor   = '#'.$_REQUEST['fontcolor'];
  $bann_borsize = $_REQUEST['bann_borsize'];

  $font_size   = $_REQUEST['fontsize'];
  $fontfamily  = $_REQUEST['fontfamily'];
  $bann_width  = $_REQUEST['bannwidth'];
  $bann_height = $_REQUEST['bannheight'];
  $bann_caption = $_REQUEST['bann_caption'];
  $cornerradius = $_REQUEST['corner'];
  $bannspacing  = $_REQUEST['bannspacing'];
   $bann_timing  = $_REQUEST['bann_timing'];
 
  $sql = $wpdb->get_results("UPDATE " . $wpdb->prefix . "bannerstyles SET
         bann_bgcolor = '$bgcolor', bann_border = '$bordercolor',bann_borsize = '$bann_borsize',bann_corner = '$cornerradius',
         bann_fontcolor = '$fontcolor', bann_fontfamily = '$fontfamily', bann_fontsize = '$font_size',bann_width = '$bann_width',
         bann_height = '$bann_height',bann_caption = '$bann_caption',bann_spacing= '$bannspacing',bann_timing='$bann_timing' WHERE bann_tempid = '$bann_style'");
  ?>
