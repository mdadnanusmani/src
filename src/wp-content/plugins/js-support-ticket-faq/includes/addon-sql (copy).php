<?php

$charset_collate = jssupportticket::$_db->get_charset_collate();
        $query = "CREATE TABLE " . jssupportticket::$_db->prefix . "js_ticket_faqs (
        						  id int(11) NOT NULL AUTO_INCREMENT,
        						  categoryid int(11) DEFAULT NULL,
        						  staffid int(11) DEFAULT NULL,
        						  subject varchar(255) DEFAULT NULL,
        						  content text,
        						  views tinyint(4) DEFAULT NULL,
        						  ordering int(11) NOT NULL,
        						  created datetime DEFAULT NULL,
        						  status tinyint(1) DEFAULT NULL,
        						  PRIMARY KEY  (id)
        						) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $query );


 ?>