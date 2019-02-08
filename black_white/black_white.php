<?php
/**
 * @name        Apptha Banner.
 * @version	1.2: black&white.php 2011-07-18
 * @since       Wordpress 3black&white.2.1
 * @package	apptha
 * @subpackage  apptha-banner
 * @author      saranya
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license	GNU General Public License version 2 or later; see LICENSE.txt
 * @abstract    The Black & White Banner Style.
 * */
global $wpdb;
$site_url = get_bloginfo('url');
$plugin_name   = explode('/',dirname(plugin_basename(__FILE__)));
$folder_name   = $plugin_name[0];
$banner_show = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "bannerstyles WHERE bann_status='ON'");
?>
<script type="text/javascript" src="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder_name; ?>/black_white/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder_name; ?>/black_white/js/jquery-ui-min.js"></script>
<script type="text/javascript">
        $(document).ready(function(){
        $('#banner_solu').prepend('<img src="http://www.platoon.in/images/1.png" style="display:block">');
        var get_width = '<?php echo $banner_show->bann_width; ?>';
            // Getting the width of the theme to fix the banner fix
            if(get_width == 'auto')
            {
                var theme_width  =  $("#content").css('width');
                var theme_width  =  $("#container").css('width');
               
                var theme_width  =  $("#main").css('width');
                var theme_width  =  $("#page").css('width');
                var theme_width  =  $("#wrapper").css('width');
                
            }
            else
            {
                var theme_width = get_width;
            }
               if(theme_width == undefined)
            {
              var theme_width = '950';
            }
            // Getting the theme width and subtracting the border
            var border_width = parseInt('<?php echo (2*$banner_show->bann_borsize); ?>');
            var actual_width = parseInt(theme_width) - (border_width);

            $("#featured").css('width',actual_width);
            $("#slider_banner > ul").tabs({fx:{opacity: "toggle"}}).tabs("rotate",  '<?php echo ($banner_show->bann_timing*1000); ?>', true);
        });
    </script>

<link rel="stylesheet" href="<?php echo $site_url .'/wp-content/plugins/'.$folder_name.'/black_white/css/black&white.css'?>">
<?php
    $edit_color   = explode(',',$banner_show->bann_fontcolor);
    $banner_thumb = $edit_color[1];
    $banner_color = $edit_color[0];
?>
<!--------------------------- THE SCRIPT INCLUDED FOR THE STYLE ---------------------------------->
<?php
// Fetching the Published styles of the Banner in the front side
    echo $sty_bann = '<style type="text/css">
            #featured {
            border: ' . $banner_show->bann_borsize . 'px solid ' . $banner_show->bann_border . ';
            font-family:' . $banner_show->bann_fontfamily . ';
            color:' . $banner_show->bann_fontcolor . ';
	    background:' . $banner_show->bann_bgcolor . ';
            border-bottom-left-radius: ' . $banner_show->bann_corner . 'px ' . $banner_show->bann_corner . 'px;
            border-bottom-right-radius: ' . $banner_show->bann_corner . 'px ' . $banner_show->bann_corner . 'px;
            border-style: solid;
            border-top-left-radius: ' . $banner_show->bann_corner . 'px ' . $banner_show->bann_corner . 'px;
            border-top-right-radius: ' . $banner_show->bann_corner . 'px ' . $banner_show->bann_corner . 'px;
            margin-top:'.$banner_show->bann_spacing . 'px;
            margin-bottom:'.$banner_show->bann_spacing . 'px;
            -moz-border-radius: ' . $banner_show->bann_corner . 'px;
           }
           
            #featured .ui-tabs-panel #info{
            position:absolute;
            top:75%; left:0;
            width: 73%;
            margin-left:6px;
            color:' .$banner_color. ';
            padding:0 0 0 5px;
            background: url("./wp-content/plugins/'.$folder_name.'/image/transparent-bg.png");
            }
           .feat_uldesc
            {
             color:' . $banner_color . ';
            }
            #featured ul.ui-tabs-nav li.ui-tabs-selected {
            background:' . $banner_show->bann_hover . ';
            }
            .thumb_ulname
            {
              font-family:' . $banner_show->bann_fontfamily . ';
              color:' . $banner_thumb . ';
              font-size:'.$banner_show->bann_fontsize.'px;
            }
            .thumb_uldesc
            {
              font-family:' . $banner_show->bann_fontfamily . ';
              color:' . $banner_thumb . ';
              font-size:'.$banner_show->bann_fontsize.'px;
            }
             </style>';

