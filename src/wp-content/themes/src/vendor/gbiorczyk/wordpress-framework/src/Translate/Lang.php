<?php

  namespace Framework\Translate;

  class Lang {

    private $lang;

    public function __construct() {

      $this->lang = $this->getCurrentSiteLang();

    }

    /* ---
      Actions
    --- */

      public function getCurrentLang() {

        return $this->lang;

      }

    /* ---
      Functions
    --- */

      private function getCurrentSiteLang() {

        $locale = (function_exists('pll_current_language') && pll_current_language('locale')) ? pll_current_language('locale') : get_locale();
        $locale = explode('_', $locale);

        return $locale[0];

      }

  }