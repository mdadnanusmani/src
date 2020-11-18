<?php

  namespace SiteManagement\Intranet;

  class Users {

    public function __construct() {

      add_filter('intranet_users',            [$this, 'getUsers']);
      add_filter('intranet_user',             [$this, 'getUser']);
      add_action('wp_ajax_intranet_favorite', [$this, 'switchUser']);

    }

    /* ---
      Functions
    --- */

      public function getUsers() {

        $users = get_users([
          'role__in' => ['subscriber']
        ]);

        $list = [];

        if (!$users)
          return $list;

        foreach ($users as $user)
          $list[] = $this->getUser($user);

        usort($list, function($a, $b) {

          if ($a['favorite'] == $b['favorite'])
            return 0;

          return $a['favorite'] < $b['favorite'];

        });

        return $list;

      }

      public function getUser($user) {

        if (!$user)
          return;

        $avatar = get_field('avatar', 'user_' . $user->ID);
        $data   = [
          'id'       => $user->ID,
          'favorite' => get_user_meta($user->ID, 'favorite_user_' . $user->ID, true) ? 1 : 0,
          'image'    => $avatar ? $avatar['sizes']['image-small'] : '',
          'name'     => $user->data->display_name,
          'position' => get_field('position', 'user_' . $user->ID),
          'email'    => $user->data->user_email,
          'phone'    => get_field('phone', 'user_' . $user->ID),
          'linkedin' => get_field('linkedin', 'user_' . $user->ID),
          'skype'    => get_field('skype', 'user_' . $user->ID)
        ];

        return $data;

      }

      public function switchUser() {

        $currentId = get_current_user_id();
        $key       = 'favorite_user_' . $_GET['user_id'];

        if (get_user_meta($currentId, $key, true))
          delete_user_meta($currentId, $key);
        else
          add_user_meta($currentId, $key, true, true);

      }

  }