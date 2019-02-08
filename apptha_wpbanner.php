<?php
/**
 * Plugin Name:  Apptha Banner
 * Description:  Apptha Banner Styles for the worpress.It gives you a classy effects of banner styles in one plugin.
 * Version: 1.2
 * Author: Contus Support
 * @since       Wordpress 3.2.1
 * @package	apptha
 * @subpackage	apptha-banner
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license	GNU General Public License version 2 or later; see LICENSE.txt
 * @abstract    The first loading page of the Banner these contain admin setting too.
**/
// This is used for setting the Apptha banner link in the admin dashboard settings

function banner_page()
{
add_menu_page('Apptha Banner', 'Apptha Banner', 'manage_options', 'banner_show', 'showbanner_admin',get_bloginfo('url').'/wp-content/plugins/'.dirname(plugin_basename(__FILE__)).'/image/icon.png');
add_submenu_page( 'banner_show', 'Page title', 'Image Upload', 'manage_options', 'banner_img', 'showbanner_admin');
add_submenu_page( 'banner_show', 'Page title', 'Settings', 'manage_options', 'banner_temp', 'showbanner_admin');
}
// Include the respective page based of the page request in url

function showbanner_admin()
{
    switch ($_GET['page'])
    {
        case 'banner_show' :
            include_once (dirname(__FILE__) . '/admin/banner_show.php'); // admin functions
            break;
       case 'banner_temp' :
           include_once (dirname(__FILE__) .'/banner_temp.php'); // admin functions
           break;
        case 'banner_img' :
            include_once (dirname(__FILE__) . '/admin/banner_img.php'); // admin functions
            break;
    }
}
// The user will call this function to display the banner
function apptha_banner()
{
  global $wpdb;
  $site_url      = get_bloginfo('url');
  $temp_name = $wpdb->get_var("SELECT bann_tempname  FROM " . $wpdb->prefix . "bannerstyles WHERE bann_status='ON'");
  if($temp_name == '')
  {
       echo '<script> alert("Please Go and Select the Banner Style correctly"); location.href = "'.$site_url.'/wp-admin/admin.php?page=banner_show";</script>';
  }
   else
  {
  include_once (dirname(__FILE__).DIRECTORY_SEPARATOR.$temp_name.DIRECTORY_SEPARATOR.$temp_name.'.php'); // admin functions
  }
}
 $lookupObj = array();
 $chars_str;
 $chars_array = array();

function appbanner_generate($domain)
{
$code=appbanner_encrypt($domain);
$code = substr($code,0,25)."CONTUS";
return $code;
}

function appbanner_encrypt($tkey) {

$message =  "EW-ABMP0EFIL9XEV8YZAL7KCIUQ6NI5OREH4TSEB3TSRIF2SI1ROTAIDALG-JW";

	for($i=0;$i<strlen($tkey);$i++){
$key_array[]=$tkey[$i];
}
	$enc_message = "";
	$kPos = 0;
        $chars_str =  "WJ-GLADIATOR1IS2FIRST3BEST4HERO5IN6QUICK7LAZY8VEX9LIFEMP0";
	for($i=0;$i<strlen($chars_str);$i++){
$chars_array[]=$chars_str[$i];
}
	for ($i = 0; $i<strlen($message); $i++) {
		$char=substr($message, $i, 1);

		$offset = appbanner_getOffset($key_array[$kPos], $char);
		$enc_message .= $chars_array[$offset];
		$kPos++;
		if ($kPos>=count($key_array)) {
			$kPos = 0;
		}
	}

	return $enc_message;
}
function appbanner_getOffset($start, $end) {

    $chars_str =  "WJ-GLADIATOR1IS2FIRST3BEST4HERO5IN6QUICK7LAZY8VEX9LIFEMP0";
	for($i=0;$i<strlen($chars_str);$i++){
$chars_array[]=$chars_str[$i];
}

	for ($i=count($chars_array)-1;$i>=0;$i--) {
		$lookupObj[ord($chars_array[$i])] = $i;

	}

	$sNum = $lookupObj[ord($start)];
	$eNum = $lookupObj[ord($end)];

	$offset = $eNum-$sNum;

	if ($offset<0) {
		$offset = count($chars_array)+($offset);
	}

	return $offset;
}
// The common admin CSS and JS will included by checking the admin setted
if (is_admin()) {
 function banner_common_js_css()
    {
        $site_url    = get_bloginfo('url');
        $plugin_name = dirname(plugin_basename(__FILE__));
        wp_enqueue_style('banner_style', $site_url . '/wp-content/plugins/'.$plugin_name.'/css/banner_style.css');
        wp_register_script('banner_js', '/wp-content/plugins/'.$plugin_name.'/js/banner_js.js');
        wp_enqueue_script('banner_js');
    }
add_action('init', 'banner_common_js_css'); // hook init to call the JS and CSS
}

