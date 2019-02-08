<?php
/**
 * @name        Apptha Banner.
 * @version	1.2: banner_img.php 2011-07-18
 * @since       Wordpress 3.2.1
 * @package	apptha
 * @subpackage  apptha-banner
 * @author      saranya
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license	GNU General Public License version 2 or later; see LICENSE.txt
 * @abstract    Image listing page of the banner.
 **/

  global $wpdb;
  $banner_url = get_bloginfo('url');
  $plugin_name   = explode('/',dirname(plugin_basename(__FILE__)));
  $folder_name   = $plugin_name[0];
   $publish_show = $wpdb->get_row("SELECT bann_tempid,bann_tempname,bann_tempimg,bann_status
                                                 FROM " . $wpdb->prefix . "bannerstyles WHERE bann_status='ON'");
  require_once('../wp-content/plugins'.DIRECTORY_SEPARATOR.$folder_name.DIRECTORY_SEPARATOR.'apptha_wpdirectory.php');  // Load file for the plugin
?>
<!-------------------------------                      FOR SORTING THE IMAGE                         ------------------------------->
<script type="text/javascript" src="<?php echo $banner_url; ?>/wp-content/plugins/<?php echo $folder_name; ?>/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo $banner_url; ?>/wp-content/plugins/<?php echo $folder_name; ?>/js/jquery-ui-1.7.1.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $banner_url; ?>/wp-content/plugins/<?php echo $folder_name; ?>/js/preview.js"></script>
<!-------------------------------                      FOR MULTIPLE UPLOAD                           ------------------------------->
<script type="text/javascript" src="<?php echo $banner_url; ?>/wp-content/plugins/<?php echo $folder_name; ?>/js/swfupload/swfupload.js"></script>
<script type="text/javascript" src="<?php echo $banner_url; ?>/wp-content/plugins/<?php echo $folder_name; ?>/js/swfupload/jquery.swfupload.js"></script>

<!-------------------------------                      JQUERY FOR SORTING AND MULTIPLE UPLOAD                           ------------------------------->
<script type="text/javascript">
   var banner_url,folder_name,numfiles;
   banner_url = '<?php echo $banner_url; ?>'; //Initialize the Base Url to Javascript
   folder_name = '<?php echo $folder_name; ?>';
   var banner = jQuery.noConflict();     //For No conflict

   banner(document).ready(function()
   {
       if(document.getElementById('test-list'))  // Sorting
       {
        banner("#test-list").sortable({
                handle : '.handle',
                update : function () {
                    var order = banner('#test-list').sortable('serialize');
                    banner("#info").load(banner_url+"/wp-content/plugins/"+folder_name+"/admin/banner_sortable.php?"+order);
                   // location.reload();
                    }
                });
       } // Sorting Over

        //Multiple Upload Of Images
         banner('#swfupload-control').swfupload({
                upload_url: banner_url+"/wp-content/plugins/"+folder_name+"/admin/upload-file.php",
                file_post_name: 'uploadfile',
                file_size_limit : 0,
                file_types : "*.jpg;*.png;*.jpeg;*.gif;*.mp4",
                file_types_description : "Image files",
                file_upload_limit : 1000,
                flash_url : banner_url+"/wp-content/plugins/"+folder_name+"/js/swfupload/swfupload.swf",
                button_image_url : banner_url+'/wp-content/plugins/'+folder_name+'/js/swfupload/wdp_buttons_upload_114x29.png',
                button_width : 114,
                button_height : 29,
                button_placeholder :banner('#button')[0],
                debug: false
            })
            .bind('fileQueued', function(event, file){
                var listitem='<li id="'+file.id+'" >'+
                    'File: <em>'+file.name+'</em> ('+Math.round(file.size/1024)+' KB) <span class="progressvalue" ></span>'+
                    '<div class="progressbar" ><div class="progress" ></div></div>'+
                    '<p class="status" >Pending</p>'+
                    '<span class="cancel" >&nbsp;</span>'+
                    '</li>';

                banner('#log').append(listitem);

               banner('li#'+file.id+' .cancel').bind('click', function(){
                    var swfu =banner.swfupload.getInstance('#swfupload-control');
                    swfu.cancelUpload(file.id);
                    banner('li#'+file.id).slideUp('fast');
                });
                // start the upload since it's queued
                banner(this).swfupload('startUpload');
            })
            .bind('fileQueueError', function(event, file, errorCode, message){
                alert('Size of the file '+file.name+' is greater than limit');

            })
            .bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
               banner('#queuestatus').text('Files Selected: '+numFilesSelected+' / Queued Files: '+numFilesQueued);
                numfiles = numFilesQueued;

            })
            .bind('uploadStart', function(event, file){

               banner('#log li#'+file.id).find('p.status').text('Uploading...');
               banner('#log li#'+file.id).find('span.progressvalue').text('0%');
               banner('#log li#'+file.id).find('span.cancel').hide();
            })
            .bind('uploadProgress', function(event, file, bytesLoaded){
                //Show Progress

                var percentage=Math.round((bytesLoaded/file.size)*100);
               banner('#log li#'+file.id).find('div.progress').css('width', percentage+'%');
               banner('#log li#'+file.id).find('span.progressvalue').text(percentage+'%');
            })
            .bind('uploadSuccess', function(event, file, serverData){
                var item=banner('#log li#'+file.id);
                item.find('div.progress').css('width', '100%');
                item.find('span.progressvalue').text('100%');
                var pathtofile='<img src="'+banner_url+'/wp-content/plugins/'+folder_name+'/admin/uploads/'+file.name+'" width="50" height="50" />';

                item.addClass('success').find('p.status').html('Done!!!Image uploaded successfully. Your image will appear only when you refresh the page.');

            })
            .bind('uploadComplete', function(event, file){
                // upload has completed, try the next one in the queue
                banner(this).swfupload('startUpload');

            })
       });

       //Multiple Upload Image is over

    </script>
        <script type="text/javascript">
