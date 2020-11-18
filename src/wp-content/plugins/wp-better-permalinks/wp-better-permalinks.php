<?php 

  /*
    Plugin Name: WP Better Permalinks
    Description: Set custom friendly permalinks structure: Custom Post Type > Taxonomy > Post and Custom Post Type > Taxonomy instead of default WordPress structure.
    Version: 3.0.3
    Author: Mateusz Gbiorczyk
    Author URI: https://gbiorczyk.pl/
  */

  define('WBP_VERSION', '3.0.3');
  define('WBP_PATH',    plugin_dir_path(__FILE__));
  define('WBP_HTTP',    plugin_dir_url(__FILE__));
  define('WBP_NOTICE',  'wbp_notice_hidden');

  include 'functions/_core.php';
  new WPBetterPermalinks();