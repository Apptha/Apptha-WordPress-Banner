<?php
/**
 * @name        Apptha Banner.
 * @version	1.2:banner_ajax.php 2011-07-18
 * @since       Wordpress 3.2.1
 * @package	apptha
 * @subpackage	apptha-banner
 * @author      saranya
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license	GNU General Public License version 2 or later; see LICENSE.txt
 * @abstract    Ajax Datas Getting and Retreving page.
**/

/* Images Listing while uploading */
require_once('../apptha_wpdirectory.php');  // Load file for the plugin
global $wpdb;
$site_url = get_bloginfo('url');
$plugin_name   = explode('/',dirname(plugin_basename(__FILE__)));
$folder_name   = $plugin_name[0];

/****************************************** UPDATE THE BANNER IMAGE NAME AND DESCRIPTION ******************************************/
 if($_REQUEST['bannedit_phtid'] != '')
 {
      $bannedit_name = $_REQUEST['bannedit_name'];
      $bannedit_desc = $_REQUEST['bannedit_desc'];
      $bannedit_id   = $_REQUEST['bannedit_phtid'];
      $bannedit_url  = $_REQUEST['bannedit_url'];
      $sql = $wpdb->get_results("UPDATE " . $wpdb->prefix . "bannerimages SET `bann_imgname` = '$bannedit_name', `bann_imgdesc` = '$bannedit_desc' , `bann_imgurl` = '$bannedit_url' WHERE `bann_imgid` = '$bannedit_id'");
 }

 /******************************************  ENABLE AND DISABLE THE STATUS OF THE IMAGE ******************************************/

else if($_REQUEST['bannpht_id'] != '')
{
      $bannpht_id  = $_REQUEST['bannpht_id'];
      if($_REQUEST['status'] == '1')
    {
      $photo_img = $wpdb->query("UPDATE " . $wpdb->prefix . "bannerimages SET bann_imgstatus='1' WHERE bann_imgid='$bannpht_id'");
      echo "<img src='$site_url/wp-content/plugins/$folder_name/image/tick.png' class='gallery_btn' width='16' height='16' onclick=banner_status('0',$bannpht_id)  />";
    }
    else
    {
      $photo_img = $wpdb->query("UPDATE " . $wpdb->prefix . "bannerimages SET bann_imgstatus='0' WHERE bann_imgid='$bannpht_id'");
      echo "<img src='$site_url/wp-content/plugins/$folder_name/image/publish_x.png' class='gallery_btn' width='16' height='16' onclick=banner_status('1',$bannpht_id)  />";
    }

}
/****************************************** QUICK EDIT FORM FOR THE IMAGE NAME AND DESCRIPTION     ******************************************/
    else if($_GET['bann_editid'] != '')
{
    $bann_editid = $_GET['bann_editid'];
    $fet_res = $wpdb->get_row("SELECT * FROM  " . $wpdb->prefix . "bannerimages WHERE bann_imgid='$bann_editid'");
    $div = '<form name="macUptform" method="POST">
            <table class="quickedit"><tr><td> Name:</td><td><input type="text"
             name="bannimg_name_'.$bann_editid.'" id="bannimg_name_'.$bann_editid.'" size="29" value="'.$fet_res->bann_imgname.'" ></td></tr>';

    $div .= '<tr><td> Caption:</td><td><textarea name="bannimg_desc_'.$bann_editid.'"  id="bannimg_desc_'.$bann_editid.'" rows="3" cols="19" >'.$fet_res->bann_imgdesc.'</textarea></td></tr>';
    $div .= '<tr><td> Url:</td><td><input type="text" name="bannimg_url_'.$bann_editid.'"  id="bannimg_url_'.$bann_editid.'" value="'.$fet_res->bann_imgurl.'" size="29"></td></tr>';
    $div .= '<tr><td></td><td><input type="button"  name="updateMac_name"  class="button" value="Update" onclick="updimgfield('.$bann_editid.')";>
             <input type="button" class="button" onclick="cancelimgfield('.$bann_editid.')"   value="Cancel"></td></tr>
             </table>';
    $div .= '</form/>' ;
    echo $div;
}
/******************************************  QUICK EDIT UPDATION FOR THE IMAGE NAME AND DESCRIPTION  ******************************************/
 else if($_REQUEST['bann_fieldid'] != '' )
{
      $bann_fieldid = $_GET['bann_fieldid'];
      $bannImg_name = $_GET['bannImg_name'];
      $bannImg_desc = $_GET['bannImg_desc'];
      $bannImg_url  = $_GET['bannImg_url'];
      $sql = $wpdb->get_results("UPDATE " . $wpdb->prefix . "bannerimages SET `bann_imgname`='$bannImg_name',`bann_imgdesc` ='$bannImg_desc',
                                     `bann_imgurl`='$bannImg_url'  WHERE `bann_imgid` = '$bann_fieldid'");

}
/******************************************  PUBLISHING THE BANNER  ******************************************/

else if($_GET['publish'] != '')
{
  $publish    = $_GET['publish'];
  $tmp_id     = $_GET['tmp_id'];
  $banner_url = $_GET['banner_url'];
 
    if($publish == 'ON')
    {
         
         $album_cover = $wpdb->query("UPDATE " . $wpdb->prefix . "bannerstyles SET bann_status=(CASE WHEN bann_tempid='$tmp_id' THEN 'ON' WHEN bann_tempid!='$tmp_id' THEN 'OFF' END)");
         $get_pageid  = $wpdb->get_row("SELECT bann_tempimg,bann_tempname,bann_tempid FROM " . $wpdb->prefix . "bannerstyles WHERE bann_status= 'ON'");
         echo '<h3>'.$get_pageid->bann_tempname.'</h3><img src="'.$banner_url.'/wp-content/plugins/apptha-banner/'.$get_pageid->bann_tempname.'/'.$get_pageid->bann_tempimg.'">
              ++'.'<a href="?page=banner_temp&style='.$get_pageid->bann_tempid.'" class="nav-tab">Style Settings</a>';
        }
   
}

else if(isset($_REQUEST['temp_id']))
{
    $tempid = $_REQUEST['temp_id'];
    $album_remove = $wpdb->query("DELETE FROM " . $wpdb->prefix . "bannerstyles WHERE bann_tempid='$tempid'");
}
?>
