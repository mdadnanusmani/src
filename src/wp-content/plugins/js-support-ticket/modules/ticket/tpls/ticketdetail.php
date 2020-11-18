<div class="jsst-main-up-wrapper">
<?php
if (jssupportticket::$_config['offline'] == 2) {
    if(isset(jssupportticket::$_data['error_message'])){
        if(jssupportticket::$_data['error_message'] == 1){
            JSSTlayout::getUserGuest();
        }elseif(jssupportticket::$_data['error_message'] == 2){
            JSSTlayout::getYouAreNotAllowedToViewThisPage();
        }
    }elseif (get_current_user_id() != 0 || jssupportticket::$_config['visitor_can_create_ticket'] == 1) {
        JSSTmessage::getMessage();

        $printflag = false;
        if(isset(jssupportticket::$_data['print']) && jssupportticket::$_data['print'] == 1){
            $printflag = true;
        }
        if($printflag == true){
            wp_head();
        }

        if($printflag == false){
            JSSTbreadcrumbs::getBreadcrumbs();
            include_once(jssupportticket::$_path . 'includes/header.php');
        }

        if (jssupportticket::$_data['permission_granted'] == true) {
        if (!empty(jssupportticket::$_data[0])) {

        wp_enqueue_script('file_validate.js', jssupportticket::$_pluginpath . 'includes/js/file_validate.js');
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('jquery.cluetip.min.js', jssupportticket::$_pluginpath . 'includes/js/jquery.cluetip.min.js');
        wp_enqueue_script('jquery.hoverIntent.js', jssupportticket::$_pluginpath . 'includes/js/jquery.hoverIntent.js');
        wp_enqueue_style('jquery.cluetip', jssupportticket::$_pluginpath . 'includes/css/jquery.cluetip.css');
        wp_enqueue_script('timer.js', jssupportticket::$_pluginpath . 'includes/js/timer.jquery.js');
        ?>
        <script type="text/javascript">
            var timer_flag = 0;
            var seconds = 0;
            function getpremade(val) {
                jQuery.post(ajaxurl, {action: 'jsticket_ajax', val: val, jstmod: 'cannedresponses', task: 'getpremadeajax'}, function (data) {
                    if (data) {
                        var append = jQuery('input#append_premade1:checked').length;
                        if (append == 1) {
                            var content = tinyMCE.get('jsticket_message').getContent();
                            content = content + data;
                            tinyMCE.get('jsticket_message').execCommand('mceSetContent', false, content);
                        } else {
                            tinyMCE.get('jsticket_message').execCommand('mceSetContent', false, data);
                        }

                    }
                });
            }

            function changeTimerStatus(val) {
                if(timer_flag == 2){// to handle stopped timer
                        return;
                }
                if(!jQuery('span.timer-button.cls_'+val).hasClass('selected')){
                    jQuery('span.timer-button').removeClass('selected');
                    jQuery('span.timer-button.cls_'+val).addClass('selected');
                    if(val == 1){
                        if(timer_flag == 0){
                            jQuery('div.timer').timer({format: '%H:%M:%S'});
                        }
                        timer_flag = 1;
                        jQuery('div.timer').timer('resume');
                    }else if(val == 2) {
                         jQuery('div.timer').timer('pause');
                    }else{
                         jQuery('div.timer').timer('remove');
                        timer_flag = 2;
                    }
                }
            }

            jQuery(document).ready(function(){
              changeIconTabs();
            });


            jQuery(function(){
                jQuery('ul li a').click(function (e) {
                    var imgID= jQuery(this).find('img').attr('id');
                    changeIconTabs(imgID);
                  });
            });

            function changeIconTabs(tabValue = ""){
                jQuery(document).ready(function(){
                    if(tabValue == ""){
                        tabValue = jQuery("#ul-nav .ui-tabs-active > a > img").attr("id");
                    }
                    if(tabValue == "post-reply"){
                        jQuery("#internal-note").attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/internal-reply-black.png");
                        jQuery("#dept-transfer").attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/department-transfer-black.png");
                        jQuery("#assign-staff").attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/assign-staff-black.png");
                        jQuery("#"+tabValue).attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/post-reply-white.png");
                    }else if(tabValue == "internal-note"){
                        jQuery("#dept-transfer").attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/department-transfer-black.png");
                        jQuery("#assign-staff").attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/assign-staff-black.png");
                        jQuery("#post-reply").attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/post-reply-black.png");
                        jQuery("#"+tabValue).attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/internal-reply-white.png");
                    }else if(tabValue == "dept-transfer"){
                        jQuery("#internal-note").attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/internal-reply-black.png");
                        jQuery("#assign-staff").attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/assign-staff-black.png");
                        jQuery("#post-reply").attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/post-reply-black.png");
                        jQuery("#"+tabValue).attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/department-transfer-white.png");
                    }else if(tabValue == "assign-staff"){
                        jQuery("#dept-transfer").attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/department-transfer-black.png");
                        jQuery("#internal-note").attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/internal-reply-black.png");
                        jQuery("#post-reply").attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/post-reply-black.png");
                        jQuery("#"+tabValue).attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/assign-staff-white.png");
                    }

                });
            }
            function changeIconTabsOnMouseover(){
                jQuery(document).ready(function(){
                    jQuery('ul li').hover(function (e) {
                        var imgID= jQuery(this).find('img').attr('id');
                        tabValue=imgID;
                        if(tabValue == ""){
                            tabValue = jQuery("#ul-nav .ui-tabs-active > a > img").attr("id");
                        }
                        if(tabValue == "post-reply"){
                            jQuery("#"+tabValue).attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/post-reply-white.png");
                        }else if(tabValue == "internal-note"){
                            jQuery("#"+tabValue).attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/internal-reply-white.png");
                        }else if(tabValue == "dept-transfer"){
                            jQuery("#"+tabValue).attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/department-transfer-white.png");
                        }else if(tabValue == "assign-staff"){
                            jQuery("#"+tabValue).attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/assign-staff-white.png");
                        }

                    });
                });
            }
            function changeIconTabsOnMouseOut(){
                jQuery(document).ready(function(){
                    jQuery('ul li').hover(function (e) {
                        var imgID= jQuery(this).find('img').attr('id');
                        tabValue=imgID;
                        if(tabValue == ""){
                            tabValue = jQuery("#ul-nav .ui-tabs-active > a > img").attr("id");
                        }
                        if(tabValue == "post-reply" && !jQuery(this).hasClass('ui-tabs-active')){
                            jQuery("#"+tabValue).attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/post-reply-black.png");
                        }else if(tabValue == "internal-note" && !jQuery(this).hasClass('ui-tabs-active')){
                            jQuery("#"+tabValue).attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/internal-reply-black.png");
                        }else if(tabValue == "dept-transfer" && !jQuery(this).hasClass('ui-tabs-active')){
                            jQuery("#"+tabValue).attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/department-transfer-black.png");
                        }else if(tabValue == "assign-staff" && !jQuery(this).hasClass('ui-tabs-active')){
                            jQuery("#"+tabValue).attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/assign-staff-black.png");
                        }

                    });
                });
            }
            function showEditTimerPopup(){
                jQuery('form#jsst-time-edit-form').hide();
                jQuery('form#jsst-reply-form').hide();
                jQuery('form#jsst-note-edit-form').hide();
                jQuery('div.edit-time-popup').show();
                jQuery('span.timer-button').removeClass('selected');
                if(timer_flag != 0){
                    jQuery('div.timer').timer('pause');
                }
                ex_val = jQuery('div.timer').html();
                jQuery('input#edited_time').val('');
                jQuery('input#edited_time').val(ex_val.trim());
                jQuery('div.jsst-popup-background').show();
                jQuery('div.jsst-popup-wrapper').slideDown('slow');
            }
            function updateTimerFromPopup(){
                val = jQuery('input#edited_time').val();
                arr = val.split(':', 3);
                jQuery('div.timer').html(val);
                jQuery('div.jsst-popup-background').hide();
                jQuery('div.jsst-popup-wrapper').slideUp('slow');
                seconds = parseInt(arr[0])*3600 + parseInt(arr[1])*60 + parseInt(arr[2]);
                if(seconds < 0){
                    seconds = 0;
                }
                jQuery('div.timer').timer('remove');
                jQuery('div.timer').timer({
                    format: '%H:%M:%S',
                    seconds: seconds,
                });
                jQuery('div.timer').timer('pause');
                timer_flag = 1;
                desc = jQuery('textarea#t_desc').val();
                jQuery('input#timer_edit_desc').val(desc);
            }
            jQuery(document).ready(function ($) {
                //$('img.tooltip').cluetip({splitTitle: '|'});
                jQuery( "form" ).submit(function(e) {
                    if(timer_flag != 0){
                        jQuery('input#timer_time_in_seconds').val(jQuery('div.timer').data('seconds'));
                    }
                });
                jQuery("div#action-div a.button").click(function (e) {
                    e.preventDefault();
                });
                <?php if($printflag != true){ ?>
                    jQuery("#tabs").tabs();
                <?php } ?>

                jQuery("#tk_attachment_add").click(function () {
                    var obj = this;
                    var att_flag = jQuery(this).attr("data-ident");
                    var current_files = jQuery("div."+att_flag).children('.tk_attachment_value_text').length;
                    var total_allow =<?php echo jssupportticket::$_config['no_of_attachement']; ?>;
                    var append_text = "<span class='tk_attachment_value_text'><input name='filename[]' type='file' onchange=\"uploadfile(this,'<?php echo jssupportticket::$_config['file_maximum_size']; ?>','<?php echo jssupportticket::$_config['file_extension']; ?>');\" size='20'  /><span  class='tk_attachment_remove'></span></span>";
                    if (current_files < total_allow) {
                        jQuery(".tk_attachment_value_wrapperform."+att_flag).append(append_text);
                    } else if ((current_files === total_allow) || (current_files > total_allow)) {
                        alert('<?php echo __('File upload limit exceed', 'js-support-ticket'); ?>');
                    }
                });
                jQuery(document).delegate(".tk_attachment_remove", "click", function (e) {
                    jQuery(this).parent().remove();
                    var current_files = jQuery('input[type="file"]').length;
                    var total_allow =<?php echo jssupportticket::$_config['no_of_attachement']; ?>;
                    if (current_files < total_allow) {
                        jQuery("#tk_attachment_add").show();
                    }
                });
                jQuery("a#showhidedetail").click(function (e) {
                    e.preventDefault();
                    var divid = jQuery(this).attr('data-divid');
                    jQuery("div#" + divid).slideToggle();
                    jQuery(this).find('img').toggleClass('js-hidedetail');
                });

                jQuery("a#showhistory").click(function (e) {
                    e.preventDefault();
                    jQuery("div#userpopup").slideDown('slow');
                    jQuery('div#userpopupblack').show();
                });
                jQuery("a#changepriority").click(function (e) {
                    e.preventDefault();
                    jQuery("div#userpopupforchangepriority").slideDown('slow');
                    jQuery('div#userpopupblack').show();
                });

                jQuery("div#userpopupblack,span.close-history,span.close-credentails").click(function (e) {
                    jQuery("div#userpopup").slideUp('slow');
                    jQuery("div#userpopupforchangepriority").slideUp('slow');
                    jQuery("div#userpopupforchangepriority").slideUp('slow');
                    jQuery("#usercredentailspopup").slideUp('slow');
                    setTimeout(function () {
                        jQuery('div#userpopupblack').hide();
                    }, 700);
                });

                jQuery(document).delegate("#close-pop", "click", function (e) {
                    jQuery("div#mergeticketselection").fadeOut();
                    jQuery("div#popup-record-data").html("");
                });

                jQuery("div.popup-header-close-img,div.jsst-popup-background,input#cancele,input#cancelee,input#canceleee,input#canceleeee,input#canceleeeee,input#canceleeeeee").click(function (e) {
                    jQuery("div.jsst-popup-wrapper").slideUp('slow');
                    jQuery("div.jsst-merge-popup-wrapper").slideUp('slow');
                    setTimeout(function () {
                        jQuery('div.jsst-popup-background').hide();
                    }, 700);
                });

                jQuery(document).delegate("#ticketpopupsearch",'submit', function (e) {
                    var ticketid = jQuery("#ticketidformerge").val();
                    e.preventDefault();
                    var name = jQuery("input#name").val();
                    var email = jQuery("input#email").val();
                    jQuery.post(ajaxurl, {action: 'jsticket_ajax', jstmod: 'mergeticket', task: 'getTicketsForMerging', name: name, email: email,ticketid:ticketid}, function (data) {
                        data=jQuery.parseJSON(data);
                       if(data !== 'undefined' && data !== '') {
                            jQuery("div#popup-record-data").html("");
                            jQuery("div#popup-record-data").html(data['data']);
                        }else{
                            jQuery("div#popup-record-data").html("");
                        }
                    });//jquery closed
                });

                jQuery("a#print-link").click(function (e) {
                    e.preventDefault();
                    var href = '<?php echo jssupportticket::makeUrl(array('jstmod'=>'ticket','jstlay'=>'printticket','jssupportticketid'=>jssupportticket::$_data[0]->id)); ?>';
                    print = window.open(href, 'print_win', 'width=1024, height=800, scrollbars=yes');
                });
            });

            function actionticket(action) {
                /*  Action meaning
                 * 1 -> Change Priority
                 * 2 -> Close Ticket
                 * 2 -> Reopen Ticket
                 */
                jQuery("input#actionid").val(action);
                jQuery("form#adminTicketform").submit();
            }

            function getmergeticketid(mergeticketid, mergewithticketid){
                if(mergewithticketid == 0){
                    mergewithticketid =  jQuery("#mergeticketid").val();
                }else{
                    jQuery("#mergeticketid").val(mergewithticketid);
                }
                if(mergeticketid == mergewithticketid){
                    alert("Primary id must be differ from merge ticket id");
                    return false;
                }
                jQuery("#mergeticketselection").hide();
                getTicketdataForMerging(mergeticketid,mergewithticketid);
            }

            function getTicketdataForMerging(mergeticketid,mergewithticketid){
                jQuery.post(ajaxurl, {action: 'jsticket_ajax',jstmod: 'mergeticket', task: 'getLatestReplyForMerging', mergeid:mergeticketid,mergewith:mergewithticketid}, function (data) {
                    if(data){
                        data = jQuery.parseJSON(data);
                        jQuery("div#popup-record-data").html("");
                        jQuery("div#popup-record-data").html(data['data']);
                    }
                });
            }
            function closePopup(){
                setTimeout(function () {
                    jQuery('div.jsst-popup-background').hide();
                    jQuery('div#userpopupblack').hide();
                    }, 700);

                jQuery('div.jsst-popup-wrapper').slideUp('slow');
                jQuery('div#userpopupforchangepriority').slideUp('slow');
                jQuery('div#userpopup').slideUp('slow');

            }

            function checktinymcebyid(id) {
                var content = tinymce.get(id).getContent({format: 'text'});
                if (jQuery.trim(content) == '')
                {
                    alert('<?php echo __('Some values are not acceptable please retry', 'js-support-ticket'); ?>');
                    return false;
                }
                return true;
            }
        </script>
        <?php
    $yesno = array(
        (object) array('id' => '1', 'text' => __('Yes', 'js-support-ticket')),
        (object) array('id' => '0', 'text' => __('No', 'js-support-ticket'))
    );
?>
    <div id="userpopupblack" style="display:none;"> </div>
    <script>
        jQuery(document).ready(function(){
            jQuery(document).on('submit','#js-ticket-usercredentails-form',function(e){
                e.preventDefault(); // avoid to execute the actual submit of the form.
                var fdata = jQuery(this).serialize(); // serializes the form's elements.
                jQuery.post(ajaxurl, {action: 'jsticket_ajax', jstmod: 'privatecredentials', task: 'storePrivateCredentials',formdata_string:fdata}, function (data) {
                    if(data){ // ajax executed
                        var return_data = jQuery.parseJSON(data);
                        if(return_data.status == 1){
                            jQuery('.js-ticket-usercredentails-wrp').show();
                            jQuery('.js-ticket-usercredentails-form-wrap').hide();
                            jQuery('.js-ticket-usercredentails-credentails-wrp').append(return_data.content);
                        }else{
                            alert(return_data.error_message);
                        }
                    }
                });
            })
        });

        function addEditCredentail(ticketid, uid, cred_id = 0, cred_data = ''){
            jQuery.post(ajaxurl, {action: 'jsticket_ajax', jstmod: 'privatecredentials', task: 'getFormForPrivteCredentials', ticketid: ticketid, cred_id: cred_id, cred_data: cred_data, uid: uid}, function (data) {
                if(data){ // ajax executed
                    var return_data = jQuery.parseJSON(data);
                    jQuery('.js-ticket-usercredentails-wrp').hide();
                    jQuery('.js-ticket-usercredentails-form-wrap').show();
                    jQuery('.js-ticket-usercredentails-form-wrap').html(return_data);
                    if(cred_id != 0){
                        jQuery('#js-ticket-usercredentails-single-id-'+cred_id).remove();
                    }
                }
            });
        }

        function getCredentails(ticketid){
            jQuery.post(ajaxurl, {action: 'jsticket_ajax', jstmod: 'privatecredentials', task: 'getPrivateCredentials',ticketid:ticketid}, function (data) {
                if(data){ // ajax executed
                    var return_data = jQuery.parseJSON(data);
                    if(return_data.status == 1){
                        jQuery('#userpopupblack').show();
                        jQuery('#usercredentailspopup').slideDown('slow');
                        jQuery('.js-ticket-usercredentails-wrp').slideDown('slow');
                        jQuery('.js-ticket-usercredentails-form-wrap').hide();
                        if(return_data.content != ''){
                            jQuery('.js-ticket-usercredentails-credentails-wrp').html('');
                            jQuery('.js-ticket-usercredentails-credentails-wrp').append(return_data.content);
                        }
                    }
                }
            });
            return false;
        }

        function removeCredentail(cred_id){
            jQuery.post(ajaxurl, {action: 'jsticket_ajax', jstmod: 'privatecredentials', task: 'removePrivateCredential',cred_id:cred_id}, function (data) {
                if(data){ // ajax executed
                    if(cred_id != 0){
                        jQuery('#js-ticket-usercredentails-single-id-'+cred_id).remove();
                    }
                }
            });
            return false;
        }
        function closeCredentailsForm(ticketid){
            getCredentails(ticketid);
        }
    </script>
        <div id="usercredentailspopup" style="display: none;">
            <div class="js-ticket-usercredentails-header">
                <?php echo __('Private Credentials', 'js-support-ticket'); ?><span class="close-credentails"></span>
            </div>
            <div class="js-ticket-usercredentails-wrp" style="display: none;">
                <div class="js-ticket-usercredentails-credentails-wrp">
                </div>
                <?php
                    if(in_array('privatecredentials',jssupportticket::$_active_addons) && jssupportticket::$_data[0]->status != 4 && jssupportticket::$_data[0]->status != 5 ){
                        $credential_add_permission = false;
                        if(in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()){
                            $credential_add_permission = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Add Credentials');
                        }elseif(current_user_can('manage_options')){
                            $credential_add_permission = true;
                        }elseif(get_current_user_id() == jssupportticket::$_data[0]->uid){
                            $credential_add_permission = true;
                        }
                        if($credential_add_permission){ ?>
                            <div class="js-ticket-usercredentail-data-add-new-button-wrap" >
                                <button class="js-ticket-usercredentail-data-add-new-button" onclick="addEditCredentail(<?php echo jssupportticket::$_data[0]->id;?>,<?php echo get_current_user_id();?>);" >
                                    <?php echo __("Add New Credential","js-support-ticket"); ?>
                                </button>
                            </div><?php
                        }
                    }
                    ?>
            </div>
            <div class="js-ticket-usercredentails-form-wrap" >
            </div>
        </div>

        <div id="userpopup" style="display:none;"><!-- Ticket History popup -->
            <div class="js-row js-ticket-popup-row">
                <form id="userpopupsearch">
                    <div class="search-center-history"><?php echo __('Ticket History', 'js-support-ticket'); ?><span class="close-history"></span></div>
                </form>
            </div>
            <div id="records">
                <?php // data[5] holds the tickect history
                $field_array = JSSTincluder::getJSModel('fieldordering')->getFieldTitleByFieldfor(1);
                if ((!empty(jssupportticket::$_data[5]))) {
                    ?>
                    <div class="js-ticket-history-table-wrp">
                        <table class="js-table js-table-striped">
                            <thead>
                              <tr>
                                <th class="js-ticket-textalign-center"><?php echo __('Date','js-support-ticket');?></th>
                                <th class="js-ticket-textalign-center"><?php echo __('Time','js-support-ticket');?></th>
                                <th class=""><?php echo __('Message Logs','js-support-ticket');?></th>
                              </tr>
                            </thead>
                            <tbody class="js-ticket-ticket-history-body">
                                <?php foreach (jssupportticket::$_data[5] AS $history) { ?>
                                  <tr>
                                    <td class="js-ticket-textalign-center"><?php echo date_i18n('Y-m-d', strtotime($history->datetime)); ?></td>
                                    <td class="js-ticket-textalign-center"><?php echo date_i18n('H:i:s', strtotime($history->datetime)); ?></td>
                                    <?php
                                        if (is_super_admin($history->uid)) {
                                            $message = 'admin';
                                        } elseif ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff($history->uid)) {
                                            $message = 'agent';
                                        } else {
                                            $message = 'member';
                                        }
                                        ?>
                                    <td class=""><?php echo wp_kses_post($history->message); ?></td>
                                  </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="js-ticket-priorty-btn-wrp">
                            <?php echo JSSTformfield::button('canceleee', __('Close', 'js-support-ticket'), array('class' => 'js-ticket-priorty-cancel','onclick'=>'closePopup();')); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <script>
            function showPopupAndFillValues(id,pfor) {
                jQuery('div.edit-time-popup').hide();
                if(pfor == 1){
                    jQuery.post(ajaxurl, {action: 'jsticket_ajax', val: id, jstmod: 'reply', task: 'getReplyDataByID'}, function (data) {
                        if (data) {
                            jQuery('div.popup-header-text').html('<?php echo __("Edit Reply","js-support-ticket");?>');
                            d = jQuery.parseJSON(data);
                            tinyMCE.get('jsticket_replytext').execCommand('mceSetContent', false, d.message);
                            jQuery('div.edit-time-popup').hide();
                            jQuery('form#jsst-time-edit-form').hide();
                            jQuery('form#jsst-note-edit-form').hide();
                            jQuery('form#jsst-reply-form').show();
                            jQuery('input#reply-replyid').val(id);
                            jQuery('div.jsst-popup-background').show();
                            jQuery('div.jsst-popup-wrapper').slideDown('slow');
                        }
                    });
                }else if(pfor == 2){
                    jQuery.post(ajaxurl, {action: 'jsticket_ajax', val: id, jstmod: 'timetracking', task: 'getTimeByReplyID'}, function (data) {
                        if (data) {
                            jQuery('div.popup-header-text').html('<?php echo __("Edit Time","js-support-ticket");?>');
                            d = jQuery.parseJSON(data);
                            jQuery('div.edit-time-popup').hide();
                            jQuery('form#jsst-reply-form').hide();
                            jQuery('form#jsst-note-edit-form').hide();
                            jQuery('div.system-time-div').hide();
                            jQuery('form#jsst-time-edit-form').show();
                            jQuery('input#reply-replyid').val(id);
                            jQuery('div.jsst-popup-background').show();
                            jQuery('div.jsst-popup-wrapper').slideDown('slow');
                            jQuery('input#edited_time').val(d.time);
                            jQuery('textarea#edit_reason').text(d.desc);
                            if(d.conflict == 1){
                                jQuery('div.system-time-div').show();
                                jQuery('input#time-confilct').val(d.conflict);
                                jQuery('input#systemtime').val(d.systemtime);
                                jQuery('select#time-confilct-combo').val(0);
                            }
                        }
                    });
                }else if(pfor == 3){
                    jQuery.post(ajaxurl, {action: 'jsticket_ajax', val: id, jstmod: 'note', task: 'getTimeByNoteID'}, function (data) {
                        if (data) {
                            jQuery('div.popup-header-text').html('<?php echo __("Edit Time","js-support-ticket");?>');
                            d = jQuery.parseJSON(data);
                            jQuery('div.edit-time-popup').hide();
                            jQuery('form#jsst-reply-form').hide();
                            jQuery('form#jsst-note-edit-form').show();
                            jQuery('form#jsst-time-edit-form').hide();
                            jQuery('div.system-time-div').hide();
                            jQuery('input#note-noteid').val(id);
                            jQuery('div.jsst-popup-background').show();
                            jQuery('div.jsst-popup-wrapper').slideDown('slow');
                            jQuery('input#edited_time').val(d.time);
                            jQuery('textarea#edit_reason').text(d.desc);
                            if(d.conflict == 1){
                                jQuery('div.system-time-div').show();
                                jQuery('input#time-confilct').val(d.conflict);
                                jQuery('input#systemtime').val(d.systemtime);
                                jQuery('select#time-confilct-combo').val(0);
                            }
                        }
                    });
                }else if(pfor == 4){
                    jQuery.post(ajaxurl, {action: 'jsticket_ajax', ticketid: id, jstmod: 'mergeticket', task: 'getTicketsForMerging'}, function (data) {
                        if (data) {
                            jQuery('div.popup-header-text').html('<?php echo __("Merge Ticket","js-support-ticket");?>');
                            data=jQuery.parseJSON(data);
                            jQuery("div#popup-record-data").html("");
                            jQuery('div#popup-record-data').slideDown('slow');
                            jQuery("div#popup-record-data").html(data['data']);
                        }
                    });
                }
                 return false;
            }
            function updateticketlist(pagenum,ticketid){
                jQuery.post(ajaxurl, {action: 'jsticket_ajax',jstmod: 'mergeticket', task: 'getTicketsForMerging', ticketid:ticketid,ticketlimit:pagenum}, function (data) {
                if(data){
                    data=jQuery.parseJSON(data);
                        jQuery("div#popup-record-data").html("");
                        jQuery("div#popup-record-data").html(data['data']);
                }
            });
        }
        </script>
        <span style="display:none" id="filesize"><?php echo __('Error file size too large', 'js-support-ticket'); ?></span>
        <span style="display:none" id="fileext"><?php echo __('Error file ext mismatch', 'js-support-ticket'); ?></span>
        <div class="jsst-popup-background" style="display:none" ></div>
        <div id="popup-record-data" style="display:inline-block;width:100%;"></div>
        <div class="jsst-popup-wrapper" style="display:none" ><!-- Js Ticket Edit Time Popups -->
            <div class="jsst-popup-header" >
                <div class="popup-header-text" >
                    <?php echo __('Edit Timer','js-support-ticket')?>
                </div>
                <div class="popup-header-close-img" >
                </div>
            </div>
            <div class="edit-time-popup" style="display:none;" >
                <div class="js-ticket-edit-form-wrp">
                    <div class="js-ticket-edit-field-title">
                        <?php echo __('Time', 'js-support-ticket'); ?>&nbsp;<span style="color: red">*</span>
                    </div>
                    <div class="js-ticket-edit-field-wrp">
                        <?php echo JSSTformfield::text('edited_time', '', array('class' => 'inputbox js-ticket-edit-field-input')) ?>
                    </div>
                    <div class="js-ticket-edit-field-title">
                        <?php echo __('Reason For Editing the timer', 'js-support-ticket'); ?>
                    </div>
                    <div class="js-ticket-edit-field-wrp">
                        <?php echo JSSTformfield::textarea('t_desc', '', array('class' => 'inputbox')); ?>
                    </div>
                    <div class="js-ticket-priorty-btn-wrp">
                        <?php echo JSSTformfield::submitbutton('pok', __('Save', 'js-support-ticket'), array('class' => 'js-ticket-priorty-save','onclick' => 'updateTimerFromPopup();')); ?>
                        <?php echo JSSTformfield::button('canceleeee', __('Cancel', 'js-support-ticket'), array('class' => 'js-ticket-priorty-cancel','onclick'=>'closePopup();')); ?>
                    </div>
                </div>
            </div>

            <form id="jsst-reply-form" style="display:none" method="post" action="<?php echo admin_url("admin.php?page=reply&task=saveeditedreply&action=jstask"); ?>" >
                <div class="js-ticket-edit-form-wrp">
                    <div class="js-ticket-form-field-wrp">
                        <?php echo wp_editor('', 'jsticket_replytext', array('media_buttons' => false,'editor_height' => 200, 'textarea_rows' => 20,)); ?>
                    </div>
                </div>
                <div class="js-ticket-priorty-btn-wrp">
                    <?php echo JSSTformfield::submitbutton('ppok', __('Save', 'js-support-ticket'), array('class' => 'js-ticket-priorty-save')); ?>
                    <?php echo JSSTformfield::button('canceleeeee', __('Cancel', 'js-support-ticket'), array('class' => 'js-ticket-priorty-cancel','onclick'=>'closePopup();')); ?>
                </div>
                <?php echo JSSTformfield::hidden('reply-replyid', ''); ?>
                <?php echo JSSTformfield::hidden('reply-tikcetid',jssupportticket::$_data[0]->id); ?>
            </form>
            <?php if(in_array('timetracking', jssupportticket::$_active_addons)){ ?>

                <form id="jsst-time-edit-form" style="display:none" method="post" action="<?php echo admin_url("admin.php?page=reply&task=saveeditedtime&action=jstask"); ?>" >
                    <div class="js-ticket-edit-form-wrp">
                        <div class="js-ticket-edit-field-title">
                            <?php echo __('Time', 'js-support-ticket'); ?>&nbsp;<span style="color: red">*</span>
                        </div>
                        <div class="js-ticket-edit-field-wrp">
                            <?php echo JSSTformfield::text('edited_time', '', array('class' => 'inputbox js-ticket-edit-field-input')) ?>
                        </div>
                        <div class="js-ticket-edit-field-title">
                            <?php echo __('System Time', 'js-support-ticket'); ?>
                        </div>
                        <div class="js-ticket-edit-field-wrp">
                            <?php echo JSSTformfield::text('systemtime', '', array('class' => 'inputbox js-ticket-edit-field-input','disabled'=>'disabled')) ?>
                        </div>
                        <div class="js-ticket-edit-field-title">
                            <?php echo __('Reason For Editing', 'js-support-ticket'); ?>
                        </div>
                        <div class="js-ticket-edit-field-wrp">
                            <?php echo JSSTformfield::textarea('edit_reason', '', array('class' => 'inputbox js-ticket-edit-field-input')) ?>
                        </div>
                        <div class="js-form-wrapper system-time-div" style="display:none;" >
                            <div class="js-form-title"><?php echo __('Resolve conflict', 'js-support-ticket'); ?></div>
                            <div class="js-form-value"><?php echo JSSTformfield::select('time-confilct-combo', $yesno, ''); ?></div>
                        </div>
                        <div class="js-ticket-priorty-btn-wrp">
                            <?php echo JSSTformfield::submitbutton('pppok', __('Save', 'js-support-ticket'), array('class' => 'js-ticket-priorty-save','onclick' => 'updateTimerFromPopup();')); ?>
                            <?php echo JSSTformfield::button('canceleeeeee', __('Cancel', 'js-support-ticket'), array('class' => 'js-ticket-priorty-cancel','onclick'=>'closePopup();')); ?>
                        </div>
                    </div>
                    <?php echo JSSTformfield::hidden('reply-replyid', ''); ?>
                    <?php echo JSSTformfield::hidden('reply-tikcetid',jssupportticket::$_data[0]->id); ?>
                    <?php echo JSSTformfield::hidden('time-confilct',''); ?>
                </form>

                <form id="jsst-note-edit-form" style="display:none" method="post" action="<?php echo admin_url("admin.php?page=note&task=saveeditedtime&action=jstask"); ?>" >
                    <div class="js-col-md-12 js-form-wrapper">
                        <div class="js-col-md-12 js-form-title"><?php echo __('Time', 'js-support-ticket'); ?></div>
                        <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::text('edited_time', '', array('class' => 'inputbox')) ?></div>
                    </div>
                    <div class="js-col-md-12 js-form-wrapper system-time-div" style="display:none;" >
                        <div class="js-col-md-12 js-form-title"><?php echo __('System Time', 'js-support-ticket'); ?></div>
                        <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::text('systemtime', '', array('class' => 'inputbox','disabled'=>'disabled')) ?></div>
                    </div>
                    <div class="js-col-md-12 js-form-wrapper">
                        <div class="js-col-md-12 js-form-title"><?php echo __('Reason For Editing', 'js-support-ticket'); ?></div>
                        <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::textarea('edit_reason', '', array('class' => 'inputbox')) ?></div>
                    </div>
                    <div class="js-col-md-12 js-form-wrapper system-time-div" style="display:none;" >
                        <div class="js-col-md-12 js-form-title"><?php echo __('Resolve conflict', 'js-support-ticket'); ?></div>
                        <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::select('time-confilct-combo', $yesno, ''); ?></div>
                    </div>
                    <div class="js-col-md-12 js-form-button-wrapper">
                        <?php echo JSSTformfield::submitbutton('ppppok', __('Save', 'js-support-ticket'), array('class' => 'button')); ?>
                        <?php echo JSSTformfield::button('cancele', __('Cancel', 'js-support-ticket'), array('class' => 'button', 'onclick'=>'closePopup();')); ?>
                    </div>
                    <?php echo JSSTformfield::hidden('note-noteid', ''); ?>
                    <?php echo JSSTformfield::hidden('note-tikcetid',jssupportticket::$_data[0]->id); ?>
                    <?php echo JSSTformfield::hidden('time-confilct',''); ?>
                </form>
            <?php } ?>
        </div>
        <div class="jsst-popup-wrapper jsst-merge-popup-wrapper" style="display:none" >
            <div class="jsst-popup-header" >
                <div class="popup-header-text" >
                    <?php echo __('Edit Timer','js-support-ticket')?>
                </div>
                <div class="popup-header-close-img" >
                </div>
            </div>
        </div>

        <?php
            jssupportticket::$_data['custom']['ticketid'] = jssupportticket::$_data[0]->id;
                if (jssupportticket::$_data[0]->lock == 1) {
                    $style = "darkred";
                    $status = __('Lock', 'js-support-ticket');
                } elseif (jssupportticket::$_data[0]->status == 0) {
                    $style = "#5bb12f";
                    $status = __('New', 'js-support-ticket');
                } elseif (jssupportticket::$_data[0]->status == 1) {
                    $style = "#28abe3";
                    $status = __('Waiting reply', 'js-support-ticket');
                } elseif (jssupportticket::$_data[0]->status == 2) {
                    $style = "#69d2e7";
                    $status = __('In Progress', 'js-support-ticket');
                } elseif (jssupportticket::$_data[0]->status == 3) {
                    $style = "#FFB613";
                    $status = __('Replied', 'js-support-ticket');
                } elseif (jssupportticket::$_data[0]->status == 4) {
                    $style = "#ed1c24";
                    $status = __('Closed', 'js-support-ticket');
                }
                $cur_uid = get_current_user_id();
                if (in_array('agent',jssupportticket::$_active_addons) && jssupportticket::$_data['user_staff']) {
                    $link = jssupportticket::makeUrl(array('jstmod'=>'ticket','task'=>'actionticket'));
                } else {
                    $link = jssupportticket::makeUrl(array('jstmod'=>'reply','task'=>'savereply'));
                }
                ?>
                <div class="js-ticket-ticket-detail-wrapper">
                   <?php if($printflag != true){?>
                        <form method="post" action="<?php echo $link; ?>" id="adminTicketform" enctype="multipart/form-data">
                    <?php } ?>
                    <div class="js-col-md-12 js-ticket-detail-wrapper"> <!-- Ticket Detail Data Top -->
                        <div class="js-ticket-detail-box"><!-- Ticket Detail Box -->
                            <div class="js-ticket-detail-left"><!-- Left Side Image -->
                                <div class="js-ticket-user-img-wrp">
                                    <?php
                                    if (isset(jssupportticket::$_data[0]->uid) && !empty(jssupportticket::$_data[0]->uid)) {
                                        echo get_avatar(jssupportticket::$_data[0]->uid);
                                    } else { ?>
                                       <img alt="ticket image" class="js-ticket-staff-img" src="<?php echo jssupportticket::$_pluginpath . '/includes/images/ticketmanbig.png'; ?>" />
                                    <?php } ?>
                                </div>
                                <div class="js-ticket-user-name-wrp">
                                    <?php echo __(jssupportticket::$_data[0]->name,"js-support-ticket"); ?>
                                </div>
                                <div class="js-ticket-user-email-wrp">
                                    <?php echo jssupportticket::$_data[0]->email; ?>
                                </div>
                                <div class="js-ticket-user-email-wrp">
                                    <?php echo jssupportticket::$_data[0]->phone; ?>
                                </div>
                            </div>
                            <div class="js-ticket-detail-right"><!-- Right Side Ticket Data -->
                                <div class="js-ticket-rows-wrp" >
                                    <div class="js-ticket-row">
                                        <div class="js-ticket-field-title">
                                            <?php echo __($field_array['subject'], 'js-support-ticket');?><?php echo __(' :', 'js-support-ticket');?>
                                        </div>
                                        <div class="js-ticket-field-value">
                                           <span class="js-ticket-subject-link"><?php echo __(jssupportticket::$_data[0]->subject ,'js-support-ticket'); ?></span>
                                        </div>
                                    </div>
                                    <div class="js-ticket-row">
                                        <div class="js-ticket-field-title">
                                            <?php echo __($field_array['department'], 'js-support-ticket'); ?><?php echo __(' :', 'js-support-ticket');?>
                                        </div>
                                        <div class="js-ticket-field-value">
                                            <?php echo __(jssupportticket::$_data[0]->departmentname ,'js-support-ticket'); ?>
                                        </div>
                                    </div>
                                    <div class="js-ticket-row">
                                        <div class="js-ticket-field-title">
                                           <?php echo __('Created', 'js-support-ticket') . ': '; ?>
                                        </div>
                                        <div class="js-ticket-field-value">
                                           <?php
                                                $startTimeStamp = strtotime(jssupportticket::$_data[0]->created);
                                                $endTimeStamp = strtotime("now");
                                                $timeDiff = abs($endTimeStamp - $startTimeStamp);
                                                $numberDays = $timeDiff / 86400;  // 86400 seconds in one day
                                                // and you might want to convert to integer
                                                $numberDays = intval($numberDays);
                                                if ($numberDays != 0 && $numberDays == 1) {
                                                    $day_text = __('Day', 'js-support-ticket');
                                                } elseif ($numberDays > 1) {
                                                    $day_text = __('Days', 'js-support-ticket');
                                                } elseif ($numberDays == 0) {
                                                    $day_text = __('Today', 'js-support-ticket');
                                                }
                                                if ($numberDays == 0) {
                                                    echo $day_text;
                                                } else {
                                                    echo $numberDays . ' ' . $day_text . ' ';
                                                    echo __('Ago', 'js-support-ticket'). " , ";
                                                }
                                            ?>
                                           <?php echo ' ' . date_i18n("d F, Y", strtotime(jssupportticket::$_data[0]->created)); ?>
                                        </div>
                                    </div>
                                    <div class="js-ticket-row">
                                        <div class="js-ticket-field-title">
                                           <?php echo __('Ticket ID', 'js-support-ticket'); ?><?php echo __(' :', 'js-support-ticket');?>
                                        </div>
                                        <div class="js-ticket-field-value">
                                           <?php echo jssupportticket::$_data[0]->ticketid; ?>
                                        </div>
                                    </div>
                                    <div class="js-ticket-row">
                                        <div class="js-ticket-field-title">
                                           <?php echo __($field_array['priority'], 'js-support-ticket'); ?><?php echo __(' :', 'js-support-ticket');?>
                                        </div>
                                        <div class="js-ticket-field-value js-ticket-priorty" style="background:<?php echo jssupportticket::$_data[0]->prioritycolour;?>; color:#ffffff;">
                                           <?php echo __(jssupportticket::$_data[0]->priority, 'js-support-ticket'); ?>
                                        </div>
                                    </div>
                                    <div class="js-ticket-row">
                                        <div class="js-ticket-field-title">
                                           <?php echo __('Last Reply', 'js-support-ticket'); ?><?php echo __(' :', 'js-support-ticket');?>
                                        </div>
                                        <div class="js-ticket-field-value">
                                           <?php if (empty(jssupportticket::$_data[0]->lastreply) || jssupportticket::$_data[0]->lastreply == '0000-00-00 00:00:00') echo __('No Last Reply', 'js-support-ticket');
                                                else echo date_i18n(jssupportticket::$_config['date_format'], strtotime(jssupportticket::$_data[0]->lastreply)); ?>
                                        </div>
                                    </div>
                                    <div class="js-ticket-row">
                                        <div class="js-ticket-field-title">
                                           <?php echo __($field_array['status'], 'js-support-ticket'); ?><?php echo __(' :', 'js-support-ticket');?>
                                        </div>
                                        <div class="js-ticket-field-value">
                                           <?php
                                                if (jssupportticket::$_data[0]->status == 4 || jssupportticket::$_data[0]->status == 5 )
                                                    $ticketmessage = __('Closed', 'js-support-ticket');
                                                elseif (jssupportticket::$_data[0]->status == 2)
                                                    $ticketmessage = __('In Progress', 'js-support-ticket');
                                                else
                                                    $ticketmessage = __('Open', 'js-support-ticket');
                                                $printstatus = 1;
                                                if (jssupportticket::$_data[0]->lock == 1) {
                                                    echo '<div class="js-ticket-status-note">' . __('Lock', 'js-support-ticket').' '. __(',', 'js-support-ticket') . '</div>';
                                                    $printstatus = 0;
                                                }
                                                if (jssupportticket::$_data[0]->isoverdue == 1) {
                                                    echo '<div class="js-ticket-status-note">' . __('Overdue', 'js-support-ticket') . '</div>';
                                                    $printstatus = 0;
                                                }
                                                if ($printstatus == 1) {
                                                    echo $ticketmessage;
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <?php  if(in_array('helptopic', jssupportticket::$_active_addons)){ ?>
                                        <div class="js-ticket-row">
                                            <div class="js-ticket-field-title">
                                                <?php echo __($field_array['helptopic'], 'js-support-ticket'); ?><?php echo __(' :', 'js-support-ticket');?>
                                            </div>
                                            <div class="js-ticket-field-value">
                                                <?php echo jssupportticket::$_data[0]->helptopic; ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php
                                    if(in_array('timetracking', jssupportticket::$_active_addons)){
                                        if(isset(jssupportticket::$_data['time_taken'])){ ?>
                                            <div class="js-ticket-row">
                                                <div class="js-ticket-field-title">
                                                    <?php echo __('Total Time Taken', 'js-support-ticket'); ?><?php echo __(' :', 'js-support-ticket');?>
                                                </div>
                                                <div class="js-ticket-field-value">
                                                    <?php
                                                        $hours = floor(jssupportticket::$_data['time_taken'] / 3600);
                                                        $mins = floor(jssupportticket::$_data['time_taken'] / 60 % 60);
                                                        $secs = floor(jssupportticket::$_data['time_taken'] % 60);
                                                        echo __('','js-support-ticket') .sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                                                    ?>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                    } ?>
                                    <div class="js-ticket-row">
                                        <?php
                                            $customfields = JSSTincluder::getObjectClass('customfields')->userFieldsData(1);
                                            foreach ($customfields as $field) {
                                                $array =  JSSTincluder::getObjectClass('customfields')->showCustomFields($field,3, jssupportticket::$_data[0]->params);
                                                if($field->userfieldtype=='file'){
                                                    $fvalue = $array['value'];
                                                $html = '<span class="js-ticket-title">' . __($field->fieldtitle,'js-support-ticket') . ':&nbsp</span>';
                                                   if($fvalue !=null){
                                                        $path = admin_url("?page=ticket&action=jstask&task=downloadbyname&id=".jssupportticket::$_data['custom']['ticketid']."&name=".$fvalue);
                                                        $html .= '
                                                            <div class="js_ticketattachment">
                                                                ' . __($field->fieldtitle,'js-support-ticket') . ' ( ' . $fvalue . ' ) ' . '
                                                                <a class="button" target="_blank" href="' . esc_url($path) . '">' . __('Download', 'js-support-ticket') . '</a>
                                                            </div>';
                                                        $array['value'] = $html;

                                                    }
                                                }elseif($field->userfieldtype=='date' && !empty($fvalue)){
                                                    $fvalue = $array['value'];
                                                    $fvalue = date_i18n(jssupportticket::$_config['date_format'],strtotime($fvalue));
                                                    $html .=    '<span class="js-ticket-title textstylebold">' . __($field->fieldtitle,'js-support-ticket') . ':&nbsp</span>
                                                            <span class="js-ticket-value">' . $fvalue . '</span>';
                                                    $array['value'] = $html;
                                                } ?>
                                                <div class="js-ticket-row">
                                                    <div class="js-ticket-field-title">
                                                        <?php echo  __($array['title'],'js-support-ticket') .' :';?>
                                                    </div>
                                                    <div class="js-ticket-field-value">
                                                        <?php echo $array['value'];
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                    <?php
                                        if (jssupportticket::$_data[0]->status == 0) {
                                            $color = "#5bb12f;";
                                            $ticketmessage = __('Open', 'js-support-ticket');
                                        } elseif (jssupportticket::$_data[0]->status == 1) {
                                            $color = "#28abe3;";
                                            $ticketmessage = __('On Waiting', 'js-support-ticket');
                                        } elseif (jssupportticket::$_data[0]->status == 2) {
                                            $color = "#69d2e7;";
                                            $ticketmessage = __('In Progress', 'js-support-ticket');
                                        } elseif (jssupportticket::$_data[0]->status == 3) {
                                            $color = "#FFB613;";
                                            $ticketmessage = __('Replied', 'js-support-ticket');
                                        } elseif (jssupportticket::$_data[0]->status == 4) {
                                            $color = "#ed1c24;";
                                            $ticketmessage = __('Closed', 'js-support-ticket');
                                        } elseif (jssupportticket::$_data[0]->status == 5) {
                                            $color = "#dc2742;";
                                            $ticketmessage = __('Closed and Merged', 'js-support-ticket');
                                        }
                                    ?>
                                    <div class="js-ticket-openclosed-box" style="background-color:<?php echo $color;?>;">
                                        <?php echo $ticketmessage; ?>
                                    </div>
                                </div>
                                <?php if(in_array('agent',jssupportticket::$_active_addons)){ ?>
                                    <div class="js-ticket-right-bottom"><!-- Right Side Bottom Data -->
                                        <div class="js-ticket-row">
                                            <div class="js-ticket-field-title">
                                                <?php echo __($field_array['assignto'], 'js-support-ticket'); ?><?php echo __(' :', 'js-support-ticket');?>
                                            </div>
                                            <div class="js-ticket-field-value">
                                               <span class="js-ticket-subject-link"><?php echo __(jssupportticket::$_data[0]->staffname);?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                        <div class="js-ticket-action-btn-wrp"> <!-- Ticket Action Button -->
                            <?php if ($printflag == false){
                                    $printpermission = false;
                                    $mergepermission = false;
                                if (in_array('agent',jssupportticket::$_active_addons) && jssupportticket::$_data['user_staff'] && jssupportticket::$_data[0]->status != 5 ) {
                                    $printpermission = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Print Ticket');
                                    $mergepermission = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Ticket Merge');

                                    ?>
                                    <div class="js-ticket-btn-box">
                                        <a class="js-button" href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'agent','jstlay'=>'staffaddticket','jssupportticketid'=>jssupportticket::$_data[0]->id))); ?>" title="<?php echo __('Edit Ticket', 'js-support-ticket'); ?>">
                                            <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/edit.png" title="<?php echo __('Edit', 'js-support-ticket'); ?>" /><?php echo __('Edit', 'js-support-ticket'); ?>
                                        </a>
                                    </div>
                                    <div class="js-ticket-btn-box">
                                        <?php if (jssupportticket::$_data[0]->status != 4) { ?>
                                            <a class="js-button" href="#" onclick="actionticket(2);" title="<?php echo __('Close Ticket', 'js-support-ticket'); ?>">
                                                <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/close.png" title="<?php echo __('Close', 'js-support-ticket'); ?>" /><?php echo __('Close', 'js-support-ticket'); ?>
                                            </a>
                                        <?php } else { ?>
                                            <a class="js-button" href="#" onclick="actionticket(3);" title="<?php echo __('Reopen Ticket', 'js-support-ticket'); ?>">
                                                <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/reopen.png" title="<?php echo __('Reopen', 'js-support-ticket'); ?>" /><?php echo __('Reopen', 'js-support-ticket'); ?>
                                            </a>
                                        <?php } ?>
                                    </div>
                                    <?php if(in_array('tickethistory', jssupportticket::$_active_addons)){ ?>
                                        <div class="js-ticket-btn-box">
                                            <a class="js-button" href="#" id="showhistory">
                                                <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/log-history.png" title="<?php echo __('History', 'js-support-ticket'); ?>" /><?php echo __('Ticket History', 'js-support-ticket'); ?>
                                            </a>
                                        </div>
                                    <?php }?>
                                    <?php if(in_array('mergeticket',jssupportticket::$_active_addons) && $mergepermission) {
                                        if (jssupportticket::$_data[0]->status != 4 && jssupportticket::$_data[0]->status != 5) { ?>
                                            <div class="js-ticket-btn-box">
                                                <a class="js-button" href="#" id="mergeticket" onclick="return showPopupAndFillValues(<?php echo jssupportticket::$_data[0]->id;?>,4)">
                                                    <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/merge.png" title="<?php echo __('Merge', 'js-support-ticket'); ?>" /><?php echo __('Merge', 'js-support-ticket'); ?>
                                                </a>
                                            </div>
                                        <?php }/*Merge Ticket*/
                                    } ?>
                                    <?php if(in_array('actions',jssupportticket::$_active_addons)){ ?>
                                        <?php if($printpermission && jssupportticket::$_data[0]->status != 5) { ?>
                                            <div class="js-ticket-btn-box">
                                                <a class="js-button" href="#" id="print-link" data-ticketid="<?php echo jssupportticket::$_data[0]->id; ?>">
                                                    <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/print.png" title= "<?php echo __('Print', 'js-support-ticket'); ?>" /><?php echo __('Print', 'js-support-ticket'); ?>
                                                </a>
                                            </div> <!-- Print Ticket -->
                                        <?php } ?>
                                    <?php } ?>
                                    <?php $deletepermission = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Delete Ticket');
                                    if($deletepermission) { ?>
                                        <div class="js-ticket-btn-box">
                                            <a class="js-button" onclick="return confirm('<?php echo __('Are you sure to delete ticket', 'js-support-ticket'); ?>');"  href="<?php echo esc_url(wp_nonce_url(jssupportticket::makeUrl(array('jstmod'=>'ticket','task'=>'deleteticket','action'=>'jstask','ticketid'=> jssupportticket::$_data[0]->id ,'jsstpageid'=>get_the_ID())),'delete-ticket')); ?>" data-ticketid="<?php echo jssupportticket::$_data[0]->id; ?>">
                                                <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/delete.png" title= "<?php echo __('Delete', 'js-support-ticket'); ?>" /><?php echo __('Delete', 'js-support-ticket'); ?>
                                            </a>
                                        </div><?php
                                    }
                                    $credentialpermission = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('View Credentials');
                                    if(in_array('privatecredentials',jssupportticket::$_active_addons) && $credentialpermission){ ?>
                                        <div class="js-ticket-btn-box">
                                            <a class="js-button" href="javascript:return false;" id="private-credentials-button" onclick="getCredentails(<?php echo jssupportticket::$_data[0]->id; ?>)">
                                                <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/privatecredentials.png" title= "<?php echo __('Print', 'js-support-ticket'); ?>" /><?php echo __('Private Credentials', 'js-support-ticket'); ?>
                                            </a>
                                        </div><?php
                                    }
                                } else { ?>
                                        <?php if (jssupportticket::$_data[0]->status != 5) { ?>
                                            <?php if (jssupportticket::$_data[0]->status != 4) { ?>
                                                <div class="js-ticket-btn-box">
                                                    <a onclick="return confirm('<?php echo __('Are you sure to close ticket', 'js-support-ticket'); ?>');" class="js-button" href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'ticket','task'=>'closeticket','action'=>'jstask','ticketid'=> jssupportticket::$_data[0]->id ,'jsstpageid'=>get_the_ID()))); ?>">
                                                        <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/close.png" title="<?php echo __('Close', 'js-support-ticket'); ?>" /><?php echo __('Close', 'js-support-ticket'); ?>
                                                    </a>
                                                </div>
                                                <?php if(in_array('tickethistory', jssupportticket::$_active_addons)){ ?>
                                                    <div class="js-ticket-btn-box">
                                                        <a class="js-button js-margin-right" href="#" id="showhistory">
                                                            <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/log-history.png" title="<?php echo __('Ticket History', 'js-support-ticket'); ?>" /><?php echo __('Ticket History', 'js-support-ticket'); ?>
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                            <?php } else {
                                                    if (JSSTincluder::getJSModel('ticket')->checkCanReopenTicket(jssupportticket::$_data[0]->id)) {
                                                        $link = jssupportticket::makeUrl(array('jstmod'=>'ticket','task'=>'reopenticket','action'=>'jstask','ticketid'=> jssupportticket::$_data[0]->id,'jsstpageid'=>get_the_ID())); ?>
                                                        <div class="js-ticket-btn-box">
                                                            <a class="js-button" href="<?php echo esc_url($link); ?>" title="<?php echo __('Reopen Ticket', 'js-support-ticket'); ?>">
                                                                <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/reopen.png" title="<?php echo __('Reopen', 'js-support-ticket'); ?>" /><?php echo __('Reopen', 'js-support-ticket'); ?>
                                                            </a>
                                                        </div>
                                                    <?php } ?>
                                            <?php } ?>
                                        <?php }
                                        if(jssupportticket::$_config['print_ticket_user'] == 1 ){
                                            if(in_array('actions',jssupportticket::$_active_addons)){ ?>
                                                <div class="js-ticket-btn-box">
                                                    <a class="js-button" href="#" id="print-link" data-ticketid="<?php echo jssupportticket::$_data[0]->id; ?>">
                                                        <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/print.png" title= "<?php echo __('Print', 'js-support-ticket'); ?>" /><?php echo __('Print', 'js-support-ticket'); ?>
                                                    </a>
                                                </div><?php
                                            }
                                        }
                                        if(in_array('privatecredentials',jssupportticket::$_active_addons) && jssupportticket::$_data[0]->status != 4 && jssupportticket::$_data[0]->status != 5){ ?>
                                            <div class="js-ticket-btn-box">
                                                <a class="js-button" href="javascript:return false;" id="private-credentials-button" onclick="getCredentails(<?php echo jssupportticket::$_data[0]->id; ?>)">
                                                    <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/privatecredentials.png" title= "<?php echo __('Print', 'js-support-ticket'); ?>" /><?php echo __('Private Credentials', 'js-support-ticket'); ?>
                                                </a>
                                            </div><?php
                                        }
                                    } ?>
                                    <?php if (in_array('agent',jssupportticket::$_active_addons) && jssupportticket::$_data['user_staff'] && jssupportticket::$_data[0]->status != 5) { ?>
                                    <?php if (in_array('actions',jssupportticket::$_active_addons)) { ?>
                                        <div class="js-ticket-btn-box">
                                            <?php if (jssupportticket::$_data[0]->lock == 1) { ?>
                                                <a class="js-button" href="#" onclick="actionticket(5);" title="<?php echo __('Unlock Ticket', 'js-support-ticket'); ?>">
                                                    <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/unlock.png" title="<?php echo __('Unlock', 'js-support-ticket'); ?>" /><?php echo __('Unlock', 'js-support-ticket'); ?>
                                                </a>
                                            <?php } else { ?>
                                                <a class="js-button" href="#" onclick="actionticket(4);" title="<?php echo __('Lock Ticket', 'js-support-ticket'); ?>">
                                                    <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/lock.png" title="<?php echo __('Lock', 'js-support-ticket'); ?>" /><?php echo __('Lock', 'js-support-ticket'); ?>
                                                </a>
                                            <?php } ?>
                                    </div>
                                    <?php } ?>
                                    <?php if(in_array('banemail', jssupportticket::$_active_addons)){ ?>
                                        <div class="js-ticket-btn-box">
                                        <?php
                                            if (JSSTincluder::getJSModel('banemail')->isEmailBan(jssupportticket::$_data[0]->email)) { ?>
                                                <a class="js-button" href="#" onclick="actionticket(7);">
                                                    <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/unban.png" title="<?php echo __('Unban Email', 'js-support-ticket'); ?>" /><?php echo __('Unban Email', 'js-support-ticket'); ?>
                                                </a>
                                            <?php } else { ?>
                                                <a class="js-button" href="#" onclick="actionticket(6);">
                                                    <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/ban.png" title="<?php echo __('Ban Email', 'js-support-ticket'); ?>" /><?php echo __('Ban Email', 'js-support-ticket'); ?>
                                                </a>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                    <?php if(in_array('overdue', jssupportticket::$_active_addons)){ ?>
                                        <div class="js-ticket-btn-box">
                                            <?php if (jssupportticket::$_data[0]->isoverdue == 1) { ?>
                                                    <a class="js-button" href="#" onclick="actionticket(11);">
                                                        <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/unmark-overdue.png" title="<?php echo __('Unmark Overdue', 'js-support-ticket'); ?>" /><?php echo __('Unmark Overdue', 'js-support-ticket'); ?>
                                                    </a>
                                            <?php } else { ?>
                                                    <a class="js-button" href="#" onclick="actionticket(8);">
                                                        <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/overdue.png" title="<?php echo __('Mark Overdue', 'js-support-ticket'); ?>" /><?php echo __('Mark Overdue', 'js-support-ticket'); ?>
                                                    </a>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (in_array('actions',jssupportticket::$_active_addons)) { ?>
                                        <div class="js-ticket-btn-box">
                                            <a class="js-button" href="#" onclick="actionticket(9);">
                                                <img alt="image" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/ticketdetailicon/inprogress.png'; ?>" title="<?php echo __('Mark in Progress', 'js-support-ticket'); ?>" /><?php echo __('Mark in Progress', 'js-support-ticket');?>
                                            </a>
                                        </div>
                                    <?php } ?>
                                    <?php if(in_array('banemail', jssupportticket::$_active_addons)){ ?>
                                        <div class="js-ticket-btn-box">
                                            <a class="js-button" href="#" onclick="actionticket(10);">
                                                <img alt="image" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/ticketdetailicon/ban-email-close-ticket.png'; ?>" title="<?php echo __('Ban Email and Close Ticket', 'js-support-ticket'); ?>" /><?php echo __('Ban Email and Close Ticket', 'js-support-ticket'); ?>
                                            </a>
                                        </div>
                                    <?php } ?>
                                    <div class="js-ticket-btn-box">
                                        <a class="js-button" href="#" id="changepriority">
                                            <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/change.png" title="<?php echo __('Change Priority', 'js-support-ticket'); ?>" /><?php echo __('Change Priority', 'js-support-ticket'); ?>
                                        </a>
                                    </div>
                                    <div id="userpopupforchangepriority" style="display:none;">
                                        <div class="js-ticket-priorty-header">
                                            <?php echo __('Change Priority', 'js-support-ticket'); ?><span class="close-history"></span>
                                        </div>
                                        <div class="js-ticket-priorty-fields-wrp">
                                            <div class="js-ticket-select-priorty">
                                                <?php echo JSSTformfield::select('priority', JSSTincluder::getJSModel('priority')->getPriorityForCombobox(), jssupportticket::$_data[0]->priorityid, __('Change Priority', 'js-support-ticket'), array()); ?>
                                            </div>
                                        </div>
                                        <div class="js-ticket-priorty-btn-wrp">
                                            <?php echo JSSTformfield::button('changepriority', __('Change Priority', 'js-support-ticket'), array('class' => 'js-ticket-priorty-save', 'onclick' => 'actionticket(1);')); ?>
                                            <?php echo JSSTformfield::button('cancelee', __('Cancel', 'js-support-ticket'), array('class' => 'js-ticket-priorty-cancel','onclick'=>'closePopup();')); ?>
                                        </div>
                                    </div>
                            <?php } ?>

                            <?php } else { ?>
                                <div class="js-ticket-btn-box">
                                    <a class="js-button" href="javascript:window.print();">
                                        <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/print.png" title= "<?php echo __('Print', 'js-support-ticket'); ?>" /><?php echo __('Print', 'js-support-ticket'); ?>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                    $ticket = jssupportticket::$_data[0];
                    if( class_exists('WooCommerce') && in_array('woocommerce', jssupportticket::$_active_addons)){
                        $order = wc_get_order(jssupportticket::$_data[0]->wcorderid);
                        $order_itemid = jssupportticket::$_data[0]->wcproductid;
                        if($order){ ?>
                            <div class="js-ticket-post-reply-wrapper">
                                <div class="js-ticket-thread-heading"><?php echo __("Woocommerce Order",'js-support-ticket'); ?></div>
                                <div class="js-ticket-detail-box js-ticket-post-reply-box js-ticket-wc-order-box">
                                    <div class="js-ticket-wc-order-item">
                                        <div class="js-ticket-wc-order-item-title"><?php echo __($field_array['wcorderid'],'js-support-ticket'); ?>:</div>
                                        <div class="js-ticket-wc-order-item-value">#<?php echo $order->get_id(); ?></div>
                                    </div>
                                    <div class="js-ticket-wc-order-item">
                                        <div class="js-ticket-wc-order-item-title"><?php echo __("Status",'js-support-ticket'); ?>:</div>
                                        <div class="js-ticket-wc-order-item-value"><?php echo wc_get_order_status_name($order->get_status()); ?></div>
                                    </div>
                                    <?php
                                    if($order_itemid){
                                        $item = new WC_Order_Item_Product($order_itemid);
                                        if($item){
                                            ?>
                                            <div class="js-ticket-wc-order-item">
                                                <div class="js-ticket-wc-order-item-title"><?php echo __($field_array['wcproductid'],'js-support-ticket'); ?>:</div>
                                                <div class="js-ticket-wc-order-item-value"><?php echo $item->get_name(); ?></div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="js-ticket-wc-order-item">
                                        <div class="js-ticket-wc-order-item-title"><?php echo __("Created",'js-support-ticket'); ?>:</div>
                                        <div class="js-ticket-wc-order-item-value"><?php echo $order->get_date_created()->date_i18n(wc_date_format()); ?></div>
                                    </div>
                                    <?php
                                    if($ticket->uid == get_current_user_id()){
                                        ?>
                                        <a href="<?php echo wc_get_endpoint_url('orders','',wc_get_page_permalink('myaccount')); ?>" class="js-ticket-wc-order-link">
                                            <?php echo __("View all orders",'js-support-ticket'); ?>
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div><?php
                        }
                    }
                    if (in_array('agent',jssupportticket::$_active_addons) && jssupportticket::$_data['user_staff']) {
                        if (!empty(jssupportticket::$_data[6])) {
                        if(in_array('note', jssupportticket::$_active_addons)){
                            ?>
                            <div class="js-ticket-post-reply-wrapper"><!-- Ticket Post Replay -->
                                <div class="js-ticket-thread-heading"><?php echo __('Internal Notes', 'js-support-ticket'); ?></div>
                                <?php foreach (jssupportticket::$_data[6] AS $note) {  ?>
                                    <div class="js-ticket-detail-box js-ticket-post-reply-box"><!-- Ticket Detail Box -->
                                        <div class="js-ticket-detail-left js-ticket-white-background"><!-- Left Side Image -->
                                            <div class="js-ticket-user-img-wrp">
                                                <?php if (in_array('agent',jssupportticket::$_active_addons) && $note->staffphoto) { ?>
                                                    <img alt="image" class="js-ticket-staff-img" src="<?php echo jssupportticket::makeUrl(array('jstmod'=>'agent','task'=>'getStaffPhoto','action'=>'jstask','jssupportticketid'=> $note->staff_id ,'jsstpageid'=>get_the_ID())); ?>">
                                                <?php } else {
                                                    if (isset(jssupportticket::$_data[0]->uid) && !empty(jssupportticket::$_data[0]->uid)) {
                                                        echo get_avatar($note->uid);
                                                    } else { ?>
                                                        <img alt="image" class="js-ticket-staff-img" src="<?php echo jssupportticket::$_pluginpath . '/includes/images/ticketmanbig.png'; ?>" />
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                            <div class="js-ticket-user-name-wrp">
                                                <?php echo !empty($note->staffname) ? $note->staffname : $note->display_name; ?>
                                            </div>
                                        </div>
                                        <div class="js-ticket-detail-right js-ticket-background"><!-- Right Side Ticket Data -->
                                            <div class="js-ticket-rows-wrapper">
                                                <?php if (isset($note->title) && $note->title != '') { ?>
                                                    <div class="js-ticket-rows-wrp" >
                                                        <div class="js-ticket-field-value"><?php echo __($field_array['subject'], 'js-support-ticket'); ?>&nbsp;:&nbsp;<?php echo $note->title; ?></div>
                                                    </div>
                                                <?php } ?>
                                                <div class="js-ticket-rows-wrp" >
                                                    <div class="js-ticket-row">
                                                        <div class="js-ticket-field-value">
                                                           <?php echo wp_kses_post($note->note); ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="js-ticket-edit-options-wrp" >
                                                <?php
                                                if(in_array('timetracking', jssupportticket::$_active_addons)){
                                                    if(JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Edit Time') && jssupportticket::$_data[0]->status != 5){ ?>
                                                        <a class="js-button" href="#" onclick="return showPopupAndFillValues(<?php echo $note->id;?>,3)" >
                                                            <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/edit-time.png" />
                                                            <?php echo __('Edit Time','js-support-ticket');?>
                                                        </a>
                                                    <?php
                                                    }
                                                    $hours = floor($note->usertime / 3600);
                                                    $mins = floor($note->usertime / 60 % 60);
                                                    $secs = floor($note->usertime % 60);
                                                    $time = __('Time Taken','js-support-ticket').':&nbsp;'.sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                                                    ?>
                                                    <span class="js-ticket-thread-time"><?php echo $time; ?></span>
                                                <?php } ?>
                                                </div>

                                                <?php
                                                if($note->filesize > 0 && !empty($note->filename)){ ?>
                                                    <div class="js-ticket-attachments-wrp">
                                                        <div class="js_ticketattachment">
                                                            <span class="js-ticket-download-file-title">
                                                                <?php echo __($note->filename); echo __('(','js-support-ticket');echo __($note->filesize / 1024); echo __(')','js-support-ticket'); ?>
                                                            </span>
                                                            <a class="js-download-button" target="_blank" href="<?php echo admin_url('?page=note&action=jstask&task=downloadbyid&id='.$note->id); ?>">
                                                                <img alt="image" class="js-ticket-download-img" src="<?php echo jssupportticket::$_pluginpath;?>/includes/images/ticketdetailicon/download-all.png">
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="js-ticket-time-stamp-wrp">
                                                <span class="js-ticket-ticket-created-date">
                                                    <?php echo date_i18n("l F d, Y, h:i:s", strtotime($note->created)); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php }
                        }
                    } ?>
                    <div class="js-ticket-post-reply-wrapper"><!-- Ticket Post Replay -->
                        <div class="js-ticket-thread-heading"><?php echo __('Ticket Thread', 'js-support-ticket'); ?></div> <!-- Heading -->
                        <div class="js-ticket-detail-box js-ticket-post-reply-box"><!-- Ticket Detail Box -->
                            <div class="js-ticket-detail-left js-ticket-white-background"><!-- Left Side Image -->
                                <div class="js-ticket-user-img-wrp">
                                    <?php if (in_array('agent',jssupportticket::$_active_addons) && jssupportticket::$_data[0]->staffphotophoto) { ?>
                                        <img alt="image" class="js-ticket-staff-img" src="<?php echo jssupportticket::makeUrl(array('jstmod'=>'agent','task'=>'getStaffPhoto','action'=>'jstask','jssupportticketid'=> jssupportticket::$_data[0]->staffphotoid ,'jsstpageid'=>get_the_ID())); ?>">
                                    <?php } else {
                                        if (isset(jssupportticket::$_data[0]->uid) && !empty(jssupportticket::$_data[0]->uid)) {
                                            echo get_avatar(jssupportticket::$_data[0]->uid);
                                        } else { ?>
                                            <img alt="image" class="js-ticket-staff-img" src="<?php echo jssupportticket::$_pluginpath . '/includes/images/ticketmanbig.png'; ?>" />
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                                <div class="js-ticket-user-name-wrp">
                                    <?php echo jssupportticket::$_data[0]->name; ?>
                                </div>
                                <div class="js-ticket-user-email-wrp">
                                    <?php echo jssupportticket::$_data[0]->email; ?>
                                </div>
                            </div>
                            <div class="js-ticket-detail-right js-ticket-background"><!-- Right Side Ticket Data -->
                                <div class="js-ticket-rows-wrapper">
                                   <div class="js-ticket-rows-wrp" >
                                        <div class="js-ticket-row">
                                            <div class="js-ticket-field-value">
                                               <?php echo wp_kses_post(jssupportticket::$_data[0]->message); ?>
                                            </div>
                                        </div>
                                    </div>




                                    <?php
                                    if (!empty(jssupportticket::$_data['ticket_attachment'])) { ?>
                                        <div class="js-ticket-attachments-wrp">
                                            <?php foreach (jssupportticket::$_data['ticket_attachment'] AS $attachment) {
                                                    $path = jssupportticket::makeUrl(array('jstmod'=>'ticket','task'=>'downloadbyid','action'=>'jstask','id'=> $attachment->id ,'jsstpageid'=>get_the_ID()));
                                                    echo '
                                                        <div class="js_ticketattachment">
                                                            <span class="js-ticket-download-file-title">
                                                                ' . $attachment->filename . ' ( ' . round($attachment->filesize,2) . ' kb) ' . '
                                                            </span>
                                                            <a class="js-download-button" target="_blank" href="' . esc_url($path) . '">
                                                                <img alt="image" class="js-ticket-download-img" src=" '.jssupportticket::$_pluginpath .'/includes/images/ticketdetailicon/download-all.png">
                                                            </a>
                                                        </div>';
                                                    }
                                                echo'
                                                    <a class="js-all-download-button" target="_blank" href="' . esc_url(jssupportticket::makeUrl(array('jstmod'=>'ticket', 'task'=>'downloadall', 'action'=>'jstask', 'downloadid'=>jssupportticket::$_data[0]->id , 'jsstpageid'=>get_the_ID()))) . '" ><img alt="image" class="js-ticket-all-download-img" src=" '.jssupportticket::$_pluginpath .'/includes/images/ticketdetailicon/download-all.png">'. __('Download All', 'js-support-ticket') . '</a>';?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="js-ticket-time-stamp-wrp">
                                    <span class="js-ticket-ticket-created-date">
                                         <?php echo date_i18n("l F d, Y, h:i:s", strtotime(jssupportticket::$_data[0]->created)); ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- User post Reply Section -->
                        <?php if (!empty(jssupportticket::$_data[4]))
                            foreach (jssupportticket::$_data[4] AS $reply):
                                if ($cur_uid == $reply->uid) ?>
                                    <div class="js-ticket-detail-box js-ticket-post-reply-box"><!-- Ticket Detail Box -->
                                        <div class="js-ticket-detail-left js-ticket-white-background"><!-- Left Side Image -->
                                            <div class="js-ticket-user-img-wrp">
                                                <?php if (in_array('agent',jssupportticket::$_active_addons) &&  $reply->staffphoto) { ?>
                                                    <img  class="js-ticket-staff-img" src="<?php echo jssupportticket::makeUrl(array('jstmod'=>'agent','task'=>'getStaffPhoto','action'=>'jstask','jssupportticketid'=> $reply->staffid ,'jsstpageid'=>get_the_ID())); ?>">
                                                <?php } else {
                                                    if (isset($reply->uid) && !empty($reply->uid)) {
                                                        echo get_avatar($reply->uid);
                                                    } else { ?>
                                                        <img alt="image" class="js-ticket-staff-img" src="<?php echo jssupportticket::$_pluginpath . '/includes/images/ticketmanbig.png'; ?>" />
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                            <div class="js-ticket-user-name-wrp">
                                                <?php echo $reply->name; ?>
                                            </div>
                                            <div class="js-ticket-user-email-wrp">
                                                <?php echo ($reply->ticketviaemail == 1) ? __('Created via Email', 'js-support-ticket') : ''; ?>
                                            </div>
                                        </div>
                                        <div class="js-ticket-detail-right js-ticket-background"><!-- Right Side Ticket Data -->
                                            <div class="js-ticket-rows-wrapper">
                                                <div class="js-ticket-rows-wrp" >
                                                    <div class="js-ticket-row">
                                                        <div class="js-ticket-field-value">
                                                            <?php echo wp_kses_post(html_entity_decode($reply->message)); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if (in_array('agent',jssupportticket::$_active_addons) &&  jssupportticket::$_data['user_staff']) {
                                                        if($reply->staffid != 0){ ?>
                                                            <div class="js-ticket-edit-options-wrp">
                                                                <?php if(JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Edit Reply') && jssupportticket::$_data[0]->status != 5){ ?>
                                                                        <a class="js-button" href="#" onclick="return showPopupAndFillValues(<?php echo $reply->replyid;?>,1)" >
                                                                            <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/edit-reply.png" />
                                                                            <?php echo __('Edit Reply','js-support-ticket');?>
                                                                        </a>
                                                                <?php }
                                                                if(in_array('timetracking', jssupportticket::$_active_addons)){
                                                                    if(JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Edit Time') && jssupportticket::$_data[0]->status != 5){ ?>
                                                                        <a class="js-button" href="#" onclick="return showPopupAndFillValues(<?php echo $reply->replyid;?>,2)" >
                                                                            <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/edit-time.png" />
                                                                            <?php echo __('Edit Time','js-support-ticket');?>
                                                                        </a>
                                                                    <?php
                                                                    }
                                                                    $hours = floor($reply->time / 3600);
                                                                    $mins = floor($reply->time / 60 % 60);
                                                                    $secs = floor($reply->time % 60);
                                                                    $time = __('Time Taken','js-support-ticket').':&nbsp;'.sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                                                                    ?>
                                                                    <span class="js-ticket-thread-time"><?php echo $time; ?></span>
                                                                <?php } ?>
                                                            </div>
                                                        <?php } ?>
                                                <?php } ?>
                                                <?php if (!empty($reply->attachments)) { ?>
                                                    <div class="js-ticket-attachments-wrp">
                                                        <?php foreach ($reply->attachments AS $attachment) {
                                                                $path = jssupportticket::makeUrl(array('jstmod'=>'ticket','task'=>'downloadbyid','action'=>'jstask','id'=> $attachment->id ,'jsstpageid'=>get_the_ID()));
                                                                echo '
                                                                    <div class="js_ticketattachment">
                                                                        <span class="js-ticket-download-file-title">
                                                                            ' . $attachment->filename . ' ( ' . round($attachment->filesize,2) . ' kb) ' . '
                                                                        </span>
                                                                        <a class="js-download-button" target="_blank" href="' . esc_url($path) . '">
                                                                            <img alt="image" class="js-ticket-download-img" src=" '.jssupportticket::$_pluginpath .'/includes/images/ticketdetailicon/download-all.png">
                                                                        </a>
                                                                    </div>';
                                                                }
                                                            echo'
                                                                <a class="js-all-download-button" target="_blank" href="' . esc_url(jssupportticket::makeUrl(array('jstmod'=>'ticket', 'task'=>'downloadallforreply', 'action'=>'jstask', 'downloadid'=>$reply->replyid , 'jsstpageid'=>get_the_ID()))) . '" onclick="" target="_blank"><img alt="image" class="js-ticket-all-download-img" src=" '.jssupportticket::$_pluginpath .'/includes/images/ticketdetailicon/download-all.png">'. __('Download All', 'js-support-ticket') . '</a>';?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="js-ticket-time-stamp-wrp">
                                                <span class="js-ticket-ticket-created-date">
                                                     <?php echo date_i18n("l F d, Y, h:i:s", strtotime($reply->created)); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                            <?php endforeach; ?>
                    </div>

                    <div class="js-ticket-reply-forms-wrapper"><!-- Ticket Reply Forms Wrapper -->
                        <?php if($printflag == false){
                            if (!jssupportticket::$_data['user_staff']) {
                                if (jssupportticket::$_data[0]->status != 4 && jssupportticket::$_data[0]->lock != 1 && jssupportticket::$_data[0]->status != 5): ?>
                                    <div class="js-ticket-reply-forms-heading"><?php echo __('Reply a message', 'js-support-ticket'); ?></div>
                                    <div id="postreply" class="js-ticket-post-reply">
                                        <div class="js-ticket-reply-field-wrp">
                                            <div class="js-ticket-reply-field"><?php echo wp_editor('', 'jsticket_message', array('media_buttons' => false)); ?></div>
                                        </div>
                                        <div class="js-ticket-reply-attachments"><!-- Attachments -->
                                            <div class="js-attachment-field-title"><?php echo __($field_array['attachments'], 'js-support-ticket'); ?></div>
                                            <div class="js-attachment-field">
                                                <div class="tk_attachment_value_wrapperform tk_attachment_user_reply_wrapper">
                                                    <span class="tk_attachment_value_text">
                                                        <input type="file" class="inputbox js-attachment-inputbox" name="filename[]" onchange="uploadfile(this, '<?php echo jssupportticket::$_config['file_maximum_size']; ?>', '<?php echo jssupportticket::$_config['file_extension']; ?>');" size="20" />
                                                        <span class='tk_attachment_remove'></span>
                                                    </span>
                                                </div>
                                                <span class="tk_attachments_configform">
                                                    <?php echo __('Maximum File Size', 'js-support-ticket');
                                                          echo ' (' . jssupportticket::$_config['file_maximum_size']; ?>KB)<br><?php echo __('File Extension Type', 'js-support-ticket');
                                                          echo ' (' . jssupportticket::$_config['file_extension'] . ')'; ?>
                                                </span>
                                                <span id="tk_attachment_add" data-ident="tk_attachment_user_reply_wrapper" class="tk_attachments_addform"><?php echo __('Add more', 'js-support-ticket'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="js-ticket-closeonreply-wrp">
                                        <div class="js-ticket-closeonreply-title"><?php echo __('Ticket Status', 'js-support-ticket'); ?></div>
                                        <div class="replyFormStatus js-form-title-position-reletive-left">
                                            <?php echo JSSTformfield::checkbox('closeonreply', array('1' => __('Close on reply', 'js-support-ticket')), '', array('class' => 'radiobutton js-ticket-closeonreply-checkbox')); ?>
                                        </div>
                                    </div>
                                    <div class="js-ticket-reply-form-button-wrp">
                                        <?php echo JSSTformfield::submitbutton('postreplybutton', __('Post Reply', 'js-support-ticket'), array('class' => 'button js-ticket-save-button', 'onclick' => "return checktinymcebyid('message');")); ?>
                                    </div>
                                <?php endif; ?>
                                <?php echo JSSTformfield::hidden('actionid', ''); ?>
                                <?php echo JSSTformfield::hidden('ticketid', jssupportticket::$_data[0]->id); ?>
                                <?php echo JSSTformfield::hidden('created', jssupportticket::$_data[0]->created); ?>
                                <?php echo JSSTformfield::hidden('uid', get_current_user_id()); ?>
                                <?php echo JSSTformfield::hidden('ticketrandomid', jssupportticket::$_data[0]->ticketid); ?>
                                <?php echo JSSTformfield::hidden('hash', jssupportticket::$_data[0]->hash); ?>
                                <?php echo JSSTformfield::hidden('updated', jssupportticket::$_data[0]->updated); ?>
                                <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                                <?php echo JSSTformfield::hidden('jsstpageid', get_the_ID()); ?>
                            </div>
                            </form>

                            <?php
                            }else {
                                ?>
                                <?php echo JSSTformfield::hidden('actionid', ''); ?>
                                <?php echo JSSTformfield::hidden('ticketid', jssupportticket::$_data[0]->id); ?>
                                <?php echo JSSTformfield::hidden('created', jssupportticket::$_data[0]->created); ?>
                                <?php echo JSSTformfield::hidden('uid', get_current_user_id()); ?>
                                <?php echo JSSTformfield::hidden('updated', jssupportticket::$_data[0]->updated); ?>
                                <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                                <?php echo JSSTformfield::hidden('jsstpageid', get_the_ID()); ?>
                            </div>
                            </form>
                            <?php if (jssupportticket::$_data[0]->status != 4 && jssupportticket::$_data[0]->status != 5) { ?>
                                <div class="js-ticket-tabs-wrapper"><!-- Tabs Section Start -->
                                    <div id="tabs" class="tabs">
                                        <ul id="ul-nav" class="js-ticket-ul-style">
                                            <li class="js-ticket-li-style">
                                                <a class="js-ticket-tab-link" href="#postreply" onmouseover="changeIconTabsOnMouseover(this)" onmouseout="changeIconTabsOnMouseOut(this)">
                                                    <img alt="image" class="js-ticket-tab-img" id="post-reply" src="<?php echo jssupportticket::$_pluginpath;?>includes/images/ticketdetailicon/post-reply-black.png"/>
                                                    <?php echo __('Post Reply', 'js-support-ticket'); ?>
                                                </a>
                                            </li>
                                            <?php if(in_array('note', jssupportticket::$_active_addons)){ ?>
                                                <li class="js-ticket-li-style">
                                                    <a class="js-ticket-tab-link" href="#postinternalnote" onmouseover="changeIconTabsOnMouseover()" onmouseout="changeIconTabsOnMouseOut()">
                                                        <img alt="image" class="js-ticket-tab-img" id="internal-note" src="<?php echo jssupportticket::$_pluginpath;?>includes/images/ticketdetailicon/internal-reply-black.png"/>
                                                        <?php echo __('Internal Note', 'js-support-ticket'); ?>
                                                    </a>
                                                </li>
                                            <?php }
                                            if(in_array('actions',jssupportticket::$_active_addons)){ ?>
                                                <li class="js-ticket-li-style">
                                                    <a class="js-ticket-tab-link" href="#departmenttransfer" onmouseover="changeIconTabsOnMouseover()" onmouseout="changeIconTabsOnMouseOut()">
                                                        <img alt="image" class="js-ticket-tab-img" id="dept-transfer" src="<?php echo jssupportticket::$_pluginpath;?>includes/images/ticketdetailicon/department-transfer-black.png"/>
                                                        <?php echo __('Department Transfer', 'js-support-ticket') ?>
                                                    </a>
                                                </li>
                                            <?php }
                                            if ( in_array('agent',jssupportticket::$_active_addons)) { ?>
                                                <li class="js-ticket-li-style">
                                                    <a class="js-ticket-tab-link" href="#assigntostaff" onmouseover="changeIconTabsOnMouseover()" onmouseout="changeIconTabsOnMouseOut()">
                                                        <img alt="image" class="js-ticket-tab-img" id="assign-staff" src="<?php echo jssupportticket::$_pluginpath;?>includes/images/ticketdetailicon/assign-staff-black.png"/>
                                                        <?php echo __('Assign to Staff', 'js-support-ticket') ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <div class="tabInner js-ticket-inner-tab">
                                            <div id="postreply"><!-- Post Reply Area -->
                                                <form method="post" action="<?php echo jssupportticket::makeUrl(array('jstmod'=>'reply','task'=>'savereply')); ?>" enctype="multipart/form-data">
                                                    <?php if(in_array('timetracking', jssupportticket::$_active_addons)){ ?>
                                                        <div class="jsst-ticket-detail-timer-wrapper"> <!-- Timer Wrapper -->
                                                            <div class="timer-left" >
                                                            <?php echo __('Time Track','js-support-ticket'); ?>
                                                            </div>
                                                            <div class="timer-right" >
                                                                <div class="timer-total-time" >
                                                                    <?php
                                                                        $hours = floor(jssupportticket::$_data['time_taken'] / 3600);
                                                                        $mins = floor(jssupportticket::$_data['time_taken'] / 60 % 60);
                                                                        $secs = floor(jssupportticket::$_data['time_taken'] % 60);
                                                                        echo __('Time Taken','js-support-ticket').':&nbsp;'.sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                                                                    ?>
                                                                </div>
                                                                <div class="timer" >
                                                                    00:00:00
                                                                </div>
                                                                <div class="timer-buttons" >
                                                                    <?php if(JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Edit Own Time')){ ?>
                                                                        <span class="timer-button" onclick="showEditTimerPopup()" >
                                                                            <img alt="image" src="<?php echo jssupportticket::$_pluginpath;?>includes/images/timer-edit.png"/>
                                                                        </span>
                                                                    <?php } ?>
                                                                    <span class="timer-button cls_1" onclick="changeTimerStatus(1)" >
                                                                        <img alt="image" src="<?php echo jssupportticket::$_pluginpath;?>includes/images/play.png"/>
                                                                    </span>
                                                                    <span class="timer-button cls_2" onclick="changeTimerStatus(2)" >
                                                                        <img alt="image" src="<?php echo jssupportticket::$_pluginpath;?>includes/images/pause.png"/>
                                                                    </span>
                                                                    <span class="timer-button cls_3" onclick="changeTimerStatus(3)" >
                                                                        <img alt="image" src="<?php echo jssupportticket::$_pluginpath;?>includes/images/stop.png"/>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <?php echo JSSTformfield::hidden('timer_time_in_seconds',''); ?>

                                                            <?php echo JSSTformfield::hidden('timer_edit_desc',''); ?>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if(in_array('cannedresponses', jssupportticket::$_active_addons)){ ?>
                                                        <div class="js-ticket-premade-msg-wrp"><!-- Premade Message Wrapper -->
                                                            <div class="js-ticket-premade-field-title"><?php echo __($field_array['premade'], 'js-support-ticket'); ?>&nbsp;<?php echo __('Message', 'js-support-ticket'); ?></div>
                                                            <div class="js-ticket-premade-field-wrp">
                                                                <?php echo JSSTformfield::select('premadeid', JSSTincluder::getJSModel('cannedresponses')->getPreMadeMessageForCombobox(), isset(jssupportticket::$_data[0]->premadeid) ? jssupportticket::$_data[0]->premadeid : '', __('Select Premade', 'js-support-ticket'), array('class' => 'js-ticket-premade-select', 'onchange' => 'getpremade(this.value);')); ?>
                                                                <span class="js-ticket-apend-radio-btn">
                                                                    <?php echo JSSTformfield::checkbox('append_premade', array('1' => __('Append', 'js-support-ticket')), '', array('class' => 'radiobutton js-ticket-premade-radiobtn')); ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="js-ticket-text-editor-wrp">
                                                        <div class="js-ticket-text-editor-field-title"><?php echo __('Type Message', 'js-support-ticket'); ?></div>
                                                        <div class="js-ticket-text-editor-field"><?php echo wp_editor('', 'jsticket_message', array('media_buttons' => false)); ?></div>
                                                    </div>
                                                    <div class="js-ticket-reply-attachments"><!-- Attachments -->
                                                        <div class="js-attachment-field-title"><?php echo __($field_array['attachments'], 'js-support-ticket'); ?></div>
                                                        <div class="js-attachment-field">
                                                            <div class="tk_attachment_value_wrapperform tk_attachment_staff_reply_wrapper">
                                                                <span class="tk_attachment_value_text">
                                                                    <input type="file" class="inputbox js-attachment-inputbox" name="filename[]" onchange="uploadfile(this, '<?php echo jssupportticket::$_config['file_maximum_size']; ?>', '<?php echo jssupportticket::$_config['file_extension']; ?>');" size="20" />
                                                                    <span class='tk_attachment_remove'></span>
                                                                </span>
                                                            </div>
                                                            <span class="tk_attachments_configform">
                                                                <?php echo __('Maximum File Size', 'js-support-ticket');
                                                                      echo ' (' . jssupportticket::$_config['file_maximum_size']; ?>KB)<br><?php echo __('File Extension Type', 'js-support-ticket');
                                                                      echo ' (' . jssupportticket::$_config['file_extension'] . ')'; ?>
                                                            </span>
                                                            <span id="tk_attachment_add" data-ident="tk_attachment_staff_reply_wrapper" class="tk_attachments_addform"><?php echo __('Add more', 'js-support-ticket'); ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="js-ticket-append-signature-wrp"><!-- Append Signature -->
                                                        <div class="js-ticket-append-field-title"><?php echo __('Append Signature', 'js-support-ticket'); ?></div>
                                                        <div class="js-ticket-append-field-wrp">
                                                            <div class="js-ticket-signature-radio-box">
                                                                <?php echo JSSTformfield::checkbox('ownsignature', array('1' => __('Own Signature', 'js-support-ticket')), '', array('class' => 'radiobutton js-ticket-append-radio-btn')); ?>
                                                            </div>
                                                            <div class="js-ticket-signature-radio-box">
                                                                <?php echo JSSTformfield::checkbox('departmentsignature', array('1' => __('Department Signature', 'js-support-ticket')), '', array('class' => 'radiobutton js-ticket-append-radio-btn')); ?>
                                                            </div>
                                                            <div class="js-ticket-signature-radio-box">
                                                                <?php echo JSSTformfield::checkbox('nonesignature', array('1' => __('JNone', 'js-support-ticket')), '', array('class' => 'radiobutton js-ticket-append-radio-btn')); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if(in_array('agent',jssupportticket::$_active_addons)){
                                                        $staffid = JSSTincluder::getJSModel('agent')->getStaffId(get_current_user_id());
                                                        if (jssupportticket::$_data[0]->staffid != $staffid) {
                                                            ?>
                                                            <div class="js-ticket-assigntome-wrp">
                                                                <div class="js-ticket-assigntome-field-title"><?php echo __('Assign Ticket', 'js-support-ticket'); ?></div>
                                                                <div class="js-ticket-assigntome-field-wrp">
                                                                    <?php
                                                                        if(jssupportticket::$_data[0]->staffid){
                                                                            $checked = '';
                                                                        }else{
                                                                            $checked = 1;
                                                                        }
                                                                        echo JSSTformfield::checkbox('assigntome', array('1' => __('Assign to me', 'js-support-ticket')), $checked, array('class' => 'radiobutton js-ticket-assigntome-checkbox'));
                                                                    ?>
                                                                </div>
                                                            </div><!-- Assign to me -->
                                                    <?php }
                                                } ?>
                                                    <div class="js-ticket-closeonreply-wrp">
                                                        <div class="js-ticket-closeonreply-title"><?php echo __('Ticket Status', 'js-support-ticket'); ?></div>
                                                        <div class="replyFormStatus js-form-title-position-reletive-left">
                                                            <?php echo JSSTformfield::checkbox('closeonreply', array('1' => __('Close on reply', 'js-support-ticket')), '', array('class' => 'radiobutton js-ticket-closeonreply-checkbox')); ?>
                                                        </div>
                                                    </div>
                                                    <div class="js-ticket-reply-form-button-wrp">
                                                        <?php echo JSSTformfield::submitbutton('postreply', __('Post Reply', 'js-support-ticket'), array('class' => 'button js-ticket-save-button', 'onclick' => "return checktinymcebyid('message');")); ?>
                                                    </div>
                                                    <?php echo JSSTformfield::hidden('departmentid', jssupportticket::$_data[0]->departmentid); ?>
                                                    <?php echo JSSTformfield::hidden('ticketid', jssupportticket::$_data[0]->id); ?>
                                                    <?php echo JSSTformfield::hidden('uid', get_current_user_id()); ?>
                                                    <?php echo JSSTformfield::hidden('ticketrandomid',jssupportticket::$_data[0]->ticketid); ?>
                                                    <?php echo JSSTformfield::hidden('hash', jssupportticket::$_data[0]->hash); ?>
                                                    <?php echo JSSTformfield::hidden('action', 'reply_savereply'); ?>
                                                    <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                                                    <?php echo JSSTformfield::hidden('jsstpageid', get_the_ID()); ?>
                                                </form>
                                            </div>
                                            <?php if(in_array('note', jssupportticket::$_active_addons)){ ?>
                                                <div id="postinternalnote">  <!--  postinternalnote Area   -->
                                                    <form method="post" action="<?php echo jssupportticket::makeUrl(array('jstmod'=>'note','task'=>'savenote')); ?>" enctype="multipart/form-data">
                                                        <?php if(in_array('timetracking', jssupportticket::$_active_addons)){ ?>
                                                            <div class="jsst-ticket-detail-timer-wrapper"> <!-- Top Timer Section -->
                                                                <div class="timer-left" >
                                                                <?php echo __('Time Track','js-support-ticket'); ?>
                                                                </div>
                                                                <div class="timer-right" >
                                                                    <div class="timer-total-time" >
                                                                        <?php
                                                                            $hours = floor(jssupportticket::$_data['time_taken'] / 3600);
                                                                            $mins = floor(jssupportticket::$_data['time_taken'] / 60 % 60);
                                                                            $secs = floor(jssupportticket::$_data['time_taken'] % 60);
                                                                            echo __('Time Taken','js-support-ticket').':&nbsp;'.sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                                                                        ?>
                                                                    </div>
                                                                    <div class="timer" >
                                                                        00:00:00
                                                                    </div>
                                                                    <div class="timer-buttons" >
                                                                        <?php if(JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Edit Time')){ ?>
                                                                            <span class="timer-button" onclick="showEditTimerPopup()" >
                                                                                <img alt="image" src="<?php echo jssupportticket::$_pluginpath;?>includes/images/timer-edit.png"/>
                                                                            </span>
                                                                        <?php } ?>
                                                                        <span class="timer-button cls_1" onclick="changeTimerStatus(1)" >
                                                                            <img alt="image" src="<?php echo jssupportticket::$_pluginpath;?>includes/images/play.png"/>
                                                                        </span>
                                                                        <span class="timer-button cls_2" onclick="changeTimerStatus(2)" >
                                                                            <img alt="image" src="<?php echo jssupportticket::$_pluginpath;?>includes/images/pause.png"/>
                                                                        </span>
                                                                        <span class="timer-button cls_3" onclick="changeTimerStatus(3)" >
                                                                            <img alt="image" src="<?php echo jssupportticket::$_pluginpath;?>includes/images/stop.png"/>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <?php echo JSSTformfield::hidden('timer_time_in_seconds',''); ?>

                                                                <?php echo JSSTformfield::hidden('timer_edit_desc',''); ?>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="js-ticket-internalnote-wrp"><!-- Ticket Tittle -->
                                                            <div class="js-ticket-internalnote-field-title"><?php echo __('Title', 'js-support-ticket'); ?></div>
                                                            <div class="js-ticket-internalnote-field-wrp">
                                                            <?php echo JSSTformfield::text('internalnotetitle', '', array('class' => 'inputbox js-ticket-internalnote-input')) ?>
                                                            </div>
                                                        </div>
                                                        <div class="js-ticket-text-editor-wrp">
                                                            <div class="js-ticket-text-editor-field-title"><?php echo __('Type Internal Note', 'js-support-ticket'); ?></div>
                                                            <div class="js-ticket-text-editor-field"><?php echo wp_editor('', 'internalnote', array('media_buttons' => false)); ?></div>
                                                        </div>
                                                        <div class="js-ticket-reply-attachments"><!-- Attachments -->
                                                            <div class="js-attachment-field-title"><?php echo __($field_array['attachments'], 'js-support-ticket'); ?></div>
                                                            <div class="js-attachment-field">
                                                                <div class="tk_attachment_value_wrapperform tk_attachment_staff_reply_wrapper">
                                                                    <span class="tk_attachment_value_text">
                                                                        <input type="file" class="inputbox js-attachment-inputbox" name="note_attachment" onchange="uploadfile(this, '<?php echo jssupportticket::$_config['file_maximum_size']; ?>', '<?php echo jssupportticket::$_config['file_extension']; ?>');" size="20" />
                                                                        <span class='tk_attachment_remove'></span>
                                                                    </span>
                                                                </div>
                                                                <span class="tk_attachments_configform">
                                                                    <?php echo __('Maximum File Size', 'js-support-ticket');
                                                                          echo ' (' . jssupportticket::$_config['file_maximum_size']; ?>KB)<br><?php echo __('File Extension Type', 'js-support-ticket');
                                                                          echo ' (' . jssupportticket::$_config['file_extension'] . ')'; ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="js-ticket-closeonreply-wrp">
                                                            <div class="js-ticket-closeonreply-title"><?php echo __('Ticket Status', 'js-support-ticket'); ?></div>
                                                            <div class="replyFormStatus js-form-title-position-reletive-left">
                                                                <?php echo JSSTformfield::checkbox('closeonreply', array('1' => __('Close on reply', 'js-support-ticket')), '', array('class' => 'radiobutton js-ticket-closeonreply-checkbox')); ?>
                                                            </div>
                                                        </div>
                                                        <div class="js-ticket-reply-form-button-wrp">
                                                            <?php echo JSSTformfield::submitbutton('postinternalnote', __('Post Internal Note', 'js-support-ticket'), array('class' => 'button js-ticket-save-button', 'onclick' => "return checktinymcebyid('internalnote');")); ?>
                                                        </div>

                                                        <?php echo JSSTformfield::hidden('ticketid', jssupportticket::$_data[0]->id); ?>
                                                        <?php echo JSSTformfield::hidden('uid', get_current_user_id()); ?>
                                                        <?php echo JSSTformfield::hidden('action', 'note_savenote'); ?>
                                                        <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                                                        <?php echo JSSTformfield::hidden('jsstpageid', get_the_ID()); ?>
                                                    </form>
                                                </div> <!-- end of postinternalnote div -->
                                            <?php }
                                            if(in_array('actions',jssupportticket::$_active_addons)){ ?>
                                                <div id="departmenttransfer">
                                                    <form method="post" action="<?php echo jssupportticket::makeUrl(array('jstmod'=>'ticket','task'=>'transferdepartment')); ?>" enctype="multipart/form-data">
                                                        <div class="js-ticket-premade-msg-wrp"><!-- Select Department Wrapper -->
                                                            <div class="js-ticket-premade-field-title"><?php echo __('Select Department', 'js-support-ticket'); ?></div>
                                                            <div class="js-ticket-premade-field-wrp">
                                                                <?php echo JSSTformfield::select('departmentid', JSSTincluder::getJSModel('department')->getDepartmentForCombobox(), isset(jssupportticket::$_data[0]->departmentid) ? jssupportticket::$_data[0]->departmentid : '', __('Select Department', 'js-support-ticket'), array('class' => 'js-ticket-premade-select')); ?>

                                                            </div>
                                                        </div>
                                                        <?php if(in_array('note', jssupportticket::$_active_addons)){ ?>
                                                            <div class="js-ticket-text-editor-wrp">
                                                                <div class="js-ticket-text-editor-field-title"><?php echo __('Type Note for Department', 'js-support-ticket'); ?></div>
                                                                <div class="js-ticket-text-editor-field"><?php echo wp_editor('', 'departmenttranfernote', array('media_buttons' => false)); ?></div>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="js-ticket-reply-form-button-wrp">
                                                            <?php echo JSSTformfield::submitbutton('departmenttransferbutton', __('Transfer', 'js-support-ticket'), array('class' => 'button js-ticket-save-button', 'onclick' => "return checktinymcebyid('departmenttranfernote');")); ?>
                                                        </div>
                                                        <?php echo JSSTformfield::hidden('ticketid', jssupportticket::$_data[0]->id); ?>
                                                        <?php echo JSSTformfield::hidden('uid', get_current_user_id()); ?>
                                                        <?php echo JSSTformfield::hidden('action', 'ticket_transferdepartment'); ?>
                                                        <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                                                        <?php echo JSSTformfield::hidden('jsstpageid', get_the_ID()); ?>
                                                    </form>
                                                </div> <!-- end of departmenttransfer div -->
                                            <?php
                                            }
                                            if ( in_array('agent',jssupportticket::$_active_addons)) { ?>
                                                <div id="assigntostaff">
                                                    <form method="post" action="<?php echo jssupportticket::makeUrl(array('jstmod'=>'ticket','task'=>'assigntickettostaff')); ?>" enctype="multipart/form-data">
                                                        <div class="js-ticket-premade-msg-wrp"><!-- Select Department Wrapper -->
                                                            <div class="js-ticket-premade-field-title"><?php echo __('Staff Member', 'js-support-ticket'); ?></div>
                                                            <div class="js-ticket-premade-field-wrp">
                                                                <?php echo JSSTformfield::select('staffid', JSSTincluder::getJSModel('agent')->getStaffForCombobox(), jssupportticket::$_data[0]->staffid, __('Select Staff', 'js-support-ticket'), array('class' => 'inputbox js-ticket-premade-select')); ?>
                                                            </div>
                                                        </div>
                                                        <?php if(in_array('note', jssupportticket::$_active_addons)){ ?>
                                                            <div class="js-ticket-text-editor-wrp">
                                                                <div class="js-ticket-text-editor-field-title"><?php echo __('Assigning Note', 'js-support-ticket'); ?></div>
                                                                <div class="js-ticket-text-editor-field"><?php echo wp_editor('', 'assignnote', array('media_buttons' => false)); ?></div>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="js-ticket-reply-form-button-wrp">
                                                            <?php echo JSSTformfield::submitbutton('assigntostaff', __('Assign', 'js-support-ticket'), array('class' => 'button js-ticket-save-button', 'onclick' => "return checktinymcebyid('assignnote');")); ?>
                                                        </div>
                                                        <?php echo JSSTformfield::hidden('ticketid', jssupportticket::$_data[0]->id); ?>
                                                        <?php echo JSSTformfield::hidden('uid', get_current_user_id()); ?>
                                                        <?php echo JSSTformfield::hidden('action', 'ticket_assigntickettostaff'); ?>
                                                        <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                                                        <?php echo JSSTformfield::hidden('jsstpageid', get_the_ID()); ?>
                                                    <?php if($printflag != true){ ?>
                                                    </form>
                                                    <?php } ?>
                                                </div> <!-- end of assigntostaff div -->
                                            <?php } ?>
                                        </div> <!-- end of tabInner div -->
                                    </div>
                                </div>
                            <?php } ?>
                        <?php
                        }
                    }
                    ?>
                </div>
                <?php
            } else { // Record Not FOund
                JSSTlayout::getNoRecordFound();
            }
        } else {// User is permission
            JSSTlayout::getPermissionNotGranted();
        }
    } else {// User is guest
        $redirect_url = jssupportticket::makeUrl(array('jstmod'=>'ticket','jstlay'=>'ticketdetail'));
        $redirect_url = base64_encode($redirect_url);
        JSSTlayout::getUserGuest($redirect_url);
    }
} else { // System is offline
    JSSTlayout::getSystemOffline();
}
?>
</div>
