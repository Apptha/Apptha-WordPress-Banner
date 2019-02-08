<?php
/**
 * @name        Apptha Banner.
 * @version	1.0: banner_temp.php 2011-07-18
 * @since       Wordpress 3.2.1
 * @package	apptha
 * @subpackage  apptha-banner
 * @author      saranya
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license	GNU General Public License version 2 or later; see LICENSE.txt
 * @abstract    The designing of style are show here.
 **/
  global $wpdb;
  $site_url   = get_bloginfo('url');
  $plugin_name   = explode('/',dirname(plugin_basename(__FILE__)));
  $folder_name   = $plugin_name[0];
  require_once('../wp-content/plugins'.DIRECTORY_SEPARATOR.$folder_name.DIRECTORY_SEPARATOR.'apptha_wpdirectory.php');  // Load file for the plugin
  ?>

<!--        SCRIPT AND CSS FOR JQUERY UI STYLE                        -->
<script src="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/js/jquery.min.js';?>" type="text/javascript"></script>
<script src="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/js/jquery.colorbox.js';?>" type="text/javascript"></script>

<script>
       var url = '<?php echo $site_url; ?>';
          $(document).ready(function(){
		//Examples of how to assign the ColorBox event to elements
                //alert('sdfsd');
		$(".banner_preview").colorbox({width:"80%", height:"80%", iframe:true});

		});
	</script>
<?php
$options = get_option('get_api_key');
if ( !is_array($options) )
{
  $options = array('title'=>'', 'show'=>'', 'excerpt'=>'','exclude'=>'');
}

if(isset($_POST['submit_license']))
    {
       $options['title'] = strip_tags(stripslashes($_POST['get_license']));

       update_option('get_api_key', $options);
    }
      ?>
<?php
$this_url = explode('.',$site_url);
$get_url  = $this_url[1];

if($options['title'] == generatekey($get_url))
{
?>
<script src="<?php echo get_bloginfo('url') . '/wp-content/plugins/'.$folder_name.'/js/jquery-ui.min.js';?>" type="text/javascript"></script>
<?php
}
else
{
?>

<script src="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/js/jquery-pack.js'; ?>" type="text/javascript"></script>
<link href="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/css/facebox.css';?>" media="screen" rel="stylesheet" type="text/css" />
<script src="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/js/facebox.js';?>" type="text/javascript"></script>
<script type="text/javascript">

    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox()
    })
</script>
<?php
}
?>
<script src="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/js/app.js';?>" type="text/javascript"></script>

