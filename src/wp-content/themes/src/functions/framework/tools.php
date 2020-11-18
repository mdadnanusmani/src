<?php

  $framework->tools->action('cleaner');

  $framework->tools->action('stats', [
    'limit_daily'   => 8,
    'limit_monthly' => 12,
    'limit_yearly'  => 10
  ]);

  $framework->tools->action('validate-categories', [
    [
      'slug'        => 'news-category',
      'post_types'  => ['news'],
      'min_checked' => 1,
      'max_checked' => 1
    ],
    [
      'slug'        => 'people-category',
      'post_types'  => ['people'],
      'min_checked' => 1,
      'max_checked' => 1
    ]
  ]);