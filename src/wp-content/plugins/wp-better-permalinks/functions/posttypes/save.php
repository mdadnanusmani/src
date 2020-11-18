<?php

  class Save_Posttypes_WPBetterPermalinks {

    private $core;

    function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Rewrites
    --- */

      public function saveFriendlyUrl($postID, $regex, $path) {

        $this->core->posttypes->options['posts'][$postID] = [
          'path'  => $path,
          'regex' => $regex
        ];

        $this->updateFriendlyUrls();

      }

      public function updateFriendlyUrls() {

        if (get_option('wbp_posts') !== false)
          update_option('wbp_posts', $this->core->posttypes->options['posts']);
        else
          add_option('wbp_posts', $this->core->posttypes->options['posts']);

        flush_rewrite_rules(false);

      }

    /* ---
      Redirects
    --- */

      public function saveRedirect($postID, $current, $old) {

        if (isset($this->core->posttypes->options['posts_redirects'][$postID])) {

          $data = $this->core->posttypes->options['posts_redirects'][$postID];

        } else {

          $data = [
            'current'   => $current,
            'redirects' => []
          ];

        }

        $data['current']     = $current;
        $data['redirects'][] = $old;
        $data['redirects']   = array_unique($data['redirects']);

        $this->core->posttypes->options['posts_redirects'][$postID] = $data;
        $this->updateRedirects();

      }

      public function updateRedirects() {

        if (get_option('wbp_posts_redirects') !== false)
          update_option('wbp_posts_redirects', $this->core->posttypes->options['posts_redirects']);
        else
          add_option('wbp_posts_redirects', $this->core->posttypes->options['posts_redirects']);

        flush_rewrite_rules();

      }

  }