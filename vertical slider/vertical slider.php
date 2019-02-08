<?php
/**
 * @name        Apptha Banner.
 * @version	1.0: vertical slider.php 2011-07-18
 * @since       Wordpress 3.2.1
 * @package	apptha
 * @subpackage  apptha-banner
 * @author      saranya
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license	GNU General Public License version 2 or later; see LICENSE.txt
 * @abstract    The Vertical Slider Banner.
 * */

  global $wpdb;
  $site_url   = get_bloginfo('url');
  $plugin_name   = explode('/',dirname(plugin_basename(__FILE__)));
  $folder_name   = $plugin_name[0];
  
?>
<link rel="stylesheet" href="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/vertical slider/css/jimg-menu.css'; ?>" type="text/css" />
<?php
$banner_show = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."bannerstyles WHERE bann_status='ON'");
$i=1; // i is declare to identify the last li of the banner
$result    = $wpdb->get_results("SELECT bann_img,bann_imgname,bann_imgurl FROM " . $wpdb->prefix . "bannerimages
                                  WHERE bann_imgstatus=1 GROUP BY bann_imgsort DESC");
 $get_count = count($result);
// Fetching the Published styles of the Banner in the front side
if(!isset($_GET['style']))
{
echo '<script type="text/javascript" src="'.$site_url.'/wp-content/plugins/'.$folder_name.'/vertical slider/js/jquery.js"></script>';
echo '<style>
    #featured {
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
    .feat_ulname{
     font-size: '.$banner_show->bann_fontsize.'px;
     color:'.$banner_show->bann_fontcolor.';
    }
</style>';
?>
<!-------------------   Jquery to show the style 2 in front side   ----------->
<script type="text/javascript" src="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/vertical slider/js/jquery-easing-1.3.pack.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/vertical slider/js/jquery-easing-compact.js'; ?>"></script>

<!--[if IE]>
<style type="text/css">.jimgMenu {position:relative;width:630px;height:200px;overflow:hidden;margin-left:20px;}</style>
<![endif]-->
<!-- Begin jimgMenu Script -->

<script type="text/javascript">
    var noconflict = jQuery.noConflict();
noconflict(document).ready(function () {
  
   var get_width = '<?php echo $banner_show->bann_width; ?>';
   
            if(get_width == 'auto')
            {
                var theme_width =  noconflict("#content").css('width');
                var theme_width =  noconflict("#main").css('width');
               
                var theme_width =  noconflict("#container").css('width');
                var theme_width =  noconflict("#page").css('width');
                var theme_width =  noconflict("#wrapper").css('width');
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
             var border_width   = parseInt('<?php echo (2*$banner_show->bann_borsize); ?>');
             var actual_width   = parseInt(theme_width)- (border_width);
             var li_count       = '<?php echo $get_count; ?>';
             if(li_count > 1)
             {
             var seperate_width = (actual_width)/2;
             }
             else
             {
               var seperate_width = (actual_width);
             }
             var li_width       = (seperate_width) / parseInt(<?php echo $get_count; ?> - 1);

             var get_lastli     =  parseInt(<?php echo $get_count; ?>);

             noconflict('div.jimgMenu ul li a').css('width', li_width);

             noconflict('#sliding_item'+get_lastli).css('width', seperate_width);

             noconflict("#featured").css('width',actual_width); // Get the sit width and assign width to the banner div
             var jimg_sec = '<?php echo ($banner_show->bann_timing*100); ?>';
             var bigimg_sec = '<?php echo ($banner_show->bann_timing*100)+50; ?>';
             noconflict('div.jimgMenu ul li a').hover(function() {
   
    if (noconflict(this).is(':animated')) {

      noconflict(this).addClass("active").stop().animate({width:seperate_width+'px'}, {duration: bigimg_sec, easing: "easeOutQuad", complete: "callback"});
      noconflict('#sliding_item'+get_lastli).addClass("active").stop().animate({width: seperate_width+'px'}, {duration: 400, easing: "easeOutQuad", complete: "callback"});
    } else {
     
     noconflict(this).addClass("active").stop().animate({width: seperate_width+'px'}, {duration: jimg_sec, easing: "easeOutQuad", complete: "callback"});
     noconflict('#sliding_item'+get_lastli).addClass("active").stop().animate({width: seperate_width+'px'}, {duration: 400, easing: "easeOutQuad", complete: "callback"});
    }
  }, function () {

    
    if (noconflict(this).is(':animated')) {

      noconflict(this).removeClass("active").stop().animate({width:li_width+'px'}, {duration: jimg_sec, easing: "easeInOutQuad", complete: "callback"})
      noconflict('#sliding_item'+get_lastli).removeClass("active").stop(':animated').animate({width: seperate_width+'px'}, {duration: 450, easing: "easeInOutQuad", complete: "callback"});
    } else {
    
      noconflict(this).removeClass("active").stop(':animated').animate({width: li_width+'px'}, {duration: bigimg_sec, easing: "easeInOutQuad", complete: "callback"});
      noconflict('#sliding_item'+get_lastli).removeClass("active").stop(':animated').animate({width: seperate_width+'px'}, {duration: 450, easing: "easeInOutQuad", complete: "callback"});
    }


  });
});
</script>
<?php
}
// Getting the style published to show the preview in the admin side
else if(isset($_GET['style']))
{
   echo '<style>
    #featured {
    width:800px;
    height: '.$banner_show->bann_height.'px;
    background-color:'.$banner_show->bann_bgcolor.' ;
    font-family:'.$banner_show->bann_fontfamily.';
    border:'.$banner_show->bann_borsize.'px solid '.$banner_show->bann_border.';
    color:'.$banner_show->bann_fontcolor.';

    border-bottom-left-radius: '.$banner_show->bann_corner.'px '.$banner_show->bann_corner.'px;
    border-bottom-right-radius: '.$banner_show->bann_corner.'px '.$banner_show->bann_corner.'px;
    border-style: solid;
    border-top-left-radius: '.$banner_show->bann_corner.'px '.$banner_show->bann_corner.'px;
    border-top-right-radius: '.$banner_show->bann_corner.'px '.$banner_show->bann_corner.'px;
    -moz-border-radius: ' . $banner_show->bann_corner . 'px;

    }
    .feat_ulname{
     font-size: '.$banner_show->bann_fontsize.'px;
     color:'.$banner_show->bann_fontcolor.';
    }
</style>';
}
?>
<!-- End jimgMenu Script -->
<!-- Begin jimgMenu HTML -->
<?php
if(!isset($_GET['style']))
{
?>
<div class="clear"></div>
<div class="jimgMenu" id="featured">
  <ul>
      <?php
       foreach($result as $res)
       {

            echo '<li class="landscapes" ><a id="sliding_item'.$i.'" href="'. $res->bann_imgurl.'" 
            style="background: url('.get_bloginfo('url').'/wp-content/plugins/'.$folder_name.'/admin/uploads/'.$res->bann_img.') scroll 0% 0%;" >';
            if($banner_show->bann_caption == 'true')
            {
            echo '<span class="feat_ulname" id="info">'.$res->bann_imgname.'</span>';
            }
            echo '</a></li>';
            $i++;
       }
      ?>
  </ul>
</div>
<div class="clear"></div>
<?php
}
else if(isset($_GET['style'])) {
$img_width = 800/$get_count;
echo '<div class="jimgMenu" id="featured">';
echo '<ul>';
  foreach($result as $res)
       {
            echo '<li class="landscapes" ><a id="sliding_item'.$i.'" href="'. $res->bann_imgurl.'"
            style="background: url('.$site_url.'/wp-content/plugins/'.$folder_name.'/admin/uploads/'.$res->bann_img.');width:'.$img_width.'px">';
            if($banner_show->bann_caption == 'true')
            {
            echo '<span class="feat_ulname" id="info">'.$res->bann_imgname.'</span>';
            }
            echo '</a></li>';
            $i++;
       }


echo '</ul>';
echo '</div>';
}
?>

<!-- End jimgMenu HTML -->
