<?php

  class Redirects_Terms_WPBetterPermalinks {

    private $core;

    function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Functions
    --- */

      public function addRedirect($termID, $old, $new) {

        $exists  = $this->core->terms->options['terms_redirects'];
        $siteUrl = site_url('/');

        $old     = str_replace($siteUrl, '', $old);
        $old     = trim($old, '/');
        $new     = str_replace($siteUrl, '', $new);
        $new     = trim($new, '/');
        $current = isset($exists[$termID]) ? $exists[$termID]['current'] : '';

        if (($new == $old) && ($new == $current))
          return;

        $this->core->terms->save->saveRedirect($termID, $new, $old);

      }

      public function removeRedirect($termID) {

        unset($this->core->terms->options['terms_redirects'][$termID]);
        $this->core->terms->save->updateRedirects();

      }

  }