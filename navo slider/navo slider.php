<?php
/**
 * @name        Apptha Banner.
 * @version	1.0: navo slider.php 2011-07-18
 * @since       Wordpress 3.2.1
 * @package	apptha
 * @subpackage  apptha-banner
 * @author      saranya
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license	GNU General Public License version 2 or later; see LICENSE.txt
 * @abstract    The Navo Slider banner.
 * */

  global $wpdb;
  $site_url   = get_bloginfo('url');
  $plugin_name   = explode('/',dirname(plugin_basename(__FILE__)));
  $folder_name   = $plugin_name[0];
?>
<link rel="stylesheet" href="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/navo slider/css/style.css'; ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/navo slider/css/nivo-slider.css'; ?>" type="text/css" />
<?php
$banner_show = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."bannerstyles WHERE bann_status='ON'");
if(!isset($_GET['style']))
{
?>
<script type="text/javascript" src="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/navo slider/js/jquery-1.4.2.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/navo slider/js/script.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/navo slider/js/jquery.nivo.slider.pack.js'; ?>"></script>
<script type="text/javascript">
    $(window).load(function() {
        var get_width = '<?php echo $banner_show->bann_width; ?>';
                   // Getting the width of the theme to fix the banner fix

            if(get_width == 'auto')
            {
                var theme_width =  $("#content").css('width');
                var theme_width =  $("#main").css('width');
                var theme_width =  $("#container").css('width');
                var theme_width =  $("#page").css('width');
                var theme_width =  $("#wrapper").css('width');

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
             var actual_width = parseInt(theme_width)- parseInt(border_width);

             $("#nivo-slider").css('width',actual_width); // Assign width to the banner div
             $(".nivo-caption").css('width',actual_width); // Assign width to the banner image
             $("#slider-container-shadow").css('width',actual_width);
         
    });
 </script>
<script type="text/javascript">
    var anmi_speed = '<?php echo $banner_show->bann_timing*1000; ?>';
   
jQuery(function(){
	pexetoSite.loadNivoSlider(jQuery('#nivo-slider'), "random" , true, true, 15, 800, anmi_speed, true, false);
});
</script>
<?php
echo '<style>
    #nivo-slider {
    height: '.$banner_show->bann_height.'px;
    background-color:'.$banner_show->bann_bgcolor.' ;
    font-family:'.$banner_show->bann_fontfamily.';
    border:'.$banner_show->bann_borsize.'px solid '.$banner_show->bann_border.';
    color:'.$banner_show->bann_fontcolor.';

    margin-top:'.$banner_show->bann_spacing . 'px;
    margin-bottom:'.$banner_show->bann_spacing . 'px;

    border-bottom-left-radius: '.$banner_show->bann_corner.'px '.$banner_show->bann_corner.'px;
    border-bottom-right-radius: '.$banner_show->bann_corner.'px '.$banner_show->bann_corner.'px;
    border-style: solid;
    border-top-left-radius: '.$banner_show->bann_corner.'px '.$banner_show->bann_corner.'px;
    border-top-right-radius: '.$banner_show->bann_corner.'px '.$banner_show->bann_corner.'px;
    -moz-border-radius: ' . $banner_show->bann_corner . 'px;
    }
  .nivo-caption {
	position:absolute;
	left:0px;
        font-weight:bold;
	height: 50px;
	background:#000;
        font-size:'.$banner_show->bann_fontsize.'px;
	color:'.$banner_show->bann_fontcolor.';
	
	}


</style>';

?>
<div class="clear"></div>
<div id="slider-container-shadow"></div>
<div id="nivo-slider">
     <?php
     $result = $wpdb->get_results("SELECT t2.bann_height,t1.* FROM " . $wpdb->prefix . "bannerimages as t1 INNER JOIN
                             " . $wpdb->prefix . "bannerstyles as t2 WHERE t1.bann_imgstatus='1' and t2.bann_status='ON' ORDER BY t1.bann_imgsort ASC");
     foreach($result as $res)
     {
         echo '<a href="'.$res->bann_imgurl.'">
         <img src="'.$site_url.'/wp-content/plugins/'.$folder_name.'/admin/uploads/'.$res->bann_img.'" title="'.$res->bann_imgname.'" height="'.$res->bann_height.'" alt="" /></a>
         ';
      
     }
     ?>
</div>
<div id="nivo-controlNav-holder"></div>
<div class="clear"></div>
<?php
}

// For the admin preview styles
else if(isset($_GET['style']))
  {
    $style = $_REQUEST['style'];
    echo $sty_bann =  '<style type="text/css">
    #featured
    {
    width:830px;
    height: 300px;
    background-color:'.$banner_show->bann_bgcolor.';
    font-family:'.$banner_show->bann_fontfamily.';
    color:'.$banner_show->bann_fontcolor.';
    border:'.$banner_show->bann_borsize.'px solid '.$banner_show->bann_border.';
            border-bottom-left-radius: '.$banner_show->bann_corner.'px '.$banner_show->bann_corner.'px;
            border-bottom-right-radius: '.$banner_show->bann_corner.'px '.$banner_show->bann_corner.'px;
            border-style: solid;
            border-top-left-radius: '.$banner_show->bann_corner.'px '.$banner_show->bann_corner.'px;
            border-top-right-radius: '.$banner_show->bann_corner.'px '.$banner_show->bann_corner.'px;
     }
    .nivo-caption
    {
    color:#fff;
    width:'.$banner_show->bann_width.'px;
    }
    .navo_cont p
    {
    background-color:'.$banner_show->bann_bgcolor.' ;
    }
</style>';
}
else
{
echo '<link rel="stylesheet" href="'.$site_url . '/wp-content/plugins/'.$folder_name.'/navo slider/css/default_css.css" type="text/css" />';
}
?>
<!-- This is for admin Preview -->
<?php
if(isset($_GET['style']))
{
    ?>
 <div id="featured" style="position: relative;">
  <div>
     <?php
     $res= $wpdb->get_row("SELECT count(*) as img_count,bann_img,bann_imgname FROM " . $wpdb->prefix . "bannerimages WHERE bann_imgstatus='1' ORDER BY bann_imgsort ASC LIMIT 0,1");
     echo '<img src="'.$site_url.'/wp-content/plugins/'.$folder_name.'/admin/uploads/'.$res->bann_img.'" title="'.$res->bann_imgname.'" width="830px" height="300px" />';
     ?>
  </div>
     <div class="navo_prev_default"></div> <!-- Previous Button Arrow -->
     <div class="navo_next_default"></div> <!-- Next Button Arrow -->
     <div class="bullet_center"> <div class="navo_active_bullet"></div> <!-- Active bullets button -->
   <?php
   for($i=1;$i<=$res->img_count;$i++)
   {
   ?>
     <div class="navo_inactive_bullet"></div> <!-- Inactive bullets button -->
   <?php
    }
    ?>
     </div>
      <div class="navo_cont" id="info">
      <p class="feat_ulname"><?php echo $res->bann_imgname;?></p>
      </div>
 </div>
<?php
 }
 ?>
<!-- admin preview ends -->