// Getting the style to show the preview in the admin side

?>
<div class="clear"></div>
<div id="featured">
<?php
  $option_title = $wpdb->get_var("SELECT option_value FROM " . $wpdb->prefix . "options WHERE option_name='get_api_key'");
    $get_title = unserialize($option_title);
  $strDomainName = $site_url;
           preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i", $strDomainName, $matches);
            $customerurl = $matches['domain'];
            $customerurl = str_replace("www.", "", $customerurl);
            $customerurl = str_replace(".", "D", $customerurl);
            $customerurl = strtoupper($customerurl);
    $get_option_title = appbanner_generate($customerurl);
if ($get_title['title'] != $get_option_title) { ?>
<div style="position:absolute;top:10px;left:10px;z-index:99999;" id="banner_solu"></div>
<?php } ?>
<?php
$result = $wpdb->get_results("SELECT t2.bann_height,t2.bann_caption,t1.* FROM " . $wpdb->prefix . "bannerimages as t1 INNER JOIN
                             " . $wpdb->prefix . "bannerstyles as t2 WHERE t1.bann_imgstatus='1' and t2.bann_status='ON' ORDER BY t1.bann_imgsort ASC LIMIT 0,4");
$i = 1; // i is declare to identify the first default from the dynamic loop
$j = 1; // j is declare to identify the thumbnails first default from the dynamic loop
?>
<div class="left_side">
    <?php
        foreach ($result as $res) {
        if ($j == 1) {
    ?>
     <div id="fragment-<?php echo $j; ?>" class="ui-tabs-panel" style="height:100%">
        <?php
        } else {
        ?>
                <div id="fragment-<?php echo $j; ?>" class="ui-tabs-panel ui-tabs-hide" >
                <?php
                }
               
                    $get_height =  ($res->bann_height-5).'px';
                
                ?>
                <a  href="<?php echo $res->bann_imgurl; ?>"><img src="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder_name; ?>/admin/uploads/<?php echo $res->bann_img;?>" class="img_black" style="height:<?php echo $get_height; ?>;" alt="" /></a>
            <?php
                if ($res->bann_caption == 'true') {
            ?>
                    <div id="info">
                    <h2 class="feat_ulname"><?php echo $res->bann_imgname; ?></h2>
                    <a href=""><p class="feat_uldesc"><?php echo $res->bann_imgdesc; ?></p></a>
                </div>
         <?php } ?>
            </div>
         
                <?php
                $j++;
            } ?>
        </div>
<!-----------------  THUMB VIEW OF THE BANNER STYLE 1----------------->
        <div class="right_side" id="slider_banner"><ul class="ui-tabs-nav">
<?php
            foreach ($result as $res) {
                if ($i == 1) {
?>
                        <li class="ui-tabs-nav-item ui-tabs-selected" id="nav-fragment-<?php echo $i; ?>">
<?php
                } else {
?>
                        <li class="ui-tabs-nav-item" id="nav-fragment-<?php echo $i; ?>">
                <?php
                }
                ?>
                    <a href="#fragment-<?php echo $i; ?>"><img src="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder_name; ?>/admin/thumbnails/<?php echo $res->bann_img; ?>" width="80" height="50" alt="" />
                        <span class="thumb_ulname"><strong><?php echo $res->bann_imgname; ?></strong></span>
                        <div class="thumb_uldesc"><?php echo $res->bann_imgdesc; ?></div>
                    </a>
                </li>
                <!-- First Content -->
                    <?php
                    $i++;
                }
                    ?>
            </ul></div>
        <div class="clear"></div>
    </div><!-- /#components -->