<link rel="stylesheet" href="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/css/jquery-ui.css'; ?>">
<link rel="stylesheet" href="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/css/app_screen.css'; ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/css/farbtastic.css'; ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo $site_url . '/wp-content/plugins/'.$folder_name.'/css/colorbox.css'; ?>">
<!--            DYNAMICALLY GETTING THE PREVIEW AND SHOW                        -->
<script>
 
    function bann_bg()
    {
        var bann_ui_bg = $('#bgColorHeader').val();
        document.getElementById('featured').style.backgroundColor = bann_ui_bg;
        document.getElementById('featured_background').style.backgroundColor = bann_ui_bg;
    }
    function bann_brd()
    {
        var bann_ui_brd = $('#borderColorHeader').val();
        document.getElementById('featured').style.borderColor = bann_ui_brd;
    }
   
    function bann_color()
    {
         var bann_ui_color = $('#fcHeader').val();
         $('.feat_uldesc').css('color',bann_ui_color);
         $('.feat_ulname').css('color',bann_ui_color);

    }
    function bann_family()
    {

         var bann_ui_family = $('#fon_family').val();
         $('.feat_uldesc').css('font-family',bann_ui_family);
         $('.feat_ulname').css('font-family',bann_ui_family);

    }
    function bann_wid()
    {
       var bann_ui_width = document.getElementById('bannerWidth').value;
       document.getElementById('featured').style.width = bann_ui_width+'px';
    }
    function bann_hei()
    {
        var bann_ui_height = $('#bannerHeight').val();
        document.getElementById('featured').style.height = bann_ui_height+'px';
    }
    function bann_fntsize()
    {
         var bann_ui_fntsize = $('#fon_size').val();
         $('.feat_uldesc').css('font-size',parseInt(bann_ui_fntsize));
         $('.feat_ulname').css('font-size',parseInt(bann_ui_fntsize));
    }
   
      function bann_borsize()
    {
        var borsize = $('#bannerborder').val();
        var bann_ui_borsize = $('#borderColorHeader').val();
        document.getElementById('featured').style.border = borsize+'px solid '+bann_ui_borsize;
    }
    
    function bann_text(txt)
    {
     if(txt == 'no')
         {
            alert('no');
          document.getElementById('info').style.display = 'none';
         }
         else
         {
             alert('yes');
          document.getElementById('info').style.display = 'block';
         }
   }
 // STORING THE UPDATED STYLE TO STORED IN TABLE
  function updateDesign()
    {
      var site_url       = '<?php echo $site_url;?>';
      var bann_style     = '<?php echo $_REQUEST['style'];?>';
       var folder_name    = '<?php echo $folder_name; ?>';
      var bgColorHeader     = document.getElementById('bgColorHeader').value;
      var bgcolor           = bgColorHeader.substr(1);
      var borderColorHeader = document.getElementById('borderColorHeader').value;
      var bordercolor       = borderColorHeader.substr(1);
      var fcHeader          = document.getElementById('fcHeader').value;
      var fontcolor         = fcHeader.substr(1);
      var bann_borsize  = document.getElementById('bannerborder').value;
      var cornerradius  = document.getElementById('cornerRadius').value;
      var fontfamily    = document.getElementById('fon_family').value;
      var fontsize      = document.getElementById('fon_size').value;
      var bannwidth     = document.getElementById('bannerWidth').value;
      var bannheight    = document.getElementById('bannerHeight').value;
      var banncaption   = document.getElementById('bannerCaption').checked;
      var bannspacing   = document.getElementById('banner_spacing').value;
      var bann_timing   = document.getElementById('banner_timing').value;
      banner = jQuery.noConflict();
      banner.ajax({
       method:"GET",
       url: site_url+'/wp-content/plugins/'+folder_name+'/blinking navo/banner_temp_ajax.php',
       data : "&bann_style="+bann_style+"&bgcolor="+bgcolor+"&bordercolor="+bordercolor+
           "&fontcolor="+fontcolor+"&fontsize="+fontsize+"&fontfamily="+fontfamily+"&bannwidth="+bannwidth+"&bannheight="+bannheight+
           "&corner="+cornerradius+"&bann_borsize="+bann_borsize+"&bann_caption="+banncaption+"&bannspacing="+bannspacing+
           "&bann_timing="+bann_timing,
       asynchronous:false,
       success: function() {
            // data.redirect contains the string URL to redirect to
           window.location.href = site_url+'/wp-admin/options-general.php?page=banner_temp&style='+bann_style;
       }
});
}
  function resetForm()
  {
   document.getElementById("themeConfig").reset();
     window.location = self.location;
  }
  </script>
