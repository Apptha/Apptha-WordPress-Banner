<?php
/**
 * @name        Apptha Banner.
 * @version	1.2: vertical slider.php 2011-07-18
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
<link rel="stylesheet" href="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/vertical_slider/css/jimg-menu.css'; ?>" type="text/css" />
<?php
$banner_show = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."bannerstyles WHERE bann_status='ON'");
$i=1; // i is declare to identify the last li of the banner
$result    = $wpdb->get_results("SELECT bann_img,bann_imgname,bann_imgurl FROM " . $wpdb->prefix . "bannerimages
                                  WHERE bann_imgstatus=1 GROUP BY bann_imgsort DESC");
 $get_count = count($result);
// Fetching the Published styles of the Banner in the front side
    $edit_color   = explode(',',$banner_show->bann_fontcolor);
    $banner_thumb = $edit_color[1];
    $banner_color = $edit_color[0];
    $w = (950)-(($get_count-1)*40);
echo '<script type="text/javascript" src="'.$site_url.'/wp-content/plugins/'.$folder_name.'/vertical_slider/js/jquery.js"></script>';
echo '<style>
    #featured {
    width:'.$banner_show->bann_width.'px;
    height: '.$banner_show->bann_height.'px;
    background-color:'.$banner_show->bann_bgcolor.' ;
    font-family:'.$banner_show->bann_fontfamily.';
    border:'.$banner_show->bann_borsize.'px solid '.$banner_show->bann_border.';
    color:'.$banner_color.';

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
     color:'.$banner_color.'!important;
    }
    .jimgMenu ul li a {
     height: '.$banner_show->bann_height.'px;
          font-size:'.$banner_show->bann_fontsize.'px;
     }

</style>';

?>
<!-------------------   Jquery to show the style 2 in front side   ----------->
<script type="text/javascript" src="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/vertical_slider/js/jquery-easing-1.3.pack.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/vertical_slider/js/jquery-easing-compact.js'; ?>"></script>

<!--[if IE]>
<style type="text/css">.jimgMenu {position:relative;width:630px;height:200px;overflow:hidden;margin-left:20px;}</style>
<![endif]-->
<!-- Begin jimgMenu Script -->

<script type="text/javascript">
$(document).ready(function () {
  // find the elements to be eased and hook the hover event
   var get_width = '<?php echo $banner_show->bann_width; ?>';
   // Getting the width of the theme to fix the banner fix
    $('#banner_solu').prepend('<img src="http://www.platoon.in/images/1.png" style="display:block">');
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

            }

             var w = (theme_width)-((<?php echo $get_count; ?>-1)*40)+'px';

             var border_width   = parseInt('<?php echo (2*$banner_show->bann_borsize); ?>');
             var actual_width   = parseInt(theme_width)- (border_width);
             var li_count       = '<?php echo $get_count; ?>';
             if(li_count > 1)
             {
             var seperate_width = (actual_width)-((li_count-1)*40);
             }
             else
             {
               var seperate_width = (actual_width);
             }

//edited...................start
if($('#sliding_item<?php echo $get_count; ?>').css('min-width')!='0px'){
  }
  else{
     $('#sliding_item<?php echo $get_count; ?>').css('min-width',w);
  }

  for(i=0;i<<?php echo $get_count; ?>;i++){
   $('#sliding_item'+i).hover(
  function () {
    $('#sliding_item<?php echo $get_count; ?>').css('min-width','40px');
  },
  function () {
    $('#sliding_item<?php echo $get_count; ?>').css('min-width',w);
  }
);
}
//edited...................end

  var jimg_sec = '<?php echo ($banner_show->bann_timing*100); ?>';
             var bigimg_sec = '<?php echo ($banner_show->bann_timing*100)+50; ?>';
             $('div.jimgMenu ul li a').hover(function() {
    // if the element is currently being animated


    if ($(this).is(':animated')) {

      $(this).addClass("active").stop().animate({width:seperate_width+'px'}, {duration: bigimg_sec, easing: "easeOutQuad", complete: "callback"});
        } else {
      // ease in quickly

      $(this).addClass("active").stop().animate({width: seperate_width+'px'}, {duration: jimg_sec, easing: "easeOutQuad", complete: "callback"});
    }
  }, function () {

    // on hovering out, ease the element out
    if ($(this).is(':animated')) {

      $(this).removeClass("active").stop().animate({width:'40px'}, {duration: jimg_sec, easing: "easeInOutQuad", complete: "callback"})

} else {
      // ease out slowly
         $(this).removeClass("active").stop(':animated').animate({width: '40px'}, {duration: bigimg_sec, easing: "easeInOutQuad", complete: "callback"});

 }
  });
});
</script>
<!-- End jimgMenu Script -->
<!-- Begin jimgMenu HTML -->
<div class="clear"></div>
<div class="jimgMenu" id="featured">
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
  <ul>
      <?php
       foreach($result as $res)
       {
            echo '<li class="landscapes"  ><a id="sliding_item'.$i.'" href="'. $res->bann_imgurl.'"
            style="background: url('.get_bloginfo('url').'/wp-content/plugins/'.$folder_name.'/admin/uploads/'.$res->bann_img.') scroll 0% 0%;width:40px;" >';
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
<!-- End jimgMenu HTML -->