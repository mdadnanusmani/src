<?php

  namespace Framework\Options;
  use Framework\Acf as GlobalAcf;

  class Page {

    private $core;

    public function __construct($core) {

      $this->core = $core;

      add_action('after_setup_theme', [$this, 'loadFields']);

    }

    /* ---
      Functions
    --- */

      public function loadFields() {

        $args = [
          'title'       => __('WP Framework', 'lang'),
          'slug'        => 'wpf',
          'icon'        => 'dashicons-wordpress',
          'pages'       => [
            'seo-share'    => __('Social media share', 'wpf'),
            'integrations' => __('Integrations', 'wpf'),
            'sitemap'      => __('Sitemap', 'wpf'),
            'phpmailer'    => __('PHPMailer', 'wpf')
          ],
          'notranslate' => [
            'integrations',
            'sitemap',
            'phpmailer'
          ]
        ];

        $optionspage = new GlobalAcf\Optionspage($this->core);
        $optionspage->registerOptionsPage($args, true);

      }

  }