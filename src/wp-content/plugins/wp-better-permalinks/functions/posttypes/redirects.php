<?php

  class Redirects_Posttypes_WPBetterPermalinks {

    private $core;

    function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Functions
    --- */

      public function addRedirect($postID, $old, $new) {

        $exists  = $this->core->posttypes->options['posts_redirects'];
        $siteUrl = site_url('/');

        $old     = str_replace($siteUrl, '', $old);
        $old     = trim($old, '/');
        $new     = str_replace($siteUrl, '', $new);
        $new     = trim($new, '/');
        $current = isset($exists[$postID]) ? $exists[$postID]['current'] : '';

        if (($new == $old) && ($new == $current))
          return;

        $this->core->posttypes->save->saveRedirect($postID, $new, $old);

      }

      public function removeRedirect($postID) {

        unset($this->core->posttypes->options['posts_redirects'][$postID]);
        $this->core->posttypes->save->updateRedirects();

      }

  }