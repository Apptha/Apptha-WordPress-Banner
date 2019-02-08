<?php
/**
 * @name        Apptha Banner.
 * @version	1.2: blinking_navo.php 2011-07-18
 * @since       Wordpress 3.2.1
 * @package	apptha
 * @subpackage  apptha-banner
 * @author      saranya
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license	GNU General Public License version 2 or later; see LICENSE.txt
 * @abstract    The Blinking Navo Banner.
 * */
?>
<?php
  global $wpdb;
  $site_url   = get_bloginfo('url');
  $plugin_name   = explode('/',dirname(plugin_basename(__FILE__)));
  $folder_name   = $plugin_name[0];
   $banner_show = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."bannerstyles WHERE bann_status='ON'");
    $edit_color   = explode(',',$banner_show->bann_fontcolor);
    $banner_thumb = $edit_color[1];
    $banner_color = $edit_color[0];
    $prev_next   = $banner_show->bann_height-80;
?>
<script type="text/javascript" src="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/blinking_navo/js/jquery-1.3.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/blinking_navo/js/jquery.sliderkit.1.5.1.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/blinking_navo/js/jquery.easing.1.3.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/blinking_navo/js/jquery.mousewheel.min.js'; ?>"></script>
<!-- Launch Slider Kit -->
<script type="text/javascript">
    jQuery(window).load(function(){ //jQuery(window).load() must be used instead of jQuery(document).ready() because of Webkit compatibility

            var get_width = '<?php echo $banner_show->bann_width; ?>';
                   // Getting the width of the theme to fix the banner fix
            $('#banner_solu').prepend('<img src="http://www.platoon.in/images/1.png" style="display:block">');
            if(get_width == 'auto')
            {
                var theme_width =  $("#content").css('width');
                var theme_width =  $("#main").css('width');
                var theme_width =  $("#page").css('width');
                var theme_width =  $("#container").css('width');
                var theme_width =  $("#wrapper").css('width');
                var theme_width =  $("#header").css('width');
            }
            else
            {
                var theme_width = get_width;
            }
             if(theme_width == undefined)
            {
              var theme_width = '950';
            
            }
            var border_width = parseInt('<?php echo (2*$banner_show->bann_borsize); ?>');
            var actual_width = parseInt(theme_width)-(border_width);
            
            $("#featured ").css('width',actual_width);
           // Photo gallery > Standard
            jQuery(".photosgallery-std").sliderkit({
            mousewheel:true,
            shownavitems:4,
            //navfx:"none",
            panelbtnshover:true,
            autospeed:'<?php echo ($banner_show->bann_timing*1000); ?>',
            auto:true,
            circular:true,
            navscrollatend:true
        });
        
    });
</script>

<!-- Plugin styles -->
<link rel="stylesheet" type="text/css" href="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/blinking_navo/css/sliderkit-core.css'; ?>" media="screen, projection" />
<link rel="stylesheet" type="text/css" href="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/blinking_navo/css/sliderkit-demos.css'; ?>" media="screen, projection" />
<?php
// Fetching the Published styles of the Banner in the front side

    echo $sty_bann = '<style type="text/css">
            #featured {
            margin-top:'.$banner_show->bann_spacing . 'px;
            margin-bottom:'.$banner_show->bann_spacing . 'px;
           }
           .sliderkit-nav
           {
            border: ' . $banner_show->bann_borsize . 'px solid ' . $banner_show->bann_border . ';
            font-family:' . $banner_show->bann_fontfamily . ';
            color:' . $banner_color . ' !important;
	    background:' . $banner_show->bann_bgcolor . ';
            border-bottom-left-radius: ' . $banner_show->bann_corner . 'px ' . $banner_show->bann_corner . 'px;
            border-bottom-right-radius: ' . $banner_show->bann_corner . 'px ' . $banner_show->bann_corner . 'px;
           }
           .sliderkit-panels img
           {
            border-style: solid;
            -moz-border-radius: ' . $banner_show->bann_corner . 'px;
            border-top-left-radius: ' . $banner_show->bann_corner . 'px ' . $banner_show->bann_corner . 'px;
            border-top-right-radius: ' . $banner_show->bann_corner . 'px ' . $banner_show->bann_corner . 'px;
          }
            .feat_ulname{

            font-family:' . $banner_show->bann_fontfamily . ';
            color:' . $banner_color . ' !important;
            font-size:'.$banner_show->bann_fontsize.'px;
            }
           .feat_uldesc
            {
            font-size: ' . $banner_show->bann_fontsize. 'px;
            font-family:' . $banner_show->bann_fontfamily . ';
            color:' . $banner_color . '!important;
            }
             .photosgallery-std{height:'.$banner_show->bann_height.'px;}
            .photosgallery-std .sliderkit-go-btn a {height:'.$prev_next.'px; }
           </style>';

?>
<div class="sliderkit photosgallery-std" style="display:block" id="featured">
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
    <div class="sliderkit-nav" id="featured_background">
        <div class="sliderkit-nav-clip">
            <ul>
                <?php
                $result = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "bannerimages WHERE bann_imgstatus='1' ORDER BY bann_imgsort ASC");
                foreach ($result as $res) {
                    echo '<li><a href="#" rel="nofollow" title="'.$res->bann_imgname.'">
                    <img src="' . $site_url . '/wp-content/plugins/'.$folder_name.'/admin/thumbnails/' . $res->bann_img . '" alt="' . $res->bann_imgname . '"/></a></li>';
                }
                ?>
            </ul>
        </div>
        <div class="sliderkit-btn sliderkit-nav-btn sliderkit-nav-prev"><a rel="nofollow" href="#" title="Previous line"><span>Previous line</span></a></div>
        <div class="sliderkit-btn sliderkit-nav-btn sliderkit-nav-next"><a rel="nofollow" href="#" title="Next line"><span>Next line</span></a></div>
    </div>

    <div class="sliderkit-panels" >
        <div class="sliderkit-btn sliderkit-go-btn sliderkit-go-prev"><a rel="nofollow" href="#" title="Previous"><span>Previous</span></a></div>
        <div class="sliderkit-btn sliderkit-go-btn sliderkit-go-next"><a rel="nofollow" href="#" title="Next"><span>Next</span></a></div>
<?php
                foreach ($result as $res) {
                    echo '<div class="sliderkit-panel"><a href="'.$res->bann_imgurl.'" title="'.$res->bann_imgname.'">
                   <img src="' . $site_url . '/wp-content/plugins/'.$folder_name.'/admin/uploads/' . $res->bann_img . '" alt="'.$res->bann_imgname.'" width="100%"/></a>';
                    if($banner_show->bann_caption == 'true')
                    {
                  echo '<div id="info">
                   <div class="sliderkit-panel-text">
                   <h2 class="feat_ulname">'.$res->bann_imgname.'</h2>
                   <p class="feat_uldesc">'.$res->bann_imgdesc.'</p>
                  </div>
               <div class="sliderkit-panel-overlay"></div>
	   </div>';
                    }
	echo '</div>';
                } ?>
    </div>
</div>
                
<!-- // end of photosgallery-std -->
<div class="spacer"></div>
