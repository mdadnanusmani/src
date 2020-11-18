<?php

  $framework->cache->action('config', [
    'timeout'       => 3600,
    'clear_actions' => [
      'save_post',
      'acf/save_post',
      'created_term',
      'edited_terms',
      'delete_term'
    ]
  ]);