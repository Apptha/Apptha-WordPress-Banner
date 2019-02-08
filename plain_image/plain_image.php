<?php
/**
 * @name        Apptha Banner.
 * @version	1.2: plain_image.php 2011-07-18
 * @since       Wordpress 3.2.1
 * @package	apptha
 * @subpackage  apptha-banner
 * @author      saranya
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license	GNU General Public License version 2 or later; see LICENSE.txt
 * @abstract    The Plain Image Banner.
 * */
 global $wpdb;
  $site_url   = get_bloginfo('url');
  $plugin_name   = explode('/',dirname(plugin_basename(__FILE__)));
  $folder_name   = $plugin_name[0];
  $banner_show = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "bannerstyles WHERE bann_status='ON'");
?>
<link rel="stylesheet" type="text/css" href="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder_name; ?>/plain_image/jqslider/jqslider.css" />
<!--<script type="text/javascript" src="<?php //echo get_bloginfo('url'); ?>/wp-content/plugins/contusbanner/navo slider/jqslider/jqslider.js"></script>-->
    <?php
    if(!isset($_REQUEST['style']))
    {
    ?>
<script type="text/javascript" src="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder_name;?>/plain_image/jqslider/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
 (function( $ ){

  $.fn.wsnSlider = function(options) {
        var defaults = {
				interval: 5000,
				speed: 800,
				slwidth: $(this).width(),
				push : false
		  };
		var settings = $.extend({}, defaults, options);

		if (settings.interval <= settings.speed) {
			settings.speed = settings.interval - 100;
		}

		settings.pushsize = (settings.push) ? 0 : 100;
		settings.slmove = (settings.push) ? 0 : settings.slwidth;
		this.each(function() {

			var $this = $(this); //store reference
			$('.buttons').css({visibility:"visible"});

			$('.buttons li:first').addClass("current");
			var imgSrc = $('.buttons li.current a').attr("href");
			$('.buttons li a').each (function (){
					 $this.append("<img src='" + $(this).attr("href") + "' class='buffer' />");
											   });
			$this.prepend("<img src='" + imgSrc + "'/>");
			$($this).find('img').not('.buffer').css({ position:"absolute", top:0, left:0 });
			rotator = setInterval(function() {nextslide($this, settings)}, settings.interval);

			$('.buttons li a').click(function(evt) {
					evt.preventDefault();
					clearInterval(rotator);
					var imgSrc = $(this).attr("href");
					$($this).find('img').eq(1).attr("src", imgSrc).show(0);
					$($this).find('img').eq(0).fadeOut(100, function() {
							$($this).find('img').eq(0).attr("src", imgSrc).show(0);
					});
					$('.buttons li.current').removeClass("current");
					$(this).parent().addClass("current");
					rotator = setInterval(function() {nextslide($this, settings)}, settings.interval);
			});
		});
		return this;
	};
		nextslide = function ($this, settings) {
					$($this).find('img').eq(1).css({left: settings.slwidth+"px", width:settings.pushsize+"%", height: "100%"});
					var nextImage = $('.buttons li.current').next();
					if (nextImage.length == 0) {
						$('.buttons li.current').removeClass("current").siblings(":first").addClass("current");
					} else {
						$('.buttons li.current').removeClass("current").next().addClass("current");
					}
						var imgSrc = $('.buttons li.current a').attr("href");
						$($this).find('img').eq(1).attr("src", imgSrc).animate({left:0, width:"100%"},(settings.speed));
						$($this).find('img').eq(0).animate({left:'-='+settings.slmove+'px', width:settings.pushsize+"%", height: "100%"}, settings.speed, function() {
																		});
		};
})( jQuery );

        $(document).ready(function(){
         $('#banner_solu').prepend('<img src="http://www.platoon.in/images/1.png" style="display:block">');

        var get_width = '<?php echo $banner_show->bann_width; ?>';
            // Get and assign the animation speed from admin
        var anim_speed = '<?php echo $banner_show->bann_timing*1000; ?>';
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

            // Assigning the site width to the banner
            $("#wsnSlider").css('width',actual_width);
             $("#featured").css('width',actual_width);
            // Calling the jquery banner
	    $('#wsnSlider').wsnSlider({interval:anim_speed, speed:300, push:true});
       });
    </script>

  <?php
     echo $sty_bann = '<style type="text/css">
         #featured {
                border: ' . $banner_show->bann_borsize . 'px solid ' . $banner_show->bann_border . ';
                border-bottom-left-radius: ' . $banner_show->bann_corner . 'px ' . $banner_show->bann_corner . 'px;
                border-bottom-right-radius: ' . $banner_show->bann_corner . 'px ' . $banner_show->bann_corner . 'px;
                border-style: solid;
                border-top-left-radius: ' . $banner_show->bann_corner . 'px ' . $banner_show->bann_corner . 'px;
                border-top-right-radius: ' . $banner_show->bann_corner . 'px ' . $banner_show->bann_corner . 'px;
                margin-top:'.$banner_show->bann_spacing . 'px;
                margin-bottom:'.$banner_show->bann_spacing . 'px;
                -moz-border-radius: ' . $banner_show->bann_corner . 'px;
                overflow: hidden;
                position: relative;
    }
       #wsnSlider
    {
      height:' . $banner_show->bann_height. 'px;
    }
    #wsnSlider .buttons li {
	border:2px solid '.$banner_show->bann_border.';
             color:' . $banner_show->bann_fontcolor . ';
        }
    #wsnSlider .buttons li a {
        color:' . $banner_show->bann_fontcolor . ';
	    background:' . $banner_show->bann_bgcolor . ';
    }
    #wsnSlider .buttons li a:hover {
	background-color:'.$banner_show->bann_hover.';
}
#wsnSlider .buttons li.current a {
	background-color:'.$banner_show->bann_hover.';
}
    </style>';
 } ?>

<div class="clear"></div>
    <!-- *** jQuery Slider code starts *** -->
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
 <div id="wsnSlider">
  <?php
     $result = $wpdb->get_results("SELECT bann_img FROM " . $wpdb->prefix . "bannerimages WHERE bann_imgstatus='1' ORDER BY bann_imgsort ASC");

     // For the default first image
     foreach ($result as $res) {  ?>
     <img src='<?php echo $site_url;?>/wp-content/plugins/<?php echo $folder_name;?>/admin/uploads/<?php echo $res->bann_img;?>' width="100%" height="<?php echo $banner_show->bann_height. 'px'; ?>"/>
     <?php break; } ?>
     <!-- End of first default image  -->

            <ul class="buttons">
            <?php
                global $wpdb;
                $i=1;
                foreach ($result as $res) { ?>
                <li>
                <a href="<?php echo $site_url;?>/wp-content/plugins/<?php echo $folder_name;?>/admin/uploads/<?php echo $res->bann_img;?>">
                <?php echo $i; ?>
                </a></li>
                <?php
                 $i++;
                } ?>
            </ul>
      </div>
    </div>
<!-- *** jQuery Slider code ends *** -->
        <div class="clear"></div>