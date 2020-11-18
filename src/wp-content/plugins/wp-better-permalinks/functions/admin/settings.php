<?php

  class Settings_Admin_WPBetterPermalinks {

    private $core;

    function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Actions
    --- */

      public function initActions() {

        add_action('admin_menu', [$this, 'addSettingsPage']);
        add_action('init',       [$this, 'getPostTypes'], 100);
        add_action('init',       [$this, 'redirectToSettingsPage']);

      }

    /* ---
      Admin page
    --- */

      public function addSettingsPage() {

        add_submenu_page(
          'options-general.php',
          'WP Better Permalinks',
          'WP Better Permalinks',
          'manage_options',
          'wbp_admin_page',
          [$this, 'showSettingsPage']
        );

      }

      public function showSettingsPage() {

        $list = $this->list;
        require_once WBP_PATH . 'includes/_core.php';

      }

    /* ---
      Options
    --- */

      public function getPostTypes() {

        $settings  = get_option('wbp_settings', []);
        $list      = [];
        $postTypes = get_post_types(
          [
            'public'             => true,
            'publicly_queryable' => true,
            '_builtin'           => false
          ],
          'objects'
        );

        foreach ($postTypes as $index => $object) {

          $taxonomies = get_object_taxonomies($object->name, 'objects');

          if (!$taxonomies)
            continue;

          $key     = 'wpbs_' . $object->name . '_taxonomy';
          $current = isset($_POST[$key]) ? $_POST[$key] : (isset($settings[$object->name]) ? sanitize_text_field($settings[$object->name]) : false);

          if ($current && !taxonomy_exists($current))
            $current = false;

          $element = array(
            'slug'   => $object->name,
            'label'  => $object->label,
            'terms'  => [],
            'active' => $current ? $current : false,
            'path'   => array_filter([
              $object->name,
              ($current) ? '[' . $current . '-term-slug]' : false,
              '[single-' . $object->name . ']'
            ])
          );

          foreach ($taxonomies as $taxonomy) {

            if (!$taxonomy->public)
              continue;

            $element['terms'][] = [
              'slug'  => $taxonomy->name,
              'label' => $taxonomy->label,
            ];

          }

          $list[] = $element;

        }

        $this->list = $list;
        $this->initSettingsSaving();

      }

    /* ---
      Save settings
    --- */

      private function initSettingsSaving() {

        if (!isset($_POST['wbp_save'])) 
          return;

        $settings = array();

        foreach ($this->list as $index => $element)
          $settings[$element['slug']] = $element['active'];

        $this->saveSettings($settings);

      }

      private function saveSettings($list) {

        $list = sanitize_option('wbp_settings', $list);

        foreach ($list as $postType => $taxonomy) {

          if (!post_type_exists($postType) || ($taxonomy && !taxonomy_exists($taxonomy)))
            unset($list[$postType]);

        }

        $list = array_filter($list);

        if (get_option('wbp_settings') !== false)
          update_option('wbp_settings', $list);
        else
          add_option('wbp_settings', $list);

        $this->refreshSettings($list);

      }

    /* ---
      Refresh
    --- */

      private function refreshSettings($list) {

        $this->refreshPostTypes($list);
        $this->refreshTerms($list);

        wp_redirect(get_admin_url('/') . 'options-permalink.php?wbp_flush_rewrite_rules');

      }

      private function refreshPostTypes($list) {

        $this->core->posttypes->options['settings'] = $list;
        $this->core->posttypes->refresh->refreshPostTypes();

      }

      private function refreshTerms($list) {

        $this->core->terms->options['settings'] = $list;
        $this->core->terms->refresh->refreshTerms();

      }

      public function redirectToSettingsPage() {

        if (!isset($_GET['wbp_flush_rewrite_rules']))
          return;

        wp_redirect(get_admin_url('/') . 'options-general.php?page=wbp_admin_page');

      }

  }