// starting the script on page load
banner(document).ready(function(){

	imagePreview();
});
 </script>

    <!-------------------------------                      CHECKING ALL THE CHECKBOX                           ------------------------------->
    <script type="text/javascript">
        function checkallimage(frm,chkall)
        {
            var j = 0;
            comlist  = document.forms[frm].elements['checkList[]'];
            checkAll = (chkall.checked)?true:false; // what to do? Check all or uncheck all.
            // Is it an array
            if (comlist.length) {
                if (checkAll) {
                    for (j = 0; j < comlist.length; j++) {
                        comlist[j].checked = true;
                    }
                }
                else {
                    for (j = 0; j < comlist.length; j++) {
                        comlist[j].checked = false;
                    }
                }
            }
            else {
                /* This will take care of the situation when your
    checkbox/dropdown list (checkList[] element here) is dependent on
    a condition and only a single check box came in a list.
                 */
                if (checkAll) {
                    comlist.checked = true;
                }
                else {
                    comlist.checked = false;
                }
            }
            return;
        }
    </script>
<div>
   <?php
    $option_title = $wpdb->get_var("SELECT option_value FROM " . $wpdb->prefix . "options WHERE option_name='get_api_key'");
    $get_title = unserialize($option_title);
    $strDomainName = $banner_url;
            preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i", $strDomainName, $matches);
            $customerurl = $matches['domain'];
            $customerurl = str_replace("www.", "", $customerurl);
            $customerurl = str_replace(".", "D", $customerurl);
            $customerurl = strtoupper($customerurl);
    $get_option_title = appbanner_generate($customerurl);

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
	<div id="icon-themes" class="icon32"><br /></div>
        <h2 class="nav-tab-wrapper">
        <a href="?page=banner_show" class="nav-tab">Banner Styles</a>
        <a href="?page=banner_img&style=<?php echo $publish_show->bann_tempid;?>" class="nav-tab  nav-tab-active">Upload/Edit</a>
      	<a href="?page=banner_temp&style=<?php echo $publish_show->bann_tempid;?>" class="nav-tab">Style Settings</a>
        <div class="buy">
    </div>

	</h2>



