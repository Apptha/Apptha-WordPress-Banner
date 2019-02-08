<?php
/**
 * @name        Apptha Banner.
 * @version	1.0: plain image.php 2011-07-18
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
<link rel="stylesheet" type="text/css" href="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder_name; ?>/plain image/jqslider/jqslider.css" />
<!--<script type="text/javascript" src="<?php //echo get_bloginfo('url'); ?>/wp-content/plugins/contusbanner/navo slider/jqslider/jqslider.js"></script>-->
    <?php
    if(!isset($_REQUEST['style']))
    {
    ?>
<script type="text/javascript" src="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder_name;?>/plain image/jqslider/jquery-1.4.2.min.js"></script>
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

			var $this = $(this); 
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
        var get_width = '<?php echo $banner_show->bann_width; ?>';
            
        var anim_speed = '<?php echo $banner_show->bann_timing*1000; ?>';
          
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
           
           
            $("#wsnSlider").css('width',actual_width);
             $("#featured").css('width',actual_width);
           
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
    </style>';
 } ?>

<div class="clear"></div>
    <!-- *** jQuery Slider code starts *** -->
<div id="featured">
 <div id="wsnSlider">
  <?php
     $result = $wpdb->get_results("SELECT bann_img FROM " . $wpdb->prefix . "bannerimages WHERE bann_imgstatus='1' ORDER BY bann_imgsort ASC");

     // For the default first image
     foreach ($result as $res) {  ?>
     <img src='<?php echo $site_url;?>/wp-content/plugins/<?php echo $folder_name;?>/admin/uploads/<?php echo $res->bann_img;?>' width="100%" />
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