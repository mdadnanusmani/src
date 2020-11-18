<?php wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js'); ?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $.validate();
    });
</script>
<div id="jsstadmin-wrapper">
    <div id="jsstadmin-leftmenu">
        <?php  JSSTincluder::getClassesInclude('jsstadminsidemenu'); ?>
    </div>
    <div id="jsstadmin-data">
    <span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=banemail&jstlay=banemails');?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Add Email', 'js-support-ticket'); ?></span></span>
    <form method="post" action="<?php echo admin_url("admin.php?page=banemail&task=savebanemail"); ?>">
        <div class="js-form-wrapper">
            <div class="js-form-title"><?php echo __('Email', 'js-support-ticket'); ?>&nbsp;<span style="color: red;" >*</span></div>
            <div class="js-form-field"><?php echo JSSTformfield::text('email', isset(jssupportticket::$_data[0]->email) ? jssupportticket::$_data[0]->email : '', array('class' => 'inputbox', 'data-validation' => 'email')) ?></div>
        </div>
        <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : ''); ?>
        <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]->created) ? jssupportticket::$_data[0]->created : ''); ?>

        <?php
        if(in_array('agent', jssupportticket::$_active_addons)){
            echo JSSTformfield::hidden('submitter', JSSTincluder::getJSModel('agent')->getStaffId(get_current_user_id()));
        }else{
            echo JSSTformfield::hidden('submitter', get_current_user_id());
        }
         ?>

        <?php echo JSSTformfield::hidden('action', 'banemail_savebanemail'); ?>
        <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
        <div class="js-form-button">
            <?php echo JSSTformfield::submitbutton('save', __('Save Email', 'js-support-ticket'), array('class' => 'button')); ?>
        </div>
    </form>
</div>
</div>
