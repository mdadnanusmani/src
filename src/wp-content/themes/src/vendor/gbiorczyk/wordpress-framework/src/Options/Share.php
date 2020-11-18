<?php

  namespace Framework\Options;

  class Share {

    private $core;

    public function __construct($core) {

      $this->core = $core;

      add_action('init', [$this, 'loadGlobalFields'], 100);
      add_action('init', [$this, 'loadFields'],       100);

    }

    /* ---
      Functions
    --- */

      public function loadGlobalFields() {

        if (!function_exists('acf_add_local_field_group'))
          return;

        $list = [
          'key'    => 'group_wpf2aof98u4j2',
          'title'  => __('Settings', 'wpf'),
          'fields' => [
            [
              'key'          => 'field_wpfc74ccw26je',
              'label'        => __('Module active?', 'wpf'),
              'name'         => 'wpf_seo_share_active',
              'type'         => 'true_false',
              'instructions' => __('(enable support for Open Graph meta tags)', 'wpf'),
            ],
            [
              'key'   => 'field_wpfjscpmpf4ym',
              'label' => __('Default', 'wpf'),
              'name'  => '',
              'type'  => 'tab',
              'logic' => [
                [
                  [
                    'field'    => 'field_wpfc74ccw26je',
                    'operator' => '==',
                    'value'    => 1,
                  ],
                ],
              ],
            ],
            [
              'key'        => 'field_wpfzudkgd3ans',
              'label'      => __('Default settings', 'wpf'),
              'name'       => 'wpf_seo_share_default',
              'type'       => 'group',
              'layout'     => 'row',
              'sub_fields' => [
                [
                  'key'          => 'field_wpf4mcf5ts63e',
                  'label'        => __('Image', 'wpf'),
                  'name'         => 'image',
                  'type'         => 'image',
                  'instructions' => __('(unique image representing content of page; recommended image size is 1200 x 630px)', 'wpf'),
                ],
              ],
              'logic' => [
                [
                  [
                    'field'    => 'field_wpfc74ccw26je',
                    'operator' => '==',
                    'value'    => 1,
                  ],
                ],
              ],
            ],
            [
              'key'   => 'field_wpf8k8xkq2v9x',
              'label' => __('Post types', 'wpf'),
              'name'  => '',
              'type'  => 'tab',
              'logic' => [
                [
                  [
                    'field'    => 'field_wpfc74ccw26je',
                    'operator' => '==',
                    'value'    => 1,
                  ],
                ],
              ],
            ],
            [
              'key'          => 'field_wpfbjjaeocsef',
              'label'        => __('Archives', 'wpf'),
              'name'         => 'wpf_seo_share_posttypes',
              'type'         => 'repeater',
              'instructions' => __('(custom settings for archive pages of selected post types)', 'wpf'),
              'min'          => 0,
              'layout'       => 'row',
              'button_label' => __('Add post type', 'wpf'),
              'sub_fields'   => [
                [
                  'key'   => 'field_wpfx3otueznd5',
                  'label' => __('Post type', 'wpf'),
                  'name'  => 'wpf_seo_share_posttype',
                  'type'  => 'select',
                ],
                [
                  'key'          => 'field_wpfjd7x5mjw69',
                  'label'        => __('Title', 'wpf'),
                  'name'         => 'title',
                  'type'         => 'text',
                  'instructions' => __('(optionally; by default this is title of page)', 'wpf'),
                ],
                [
                  'key'          => 'field_wpf8ezjb28yaw',
                  'label'        => __('Description', 'wpf'),
                  'name'         => 'desc',
                  'type'         => 'text',
                  'instructions' => __('(description that concisely summarizes content)', 'wpf'),
                  'maxlength'    => 200,
                ],
                [
                  'key'          => 'field_wpf6mepvtc7mq',
                  'label'        => __('Image', 'wpf'),
                  'name'         => 'image',
                  'type'         => 'image',
                  'instructions' => __('(unique image representing content of page; recommended image size is 1200 x 630px)', 'wpf'),
                ],
              ],
              'logic' => [
                [
                  [
                    'field'    => 'field_wpfc74ccw26je',
                    'operator' => '==',
                    'value'    => 1,
                  ],
                ],
              ],
            ],
            [
              'key'   => 'field_wpft2u7msvspu',
              'label' => __('Taxonomies', 'wpf'),
              'name'  => '',
              'type'  => 'tab',
              'logic' => [
                [
                  [
                    'field'    => 'field_wpfc74ccw26je',
                    'operator' => '==',
                    'value'    => 1,
                  ],
                ],
              ],
            ],
            [
              'key'          => 'field_wpf37ma6qh3bt',
              'label'        => __('Archives', 'wpf'),
              'name'         => 'wpf_seo_share_taxonomies',
              'type'         => 'repeater',
              'instructions' => __('(custom settings for archive pages of selected taxonomies)', 'wpf'),
              'min'          => 0,
              'layout'       => 'row',
              'button_label' => __('Add taxonomy', 'wpf'),
              'sub_fields'   => [
                [
                  'key'   => 'field_wpf7aw89wnvyw',
                  'label' => __('Taxonomy', 'wpf'),
                  'name'  => 'wpf_seo_share_taxonomy',
                  'type'  => 'select',
                ],
                [
                  'key'          => 'field_wpffrw9wh2saq',
                  'label'        => __('Title', 'wpf'),
                  'name'         => 'title',
                  'type'         => 'text',
                  'instructions' => __('(optionally; by default this is title of page)', 'wpf'),
                ],
                [
                  'key'          => 'field_wpfnbw8k2w348',
                  'label'        => __('Description', 'wpf'),
                  'name'         => 'desc',
                  'type'         => 'text',
                  'instructions' => __('(description that concisely summarizes content)', 'wpf'),
                  'maxlength'    => 200,
                ],
                [
                  'key'          => 'field_wpfuagqgqn4kk',
                  'label'        => __('Image', 'wpf'),
                  'name'         => 'image',
                  'type'         => 'image',
                  'instructions' => __('(unique image representing content of page; recommended image size is 1200 x 630px)', 'wpf'),
                ],
              ],
              'logic' => [
                [
                  [
                    'field'    => 'field_wpfc74ccw26je',
                    'operator' => '==',
                    'value'    => 1,
                  ],
                ],
              ],
            ],
          ],
          'location' => [
            [
              [
                'param'    => 'options_page',
                'operator' => '==',
                'value'    => 'wpf-seo-share',
              ],
            ],
          ],
          'menu_order'            => 0,
          'position'              => 'normal',
          'style'                 => 'default',
          'label_placement'       => 'top',
          'instruction_placement' => 'label',
          'hide_on_screen'        => '',
          'active'                => 1,
          'description'           => '',
        ];

        $list = json_encode($list);
        $list = str_replace('"logic":', '"conditional_logic":', $list);
        $list = json_decode($list, true);

        acf_add_local_field_group($list);

      }

      public function loadFields() {

        if (!function_exists('acf_add_local_field_group') || !function_exists('get_field') || !get_field('wpf_seo_share_active', 'option'))
          return;

        $list = [
          'key'    => 'group_wpf8mg8yabcw7',
          'title'  => __('Share in social media', 'wpf'),
          'fields' => [
            [
              'key'        => 'field_wpf2bv6t2xk44',
              'label'      => __('Settings', 'wpf'),
              'name'       => 'wpf_seo_share',
              'type'       => 'group',
              'sub_fields' => [
                [
                  'key'          => 'field_wpfx7rp7p4ng8',
                  'label'        => __('Title', 'wpf'),
                  'name'         => 'title',
                  'type'         => 'text',
                  'instructions' => __('(optionally; by default this is title of page)', 'wpf'),
                ],
                [
                  'key'          => 'field_wpf9hmy2emgvk',
                  'label'        => __('Description', 'wpf'),
                  'name'         => 'desc',
                  'type'         => 'text',
                  'instructions' => __('(description that concisely summarizes content)', 'wpf'),
                  'maxlength'    => 200,
                ],
                [
                  'key'          => 'field_wpf7r3byjeo6r',
                  'label'        => __('Image', 'wpf'),
                  'name'         => 'image',
                  'type'         => 'image',
                  'instructions' => __('(unique image representing content of page; recommended image size is 1200 x 630px)', 'wpf'),
                ],
              ]
            ],
          ],
          'location'              => array_merge($this->getPosttypes(), $this->getTaxonomies()),
          'menu_order'            => 0,
          'position'              => 'side',
          'style'                 => 'default',
          'label_placement'       => 'top',
          'instruction_placement' => 'label',
          'hide_on_screen'        => '',
          'active'                => 1,
          'description'           => '',
        ];

        $list = json_encode($list);
        $list = str_replace('"logic":', '"conditional_logic":', $list);
        $list = json_decode($list, true);

        acf_add_local_field_group($list);

      }

      private function getPosttypes() {

        $list = $this->core->posttype->acf->getValues();

        foreach ($list as $posttype) {

          $conditions[] = [
            [
              'param'    => 'post_type',
              'operator' => '==',
              'value'    => $posttype
            ]
          ];

        }

        return $conditions;

      }

      private function getTaxonomies() {

        $list = $this->core->taxonomy->acf->getValues();

        foreach ($list as $taxonomy) {

          $conditions[] = [
            [
              'param'    => 'taxonomy',
              'operator' => '==',
              'value'    => $taxonomy
            ]
          ];

        }

        return $conditions;

      }

  }