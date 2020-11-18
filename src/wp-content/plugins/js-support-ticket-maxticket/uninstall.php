<?php

/**
 * JS Support Ticket Agent Uninstall
 *
 * Uninstalling JS Support Ticket Agent tables, and pages.
 *
 * @author 		Ahmed Bilal
 * @category 	Core
 * @package 	JS Support Ticket/Uninstaller
 * @version     1.0
 */
if (!defined('WP_UNINSTALL_PLUGIN'))
    exit();

global $wpdb;
if (class_exists('jssupportticket') ) {
	JSSTincluder::getJSModel('premiumplugin')->logAddonDeletion('maxticket');
}