<?php

  namespace SiteManagement\Site;

  class Products {

    public function __construct() {

      add_filter('rewrite_rules_array', [$this, 'removeArchiveRewrites']);

    }

    /* ---
      Functions
    --- */

      public function removeArchiveRewrites($rules) {

        unset($rules['products/?$']);
        unset($rules['products/page/([0-9]{1,})/?$']);
        unset($rules['منتجات/?$']);
        unset($rules['منتجات/page/([0-9]{1,})/?$']);

        return $rules;

      }

  }