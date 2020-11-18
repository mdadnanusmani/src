<?php

  $framework->settings->action('images', [
    'image-full'   => [
      'width'  => 1920,
      'height' => 1080,
      'crop'   => true,
      'editor' => false
    ],
    'image-large' => [
      'width'  => 1200,
      'height' => 500,
      'crop'   => true,
      'editor' => 'Large photo'
    ],
    'image-medium' => [
      'width'  => 600,
      'height' => 600,
      'crop'   => true,
      'editor' => 'Medium photo'
    ],
    'image-small'  => [
      'width'  => 200,
      'height' => 200,
      'crop'   => true,
      'editor' => 'Small photo'
    ]
  ]);

  $framework->settings->action('nav', [
    'nav_top'    => 'Top nav',
    'nav_main'   => 'Main nav',
    'nav_footer' => 'Footer nav'
  ]);

  $framework->settings->action('plugins-update', [
    'admin-columns-pro' => 'admin-columns-pro.php',
    'cac-addon-acf'     => 'cac-addon-acf.php'
  ]);

  $framework->settings->action('security', [
    'wpc_path_allow' => [],
    'login_url'      => 'my-login'
  ]);

  $framework->settings->action('upload', [
    'svg' => 'image/svg+xml'
  ]);