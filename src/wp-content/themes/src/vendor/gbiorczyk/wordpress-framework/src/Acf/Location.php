<?php

  namespace Framework\Acf;

  class Location {

    private $filtered;

    public function __construct() {

      add_filter('acf/location/rule_match/page_type', [$this, 'frontPageRule'], 0);

    }

    /* ---
      Functions
    --- */

      public function frontPageRule($match) {

        if ($this->filtered)
          return $match;

        add_filter('option_page_on_front', [$this, 'translateFrontPage']);
        $this->filtered = true;

      }

      public function translateFrontPage($value) {
        
        if (function_exists('pll_get_post'))
          $value = pll_get_post($value);

        return $value;

      }

  }