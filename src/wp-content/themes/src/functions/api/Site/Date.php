<?php

  namespace SiteManagement\Site;

  class Date {

    public function __construct() {

      add_filter('date_i18n', [$this, 'parseDate']);

    }

    /* ---
      Functions
    --- */

      public function parseDate($date) {

        $lang      = function_exists('pll_current_language') ? pll_current_language('slug') : get_locale();
        $translate = [
          '1' => '۱',
          '2' => '۲',
          '3' => '۳',
          '4' => '٤',
          '5' => '۵',
          '6' => '٦',
          '7' => '۷',
          '8' => '۸',
          '9' => '۹',
          '0' => '۰'
        ];

        if (is_admin() || ($lang != 'ar'))
          return $date;

        $date = str_replace(array_keys($translate), array_values($translate), $date);
        return $date;

      }

  }