<?php

  class Links_Posttypes_WPBetterPermalinks {

    private $core;

    function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Actions
    --- */

      public function initActions() {

        add_filter('post_type_link', [$this, 'replaceLinks'], 100, 3);

      }

    /* ---
      Functions
    --- */

      public function replaceLinks($link, $post, $leavename) {

        if (!isset($this->core->posttypes->options['posts'][$post->ID]))
          return $link;

        $parts = explode('/', $this->core->posttypes->options['posts'][$post->ID]['regex']);
        $path  = array_slice($parts, 0, (count($parts) - 1));
        $slug  = !$leavename ? $post->post_name : '%postname%';
        $link  = site_url('/') . implode('/', $path) . '/' . $slug . '/';

        return $link;

      }

  }