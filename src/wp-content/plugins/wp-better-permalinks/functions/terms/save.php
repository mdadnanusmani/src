<?php

  class Save_Terms_WPBetterPermalinks {

    private $core;

    function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Rewrites
    --- */

      public function saveFriendlyUrl($termID, $regex, $path) {

        $this->core->terms->options['terms'][$termID] = [
          'path'  => $path,
          'regex' => $regex
        ];

        $this->updateFriendlyUrls();

      }

      public function updateFriendlyUrls() {

        if (get_option('wbp_terms') !== false)
          update_option('wbp_terms', $this->core->terms->options['terms']);
        else
          add_option('wbp_terms', $this->core->terms->options['terms']);

        flush_rewrite_rules(false);

      }

    /* ---
      Redirects
    --- */

      public function saveRedirect($termID, $current, $old) {

        if (isset($this->core->terms->options['terms_redirects'][$termID])) {

          $data = $this->core->terms->options['terms_redirects'][$termID];

        } else {

          $data = [
            'current'   => $current,
            'redirects' => []
          ];

        }

        $data['current']     = $current;
        $data['redirects'][] = $old;
        $data['redirects']   = array_unique($data['redirects']);

        $this->core->terms->options['terms_redirects'][$termID] = $data;
        $this->updateRedirects();

      }

      public function updateRedirects() {

        if (get_option('wbp_terms_redirects') !== false)
          update_option('wbp_terms_redirects', $this->core->terms->options['terms_redirects']);
        else
          add_option('wbp_terms_redirects', $this->core->terms->options['terms_redirects']);

        flush_rewrite_rules();

      }

  }