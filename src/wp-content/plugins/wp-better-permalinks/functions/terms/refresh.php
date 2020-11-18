<?php

  class Refresh_Terms_WPBetterPermalinks {

    private $core;

    function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Functions
    --- */

      public function refreshTerms() {

        if (!$this->core->terms->options['settings'])
          return;

        $this->core->terms->options['terms'] = [];

        foreach ($this->core->terms->options['settings'] as $postType => $taxonomy)
          $this->refreshFriendlyUrls($taxonomy);

      }

      public function refreshFriendlyUrls($taxonomy) {

        $args  = [
          'taxonomy'   => $taxonomy,
          'hide_empty' => false
        ];

        if (function_exists('pll_languages_list'))
          $args['lang'] = implode(',', pll_languages_list());

        $terms = get_terms($args);

        if (!$terms)
          return;

        foreach ($terms as $term)
          $this->core->terms->actions->addRewriteRule($term->term_id, $taxonomy);

      }

  }