<?php

  namespace SiteManagement\Helpers;

  class Sections {

    public function __construct() {

      add_filter('section_classes', [$this, 'sectionClasses']);
      add_filter('section_name',    [$this, 'sectionName']);

    }

    /* ---
      Functions
    --- */

      public function sectionClasses($section) {

        $classes   = [];
        $classes[] = isset($section['section_bg']) ? $section['section_bg'] : '';
        $classes[] = (isset($section['section_in_nav']) && $section['section_in_nav']) ? 'section--scroll' : '';

        $classes = array_filter($classes);
        $classes = implode(' ', $classes);

        return $classes;

      }

      public function sectionName($section) {

        if (!isset($section['section_name']) || !$section['section_name'])
          return '';

        return 'data-name="' . $section['section_name'] . '"';

      }

  }