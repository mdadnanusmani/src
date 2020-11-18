<?php

  namespace Framework\Forms;

  class Posttype {

    private $core;

    public function __construct($core) {

      $this->core = $core;

      add_action('init', [$this, 'registerPostType'], 0);

    }

    /* ---
      Functions
    --- */

      public function registerPostType($formID) {

        $this->core->posttype->action('register', [
          'slug'    => 'wpf-contact-forms',
          'rewrite' => 'wpf-contact-forms',
          'icon'    => 'dashicons-email-alt',
          'labels'  => [
            'name'     => __('Contact Forms', 'wpf'),
            'menu'     => __('Contact Forms', 'wpf'),
            'singular' => __('Contact Form', 'wpf'),
            'add'      => __('Add new form', 'wpf')
          ],
          'args'    => [
            'public'  => false,
            'show_ui' => true
          ]
        ]);

      }

  }