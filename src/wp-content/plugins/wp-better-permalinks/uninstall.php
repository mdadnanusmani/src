<?php

  if (!defined('WP_UNINSTALL_PLUGIN'))
    die;

  /* ---
    Remove options
  --- */

    delete_option('wbp_settings');
    delete_option('wbp_posts');
    delete_option('wbp_posts_redirects');
    delete_option('wbp_terms');
    delete_option('wbp_terms_redirects');
    delete_option('wbp_notice_hidden');

  /* ---
    Remove transient
  --- */

    delete_transient('wp_better_permalinks_notice');

  /* ---
    Flush rewrite rules
  --- */

    flush_rewrite_rules();