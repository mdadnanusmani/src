<?php

  $framework->taxonomy->action('register', [
    'slug'        => 'news-category',
    'rewrite'     => 'news-category',
    'posttypes'   => ['news'],
    'is_category' => true,
    'labels'      => [
      'name'     => __('News categories', 'lang'),
      'menu'     => 'Categories',
      'singular' => 'Category',
      'add'      => 'Add new category'
    ],
    'langs'   => [
      'en' => 'news',
      'ar' => 'news'
    ],
    'args'        => []
  ]);

  $framework->taxonomy->action('register', [
    'slug'        => 'jobs-category',
    'rewrite'     => 'jobs-category',
    'posttypes'   => ['jobs'],
    'is_category' => true,
    'labels'      => [
      'name'     => __('Jobs categories', 'lang'),
      'menu'     => 'Categories',
      'singular' => 'Category',
      'add'      => 'Add new category'
    ],
    'langs'   => [
      'en' => 'jobs',
      'ar' => 'jobs'
    ],
    'args'        => [
      'public'  => false,
      'show_ui' => true
    ]
  ]);

  $framework->taxonomy->action('register', [
    'slug'        => 'people-category',
    'rewrite'     => 'people-category',
    'posttypes'   => ['people'],
    'is_category' => true,
    'labels'      => [
      'name'     => __('People categories', 'lang'),
      'menu'     => 'Categories',
      'singular' => 'Category',
      'add'      => 'Add new category'
    ],
    'args'        => [
      'public'  => false,
      'show_ui' => true
    ]
  ]);

  $framework->taxonomy->action('register', [
    'slug'        => 'intranet-category',
    'rewrite'     => 'intranet-category',
    'posttypes'   => ['intranet'],
    'is_category' => true,
    'labels'      => [
      'name'     => __('Intranet categories', 'lang'),
      'menu'     => 'Categories',
      'singular' => 'Category',
      'add'      => 'Add new category'
    ],
    'args'        => [
      'public'  => false,
      'show_ui' => true
    ]
  ]);