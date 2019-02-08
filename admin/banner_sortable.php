<?php
/**
 * @name        Apptha Banner.
 * @version	1.2:banner_sortable.php 2011-07-18
 * @since       Wordpress 3.2.1
 * @package	apptha
 * @subpackage	apptha-banner
 * @author      saranya
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license	GNU General Public License version 2 or later; see LICENSE.txt
 * @abstract    Sorting the images in the admin.
**/

/* sorting the images in admin */

 require_once('..\apptha_wpdirectory.php');
/* This is where you would inject your sql into the database
   but we're just going to format it and send it back
*/
 $bann_imgid= $_REQUEST['bann_imgid'];
foreach ($_GET['listItem'] as $position => $item) :
    // Sort order updated in the table
    print_r($position);
	$sql[] =$wpdb->query("UPDATE " . $wpdb->prefix . "bannerimages SET `bann_imgsort` = '$position' WHERE `bann_imgid` = $item");
endforeach;
?>