function  banner_activate_loads()
{
global $wpdb;
$execute_query = $wpdb->query("INSERT INTO " . $wpdb->prefix . "bannerstyles (`bann_tempid`, `bann_tempname`, `bann_tempimg`, `bann_bgcolor`, `bann_border`, `bann_borsize`, `bann_fontcolor`, `bann_hover`, `bann_corner`, `bann_fontfamily`, `bann_fontsize`, `bann_width`, `bann_height`, `bann_status`, `bann_caption`, `bann_spacing`, `bann_timing`) VALUES
(1, 'black_white', 'black_white.jpg', '#cccccc', '#cccccc', 2, '#ffffff,#333', '#fff', 4, 'arial', 13, 'auto', 270, 'OFF', 'true', 10, 2),
(3, 'navo_slider', 'navoslider.jpg', '#ccc', '#ccc', 5, '#fff,#ae1e1e', '#e6e6e6', 0, 'arial', 12, 'auto', 280, 'OFF', 'true', 0, 5),
(2, 'vertical_slider', 'verticalslider.jpg', '#ccc', '#ccc', 1, '#000000,#', '#e6e6e6', 0, 'Verdana', 20, '950', 200, 'OFF', 'true', 10, 9),
(4, 'blinking_navo', 'blinkingnavo.jpg', '#ccc', '#666', 3, '#ffffff,#', '#e6e6e6', 0, 'Verdana', 12, 'auto', 270, 'OFF', 'true', 0, 4),
(5, 'plain_image', 'plainimage.jpg', '#ccc', '#ccc', 5, '#000,#86b120', '#e6e6e6', 0, '12', 0, '950', 230, 'ON', 'true', 10, 5);
");

$execute_query = $wpdb->query("INSERT INTO " . $wpdb->prefix . "bannerimages
(`bann_imgid`, `bann_img`, `bann_imgname`, `bann_imgdesc`, `bann_imgurl`, `bann_imgstatus`, `bann_imgsort`) VALUES
(1, '1_thumb.jpg', 'The Bird', 'A bird with a flower', '', 1, 1),
(2, '2_thumb.jpg', 'My Kitchen', 'The modular kitchen', '', 1, 2),
(3, '3_thumb.jpg', 'The Path', 'The Single way path', '', 1, 3),
(4, '4_thumb.jpg', 'Beautiful City', 'Beautiful city with light decorated', '', 1, 4),
(5, '5_thumb.jpg', 'Sunrise', 'Sunrise with coconut trees', '', 1, 5);");

}

/*Function to invoke install player plugin*/
function banners_install()
{
    require_once(dirname(__FILE__) . '/apptha_wpinstall.php');
    banner_install();
}

/*Function to activate player plugin*/
 function banner_sharactivate()
 {
  banner_activate_loads();
 }
 function banner_sharedeinstall()
 {
   global $wpdb;
   $images_drop = $wpdb->query("DROP TABLE " . $wpdb->prefix . "bannerimages");
   $styles_drop = $wpdb->query("DROP TABLE " . $wpdb->prefix . "bannerstyles");
   $options_drop = $wpdb->query("DELETE FROM " . $wpdb->prefix . "options WHERE option_name='get_api_key'");
 }
register_activation_hook(plugin_basename(dirname(__FILE__)) . '/apptha_wpbanner.php', 'banners_install');
register_activation_hook(__FILE__, 'banner_sharactivate');

register_uninstall_hook(__FILE__, 'banner_sharedeinstall');

add_action('admin_menu', 'banner_page'); // OPTIONS MENU
?>
