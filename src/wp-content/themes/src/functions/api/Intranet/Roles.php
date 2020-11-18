<?php

  namespace SiteManagement\Intranet;

  class Roles {

    public function __construct() {

      add_action('admin_init', [$this, 'removeDefaultRoles']);

    }

    /* ---
      Functions
    --- */

      public function removeDefaultRoles() {

        remove_role('author');
        remove_role('editor');
        remove_role('translator');
        remove_role('contributor');

      }

  }