<!-------------------------------                      MULTIPLE UPLOAD BUTTON                          ------------------------------->
    <div id="swfupload-control" class="upd_btn">
         <div class="sidebar-name">
	 <h3>Image Uploads</h3></div>
        <div class="listing lfloat">
           <input type="button" id="button" /><div class="lfloat prefer">Preferable upload Size <strong>950X300</strong> (in pixels)</div>
           <div class="clear"></div>
           <h4 id="queuestatus" ></h4>
            <ol id="log"></ol>

        </div>
<!-------------------------------                      BINDING THE FORM FOR MULTIPLE UPLOAD             ------------------------------->
<!--      <div class="lfloat img_right"> <div name="bind_bannpht" id="bind_bannpht" class="bind_bannpht " class='lfloat'></div>-->
      <input type="hidden" name="bind_phtvalue" id="bind_phtvalue" value="0"/></div>
      </div>
<div class="clear"></div>
<?php
/*-------------------------------                      PAGINATION                           -------------------------------*/

                                function listPagesNoTitle($args)
                                { //Pagination
                                    if ($args) {
                                        $args .= '&echo=0';
                                    } else {
                                        $args = 'echo=0';
                                    }
                                    $pages = wp_list_pages($args);
                                    echo $pages;
                                }

                                function findStart($limit)
                                { //Pagination
                                    if (!(isset($_REQUEST['pages'])) || ($_REQUEST['pages'] == "1")) {
                                        $start = 0;
                                        $_GET['pages'] = 1;
                                    } else {
                                        $start = ($_GET['pages'] - 1) * $limit;
                                    }
                                    return $start;
                                }

                                /*
                                 * int findPages (int count, int limit)
                                 * Returns the number of pages needed based on a count and a limit
                                 */

                                function findPages($count, $limit)
                                { //Pagination
                                    $pages = (($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1;
                                    if ($pages == 1) {
                                        $pages = '';
                                    }
                                    return $pages;
                                }

                                /*
                                 * string pageList (int curpage, int pages)
                                 * Returns a list of pages in the format of "ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â« < [pages] > ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â»"
                                 * */

                                function pageList($curpage, $pages)
                                {
                                    //Pagination
                                    $page_list = "";
                                    if ($search != '') {

                                        $self = '?page=' . banner_img.'&style='.$_REQUEST['style'];
                                    } else {
                                        $self = '?page=' . banner_img.'&style='.$_REQUEST['style'];
                                    }

                                    /* Print the first and previous page links if necessary */
                                    if (($curpage != 1) && ($curpage)) {
                                        $page_list .= "  <a href=\"" . $self . "&pages=1\" title=\"First Page\">First</a> ";
                                    }

                                    if (($curpage - 1) > 0) {
                                        $page_list .= "<a href=\"" . $self . "&pages=" . ($curpage - 1) . "\" title=\"Previous Page\"><</a> ";
                                    }

                                    /* Print the numeric page list; make the current page unlinked and bold */
                                    for ($i = 1; $i <= $pages; $i++) {
                                        if ($i == $curpage) {
                                            $page_list .= "<b>" . $i . "</b>";
                                        } else {
                                            $page_list .= "<a href=\"" . $self . "&pages=" . $i . "\" title=\"Page " . $i . "\">" . $i . "</a>";
                                        }
                                        $page_list .= " ";
                                    }

                                    /* Print the Next and Last page links if necessary */
                                    if (($curpage + 1) <= $pages) {
                                        $page_list .= "<a href=\"" . $self . "&pages=" . ($curpage + 1) . "\" title=\"Next Page\">></a> ";
                                    }

                                    if (($curpage != $pages) && ($pages != 0)) {
                                        $page_list .= "<a href=\"" . $self . "&pages=" . $pages . "\" title=\"Last Page\">Last</a> ";
                                    }
                                    $page_list .= "</td>\n";

                                    return $page_list;
                                }

                                /*
                                 * string nextPrev (int curpage, int pages)
                                 * Returns "Previous | Next" string for individual pagination (it's a word!)
                                 */

                                function nextPrev($curpage, $pages)
                                { //Pagination
                                    $next_prev = "";

                                    if (($curpage - 1) <= 0) {
                                        $next_prev .= "Previous";
                                    } else {
                                        $next_prev .= "<a href=\"" . $_SERVER['PHP_SELF'] . "&pages=" . ($curpage - 1) . "\">Previous</a>";
                                    }

                                    $next_prev .= " | ";

                                    if (($curpage + 1) > $pages) {
                                        $next_prev .= "Next";
                                    } else {
                                        $next_prev .= "<a href=\"" . $_SERVER['PHP_SELF'] . "&pages=" . ($curpage + 1) . "\">Next</a>";
                                    }
                                    return $next_prev;
                                }
/*-------------------------------                    END OF PAGINATION                           -------------------------------*/
?>
<!------------------------------               BULK DELETE AND SINGLE DELETE OF IMAGES                  ------------------------------>
    <?php
       if (isset($_REQUEST['doaction_images'])) {

            if (isset($_REQUEST['action_images']) == 'Delete')
                {
                for ($k = 0; $k < count($_POST['checkList']); $k++)
                {
                    $bann_imgid    = $_POST['checkList'][$k];
                    $bann_imgname  = $wpdb->get_var("SELECT bann_img FROM " . $wpdb->prefix . "bannerimages WHERE bann_imgid='$bann_imgid' ");

                    $delete = $wpdb->query("DELETE FROM " . $wpdb->prefix . "bannerimages WHERE bann_imgid='$bann_imgid'");
                    $thumb_path = '../wp-content/plugins/'.$folder_name.'/admin/thumbnails/';
                    $big_path = '../wp-content/plugins/'.$folder_name.'/admin/uploads/';
                    if ($bann_imgname != '') {
                        unlink($thumb_path . $bann_imgname);
                        unlink($big_path . $bann_imgname);
                     }

                }
            }
        }
            $options = get_option('mac_img_limit');
                if (!is_array($options)) {
                    $options = array('title' => '', 'show' => '', 'excerpt' => '', 'exclude' => '');
                }
                if (isset($_POST['doaction_pagination'])) {
                    $options['title'] = strip_tags(stripslashes($_POST['limit_page']));

                    update_option('mac_img_limit', $options);
                }
    $option_limit = $wpdb->get_var("SELECT option_value FROM " . $wpdb->prefix . "options WHERE option_name='mac_img_limit'");
    $get_limit = unserialize($option_limit);
    ?>
  <div>
    <form name="banner_img" id="banner_img" method="POST">
        <div class="action_btn lfloat">
            <select name="action_images"  class="lfloat">
                    <option value="" selected="selected"><?php _e('Bulk Actions'); ?></option>
                    <option value="Delete"><?php _e('Delete'); ?></option>
            </select>

                <input type="submit" value="<?php esc_attr_e('Apply'); ?>" name="doaction_images" id="doaction_images" class="button-secondary action" /></div>

        <div class="show_screen"><span>Show on screen</span> <input type="text" name="limit_page" size="5" value="<?php echo $get_limit['title']; ?>">
                <input type="submit" value="Apply" name="doaction_pagination" id="doaction_pagination" class="button" /></div>

    <!------------------------  Show the Banner Setting Button only when there is minimum 4 images  ------------------------>

             <div class="clear"></div>
             <table cellspacing="0" cellpadding="0" border="1" width="50%" align="center" class="bann_file">
                    <thead class="bann_photos">
                        <tr class="height_tr">
                            <th class="width_five">Sort</th>
                            <th class="width_five" >
                            <input type="checkbox"  name="maccheckPhotos"  id="maccheckPhotos" class="maccheckPhotos" onclick="checkallimage('banner_img',this);" /></th>
                            <th  class='img_table_name'>Image Name</th>
                            <th  class='img_table_caption'>Image Caption</th>
                            <th  class='img_table_url'>Image URL</th>
                            <th  class='img_table_img'>Banner Image</th>

                            <th  class='img_table_status'>Publish</th>
                        </tr>
                    </thead>
                    <tbody id="test-list" class="list:post">
                    <?php
                                    $count = $wpdb->get_var("SELECT count(*) FROM " . $wpdb->prefix . "bannerimages");
                                  if($get_limit['title'] != '')
                                   {
                                     $limit = $get_limit['title'];
                                   }
                                   else
                                   {
                                      $limit = 10;
                                   }
                                    $start = findStart($limit);
                                    /* Find the number of pages based on $count and $limit */
                                    $pages = findPages($count, $limit);
                                    /* Now we use the LIMIT clause to grab a range of rows */
                    $result    = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "bannerimages  ORDER BY bann_imgsort DESC LIMIT $start,$limit");
                    $banner    = '';
                    $boldcolor = 1; // Alternate shades for the tr

                    foreach ($result as $results)
                    {
                        if($boldcolor % 2 == 0)
                        {
                           $banner .= "<tr class='' id='listItem_$results->bann_imgid'>";
                        }
                        else
                        {
                            $banner .= "<tr class='alternate' id='listItem_$results->bann_imgid'>";
                        }
                     $banner .= "<td class='arrow_sort'><img src='$banner_url/wp-content/plugins/$folder_name/image/arrow.png' alt='move' width='16' height='16' class='handle' /></td>
                                <td class='checked_all'><input type=hidden id=bann_imgid name=bann_imgid value='$results->bann_imgid' >
                                <input type='checkbox' class='checkSing' name='checkList[]' class='others' value='$results->bann_imgid' ></td>

                                <td class='bann_imgname'><div id='bannName_$results->bann_imgid' class='gallery_btn'>" . $results->bann_imgname . "</div>
                                <div class='showEdit'><a id='displayText_" . $results->bann_imgid . "' href='javascript:banner_quickedit($results->bann_imgid);'>Quick edit</a></div>
                                </td>";

                     $banner .="<td class='bann_imgdesc'><div id='bannDesc_" . $results->bann_imgid . "'>" . $results->bann_imgdesc . "</div>
                             <span id='showfield_$results->bann_imgid'></span></td>";

                     $banner .="<td class='bann_imgurl' id='bannUrl_" . $results->bann_imgid . "'><div>$results->bann_imgurl</div></td>";
                     $banner .="<td class='img_table_img'>
                                <a id='$banner_url/wp-content/plugins/$folder_name/admin/thumbnails/$results->bann_img' class='preview' alt='Edit' href='javascript:void(0)'>
                                <img src='$banner_url/wp-content/plugins/$folder_name/admin/thumbnails/$results->bann_img' width='50' height='50' /></a></td>";

                      if ($results->bann_imgstatus == '1')
                            {
                                $banner .= "<td><div id='bannstatus_bind_$results->bann_imgid' class='text_cent' >
                                <img src='$banner_url/wp-content/plugins/$folder_name/image/tick.png' width='16' height='16' class='gallery_btn' onclick=banner_status('0',$results->bann_imgid) /></div></td>";
                            } else
                            {
                                $banner .= "<td><div id='bannstatus_bind_$results->bann_imgid' class='text_cent' >
                                <img src='$banner_url/wp-content/plugins/$folder_name/image/publish_x.png' width='16' height='16' class='gallery_btn' onclick=banner_status('1',$results->bann_imgid) /></div></td></tr>";
                            }
                            $boldcolor++;
                    }
                    echo $banner;

                    ?>
               </tbody>
             </table>
                <div class="clear"></div>
                <?php
                    $pagelist = pageList($_REQUEST['pages'], $pages);
                    ?>
                    <div class="pages"><?php echo $pagelist; ?></div>
     </form>
    </div> <!-- second div-->