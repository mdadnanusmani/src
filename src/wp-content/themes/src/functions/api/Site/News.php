<?php

  namespace SiteManagement\Site;

  class News {

    public function __construct() {

      add_action('pre_get_posts',     [$this, 'archiveArgs']);
      add_action('template_redirect', [$this, 'loadPosts']);

    }

    /* ---
      Functions
    --- */

      public function archiveArgs($query) {

        if (is_admin() || !$query->is_main_query() || (!is_post_type_archive('news') && !is_tax('news-category')))
          return;

        $query->set('posts_per_page', -1);

      }

      public function loadPosts() {

        if (!isset($_GET['ajax']) || (!is_post_type_archive('news') && !is_tax('news-category')))
          return;

        ob_start();

        get_template_part('components/sections/archive/posts');

        $output = ob_get_contents();
        ob_end_clean();

        $output = preg_replace('/(\r\n)+|\r+|\n+|\t+/i', ' ', $output);
        $output = preg_replace('/>\s+</', '><', $output);
        $output = preg_replace('/\s+/', ' ', $output);

        echo $output;
        exit;

      }

  }