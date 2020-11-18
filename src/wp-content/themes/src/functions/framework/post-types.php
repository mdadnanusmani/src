<?php

  $framework->posttype->action('register', [
    'slug'    => 'news',
    'rewrite' => 'news',
    'icon'    => 'dashicons-edit',
    'labels'  => [
      'name'     => __('News & Research', 'lang'),
      'menu'     => 'News',
      'singular' => 'News',
      'add'      => 'Add new news'
    ],
    'langs'   => [
      'en' => 'news',
      'ar' => 'أخبار'
    ],
    'args'    => []
  ]);

  $framework->posttype->action('register', [
    'slug'    => 'products',
    'rewrite' => 'products',
    'icon'    => 'dashicons-tag',
    'labels'  => [
      'name'     => __('Products', 'lang'),
      'menu'     => 'Products',
      'singular' => 'Products',
      'add'      => 'Add new product'
    ],
    'langs'   => [
      'en' => 'products',
      'ar' => 'منتجات'
    ],
    'args'    => [
      'has_archive' => false
    ]
  ]);

  $framework->posttype->action('register', [
    'slug'    => 'jobs',
    'rewrite' => 'jobs',
    'icon'    => 'dashicons-megaphone',
    'labels'  => [
      'name'     => __('Jobs', 'lang'),
      'menu'     => 'Jobs',
      'singular' => 'Jobs',
      'add'      => 'Add new job'
    ],
    'langs'   => [
      'en' => 'jobs',
      'ar' => 'وظائف'
    ],
    'args'    => [
      'has_archive' => false
    ]
  ]);

  $framework->posttype->action('register', [
    'slug'    => 'people',
    'rewrite' => 'people',
    'icon'    => 'dashicons-admin-users',
    'labels'  => [
      'name'     => __('People', 'lang'),
      'menu'     => 'People',
      'singular' => 'People',
      'add'      => 'Add new person'
    ],
    'args'    => [
      'public'  => false,
      'show_ui' => true
    ]
  ]);

  $framework->posttype->action('register', [
    'slug'    => 'intranet',
    'rewrite' => 'intranet',
    'icon'    => 'dashicons-lock',
    'labels'  => [
      'name'     => __('Intranet Pages', 'lang'),
      'menu'     => 'Intranet',
      'singular' => 'Page',
      'add'      => 'Add new page'
    ],
    'args'    => []
  ]);