<?php

  class Links_Terms_WPBetterPermalinks {

    private $core;

    function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Actions
    --- */

      public function initActions() {

        add_filter('term_link', [$this, 'replaceLinks'], 100, 3);

      }

    /* ---
      Functions
    --- */

      public function replaceLinks($link, $term, $taxonomy) {

        if (!isset($this->core->terms->options['terms'][$term->term_id]))
          return $link;

        $link = home_url('/') . $this->core->terms->options['terms'][$term->term_id]['regex'] . '/';
        return $link;

      }

  }