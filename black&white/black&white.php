<?php
/**
 * @name        Apptha Banner.
 * @version	1.0: black&white.php 2011-07-18
 * @since       Wordpress 3.2.1
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
if(!isset($_REQUEST['style']))
{
?>
<script type="text/javascript" src="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder_name; ?>/black&white/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder_name; ?>/black&white/js/jquery-ui-min.js"></script>
<script type="text/javascript">
        $(document).ready(function(){
        var get_width = '<?php echo $banner_show->bann_width; ?>';
            
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
              alert('Banner width doesn`t match with your current theme.Please Go to Settings and change the width of your banner to matach the theme');
            }
          
            var border_width = parseInt('<?php echo (2*$banner_show->bann_borsize); ?>');
            var actual_width = parseInt(theme_width) - (border_width);

            $("#featured").css('width',actual_width);
            $("#slider_banner > ul").tabs({fx:{opacity: "toggle"}}).tabs("rotate",  '<?php echo ($banner_show->bann_timing*1000); ?>', true);
        });
    </script>
<?php
}
?>
<link rel="stylesheet" href="<?php echo $site_url .'/wp-content/plugins/'.$folder_name.'/black&white/css/black&white.css'?>">
<?php
if (!isset($_REQUEST['style']))
 {
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
            }
            .thumb_uldesc
            {
              font-family:' . $banner_show->bann_fontfamily . ';
              color:' . $banner_thumb . ';
            }
             </style>';
}
// Getting the style to show the preview in the admin side

else if (isset($_GET['style'])) {

$edit_color   = explode(',',$banner_show->bann_fontcolor);
$banner_thumb = $edit_color[1];
$banner_color = $edit_color[0];
echo $sty_bann = '<style type="text/css">
            #featured {
            border: ' . $banner_show->bann_borsize . 'px solid #4D4D4C;
            font-family:' . $banner_show->bann_fontfamily . ';
            color:' .$banner_color. ';
	    background:' . $banner_show->bann_bgcolor . ';
            height:280px;
            width:800px;
            border-bottom-left-radius: ' . $banner_show->bann_corner . 'px ' . $banner_show->bann_corner . 'px;
            border-bottom-right-radius: ' . $banner_show->bann_corner . 'px ' . $banner_show->bann_corner . 'px;
            border-style: solid;
            border-top-left-radius: ' . $banner_show->bann_corner . 'px ' . $banner_show->bann_corner . 'px;
            border-top-right-radius: ' . $banner_show->bann_corner . 'px ' . $banner_show->bann_corner . 'px;
            -moz-border-radius: ' . $banner_show->bann_corner . 'px;
            }
            #featured .ui-tabs-panel #info{
            height: 55px;left: 4px;top: 79%;width: 74%;
            background: url("../wp-content/plugins/appthabanner/image/transparent-bg.png");
            }
            .feat_ulname
            {
            font-family:' . $banner_show->bann_fontfamily . ';
            color:' . $banner_color . ';
            
            }
           .feat_uldesc
            {
            font-size: 12px;
            font-family:' . $banner_show->bann_fontfamily . ';
            color:' . $banner_color . ';
            }
            #featured ul.ui-tabs-nav li.ui-tabs-selected {
            background:' . $banner_show->bann_hover . ';
            }
            .thumb_ulname
            {
              font-family:' . $banner_show->bann_fontfamily . ';
            color:' . $banner_thumb . ';
            }
            .thumb_uldesc
            {
              font-family:' . $banner_show->bann_fontfamily . ';
              color:' . $banner_thumb . ';
            }
         </style>';
}
?>
<div class="clear"></div>
<div id="featured">
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
               if(isset($_GET['style']))
               {
                $get_height = '273px';
               }
                else
                {
                    $get_height =  ($res->bann_height-5).'px';
                }
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
