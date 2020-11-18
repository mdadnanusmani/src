<?php

  class Refresh_Posttypes_WPBetterPermalinks {

    private $core;

    function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Functions
    --- */

      public function refreshPostTypes() {

        if (!$this->core->posttypes->options['settings'])
          return;

        $this->core->posttypes->options['posts'] = [];

        foreach ($this->core->posttypes->options['settings'] as $postType => $taxonomy)
          $this->refreshFriendlyUrls($postType);

      }

      public function refreshFriendlyUrls($postType) {

        $args  = [
          'posts_per_page' => -1,
          'post_type'      => $postType
        ];

        if (function_exists('pll_languages_list'))
          $args['lang'] = implode(',', pll_languages_list());

        $posts = get_posts($args);

        if (!$posts)
          return;

        foreach ($posts as $post)
          $this->core->posttypes->actions->addRewriteRule($post);

      }

  }