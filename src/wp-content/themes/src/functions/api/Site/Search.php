<?php

  namespace SiteManagement\Site;

  class Search {

    public function __construct() {

      add_action('pre_get_posts', [$this, 'searchArgs']);

    }

    /* ---
      Functions
    --- */

      public function searchArgs($query) {

        if (is_admin() || !$query->is_main_query() || !is_search())
          return;

        $query->set('posts_per_page', -1);

      }

  }