<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
JSSTmessage::getMessage();
wp_enqueue_script('file_validate.js', jssupportticket::$_pluginpath . 'includes/js/file_validate.js');
wp_enqueue_script('jquery-ui-tabs');
wp_enqueue_style('jquery-ui-css', $protocol.'ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
wp_enqueue_script('timer.js', jssupportticket::$_pluginpath . 'includes/js/timer.jquery.js');
?>
<script type="text/javascript">
    var timer_flag = 0;
            var seconds = 0;
    function checktinymcebyid(id) {
        var content = tinymce.get(id).getContent({format: 'text'});
        if (jQuery.trim(content) == '')
        {
            alert('<?php echo __('Some values are not acceptable please retry', 'js-support-ticket'); ?>');
            return false;
        }
        return true;
    }
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
    jQuery(document).ready(function ($) {
        jQuery( "form" ).submit(function(e) {
            if(timer_flag != 0){
                jQuery('input#timer_time_in_seconds').val(jQuery('div.timer').data('seconds'));
            }
        });
        jQuery("#tabs").tabs();
        jQuery("#tk_attachment_add").click(function () {
            var obj = this;
            var current_files = jQuery('input[type="file"]').length;
            var total_allow =<?php echo jssupportticket::$_config['no_of_attachement']; ?>;
            var append_text = "<span class='tk_attachment_value_text'><input name='filename[]' type='file' onchange=\"uploadfile(this,'<?php echo jssupportticket::$_config['file_maximum_size']; ?>','<?php echo jssupportticket::$_config['file_extension']; ?>');\" size='20' maxlenght='30'  /><span  class='tk_attachment_remove'></span></span>";
            if (current_files < total_allow) {
                jQuery(".tk_attachment_value_wrapperform").append(append_text);
            } else if ((current_files === total_allow) || (current_files > total_allow)) {
                alert('<?php echo __('File upload limit exceed', 'js-support-ticket'); ?>');
                obj.hide();
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
        jQuery("a#showaction").click(function (e) {
            e.preventDefault();
            jQuery("div#action-div").slideToggle();
        });

        var height = jQuery(window).height();
        jQuery("a#showhistory").click(function (e) {
            e.preventDefault();
            jQuery("div#userpopup").slideDown('slow');
            jQuery('div#userpopupblack').show();
        });
        jQuery(document).delegate("#close-pop", "click", function (e) {
            jQuery("div#mergeticketselection").fadeOut();
            jQuery("div#popup-record-data").html("");
        });

        jQuery("div#userpopupblack,span.close-history,span.close-credentails").click(function (e) {
            jQuery("div#userpopup").slideUp('slow');
            jQuery("#usercredentailspopup").slideUp('slow');
            setTimeout(function () {
                jQuery('div#userpopupblack').hide();
            }, 700);
        });

        //print code
        <?php
        if(isset(jssupportticket::$_data[0])){ ?>
            jQuery('a#print-link').click(function (e) {
                e.preventDefault();
                var href = '<?php echo jssupportticket::makeUrl(array('jstmod'=>'ticket','jstlay'=>'printticket','jssupportticketid'=>jssupportticket::$_data[0]->id,'jsstpageid'=>jssupportticket::getPageid())); ?>';
                print = window.open(href, 'print_win', 'width=1024, height=800, scrollbars=yes');
            });
        <?php } ?>
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
    });
    function actionticket(action) {
        /*  Action meaning
         * 1 -> Change Priority
         * 2 -> Close Ticket
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
        jQuery.post(ajaxurl, {action: 'jsticket_ajax',jstmod: 'mergeticket', task: 'getLatestReplyForMerging', mergeid:mergeticketid,mergewith:mergewithticketid,isadmin:1}, function (data) {
            if(data){
                data=jQuery.parseJSON(data);
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
    function updateticketlist(pagenum,ticketid){
        jQuery.post(ajaxurl, {action: 'jsticket_ajax',jstmod: 'mergeticket', task: 'getTicketsForMerging', ticketid:ticketid,ticketlimit:pagenum}, function (data) {
        if(data){
            console.log(data);
            data=jQuery.parseJSON(data);
                jQuery("div#popup-record-data").html("");
                jQuery("div#popup-record-data").html(data['data']);
            }
        });
    }

    function showPopupAndFillValues(id,pfor) {
        if(pfor == 1){
            jQuery.post(ajaxurl, {action: 'jsticket_ajax', val: id, jstmod: 'reply', task: 'getReplyDataByID'}, function (data) {
                if (data) {
                    d = jQuery.parseJSON(data);
                    tinyMCE.get('jsticket_replytext').execCommand('mceSetContent', false, d.message);
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
                    d = jQuery.parseJSON(data);
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
                    d = jQuery.parseJSON(data);
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
                    data=jQuery.parseJSON(data);
                    jQuery("div#popup-record-data").html("");
                    jQuery("div#popup-record-data").html(data['data']);

                }
            });
        }

         return false;
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

    jQuery("div.popup-header-close-img,div.jsst-popup-background,input#cancel").click(function (e) {
        jQuery("div.jsst-popup-wrapper").slideUp('slow');
        jQuery("div.jsst-merge-popup-wrapper").slideUp('slow');
        setTimeout(function () {
            jQuery('div.jsst-popup-background').hide();
        }, 700);
    });



</script>
<?php
$yesno = array(
    (object) array('id' => '1', 'text' => __('Yes', 'js-support-ticket')),
    (object) array('id' => '0', 'text' => __('No', 'js-support-ticket'))
);
?>
<span style="display:none" id="filesize"><?php echo __('Error file size too large', 'js-support-ticket'); ?></span>
<span style="display:none" id="fileext"><?php echo __('Error file ext mismatch', 'js-support-ticket'); ?></span>
<div class="jsst-popup-background" style="display:none" ></div>
<div id="popup-record-data" style="display:inline-block;width:100%;"></div>
<div class="jsst-popup-wrapper jsst-merge-popup-wrapper" style="display:none" >
    <div class="jsst-popup-header" >
        <div class="popup-header-text" >
            <?php echo __('Edit Reply','js-support-ticket')?>
        </div>
        <div class="popup-header-close-img" onclick="closePopup();" >
        </div>
    </div>
    <div class="edit-time-popup" style="display:none;" >
        <div class="js-ticket-edit-form-wrp">
            <div class="js-ticket-edit-field-title">
                <?php echo __('Time', 'js-support-ticket'); ?>&nbsp;<span style="color: red;" >*</span>
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
                <?php echo JSSTformfield::submitbutton('ok', __('Save', 'js-support-ticket'), array('class' => 'js-ticket-priorty-save','onclick' => 'updateTimerFromPopup();')); ?>
                <?php echo JSSTformfield::button('cancel', __('Cancel', 'js-support-ticket'), array('class' => 'js-ticket-priorty-cancel','onclick'=>'closePopup();')); ?>
            </div>
        </div>
    </div>
    <form id="jsst-reply-form" style="display:none" method="post" action="<?php echo admin_url("admin.php?page=reply&task=saveeditedreply&action=jstask"); ?>" >
        <div class="js-form-wrapper-popup">
            <div class="js-form-title-popup"><?php echo __('Reply', 'js-support-ticket'); ?></div>
            <div class="js-form-field-popup"><?php echo wp_editor('', 'jsticket_replytext', array('media_buttons' => false,'editor_height' => 200, 'textarea_rows' => 20,)); ?></div>
        </div>
        <div class="js-col-md-12 js-form-button-wrapper">
            <?php echo JSSTformfield::submitbutton('ok', __('Save', 'js-support-ticket'), array('class' => 'button')); ?>
            <?php echo JSSTformfield::button('cancel', __('Cancel', 'js-support-ticket'), array('class' => 'button', 'onclick'=>'closePopup();')); ?>
        </div>
        <?php echo JSSTformfield::hidden('reply-replyid', ''); ?>

        <?php
        if(isset(jssupportticket::$_data[0])){
            echo JSSTformfield::hidden('reply-tikcetid',jssupportticket::$_data[0]->id);
        } ?>
    </form>
    <?php
    if(in_array('timetracking', jssupportticket::$_active_addons)){ ?>
        <form id="jsst-time-edit-form" style="display:none" method="post" action="<?php echo admin_url("admin.php?page=reply&task=saveeditedtime&action=jstask"); ?>" >
            <div class="js-form-wrapper-popup">
                <div class="js-form-title-popup"><?php echo __('Time', 'js-support-ticket'); ?></div>
                <div class="js-form-field-popup"><?php echo JSSTformfield::text('edited_time', '', array('class' => 'inputbox')) ?></div>
            </div>
            <div class="js-form-wrapper-popup system-time-div" style="display:none;" >
                <div class="js-form-title-popup"><?php echo __('System Time', 'js-support-ticket'); ?></div>
                <div class="js-form-field-popup"><?php echo JSSTformfield::text('systemtime', '', array('class' => 'inputbox','disabled'=>'disabled')) ?></div>
            </div>
            <div class="js-form-wrapper-popup">
                <div class="js-form-title-popup"><?php echo __('Reason For Editing', 'js-support-ticket'); ?></div>
                <div class="js-form-field-popup"><?php echo JSSTformfield::textarea('edit_reason', '', array('class' => 'inputbox')) ?></div>
            </div>
            <div class="js-form-wrapper-popup system-time-div" style="display:none;" >
                <div class="js-form-title-popup"><?php echo __('Resolve conflict', 'js-support-ticket'); ?></div>
                <div class="js-form-field-popup"><?php echo JSSTformfield::select('time-confilct-combo', $yesno, ''); ?></div>
            </div>
            <div class="js-col-md-12 js-form-button-wrapper">
                <?php echo JSSTformfield::submitbutton('ok', __('Save', 'js-support-ticket'), array('class' => 'button')); ?>
                <?php echo JSSTformfield::button('cancel', __('Cancel', 'js-support-ticket'), array('class' => 'button', 'onclick'=>'closePopup();')); ?>
            </div>
            <?php echo JSSTformfield::hidden('reply-replyid', ''); ?>
            <?php echo JSSTformfield::hidden('reply-tikcetid',jssupportticket::$_data[0]->id); ?>
            <?php echo JSSTformfield::hidden('time-confilct',''); ?>
        </form>
        <?php if(in_array('note', jssupportticket::$_active_addons) && in_array('timetracking', jssupportticket::$_active_addons)){ ?>
        <form id="jsst-note-edit-form" style="display:none" method="post" action="<?php echo admin_url("admin.php?page=note&task=saveeditedtime&action=jstask"); ?>" >
            <div class="js-form-wrapper-popup">
                <div class="js-form-title-popup"><?php echo __('Time', 'js-support-ticket'); ?></div>
                <div class="js-form-field-popup"><?php echo JSSTformfield::text('edited_time', '', array('class' => 'inputbox')) ?></div>
            </div>
            <div class="js-form-wrapper-popup system-time-div" style="display:none;" >
                <div class="js-form-title-popup"><?php echo __('System Time', 'js-support-ticket'); ?></div>
                <div class="js-form-field-popup"><?php echo JSSTformfield::text('systemtime', '', array('class' => 'inputbox','disabled'=>'disabled')) ?></div>
            </div>
            <div class="js-form-wrapper-popup">
                <div class="js-form-title-popup"><?php echo __('Reason For Editing', 'js-support-ticket'); ?></div>
                <div class="js-form-field-popup"><?php echo JSSTformfield::textarea('edit_reason', '', array('class' => 'inputbox')) ?></div>
            </div>
            <div class="js-form-wrapper-popup system-time-div" style="display:none;" >
                <div class="js-form-title-popup"><?php echo __('Resolve conflict', 'js-support-ticket'); ?></div>
                <div class="js-form-field-popup"><?php echo JSSTformfield::select('time-confilct-combo', $yesno, ''); ?></div>
            </div>
            <div class="js-col-md-12 js-form-button-wrapper">
                <?php echo JSSTformfield::submitbutton('ok', __('Save', 'js-support-ticket'), array('class' => 'button')); ?>
                <?php echo JSSTformfield::button('cancel', __('Cancel', 'js-support-ticket'), array('class' => 'button', 'onclick'=>'closePopup();')); ?>
            </div>
            <?php echo JSSTformfield::hidden('note-noteid', ''); ?>
            <?php echo JSSTformfield::hidden('note-tikcetid',jssupportticket::$_data[0]->id); ?>
            <?php echo JSSTformfield::hidden('time-confilct',''); ?>
        </form>
    <?php } ?>
<?php }?>
</div>
<div id="jsstadmin-wrapper">
    <div id="jsstadmin-leftmenu">
        <?php
        if(current_user_can('jsst_support_ticket')){
            JSSTincluder::getClassesInclude('jsstadminsidemenu');
        }
        ?>
    </div>
    <div id="jsstadmin-data">
    <span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=ticket&jstlay=tickets');?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Ticket Details', 'js-support-ticket'); ?></span></span>
        <?php
        if (!empty(jssupportticket::$_data[0])) {
            if (jssupportticket::$_data[0]->lock == 1) {
                $style = "darkred;";
                $status = __('Lock', 'js-support-ticket');
            } elseif (jssupportticket::$_data[0]->status == 0) {
                $style = "red;";
                $status = __('New', 'js-support-ticket');
            } elseif (jssupportticket::$_data[0]->status == 1) {
                $style = "orange;";
                $status = __('Waiting reply', 'js-support-ticket');
            } elseif (jssupportticket::$_data[0]->status == 2) {
                $style = "#FF7F50;";
                $status = __('In Progress', 'js-support-ticket');
            } elseif (jssupportticket::$_data[0]->status == 3) {
                $style = "green;";
                $status = __('Replied', 'js-support-ticket');
            } elseif (jssupportticket::$_data[0]->status == 4 OR jssupportticket::$_data[0]->status == 5) {
                $style = "blue;";
                $status = __('Closed', 'js-support-ticket');
            }
            $cur_uid = get_current_user_id();
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
                    <?php echo __('Private Credentials', 'js-support-ticket'); ?><span class="close-credentails">X</span>
                </div>
                <div class="js-ticket-usercredentails-wrp" style="display: none;">
                    <div class="js-ticket-usercredentails-credentails-wrp">
                    </div>
                    <?php if(jssupportticket::$_data[0]->status != 4 && jssupportticket::$_data[0]->status != 5){ ?>
                        <div class="js-ticket-usercredentail-data-add-new-button-wrap" >
                            <button class="js-ticket-usercredentail-data-add-new-button" onclick="addEditCredentail(<?php echo jssupportticket::$_data[0]->id;?>,<?php echo get_current_user_id();?>);" >
                                <?php echo __("Add New Credential","js-support-ticket"); ?>
                            </button>
                        </div>
                    <?php } ?>
                </div>
                <div class="js-ticket-usercredentails-form-wrap" >
                </div>
            </div>
            <div id="userpopup" style="display:none;">
                <div class="js-row">
                    <form id="userpopupsearch">
                        <div class="search-center-history"><?php echo __('Ticket History', 'js-support-ticket'); ?><span class="close-history"></span></div>
                    </form>
                </div>
                <div id="records">
                    <?php // data[5] holds the tickect history
                        $field_array = JSSTincluder::getJSModel('fieldordering')->getFieldTitleByFieldfor(1);
                    if ((!empty(jssupportticket::$_data[5]))) {
                        ?>
                <?php foreach (jssupportticket::$_data[5] AS $history) { ?>
                        <div class="js-col-xs-12 js-col-md-12 js-popup-row-wrapper">
                            <span class="js-col-xs-4 js-col-md-2">
                                <?php echo date_i18n('Y-m-d', strtotime($history->datetime)); ?>
                            </span>
                            <span class="js-col-xs-4 js-col-md-2">
                            <?php echo date_i18n('H:i:s', strtotime($history->datetime)); ?>
                            </span>
                            <?php
                            if (is_super_admin($history->uid)) {
                                $message = 'admin';
                            } elseif ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff($history->uid)) {
                                $message = 'agent';
                            } else {
                                $message = 'member';
                            }
                            ?>
                            <span class="js-col-xs-12 js-col-md-8 <?php echo $message; ?>">
                                <?php echo wp_kses_post($history->message); ?>
                            </span>
                        </div>
                        <?php } ?>
            <?php } ?>
                </div>
            </div>

            <div class="js-col-md-12 js-ticket-detail-wrapper">
                <div class="js-row js-ticket-topbar">
                    <div class="js-col-md-5 js-openclosed">
                        <div class="js-col-md-4 js-ticket-openclosed">
                            <?php
                             jssupportticket::$_data['custom']['ticketid'] = jssupportticket::$_data[0]->id;
                            if (jssupportticket::$_data[0]->status == 4)
                                $ticketmessage = __('Closed', 'js-support-ticket');
                            elseif (jssupportticket::$_data[0]->status == 2)
                                $ticketmessage = __('In Progress', 'js-support-ticket');
                            elseif (jssupportticket::$_data[0]->status == 5)
                                $ticketmessage = __('Closed & merged', 'js-support-ticket');
                            else
                                $ticketmessage = __('Open', 'js-support-ticket');
                            echo $ticketmessage;
                            ?>
                        </div>
                        <div class="js-col-md-8">
                            <?php
                            echo __('Created', 'js-support-ticket') . ' ';
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
                                echo __('Ago', 'js-support-ticket');
                            }
                            echo ' ' . date_i18n("d F, Y, h:i:s A", strtotime(jssupportticket::$_data[0]->created));
                            ?>
                        </div>
                    </div>
                    <div class="js-col-md-4">
                        <div class="js-row js-margin-bottom">
                            <div class="js-col-xs-6 js-col-md-6 js-ticket-title"><?php echo __('Ticket ID', 'js-support-ticket'); ?></div>
                            <div class="js-col-xs-6 js-col-md-5 js-ticket-value js-border-box"><?php echo jssupportticket::$_data[0]->ticketid; ?></div>
                        </div>
                        <div class="js-row">
                            <div class="js-col-xs-6 js-col-md-6 js-ticket-title"><?php echo __($field_array['priority'], 'js-support-ticket'); ?></div>
                            <div class="js-col-xs-6 js-col-md-5 js-ticket-value js-ticket-wrapper-textcolor" style="background:<?php echo jssupportticket::$_data[0]->prioritycolour; ?>;"><?php echo __(jssupportticket::$_data[0]->priority, 'js-support-ticket'); ?></div>
                        </div>
                    </div>
                    <div class="js-col-md-3 js-last-left">
                        <div class="js-row">
                            <div class="js-col-xs-6 js-col-md-6 js-ticket-title"><?php echo __('Last Reply', 'js-support-ticket'); ?></div>
                            <div class="js-col-xs-6 js-col-md-6 js-ticket-value"><?php if (empty(jssupportticket::$_data[0]->lastreply) || jssupportticket::$_data[0]->lastreply == '0000-00-00 00:00:00') echo __('No Last Reply', 'js-support-ticket');
                            else echo date_i18n(jssupportticket::$_config['date_format'], strtotime(jssupportticket::$_data[0]->lastreply)); ?></div>
                        </div>
                        <div class="js-row">
                            <div class="js-col-xs-6 js-col-md-6 js-ticket-title"><?php echo __($field_array['duedate'], 'js-support-ticket'); ?></div>
                            <div class="js-col-xs-6 js-col-md-6 js-ticket-value"><?php if (empty(jssupportticket::$_data[0]->duedate) || jssupportticket::$_data[0]->duedate == '0000-00-00 00:00:00') echo __('Not Given', 'js-support-ticket');
                            else echo date_i18n(jssupportticket::$_config['date_format'], strtotime(jssupportticket::$_data[0]->duedate)); ?></div>
                        </div>
                        <div class="js-row">
                            <div class="js-col-xs-6 js-col-md-6 js-ticket-title"><?php echo __($field_array['status'], 'js-support-ticket'); ?></div>
                            <div class="js-col-xs-6 js-col-md-6 js-ticket-value">
                                <?php
                                $printstatus = 1;
                                if (jssupportticket::$_data[0]->lock == 1) {
                                    echo '<div><img alt="image" src="' . jssupportticket::$_pluginpath . 'includes/images/lockstatus.png"/>' . __('Lock', 'js-support-ticket') . '</div>';
                                    $printstatus = 0;
                                }
                                if (jssupportticket::$_data[0]->isoverdue == 1) {
                                    echo '<div><img alt="image" src="' . jssupportticket::$_pluginpath . 'includes/images/mark_over_due.png"/>' . __('Overdue', 'js-support-ticket') . '</div>';
                                    $printstatus = 0;
                                }
                                if ($printstatus == 1) {
                                    echo $ticketmessage;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="js-row js-ticket-middlebar">
                    <div class="js-col-xs-12 js-col-md-8 js-admin-xs-nullpadding">
                        <div class="js-col-xs-12 js-col-md-12" style = "margin-bottom:5px;">
                            <span class="js-ticket-title"><?php echo __($field_array['subject'], 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                            <span class="js-ticket-value js-subject-ticketdetail"><?php echo jssupportticket::$_data[0]->subject; ?></span>
                        </div>
                        <div class="js-col-xs-12 js-col-md-12" style = "margin-bottom:5px;">
                            <span class="js-ticket-title"><?php echo __($field_array['department'], 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                            <span class="js-ticket-value"><?php echo __(jssupportticket::$_data[0]->departmentname, 'js-support-ticket'); ?></span>
                        </div>
                        <?php
                        if(in_array('timetracking', jssupportticket::$_active_addons)){
                            $hours = floor(jssupportticket::$_data['time_taken'] / 3600);
                            $mins = floor(jssupportticket::$_data['time_taken'] / 60 % 60);
                            $secs = floor(jssupportticket::$_data['time_taken'] % 60);
                            $time =  sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                            ?>
                            <div class="js-col-xs-12 js-col-md-12" style = "margin-bottom:5px;">
                                <span class="js-ticket-title"><?php echo __('Time Taken', 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                                <span class="js-ticket-value"><?php echo $time; ?></span>
                            </div>
                            <?php
                        }
                            $customfields = JSSTincluder::getObjectClass('customfields')->userFieldsData(1);
                            foreach ($customfields as $field) {
                                echo JSSTincluder::getObjectClass('customfields')->showCustomFields($field,2, jssupportticket::$_data[0]->params);
                            }
                        ?>
                        <div class="js-col-xs-12 js-col-md-12" style = "margin-bottom:5px;">
                            <span class="js-ticket-value"><?php echo (jssupportticket::$_data[0]->ticketviaemail) ? __('Created via Email', 'js-support-ticket') : ''; ?></span>
                        </div>
                    </div>
                    <div class="js-col-xs-12 js-col-md-4 js-button-margin">
                        <a class="button" href="?page=ticket&jstlay=addticket&jssupportticketid=<?php echo jssupportticket::$_data[0]->id; ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" title="<?php echo __('Edit Ticket', 'js-support-ticket'); ?>" /></a>
                        <?php
                        if (jssupportticket::$_data[0]->status != 5) { // merged closed ticket can not be reopend.
                            if (jssupportticket::$_data[0]->status != 4) { ?>
                                <a class="button" href="#" onclick="actionticket(2);"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/close.png" title="<?php echo __('Close Ticket', 'js-support-ticket'); ?>" /></a>
                            <?php } else { ?>
                                <a class="button" href="#" onclick="actionticket(3);"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/reopen.png" title="<?php echo __('Reopen Ticket', 'js-support-ticket'); ?>" /></a>
                            <?php }
                        }

                        jssupportticket::$_data['custom']['ticketid'] = jssupportticket::$_data[0]->id; ?>
                        <a class="button" href="#" id="showaction"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/down.png" title="<?php echo __('More Option', 'js-support-ticket'); ?>" /></a>
                        <?php if(in_array('tickethistory', jssupportticket::$_active_addons)){ ?>
                            <a class="button" href="#" id="showhistory"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/tickethistory.png" title="<?php echo __('Ticket History', 'js-support-ticket'); ?>" /></a>
                        <?php } ?>
                        <?php if (  in_array('actions',jssupportticket::$_active_addons) && jssupportticket::$_data[0]->status != 4 && jssupportticket::$_data[0]->status != 5 ) { ?>
                            <a class="button" href="#" id="print-link" data-ticketid="<?php echo jssupportticket::$_data[0]->id; ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/print.png" title= "<?php echo __('Print', 'js-support-ticket'); ?>" /></a>
                        <?php } ?>
                        <?php if (  in_array('mergeticket',jssupportticket::$_active_addons) && jssupportticket::$_data[0]->status != 4 && jssupportticket::$_data[0]->status != 5 ) { ?>
                        <a class="button" href="#" id="mergeticket" data-ticketid="<?php echo jssupportticket::$_data[0]->id; ?>" onclick="return showPopupAndFillValues(<?php echo jssupportticket::$_data[0]->id ?>,4)" ><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/mergeicon.png" title= "<?php echo __('Merge Ticket', 'js-support-ticket'); ?>" /></a>
                        <?php } ?>
                        <?php if (in_array('privatecredentials',jssupportticket::$_active_addons)) { ?>
                        <a class="button" href="javascript:return false;" id="privatecredentials" onclick="getCredentails(<?php echo jssupportticket::$_data[0]->id; ?>)" ><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/privatecredentials.png" title= "<?php echo __('Private Credentials', 'js-support-ticket'); ?>" /></a>
                        <?php } ?>

                    </div>
                </div>
                <!-- ACTION AREA  -->
                <form method="post" action="<?php echo admin_url("admin.php?page=ticket&task=actionticket"); ?>" id="adminTicketform" enctype="multipart/form-data">
                    <div class="js-col-md-12" id="action-div" style="display:none;">
                            <?php
                        if(in_array('actions', jssupportticket::$_active_addons)){
                            if (jssupportticket::$_data[0]->lock == 1) { ?>
                                <a class="button" href="#" onclick="actionticket(5);"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/unlockticket.png" title="<?php echo __('Unlock Ticket', 'js-support-ticket'); ?>" /></a>
                            <?php } else { ?>
                                <a class="button" href="#" onclick="actionticket(4);"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/lockticket.png" title="<?php echo __('Lock Ticket', 'js-support-ticket'); ?>" /></a>
                            <?php }
                        }
                        if(in_array('banemail', jssupportticket::$_active_addons)){
                            if (JSSTincluder::getJSModel('banemail')->isEmailBan(jssupportticket::$_data[0]->email)) { ?>
                                <a class="button" href="#" onclick="actionticket(7);"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/unbanemail.png" title="<?php echo __('Unban Email', 'js-support-ticket'); ?>" /></a>
                            <?php } else { ?>
                                <a class="button" href="#" onclick="actionticket(6);"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/banemail.png" title="<?php echo __('Ban Email', 'js-support-ticket'); ?>" /></a>
                            <?php
                            }
                        }
                        if(in_array('overdue', jssupportticket::$_active_addons)){
                            if (jssupportticket::$_data[0]->isoverdue == 1) { ?>
                                <a class="button" href="#" onclick="actionticket(11);"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/un-overdue.png" title="<?php echo __('Unmark Overdue', 'js-support-ticket'); ?>" /></a>
                            <?php } else { ?>
                                <a class="button" href="#" onclick="actionticket(8);"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/markoverdue.png" title="<?php echo __('Mark Overdue', 'js-support-ticket'); ?>" /></a>
                            <?php }
                        } ?>
                        <?php if(in_array('actions', jssupportticket::$_active_addons)){ ?>
                            <a class="button" href="#" onclick="actionticket(9);"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/markinprogress.png" title="<?php echo __('Mark in Progress', 'js-support-ticket'); ?>" /></a>
                        <?php } ?>
                        <?php
                        if(in_array('banemail', jssupportticket::$_active_addons)){ ?>
                        <a class="button" href="#" onclick="actionticket(10);"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/banemailandcloseticket.png" title="<?php echo __('Ban Email and Close Ticket', 'js-support-ticket'); ?>" /></a>
                        <?php } ?>
                        <div class="js-row">
                            <div class="js-col-md-6 js-col-xs-12"><?php echo JSSTformfield::select('priority', JSSTincluder::getJSModel('priority')->getPriorityForCombobox(), jssupportticket::$_data[0]->priorityid, __('Change Priority', 'js-support-ticket'), array()); ?></div>
                            <div class="js-col-md-6 js-col-xs-12"><?php echo JSSTformfield::button('changepriority', __('Change Priority', 'js-support-ticket'), array('class' => 'changeprioritybutton', 'onclick' => 'actionticket(1);')); ?></div>
                        </div>
                    </div>
                    <?php
                        echo JSSTformfield::hidden('actionid', '');
                        echo JSSTformfield::hidden('ticketid', jssupportticket::$_data[0]->id);
                        echo JSSTformfield::hidden('uid', get_current_user_id()); echo JSSTformfield::hidden('action', 'reply_savereply');
                        echo JSSTformfield::hidden('form_request', 'jssupportticket');
                    ?>
                </form>  <!--END of action Area -->
            </div>
            <div class="js-col-md-12 js-ticket-detail-wrapper">
                <div class="js-row js-ticket-requester"><?php echo __('Requester Info', 'js-support-ticket'); ?></div>
                <div class="js-row js-ticket-bottombar">
                    <div class="js-col-md-5">
                        <?php
                        if (isset(jssupportticket::$_data[0]->uid) && !empty(jssupportticket::$_data[0]->uid)) {
                            echo get_avatar(jssupportticket::$_data[0]->uid,20);
                        } else { ?>
                            <img alt="image" src="<?php echo jssupportticket::$_pluginpath . '/includes/images/smallticketman.png'; ?>" />
                        <?php }
                        echo jssupportticket::$_data[0]->name; ?>
                    </div>
                    <div class="js-col-md-5">
                        <img alt="image" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/smallmail.png'; ?>" />
                        <?php echo jssupportticket::$_data[0]->email; ?>
                    </div>
                    <div class="js-col-md-2">
                        <a href="#" id="showhidedetail" data-divid="js-hidden-ticket-data"><img class="js-showdetail" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/showhide.png'; ?>" /><?php echo __('Show Detail', 'js-support-ticket'); ?></a>
                    </div>
                    <div id="js-hidden-ticket-data">
                        <div class="js-row js-ticket-requester"><?php echo __('More Detail', 'js-support-ticket'); ?></div>
                        <div class="js-row">
                            <div class="js-col-md-4 js-ticket-moredetail">
                                <div class="js-col-md-6 js-ticket-data-title"><?php echo __($field_array['phone'], 'js-support-ticket'); ?></div>
                                <div class="js-col-md-6 js-ticket-data-value"><?php echo jssupportticket::$_data[0]->phone; ?></div>
                            </div>
                            <?php if(in_array('agent',jssupportticket::$_active_addons)){ ?>
                                <div class="js-col-md-4 js-ticket-moredetail">
                                    <div class="js-col-md-6 js-ticket-data-title"><?php echo __($field_array['assignto'], 'js-support-ticket'); ?></div>
                                    <div class="js-col-md-6 js-ticket-data-value"><?php echo jssupportticket::$_data[0]->staffname; ?></div>
                                </div>
                            <?php } ?>
                            <?php if(in_array('helptopic',jssupportticket::$_active_addons)){ ?>
                                <div class="js-col-md-4 js-ticket-moredetail">
                                    <div class="js-col-md-6 js-ticket-data-title"><?php echo __($field_array['helptopic'], 'js-support-ticket'); ?></div>
                                    <div class="js-col-md-6 js-ticket-data-value"><?php echo jssupportticket::$_data[0]->helptopic; ?></div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if( class_exists('WooCommerce') && in_array('woocommerce', jssupportticket::$_active_addons)){
                $order = wc_get_order(jssupportticket::$_data[0]->wcorderid);
                $order_productid = jssupportticket::$_data[0]->wcproductid;
                if($order){
                ?>
                <div>
                    <span class="js-admin-title"><?php echo __("Woocommerce Order",'js-support-ticket'); ?></span>
                    <div class="js-ticket-detail-wrapper js-ticket-wc-order-box">
                        <div class="js-ticket-wc-order-item">
                            <div class="js-ticket-wc-order-item-title"><?php echo __($field_array['wcorderid'],'js-support-ticket'); ?>:</div>
                            <div class="js-ticket-wc-order-item-value">
                                <a href="<?php echo $order->get_edit_order_url(); ?>">
                                    #<?php echo $order->get_id(); ?>
                                </a>
                            </div>
                        </div>
                        <div class="js-ticket-wc-order-item">
                            <div class="js-ticket-wc-order-item-title"><?php echo __("Status",'js-support-ticket'); ?>:</div>
                            <div class="js-ticket-wc-order-item-value"><?php echo wc_get_order_status_name($order->get_status()); ?></div>
                        </div>
                        <?php
                        if($order_productid){
                            $item = new WC_Order_Item_Product($order_productid);
                            if($item){
                                ?>
                                <div class="js-ticket-wc-order-item">
                                    <div class="js-ticket-wc-order-item-title"><?php echo __($field_array['wcproductid'],'js-support-ticket'); ?>:</div>
                                    <div class="js-ticket-wc-order-item-value"><?php echo $item->get_name(); ?></div>
                                </div>
                                <?php
                            }
                        }?>
                        <div class="js-ticket-wc-order-item">
                            <div class="js-ticket-wc-order-item-title"><?php echo __("Created",'js-support-ticket'); ?>:</div>
                            <div class="js-ticket-wc-order-item-value"><?php echo $order->get_date_created()->date_i18n(wc_date_format()); ?></div>
                        </div>
                    </div>
                </div>
            <?php }
        } ?>


            <!-- Tickect internal Note Area -->
                <?php
                $colored = "colored";
                if (!empty(jssupportticket::$_data[6])) {
                    if(in_array('note', jssupportticket::$_active_addons)){
                    ?>
                <span class="js-admin-title"><?php echo __('Internal Note', 'js-support-ticket'); ?></span>
                    <?php
                    foreach (jssupportticket::$_data[6] AS $note) {
                        if ($cur_uid == isset($note->uid))
                            $colored = '';
                        ?>
                    <div class="js-col-xs-3 js-col-md-2 js-ticket-thread-pic">
                    <?php if (in_array('agent',jssupportticket::$_active_addons) && $note->staffphoto) { ?>
                            <img  src="<?php echo jssupportticket::makeUrl(array('jstmod'=>'agent','task'=>'getStaffPhoto','action'=>'jstask','jssupportticketid'=>$note->staff_id, 'jsstpageid'=>jssupportticket::getPageid())); ?>">
                    <?php } else {
                            if (isset($note->uid) && !empty($note->uid)) {
                                echo get_avatar($note->uid);
                            } else { ?>
                                <img alt="image" src="<?php echo jssupportticket::$_pluginpath . '/includes/images/ticketmanbig.png'; ?>" />
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="js-col-xs-9 js-col-md-10 js-ticket-thread-wrapper <?php echo $colored; ?>">
                        <div class="js-ticket-detail-corner"></div>
                        <div class="js-ticket-thread-upperpart">
                            <span class="js-ticket-thread-replied"><?php echo __('Posted by', 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                            <span class="js-ticket-thread-person">
                                <?php
                                if(isset($note->staffname)){
                                    echo $note->staffname;
                                }elseif(isset($note->display_name)){
                                    echo $note->display_name;
                                }else{
                                    echo '--------';
                                }
                                ?>
                            </span>
                            <span class="js-ticket-thread-date">(&nbsp;<?php echo date_i18n("l F d, Y, h:i:s", strtotime($note->created)); ?>&nbsp;)</span>
                            <?php
                                if(in_array('timetracking', jssupportticket::$_active_addons)){
                                    $hours = floor($note->usertime / 3600);
                                    $mins = floor($note->usertime / 60 % 60);
                                    $secs = floor($note->usertime % 60);
                                    $time = __('Time Taken','js-support-ticket').':&nbsp;'.sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                                    ?>
                                    <a class="ticket-edit-time-button" href="#" onclick="return showPopupAndFillValues(<?php echo $note->id;?>,3)" >
                                        <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit-reply-icon.png" />
                                        <?php echo __('Edit Time','js-support-ticket');?>
                                    </a>
                                    <span class="js-ticket-thread-time"><?php echo $time; ?></span>
                                <?php } ?>
                        </div>
                    <?php if (isset($note->title) && $note->title != '') { ?>
                            <div class="js-ticket-thread-upperpart">
                                <span class="js-ticket-thread-replied"><?php echo __('Subject', 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                                <span class="js-ticket-thread-person"><?php echo $note->title; ?></span>
                            </div>
                            <?php } ?>
                        <div class="js-ticket-thread-middlepart">
                        <?php
                            echo wp_kses_post($note->note);
                            if($note->filesize > 0 && !empty($note->filename)){
                                echo '<div class="js_ticketattachment">'
                                        . $note->filename . ' (' . ($note->filesize / 1024 ) . ')&nbsp;&nbsp;
                                        <a class="button" target="_blank" href="'.admin_url('?page=note&action=jstask&task=downloadbyid&id='.$note->id).'">'.__('Download','js-support-ticket').'</a>
                                        </div>';
                            }
                            ?>
                        </div>
                    </div>
                    <?php }
                    }
                } ?>
            <!-- Tickect  Reply  Area -->
            <span class="js-admin-title"><?php echo __('Ticket Thread', 'js-support-ticket'); ?></span>
            <div class="js-col-md-2 js-col-xs-3 js-ticket-thread-pic">
                <?php if ( in_array('agent',jssupportticket::$_active_addons) &&  jssupportticket::$_data[0]->staffphotophoto) { ?>
                    <img  src="<?php echo admin_url('?page=agent&action=jstask&task=getStaffPhoto&jssupportticketid='.jssupportticket::$_data[0]->staffphotoid ); ?>">
                <?php } else {
                    if (isset(jssupportticket::$_data[0]->uid) && !empty(jssupportticket::$_data[0]->uid)) {
                        echo get_avatar(jssupportticket::$_data[0]->uid);
                    } else { ?>
                        <img alt="image" src="<?php echo jssupportticket::$_pluginpath . '/includes/images/ticketmanbig.png'; ?>" />
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="js-col-md-10 js-col-xs-9 js-ticket-thread-wrapper colored">
                <div class="js-ticket-detail-corner"></div>
                <div class="js-ticket-thread-upperpart">
                    <span class="js-ticket-thread-replied"><?php echo __('Replied By', 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                    <span class="js-ticket-thread-person"><?php echo jssupportticket::$_data[0]->name; ?></span>
                    <span class="js-ticket-thread-date">(&nbsp;<?php echo date_i18n("l F d, Y, h:i:s", strtotime(jssupportticket::$_data[0]->created)); ?>&nbsp;)</span>
                </div>
                <div class="js-ticket-thread-middlepart">
                    <?php echo wp_kses_post(jssupportticket::$_data[0]->message);
                    ?>
                </div>
            <?php
            if (!empty(jssupportticket::$_data['ticket_attachment'])) {
                $datadirectory = jssupportticket::$_config['data_directory'];
                $maindir = wp_upload_dir();
                $path = $maindir['baseurl'];

                $path = $path .'/' . $datadirectory;
                $path = $path . '/attachmentdata';
                $path = $path . '/ticket/ticket_' . jssupportticket::$_data[0]->id . '/';
                foreach (jssupportticket::$_data['ticket_attachment'] AS $attachment) {
                    $path = admin_url("?page=ticket&action=jstask&task=downloadbyid&id=".$attachment->id);
                    echo '
                    <div class="js_ticketattachment">
                      ' . $attachment->filename . ' ( ' . $attachment->filesize . ' ) ' . '
                      <a class="button" target="_blank" href="' . $path . '">' . __('Download', 'js-support-ticket') . '</a>
                    </div>';
                }
            }
            ?>
            </div>
                <?php
                $colored = "colored";
                if (!empty(jssupportticket::$_data[4]))
                    foreach (jssupportticket::$_data[4] AS $reply) {
                        if ($cur_uid == $reply->uid)
                            $colored = '';
                        ?>
                    <div class="js-col-md-2 js-col-xs-3 js-ticket-thread-pic">
                        <?php if (in_array('agent',jssupportticket::$_active_addons) && $reply->staffphoto) { ?>
                            <img  src="<?php echo jssupportticket::makeUrl(array('jstmod'=>'agent','task'=>'getStaffPhoto','action'=>'jstask','jssupportticketid'=>$reply->staffid,'jsstpageid'=>jssupportticket::getPageid())); ?>">
                        <?php } else {
                            if (isset($reply->uid) && !empty($reply->uid)) {
                                echo get_avatar($reply->uid);
                            } else { ?>
                                <img alt="image" src="<?php echo jssupportticket::$_pluginpath . '/includes/images/ticketmanbig.png'; ?>" />
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="js-col-md-10 js-col-xs-9 js-ticket-thread-wrapper <?php echo $colored; ?>">
                        <div class="js-ticket-detail-corner"></div>
                        <div class="js-ticket-thread-upperpart">
                            <span class="js-ticket-thread-replied"><?php echo __('Replied By', 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                            <span class="js-ticket-thread-person"><?php echo $reply->name; ?></span>
                            <span class="js-ticket-thread-date">(&nbsp;<?php echo date_i18n("l F d, Y, h:i:s", strtotime($reply->created)); ?>&nbsp;)</span>
                            <span class="js-ticket-via-email"><?php echo ($reply->ticketviaemail == 1) ? __('Created via Email', 'js-support-ticket') : ''; ?></span> <?php
                            if($reply->staffid != 0){ ?>
                                <a class="ticket-edit-reply-button" href="#" onclick="return showPopupAndFillValues(<?php echo $reply->replyid;?>,1)" >
                                    <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit-blue.png" />
                                    <?php echo __('Edit Reply','js-support-ticket');?>
                                </a>
                        <?php } ?>
                            <?php
                            if(in_array('timetracking', jssupportticket::$_active_addons)){
                                if($reply->time > 0 ){
                                    $hours = floor($reply->time / 3600);
                                    $mins = floor($reply->time / 60 % 60);
                                    $secs = floor($reply->time % 60);
                                    $time = __('Time Taken','js-support-ticket').':&nbsp;'.sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                                    ?>
                                    <a class="ticket-edit-time-button" href="#" onclick="return showPopupAndFillValues(<?php echo $reply->replyid;?>,2)" >
                                        <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit-reply-icon.png" />
                                        <?php echo __('Edit Time','js-support-ticket');?>
                                    </a>
                                    <span class="js-ticket-thread-time"><?php echo $time; ?></span>
                                <?php
                                }
                            }
                            ?>

                        </div>
                        <div class="js-ticket-thread-middlepart">
                    <?php echo wp_kses_post(html_entity_decode($reply->message)); ?>
                        </div>
                    <?php
                    if (!empty($reply->attachments)) {
                        foreach ($reply->attachments AS $attachment) {
                            $path = admin_url("?page=ticket&action=jstask&task=downloadbyid&id=".$attachment->id);
                            echo '
                          <div class="js_ticketattachment">
                            ' . $attachment->filename . ' ( ' . $attachment->filesize . ' ) ' . '
                            <a class="button" target="_blank" href="' . $path . '">' . __('Download', 'js-support-ticket') . '</a>
                          </div>';
                        }
                    }
                    ?>
                    </div>
                <?php } ?>
            <?php if (jssupportticket::$_data[0]->status != 4 && jssupportticket::$_data[0]->status != 5 ) { //Tab on ticket detail  ?>
                <div id="tabs" class="tabs">
                    <ul>
                        <li><a href="#postreply"><?php echo __('Post Reply', 'js-support-ticket') ?></a></li>
                        <?php if(in_array('note', jssupportticket::$_active_addons)){ ?>
                            <li><a href="#postinternalnote"><?php echo __('Internal Note', 'js-support-ticket') ?></a></li>
                        <?php }
                        if ( in_array('actions',jssupportticket::$_active_addons)) { ?>
                            <li><a href="#departmenttransfer"><?php echo __('Department Transfer', 'js-support-ticket') ?></a></li>
                        <?php }
                        if ( in_array('agent',jssupportticket::$_active_addons)) { ?>
                            <li><a href="#assigntostaff"><?php echo __('Assign to Staff', 'js-support-ticket') ?></a></li>
                        <?php } ?>
                    </ul>
                    <div class="tabInner">
                        <!-- Post Reply Area -->
                        <div id="postreply">
                            <form method="post" action="<?php echo admin_url("admin.php?page=reply&task=savereply"); ?>"  enctype="multipart/form-data">
                                <span class="js-admin-title"><?php echo __('Post Reply', 'js-support-ticket'); ?></span>
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
                                                <?php if(in_array('agent', jssupportticket::$_active_addons) && JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Edit Own Time')){ ?>
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
                                    <div class="js-form-wrapper">
                                        <div class="js-form-title"><?php echo __($field_array['premade'], 'js-support-ticket'); ?></div>
                                        <div class="js-form-field">
                                            <?php echo JSSTformfield::select('premadeid', JSSTincluder::getJSModel('cannedresponses')->getPreMadeMessageForCombobox(), isset(jssupportticket::$_data[0]->premadeid) ? jssupportticket::$_data[0]->premadeid : '', __('Select Premade', 'js-support-ticket'), array('class' => 'inputbox', 'onchange' => 'getpremade(this.value)')); ?>
                                            <div class="js-ticket-detail-append-signature-xs"> <?php echo JSSTformfield::checkbox('append_premade', array('1' => __('Append', 'js-support-ticket')), '', array('class' => 'radiobutton')); ?></div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="js-form-wrapper">
                                    <div class="js-form-title"><label id="responcemsg" for="responce"><?php echo __('Response', 'js-support-ticket'); ?><span style="color: red;" >*</span></label></div>
                                    <div class="js-form-field"><?php echo wp_editor('', 'jsticket_message', array('media_buttons' => false)); ?></div>
                                </div>
                                <div class="js-form-wrapper">
                                    <div class="js-form-title"><?php echo __($field_array['attachments'], 'js-support-ticket'); ?></div>
                                    <div class="js-form-field">
                                        <div class="tk_attachment_value_wrapperform">
                                            <span class="tk_attachment_value_text">
                                                <input type="file" class="inputbox" name="filename[]" onchange="uploadfile(this, '<?php echo jssupportticket::$_config['file_maximum_size']; ?>', '<?php echo jssupportticket::$_config['file_extension']; ?>');" size="20" maxlenght='30'/>
                                                <span class='tk_attachment_remove'></span>
                                            </span>
                                        </div>
                                        <span class="tk_attachments_configform">
                                            <small><?php __('Maximum File Size','js-support-ticket');
                                            echo ' (' . jssupportticket::$_config['file_maximum_size']; ?>KB)<br><?php __('File Extension Type','js-support-ticket');
                                            echo ' (' . jssupportticket::$_config['file_extension'] . ')'; ?></small>
                                        </span>
                                        <div class="js-md-col-12"><span id="tk_attachment_add" class="tk_attachments_addform"><?php echo __('Add More File','js-support-ticket'); ?></span></div>
                                    </div>
                                </div>
                                <div class="js-form-wrapper">
                                    <div class="js-form-title"><?php echo __('Append Signature', 'js-support-ticket'); ?></div>
                                    <div class="js-form-field">
                                        <?php echo JSSTformfield::checkbox('ownsignature', array('1' => __('Own Signature', 'js-support-ticket')), '', array('class' => 'radiobutton')); ?>
                                        <?php echo JSSTformfield::checkbox('departmentsignature', array('1' => __('Department Signature', 'js-support-ticket')), '', array('class' => 'radiobutton')); ?>
                                        <?php echo JSSTformfield::checkbox('nonesignature', array('1' => __('JNone', 'js-support-ticket')), '', array('class' => 'radiobutton')); ?>
                                    </div>
                                </div>
                                <?php
                                if ( in_array('agent',jssupportticket::$_active_addons) ) {
                                    $staffid = JSSTincluder::getJSModel('agent')->getStaffId(get_current_user_id());
                                    if (jssupportticket::$_data[0]->staffid != $staffid) {?>
                                    <div class="js-form-wrapper">
                                        <div class="js-form-title"><?php echo __('Assign to me', 'js-support-ticket'); ?></div>
                                        <div class="js-form-field">
                                            <?php echo JSSTformfield::checkbox('assigntome', array('1' => __('Assign to me', 'js-support-ticket')), '', array('class' => 'radiobutton')); ?>
                                        </div>
                                    </div>
                                    <?php }
                                } ?>
                                <div class="js-form-wrapper">
                                    <div class="js-form-title"><?php echo __('Ticket', 'js-support-ticket'); echo ' '; echo __($field_array['status'],'js-support-ticket'); ?></div>
                                    <div class="js-form-field">
                                        <?php echo JSSTformfield::checkbox('closeonreply', array('1' => __('Close on reply', 'js-support-ticket')), '', array('class' => 'radiobutton')); ?>
                                    </div>
                                </div>
                                <div class="js-form-button">
                                    <?php echo JSSTformfield::submitbutton('postreply', __('Post Reply','js-support-ticket'), array('class' => 'button', 'onclick' => "return checktinymcebyid('message');")); ?>
                                </div>
                                <?php echo JSSTformfield::hidden('departmentid', jssupportticket::$_data[0]->departmentid); ?>
                                <?php echo JSSTformfield::hidden('ticketid', jssupportticket::$_data[0]->id); ?>
                                <?php echo JSSTformfield::hidden('ticketrandomid', jssupportticket::$_data[0]->ticketid); ?>
                                <?php echo JSSTformfield::hidden('hash', jssupportticket::$_data[0]->hash); ?>
                                <?php echo JSSTformfield::hidden('uid', get_current_user_id()); ?>
                                <?php echo JSSTformfield::hidden('action', 'reply_savereply'); ?>
                                <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                            </form>
                        </div> <!-- end of postreply div -->
                        <?php if(in_array('note', jssupportticket::$_active_addons)){ ?>
                            <div id="postinternalnote">  <!--  postinternalnote Area   -->
                                <form method="post" action="<?php echo admin_url("admin.php?page=note&task=savenote"); ?>"  enctype="multipart/form-data">
                                    <span class="js-admin-title"><?php echo __('Internal Note', 'js-support-ticket'); ?></span>
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
                                    <div class="js-form-wrapper">
                                        <div class="js-form-title"><?php echo __('Note Title', 'js-support-ticket'); ?></div>
                                        <div class="js-form-field"><?php echo JSSTformfield::text('internalnotetitle', '', array('class' => 'inputbox')) ?></div>
                                    </div>
                                    <div class="js-form-wrapper">
                                        <div class="js-form-title"><label id="responcemsg" for="responce"><?php echo __('Internal Note', 'js-support-ticket'); ?></label></div>
                                        <div class="js-form-field"><?php echo wp_editor('', 'internalnote', array('media_buttons' => false)); ?></div>
                                    </div>
                                    <div class="js-form-wrapper">
                                        <div class="js-form-title"><?php echo __('Ticket', 'js-support-ticket'); echo ' '; echo __($field_array['status'],'js-support-ticket'); ?></div>
                                        <div class="js-form-field">
                                    <?php echo JSSTformfield::checkbox('closeonreply', array('1' => __('Close on reply', 'js-support-ticket')), '', array('class' => 'radiobutton')); ?>
                                        </div>
                                    </div>
                                    <div class="js-form-wrapper">
                                        <div class="js-form-title"><?php echo __($field_array['attachments'], 'js-support-ticket'); ?></div>
                                        <div class="js-form-field">
                                            <div class="tk_attachment_value_wrapperform">
                                                <span class="tk_attachment_value_text">
                                                    <input type="file" class="inputbox" name="note_attachment" onchange="uploadfile(this, '<?php echo jssupportticket::$_config['file_maximum_size']; ?>', '<?php echo jssupportticket::$_config['file_extension']; ?>');" size="20" maxlenght='30'/>
                                                    <span class='tk_attachment_remove'></span>
                                                </span>
                                            </div>
                                            <span class="tk_attachments_configform">
                                                <small><?php __('Maximum File Size','js-support-ticket');
                                                echo ' (' . jssupportticket::$_config['file_maximum_size']; ?>KB)<br><?php __('File Extension Type','js-support-ticket');
                                                echo ' (' . jssupportticket::$_config['file_extension'] . ')'; ?></small>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="js-form-button">
                                        <?php echo JSSTformfield::submitbutton('postinternalnote', __('Post internal note','js-support-ticket'), array('class' => 'button', 'onclick' => "return checktinymcebyid('internalnote');")); ?>
                                    </div>
                                    <?php echo JSSTformfield::hidden('ticketid', jssupportticket::$_data[0]->id); ?>
                                    <?php echo JSSTformfield::hidden('uid', get_current_user_id()); ?>
                                    <?php echo JSSTformfield::hidden('action', 'note_savenote'); ?>
                                    <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                                </form>
                            </div> <!-- end of postinternalnote div -->
                        <?php }
                        if ( in_array('actions',jssupportticket::$_active_addons)) { ?>
                        <div id="departmenttransfer">
                            <form method="post" action="<?php echo admin_url("admin.php?page=ticket&task=transferdepartment"); ?>"  enctype="multipart/form-data">
                                <span class="js-admin-title"><?php echo __('Department Transfer', 'js-support-ticket'); ?></span>
                                <div class="js-form-wrapper">
                                    <div class="js-form-title"><?php echo __($field_array['department'], 'js-support-ticket'); ?></div>
                                    <div class="js-form-field">
                                        <?php echo JSSTformfield::select('departmentid', JSSTincluder::getJSModel('department')->getDepartmentForCombobox(), jssupportticket::$_data[0]->departmentid, __('Select Department', 'js-support-ticket'), array('class' => 'inputbox')); ?>
                                    </div>
                                </div>
                                <?php if(in_array('note', jssupportticket::$_active_addons)){ ?>
                                    <div class="js-form-wrapper">
                                        <div class="js-form-title"><label id="responcemsg" for="responce"><?php echo __('Reason For Department Transfer', 'js-support-ticket'); ?></label></div>
                                        <div class="js-form-field"><?php echo wp_editor('', 'departmenttranfernote', array('media_buttons' => false)); ?></div>
                                    </div>
                                <?php } ?>
                                <div class="js-form-button">
                                    <?php echo JSSTformfield::submitbutton('departmenttransfer', __('Transfer','js-support-ticket'), array('class' => 'button', 'onclick' => "return checktinymcebyid('departmenttranfernote');")); ?>
                                </div>
                                    <?php echo JSSTformfield::hidden('ticketid', jssupportticket::$_data[0]->id); ?>
                                    <?php echo JSSTformfield::hidden('uid', get_current_user_id()); ?>
                                    <?php echo JSSTformfield::hidden('action', 'ticket_transferdepartment'); ?>
                                    <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                            </form>
                        </div> <!-- end of departmenttransfer div -->
                    <?php } ?>
                        <?php if ( in_array('agent',jssupportticket::$_active_addons)) { ?>
                            <div id="assigntostaff">
                                <form method="post" action="<?php echo admin_url("admin.php?page=ticket&task=assigntickettostaff"); ?>"  enctype="multipart/form-data">
                                    <span class="js-admin-title"><?php echo __('Assign to Staff Member', 'js-support-ticket'); ?></span>
                                    <div class="js-form-wrapper">
                                        <div class="js-form-title"><?php echo __('Staff Member', 'js-support-ticket'); ?></div>
                                        <div class="js-form-field">
                                             <?php echo JSSTformfield::select('staffid', JSSTincluder::getJSModel('agent')->getstaffForCombobox(), jssupportticket::$_data[0]->staffid, __('Select Staff', 'js-support-ticket'), array('class' => 'inputbox')); ?>
                                        </div>
                                    </div>
                                    <?php if(in_array('note', jssupportticket::$_active_addons)){ ?>
                                        <div class="js-form-wrapper">
                                            <div class="js-form-title"><label id="responcemsg" for="responce"><?php echo __('Internal Note', 'js-support-ticket'); ?></label></div>
                                            <div class="js-form-field"><?php echo wp_editor('', 'assignnote', array('media_buttons' => false)); ?></div>
                                        </div>
                                    <?php } ?>
                                    <div class="js-form-button">
                                        <?php echo JSSTformfield::submitbutton('assigntostaff', __('Assign','js-support-ticket'), array('class' => 'button', 'onclick' => "return checktinymcebyid('assignnote');")); ?>
                                    </div>
                                    <?php echo JSSTformfield::hidden('ticketid', jssupportticket::$_data[0]->id); ?>
                                    <?php echo JSSTformfield::hidden('uid', get_current_user_id()); ?>
                                    <?php echo JSSTformfield::hidden('action', 'ticket_assigntickettostaff'); ?>
                                    <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                                </form>
                            </div> <!-- end of assigntostaff div -->
                        <?php } ?>
                    </div> <!-- end of tabInner div -->
                </div>
            <?php } ?><!-- end of tab div -->
            <?php
        } else {
            JSSTlayout::getNoRecordFound();
        }
        ?>
    </div>
</div>
