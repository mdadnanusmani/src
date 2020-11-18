<?php

  $framework->acf->action('icons', [
    'academy',
    'calendar',
    'chart',
    'cv',
    'email',
    'eye-close',
    'eye-open',
    'file',
    'heart',
    'home',
    'interview',
    'letter',
    'lifebuoy',
    'linkedin',
    'location',
    'logout',
    'microphone',
    'money',
    'mouse',
    'palm',
    'pdf',
    'phone',
    'play',
    'rocket',
    'search',
    'share',
    'squares',
    'star',
    'star-fill',
    'stats',
    'target',
    'team',
    'trash',
    'twitter',
    'umbrella',
    'vision',
    'wallet'
  ]);


  $framework->acf->action('optionspage', [
    'title'       => 'Management',
    'slug'        => 'options',
    'icon'        => 'dashicons-admin-tools',
    'pages'       => [
      'header'            => 'Header',
      'footer'            => 'Footer',
      'section_contact'   => 'Contact section',
      'section_job_apply' => 'Job apply form',
      'archive_news'      => 'News archive',
      'intranet'          => 'Intranet',
      'google_maps'       => 'Google Maps API',
      'mailchimp'         => 'Mailchimp'
    ],
    'notranslate' => [
      'intranet',
      'google_maps'
    ]
  ]);