<?php
 
      $style = $_GET['style'];
      $banner_show    = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."bannerstyles WHERE bann_tempid = '$style'");
      $edit_pgname    = $banner_show->bann_pagename;
      $edit_bgcolor   = $banner_show->bann_bgcolor;
      $edit_brdcolor  = $banner_show->bann_border;
      $edit_brdsize   = $banner_show->bann_borsize;
      $edit_color     = $banner_show->bann_fontcolor;
      $edit_width     = $banner_show->bann_width;
      $edit_height    = $banner_show->bann_height;
      $edit_fntfamily = $banner_show->bann_fontfamily;
      $edit_fntsize   = $banner_show->bann_fontsize;
      $edit_corner    = $banner_show->bann_corner;
      $edit_hover     = $banner_show->bann_hover;
      $edit_caption   = $banner_show->bann_caption;
      $edit_spacing   = $banner_show->bann_spacing;
      $edit_timing    = $banner_show->bann_timing;
 ?>
     
	<div id="icon-themes" class="icon32"><br /></div>
        <h2 class="nav-tab-wrapper">
        <a href="?page=banner_show" class="nav-tab">Banner Styles</a>
          <?php
         $split_title = $wpdb->get_var("SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name='get_api_key'");
         $get_title = unserialize($split_title);
        if($get_title['title'] == generatekey($get_url))
        {
        ?>
        <a href="?page=banner_img&style=<?php echo $_REQUEST['style']?>" class="nav-tab">Upload/Edit</a>
        <?php } ?>
	<a href="?page=banner_temp&style=<?php echo $_REQUEST['style']?>" class="nav-tab nav-tab-active">Style Settings</a>
	</h2>
         <div class="bann_note"><strong>Note:</strong> After Publishing your own style of template.<br />
        Step 1  :  Please Go To Admin Menu->Apperance-><a href="<?php echo $site_url; ?>/wp-admin/theme-editor.php"> Editor </a> and<br />
        Step 2  :  Select your theme in top select box and go to file header.php <br />
        Step 3 :  Add our <strong> &lt;?php  apptha_banner(); ?&gt; </strong> where you want to place the Banner.
         </div>
   <!--                   The left side Jquery UI designing                       -->
        <div id="themeRoller"  class="lfloat">
			<div id="rollerTabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
			<div id="rollYourOwn" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                            
            <form method="get" name="themeConfig" action="" id="themeConfig">
	    <fieldset class="clearfix">
   
            	

		<div class="theme-group clearfix" id="global-font">
			<div class="theme-group-header state-default corner-all">
				<span class="icon icon-triangle-1-e">Collapse</span>
				<a href="">Font Settings</a>
			</div><!-- /theme group header -->
			<div class="theme-group-content corner-bottom clearfix display_none">
				<div class="field-group clearfix">
					<label for="fon_family">Family</label>
					<input type="text" name="fon_family" id="fon_family" class="fon_family" value="<?php echo $edit_fntfamily; ?>" size="8" onblur="bann_family();">
				</div>
                            <div class="field-group clearfix">
					<label for="fon_family">Font-Size</label>
					<input type="text" name="fon_size" id="fon_size" class="fon_size" value="<?php echo $edit_fntsize; ?>" size="8" onblur="bann_fntsize();">
				</div>
				
				<div class="field-group clearfix">
					<label for="fsDefault">Border Size</label>
					<input type="text" name="bannerborder" id="bannerborder" value="<?php echo $edit_brdsize;?>" size="3" onblur="bann_borsize();">
				</div>
			</div><!-- /theme group content -->
		</div><!-- /theme group -->
               
		<div class="theme-group clearfix" id="global-corners">
			<div class="theme-group-header state-default corner-all">
				<span class="icon icon-triangle-1-e">Collapse</span>
				<a href="">Corner Radius</a>
			</div><!-- /theme group header -->
			<div class="theme-group-content corner-bottom clearfix" style="display: none; ">
				<div class="field-group field-group-corners clearfix">
					<label for="cornerRadius">Corners:</label>
					<input type="text" value="<?php echo $edit_corner;?>" name="cornerRadius" id="cornerRadius" class="cornerRadius">
				</div>
				<p id="cornerWarning"><em><strong>Note:</strong> The corner radius preview is not available but it will shown in the front end.</em></p>
			</div><!-- /theme group content -->

                       
		</div><!-- /theme group -->

		<div class="theme-group clearfix" id="Header">
			<div class="theme-group-header state-default corner-all">
				<span class="icon icon-triangle-1-e">Collapse</span>
