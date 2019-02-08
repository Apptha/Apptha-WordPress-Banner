<?php
/**
 * @name        Apptha Banner.
 * @version	1.2: navo_slider.php 2011-07-18
 * @since       Wordpress 3.2.1
 * @package	apptha
 * @subpackage  apptha-banner
 * @author      saranya
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license	GNU General Public License version 2 or later; see LICENSE.txt
 * @abstract    The Navo Slider banner.
 * */
    global $wpdb;
    $site_url       = get_bloginfo('url');
    $plugin_name    = explode('/',dirname(plugin_basename(__FILE__)));
    $folder_name    = $plugin_name[0];
    $banner_show  = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."bannerstyles WHERE bann_status='ON'");
    $edit_color   = explode(',',$banner_show->bann_fontcolor);
    $banner_thumb = $edit_color[1];
    $banner_color = $edit_color[0];
?>
<link rel="stylesheet" href="<?php echo $site_url .'/wp-content/plugins/'.$folder_name.'/navo_slider/css/global.css'?>">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/navo_slider/js/slides.min.jquery.js'; ?>"></script>
<script type="text/javascript">
 var get_width = '<?php echo $banner_show->bann_width; ?>';
 var conflict = jQuery.noConflict();
 conflict(function(){
     conflict('#banner_solu').prepend('<img src="http://www.platoon.in/images/1.png" style="display:block">');
      			conflict('#slides').slides({
				preload: true,
				preloadImage: 'http://localhost/wordpress/wp-content/plugins/apptha-banner/navo%20slider/img/loading.gif',
				play:  '<?php echo $banner_show->bann_timing*1000; ?>',
				pause: '<?php echo $banner_show->bann_timing*1000; ?>',
				hoverPause: true,
				animationStart: function(current){
					conflict('.caption').animate({
						bottom:-35
					},100);
					if (window.console && console.log) {
						// example return of current slide number
						console.log('animationStart on slide: ', current);
					};
				},
				animationComplete: function(current){
					conflict('.caption').animate({
						bottom:0
					},200);
					if (window.console && console.log) {
						// example return of current slide number
						console.log('animationComplete on slide: ', current);
					};
				},
				slidesLoaded: function() {
					conflict('.caption').animate({
						bottom:0
					},200);
				}
			});
                      
		});
</script>
<?php
$get_width = $banner_show->bann_width;
    if($get_width == 'auto')
    {
  $assign_width = '950';
    }
    else
    {
  $assign_width = $banner_show->bann_width;
    }
echo '<style>
     #slides{
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
     
#container { width:'.$assign_width.'px;height:'.$banner_show->bann_height.'px }
#example { width:'.$assign_width.'px;height:'.$banner_show->bann_height.'px  }
#slides .next {	left:'.$assign_width.'px;height:'.$banner_show->bann_height.'px }
.slides_container { width:'.$assign_width.'px;height:'.$banner_show->bann_height.'px }
.slides_container div.slide { width:'.$assign_width.'px; height:'.$banner_show->bann_height.'px }
.caption { width:'.$assign_width.'px; font-size:'.$banner_show->bann_fontsize.'px; }
</style>';
?>
<div class="clear"></div>
<div id="container">
    <div id="example">
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
    <span style="position:absolute;top:10px;left:10px;z-index:99999;" id="banner_solu"></span>
    <?php } ?>
    <div id="slides">
        <div class="slides_container">
        <?php
        global $wpdb;
         $banner_bind ='';
        $result = $wpdb->get_results("SELECT t2.bann_height,t1.* FROM " . $wpdb->prefix . "bannerimages as t1 INNER JOIN
                                     " . $wpdb->prefix . "bannerstyles as t2 WHERE t1.bann_imgstatus='1' and t2.bann_status='ON' ORDER BY t1.bann_imgsort ASC");
             foreach($result as $res)
             { ?>
                <div class="slide">
                    <a href="<?php echo $res->bann_imgurl; ?>" target="_blank">
                <img src="<?php echo $site_url.'/wp-content/plugins/'.$folder_name.'/admin/uploads/'.$res->bann_img ;?>" width="<?php echo $assign_width.'px';?>"  height="<?php echo $banner_show->bann_height.'px';?>" alt="" /></a>
                <div class="caption"><p><?php echo $res->bann_imgname;?></p>
                </div>
                </div>
        <?php } ?>
        </div>
        <a href="#" class="prev"><img src="<?php echo $site_url.'/wp-content/plugins/'.$folder_name.'/navo_slider/img/arrow-prev.png';?>" width="24" height="43" alt="Arrow Prev"></a>
        <a href="#" class="next"><img src="<?php echo $site_url.'/wp-content/plugins/'.$folder_name.'/navo_slider/img/arrow-next.png';?>" width="24" height="43" alt="Arrow Next"></a>
    </div>
    </div>
</div>
<div class="clear"></div>
