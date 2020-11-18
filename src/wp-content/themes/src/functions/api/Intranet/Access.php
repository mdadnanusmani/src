<?php

  namespace SiteManagement\Intranet;

  class Access {

    public function __construct() {

      add_action('template_redirect', [$this, 'redirectIntranetPages']);
      add_action('wp_loaded',         [$this, 'redirectAdmin']);
      add_action('template_redirect', [$this, 'redirectIntranetArchive']);

    }

    /* ---
      Functions
    --- */

      public function redirectIntranetPages() {

        if (is_user_logged_in() || (!is_post_type_archive('intranet') && !is_singular('intranet')))
          return;

        wp_redirect(home_url('/'), 301);

      }

      public function redirectAdmin() {

        if (!is_admin() || (defined('DOING_AJAX') && DOING_AJAX) || (is_user_logged_in() && current_user_can('administrator')))
          return;

        wp_redirect(get_post_type_archive_link('intranet'), 302);

      }

      public function redirectIntranetArchive() {

        if (!is_tax('intranet-category'))
          return;

        wp_redirect(get_post_type_archive_link('intranet'), 302);

      }

  }