<!--				<div class="state-preview corner-all ui-widget-header">abc</div>-->
				<a href="">Style Color</a>
			</div><!-- /theme group header -->
			<div class="theme-group-content corner-bottom clearfix display_none">
				<div class="field-group field-group-background clearfix">
					<label for="bgColorHeader" class="background">Background color &amp; texture</label>
					<div class="hasPicker">
                                            <input type="text" name="bgColorHeader" id="bgColorHeader" class="hex" value="<?php echo $edit_bgcolor; ?>" style="background-color: rgb(119, 233, 120); color: rgb(0, 0, 0);" onblur="bann_bg();"></div>
					
				</div>
				<div class="field-group field-group-border clearfix">
					<label for="borderColorHeader">Border</label>
					<div class="hasPicker"><input type="text" name="borderColorHeader" id="borderColorHeader" class="hex" onblur="bann_brd()" value="<?php echo $edit_brdcolor; ?>" size="6" style="background-color: rgb(170, 170, 170); color: rgb(0, 0, 0); "></div>
				</div>
				<div class="field-group clearfix">
					<label for="fcHeader">Text</label>
					<div class="hasPicker"><input type="text" name="fcHeader" id="fcHeader" onblur="bann_color()" class="hex" value="<?php echo $edit_color;?>" size="6" style="background-color: rgb(34, 34, 34); color: rgb(255, 255, 255); "></div>
				</div>
				
			</div><!-- /theme group content -->
		</div><!-- /theme group -->
		
		<div class="theme-group clearfix" id="Default">
			<div class="theme-group-header state-default corner-all">
				<span class="icon icon-triangle-1-e">Collapse</span>
<!--				<div class="state-preview corner-all ui-state-default">abc</div>-->
				<a href="">Banner Text ON/OFF</a>

			</div><!-- /theme group Default -->
			<div class="theme-group-content corner-bottom clearfix display_none">
				
				<div class="field-group field-group-background clearfix">
					<label>Banner Text</label>
				        <div class="hasPicker">
                                      <input type="radio" name="bannerCaption" id="bannerCaption" <?php if($edit_caption == 'true') { echo 'checked';}?> value="1" onclick="bann_text('yes');">Yes
                                      <input type="radio" name="bannerCaption" id="bannerCaption" <?php if($edit_caption == 'false') { echo 'checked';}?>  value="0" onclick="bann_text('no');" >No
                                      </div>
				</div>

			</div><!-- /theme group content -->
		</div><!-- /theme group -->

		<div class="theme-group clearfix" id="Hover">
			<div class="theme-group-header state-default corner-all">
				<span class="icon icon-triangle-1-e">Banner</span>
<!--				<div class="state-preview corner-all ui-state-hover">abc</div>-->
				<a href="">Banner Settings</a>
			</div><!-- /theme group Hover -->
			<div class="theme-group-content corner-bottom clearfix" style="display: none; ">
				
				<div class="field-group field-group-border clearfix">
					<label for="borderWidth">Width</label>
					<div class="hasPicker"><input type="text" name="bannerWidth" id="bannerWidth"  value="<?php echo $edit_width; ?>" size="6" onblur="bann_wid();"></div>
				</div>
				<div class="field-group clearfix">
					<label for="borderHeight">Height</label>
					<div class="hasPicker"><input type="text" name="bannerHeight" id="bannerHeight" value="<?php echo $edit_height; ?>" size="6" onblur="bann_hei();"></div>
				</div>
                             <div class="field-group clearfix">
					<label for="borderSeconds">Seconds</label>
					<div class="hasPicker"><input type="text" name="banner_timing" id="banner_timing" value="<?php echo $edit_timing; ?>" size="6"></div>
				</div>
                                <div class="field-group field-group-background clearfix">
					<label>Space:Below & Top</label>
					<div class="hasPicker"><input type="text" name="banner_spacing" id="banner_spacing" value="<?php echo $edit_spacing; ?>" size="6"></div>
				</div>
				</div><!-- /theme group content -->
		</div><!-- /theme group -->
               	</fieldset>
    <div align="center"><input type="button" value="Save"  align="right" onclick="updateDesign();"/>
        <input type="button" value="Reset"  align="right" onclick="resetForm();"/></div>
</form>
</div>
</div>
</div>

<div id="components"  class="lfloat">
<?php
$reqbanner = '../wp-content/plugins'.DIRECTORY_SEPARATOR.$folder_name.DIRECTORY_SEPARATOR.'blinking navo/blinking navo.php';
require_once "$reqbanner";
?>
    <div class="clear"></div>
 <div align="center" style="padding-left:170px;"><a class='banner_preview' href="<?php echo $site_url;?>"><img src="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder_name;?>/image/prev.png"></a></div>
</div>

   