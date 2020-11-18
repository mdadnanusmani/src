<?php

  namespace SiteManagement\Intranet;

  class Formats {

    public function __construct() {

      add_filter('acf/location/rule_types',               [$this, 'addLocationRules']);
      add_filter('acf/location/rule_values/content_type', [$this, 'addLocationRuleChoices']);
      add_filter('acf/location/rule_match/content_type',  [$this, 'matchLocationRule'], 10, 3);

    }

    /* ---
      Functions
    --- */

      public function addLocationRules($choices) {

        $choices['Custom']['content_type'] = 'Content type';
        return $choices;

      }

      public function addLocationRuleChoices($choices) {

        $choices = [
          'page' => 'News / Form',
          'link' => 'Link',
          'file' => 'File'
        ];

        return $choices;

      }

      public function matchLocationRule($match, $rule, $options) {

        $terms = wp_get_post_terms(get_the_ID(), 'intranet-category');

        if (!$terms)
          return;

        $type = get_field('content_type', $terms[0]->taxonomy . '_' . $terms[0]->term_id);

        if ($rule['operator'] == '==')
          $match = ($rule['value'] == $type);
        else if ($rule['operator'] == '!=')
          $match = ($rule['value'] != $type);

        return $match;

      }

  }