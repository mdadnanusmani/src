<?php

  $framework->admin->action('menu', [
    'posts'     => false,
    'pages'     => true,
    'comments'  => false,
    'customize' => false,
    'wp_tools'  => false
  ]);

  $framework->admin->action('tinymce', [
    'pages_editor' => false,
    'buttons_1'    => [
      'formatselect',
      'bold',
      'italic',
      'bullist',
      'numlist',
      'link',
      'removeformat',
      'pastetext',
      'undo',
      'redo'
    ],
    'buttons_2'    => [],
    'formats'      => [
      'h5' => 'Heading',
      'h3' => 'Heading large',
      'p'  => 'Paragraph'
    ]
  ]);