<?php

  $section = [
    'headline' => __('See other products', 'lang'),
    'items'    => apply_filters('products_list', get_the_ID())
  ];

  include get_template_directory() . '/components/flexible/icons-list.php';