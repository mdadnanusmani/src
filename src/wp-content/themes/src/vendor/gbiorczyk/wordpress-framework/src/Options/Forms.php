<?php

  namespace Framework\Options;

  class Forms {

    public function __construct() {

      $this->loadFields();

    }

    /* ---
      Functions
    --- */

      public function loadFields() {

        if (!function_exists('acf_add_local_field_group'))
          return;

        $list = [
          'key'    => 'group_wpf2gwyc8qhmm',
          'title'  => __('Contact Forms', 'wpf'),
          'fields' => [
            [
              'key'     => 'field_wpf04fae41f14',
              'label'   => __('Allowed shortcodes', 'wpf'),
              'type'    => 'message',
              'message' => __('Loading...', 'wpf'),
            ],
            [
              'key'       => 'field_wpf009248e8c6',
              'label'     => __('Fields', 'wpf'),
              'type'      => 'tab',
              'logic'     => [
                [
                  [
                    'field'    => 'field_wpf0092e8e8c7',
                    'operator' => '!=empty',
                  ],
                ],
              ],
              'placement' => 'top',
              'endpoint'  => 0,
            ],
            [
              'key'          => 'field_wpf0092e8e8c7',
              'label'        => __('List', 'wpf'),
              'name'         => 'fields',
              'type'         => 'repeater',
              'required'     => 1,
              'min'          => 1,
              'max'          => 0,
              'layout'       => 'row',
              'button_label' => __('Add field', 'wpf'),
              'sub_fields'   => [
                [
                  'key'           => 'field_wpf009418e8c8',
                  'label'         => __('Type', 'wpf'),
                  'name'          => 'type',
                  'type'          => 'select',
                  'required'      => 1,
                  'choices'       => [
                    'text'        => __('Text', 'wpf'),
                    'email'       => __('E-mail', 'wpf'),
                    'url'         => __('Url', 'wpf'),
                    'tel'         => __('Telephone', 'wpf'),
                    'number'      => __('Number', 'wpf'),
                    'date'        => __('Date', 'wpf'),
                    'time'        => __('Time', 'wpf'),
                    'datetime'    => __('Datetime', 'wpf'),
                    'textarea'    => __('Textarea', 'wpf'),
                    'select'      => __('Select', 'wpf'),
                    'multiselect' => __('Multiselect', 'wpf'),
                    'checkbox'    => __('Checkbox', 'wpf'),
                    'radio'       => __('Radio', 'wpf'),
                    'file'        => __('File', 'wpf'),
                    'recaptcha'   => __('reCAPTCHA', 'wpf'),
                  ],
                  'default_value' => [
                  ],
                  'allow_null'    => 0,
                  'multiple'      => 0,
                  'return_format' => 'value',
                ],
                [
                  'key'          => 'field_wpf04c0300808',
                  'label'        => __('Name', 'wpf'),
                  'name'         => 'name',
                  'type'         => 'text',
                  'instructions' => __('(only only lowercase letters and underscores)', 'wpf'),
                  'required'     => 1,
                ],
                [
                  'key'           => 'field_wpf0a5151ed87',
                  'label'         => __('Is grouped options?', 'wpf'),
                  'name'          => 'is_values_group',
                  'type'          => 'true_false',
                  'logic'         => [
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'select',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'multiselect',
                      ],
                    ],
                  ],
                  'default_value' => 0,
                ],
                [
                  'key'          => 'field_wpf6djsoumrps',
                  'label'        => __('Different labels than values?', 'wpf'),
                  'name'         => 'is_different_labels',
                  'type'         => 'true_false',
                  'instructions' => sprintf(
                    __('(to show label instead of value use %s[{field_name}__label]%s)', 'wpf'),
                    '<strong>',
                    '</strong>'
                  ),
                  'logic'        => [
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'select',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'radio',
                      ],
                    ],
                  ],
                ],
                [
                  'key'          => 'field_wpf158f8142b2',
                  'label'        => __('Values', 'wpf'),
                  'name'         => 'values',
                  'type'         => 'repeater',
                  'required'     => 1,
                  'logic'        => [
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'select',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'multiselect',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'checkbox',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'radio',
                      ],
                    ],
                  ],
                  'min'          => 0,
                  'max'          => 0,
                  'layout'       => 'row',
                  'button_label' => __('Add value', 'wpf'),
                  'sub_fields'   => [
                    [
                      'key'      => 'field_wpf15907142b3',
                      'label'    => __('Value', 'wpf'),
                      'name'     => 'value',
                      'type'     => 'text',
                      'required' => 1,
                    ],
                    [
                      'key'          => 'field_wpf0a58b1ed89',
                      'label'        => __('List', 'wpf'),
                      'name'         => 'list',
                      'type'         => 'repeater',
                      'required'     => 1,
                      'logic'        => [
                        [
                          [
                            'field'    => 'field_wpf0a5151ed87',
                            'operator' => '==',
                            'value'    => '1',
                          ],
                        ],
                      ],
                      'min'          => 0,
                      'max'          => 0,
                      'layout'       => 'row',
                      'button_label' => __('Add value', 'wpf'),
                      'sub_fields'   => [
                        [
                          'key'      => 'field_wpf0a58b1ed8a',
                          'label'    => __('Value', 'wpf'),
                          'name'     => 'value',
                          'type'     => 'text',
                          'required' => 1,
                        ],
                        [
                          'key'          => 'field_wpf0a58b1ed8b',
                          'label'        => __('Label', 'wpf'),
                          'name'         => 'label',
                          'type'         => 'text',
                          'instructions' => sprintf(
                            __('(optionally)', 'wpf'),
                            '<strong>',
                            '</strong>'
                          ),
                          'logic'        => [
                            [
                              [
                                'field'    => 'field_wpf009418e8c8',
                                'operator' => '==',
                                'value'    => 'select',
                              ],
                              [
                                'field'    => 'field_wpf6djsoumrps',
                                'operator' => '==',
                                'value'    => '1',
                              ],
                            ],
                            [
                              [
                                'field'    => 'field_wpf009418e8c8',
                                'operator' => '==',
                                'value'    => 'radio',
                              ],
                              [
                                'field'    => 'field_wpf6djsoumrps',
                                'operator' => '==',
                                'value'    => '1',
                              ],
                            ],
                          ],
                        ],
                      ],
                    ],
                    [
                      'key'          => 'field_wpf097aacda29',
                      'label'        => __('Label', 'wpf'),
                      'name'         => 'label',
                      'type'         => 'text',
                      'instructions' => sprintf(
                        __('(optionally)', 'wpf'),
                        '<strong>',
                        '</strong>'
                      ),
                      'logic'        => [
                        [
                          [
                            'field'    => 'field_wpf009418e8c8',
                            'operator' => '==',
                            'value'    => 'select',
                          ],
                          [
                            'field'    => 'field_wpf0a5151ed87',
                            'operator' => '!=',
                            'value'    => '1',
                          ],
                          [
                            'field'    => 'field_wpf0a5151ed87',
                            'operator' => '!=',
                            'value'    => '1',
                          ],
                          [
                            'field'    => 'field_wpf6djsoumrps',
                            'operator' => '==',
                            'value'    => '1',
                          ],
                        ],
                        [
                          [
                            'field'    => 'field_wpf009418e8c8',
                            'operator' => '==',
                            'value'    => 'radio',
                          ],
                          [
                            'field'    => 'field_wpf6djsoumrps',
                            'operator' => '==',
                            'value'    => '1',
                          ],
                        ],
                      ],
                    ],
                  ],
                ],
                [
                  'key'          => 'field_wpfpf7mbkqxdr',
                  'label'        => __('Default values', 'wpf'),
                  'name'         => 'values_default',
                  'type'         => 'text',
                  'instructions' => __('(seperate each value with | char)', 'wpf'),
                  'logic'        => [
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'select',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'multiselect',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'checkbox',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'radio',
                      ],
                    ],
                  ],
                ],
                [
                  'key'   => 'field_wpf042638ba69',
                  'label' => __('Minimum value', 'wpf'),
                  'name'  => 'number_min',
                  'type'  => 'number',
                  'logic' => [
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'number',
                      ],
                    ],
                  ],
                ],
                [
                  'key'   => 'field_wpf40f0018f0e',
                  'label' => __('Maximum value', 'wpf'),
                  'name'  => 'number_max',
                  'type'  => 'number',
                  'logic' => [
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'number',
                      ],
                    ],
                  ],
                ],
                [
                  'key'   => 'field_wpf40f0918f0f',
                  'label' => __('Step value', 'wpf'),
                  'name'  => 'number_step',
                  'type'  => 'number',
                  'logic' => [
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'number',
                      ],
                      [
                        'field'    => 'field_wpf042638ba69',
                        'operator' => '!=',
                        'value'    => '',
                      ],
                    ],
                  ],
                ],
                [
                  'key'          => 'field_wpfe56c293763',
                  'label'        => __('Date before', 'wpf'),
                  'name'         => 'date_before',
                  'type'         => 'text',
                  'instructions' => __('(optionally; name of field in which user selects end date - this date can not be later than end date)', 'wpf'),
                  'logic'        => [
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'date',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'time',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'datetime',
                      ],
                    ],
                  ],
                ],
                [
                  'key'          => 'field_wpfe570993764',
                  'label'        => __('Date after', 'wpf'),
                  'name'         => 'date_after',
                  'type'         => 'text',
                  'instructions' => __('(optionally; name of field in which user selects start date - this date can not be earlier than start date)', 'wpf'),
                  'logic'        => [
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'date',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'time',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'datetime',
                      ],
                    ],
                  ],
                ],
                [
                  'key'           => 'field_wpfc1b45968d6',
                  'label'         => __('First empty option?', 'wpf'),
                  'name'          => 'select_first_empty',
                  'type'          => 'true_false',
                  'logic'         => [
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'select',
                      ],
                    ],
                  ],
                  'default_value' => 0,
                ],
                [
                  'key'          => 'field_wpfab9e7bd8cc',
                  'label'        => __('Site key', 'wpf'),
                  'name'         => 'recapchta_site_key',
                  'type'         => 'text',
                  'instructions' => __('(get from website: <a href="https://www.google.com/recaptcha/" target="_blank">google.com/recaptcha</a>)', 'wpf'),
                  'required'     => 1,
                  'logic'        => [
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'recaptcha',
                      ],
                    ],
                  ],
                ],
                [
                  'key'          => 'field_wpfaba42bd8cd',
                  'label'        => __('Secret', 'wpf'),
                  'name'         => 'recapchta_secret',
                  'type'         => 'text',
                  'instructions' => __('(get from website: <a href="https://www.google.com/recaptcha/" target="_blank">google.com/recaptcha</a>)', 'wpf'),
                  'required'     => 1,
                  'logic'        => [
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'recaptcha',
                      ],
                    ],
                  ],
                ],
                [
                  'key'   => 'field_wpf00a1cbb56a',
                  'label' => __('Placeholder', 'wpf'),
                  'name'  => 'placeholder',
                  'type'  => 'text',
                  'logic' => [
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'text',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'email',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'url',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'tel',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'number',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'date',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'time',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'datetime',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'textarea',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'select',
                      ],
                      [
                        'field'    => 'field_wpfc1b45968d6',
                        'operator' => '==',
                        'value'    => '1',
                      ],
                    ],
                  ],
                ],
                [
                  'key'          => 'field_wpf2e63f8a051',
                  'label'        => __('Custom classes', 'wpf'),
                  'name'         => 'classes',
                  'type'         => 'text',
                  'instructions' => __('(seperate each class with a space)', 'lang'),
                ],
                [
                  'key'           => 'field_wpf00a5025087',
                  'label'         => __('Is required?', 'wpf'),
                  'name'          => 'validate_required',
                  'type'          => 'true_false',
                  'logic'         => [
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '!=',
                        'value'    => 'recaptcha',
                      ],
                    ],
                  ],
                  'default_value' => 0,
                ],
                [
                  'key'   => 'field_wpf2b7b437ef1',
                  'label' => __('Minimum length', 'wpf'),
                  'name'  => 'validate_length_min',
                  'type'  => 'number',
                  'logic' => [
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'text',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'textarea',
                      ],
                    ],
                  ],
                  'min'   => 0,
                  'step'  => 1,
                ],
                [
                  'key'   => 'field_wpf2b7c437ef3',
                  'label' => __('Maximum length', 'wpf'),
                  'name'  => 'validate_length_max',
                  'type'  => 'number',
                  'logic' => [
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'text',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'textarea',
                      ],
                    ],
                  ],
                  'min'   => 0,
                  'step'  => 1,
                ],
                [
                  'key'           => 'field_wpf314efe8569',
                  'label'         => __('Multiple files?', 'wpf'),
                  'name'          => 'validate_file_multiple',
                  'type'          => 'true_false',
                  'logic'         => [
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'file',
                      ],
                    ],
                  ],
                  'default_value' => 0,
                ],
                [
                  'key'          => 'field_wpf040af8ba5f',
                  'label'        => __('File max size', 'wpf'),
                  'name'         => 'validate_file_size',
                  'type'         => 'number',
                  'instructions' => __('(value in KB)', 'wpf'),
                  'logic'        => [
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'file',
                      ],
                    ],
                  ],
                  'min'          => 0,
                  'step'         => 1,
                ],
                [
                  'key'           => 'field_wpf043a88ba6d',
                  'label'         => __('File extensions', 'wpf'),
                  'name'          => 'validate_file_extensions',
                  'type'          => 'checkbox',
                  'logic'         => [
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'file',
                      ],
                    ],
                  ],
                  'choices'       => [
                    'audio/aac'                                                                 => 'aac',
                    'video/x-msvideo'                                                           => 'avi',
                    'image/bmp'                                                                 => 'bmp',
                    'text/csv'                                                                  => 'csv',
                    'application/msword'                                                        => 'doc',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'docx',
                    'image/gif'                                                                 => 'gif',
                    'image/jpeg'                                                                => 'jpg',
                    'application/json'                                                          => 'json',
                    'video/mpeg'                                                                => 'mpeg',
                    'application/vnd.oasis.opendocument.presentation'                           => 'odp',
                    'application/vnd.oasis.opendocument.spreadsheet'                            => 'ods',
                    'application/vnd.oasis.opendocument.text'                                   => 'odt',
                    'audio/ogg'                                                                 => 'oga',
                    'video/ogg'                                                                 => 'ogv',
                    'application/ogg'                                                           => 'ogx',
                    'image/png'                                                                 => 'png',
                    'application/pdf'                                                           => 'pdf',
                    'application/vnd.ms-powerpoint'                                             => 'ppt',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
                    'application/x-rar-compressed'                                              => 'rar',
                    'image/svg+xml'                                                             => 'svg',
                    'image/tiff'                                                                => 'tiff',
                    'text/plain'                                                                => 'txt',
                    'audio/wav'                                                                 => 'wav',
                    'audio/webm'                                                                => 'weba',
                    'video/webm'                                                                => 'webm',
                    'image/webp'                                                                => 'webp',
                    'application/vnd.ms-excel'                                                  => 'xls',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'xlsx',
                    'application/xml'                                                           => 'xml',
                    'application/zip'                                                           => 'zip',
                    'video/3gpp,audio/3gpp'                                                     => '3gp',
                    'application/x-7z-compressed'                                               => '7z',
                  ],
                  'allow_custom'  => 0,
                  'default_value' => [
                  ],
                  'layout'        => 'vertical',
                  'toggle'        => 1,
                  'return_format' => 'array',
                  'save_custom'   => 0,
                ],
                [
                  'key'          => 'field_wpf0415a8ba62',
                  'label'        => __('Regex', 'wpf'),
                  'name'         => 'validate_regex',
                  'type'         => 'text',
                  'instructions' => __('(e.g. <strong>^([0-9]+)$</strong>)', 'wpf'),
                  'logic'        => [
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'text',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'email',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'url',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'tel',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'number',
                      ],
                    ],
                    [
                      [
                        'field'    => 'field_wpf009418e8c8',
                        'operator' => '==',
                        'value'    => 'range',
                      ],
                    ],
                  ],
                ],
              ],
            ],
            [
              'key'       => 'field_wpf04cb1f4fac',
              'label'     => __('Form', 'wpf'),
              'type'      => 'tab',
              'placement' => 'top',
              'endpoint'  => 0,
            ],
            [
              'key'       => 'field_wpfe70e3d7de6',
              'label'     => __('Submit', 'wpf'),
              'type'      => 'message',
              'message'   => __("Enter <strong>[submit_error]</strong> tag where you want to show error message when sending the form and <strong>[submit_success]</strong> for success message.\nAdd anywhere button to send form (you can use <strong>input</strong> or <strong>button</strong>).", 'wpf'),
              'new_lines' => 'br',
              'esc_html'  => 0,
            ],
            [
              'key'           => 'field_wpf04cb9f4fad',
              'label'         => __('Template', 'wpf'),
              'name'          => 'template',
              'type'          => 'textarea',
              'default_value' => __("<label>\n  <span>Your name</span>\n  [name]\n</label>\n\n<label>\n  <span>Your e-mail</span>\n  [email]\n</label>\n\n<label>\n  <span>Subject</span>\n  [subject]\n</label>\n\n<label>\n  <span>Message</span>\n  [message]\n</label>\n\n<button type=\"submit\">Submit</button>\n[submit_error]\n[submit_success]", 'wpf'),
            ],
            [
              'key'   => 'field_wpfe7a0fb562e',
              'label' => __('Submit error class', 'wpf'),
              'name'  => 'settings_class_submit_error',
              'type'  => 'text',
            ],
            [
              'key'   => 'field_wpf01f8908b0f',
              'label' => __('Submit success class', 'wpf'),
              'name'  => 'settings_class_submit_success',
              'type'  => 'text',
            ],
            [
              'key'          => 'field_wpfjnw792j4gg',
              'label'        => __('JS variable holding of instance extension', 'wpf'),
              'name'         => 'settings_instance_extension',
              'type'         => 'text',
              'instructions' => __('(optionally, name of JS variable loaded before Vue.js; allows you to add custom Vue.js methods)', 'wpf'),
            ],
            [
              'key'       => 'field_wpf04db47c090',
              'label'     => __('Mail', 'wpf'),
              'type'      => 'tab',
              'placement' => 'top',
              'endpoint'  => 0,
            ],
            [
              'key'          => 'field_wpf04db97c091',
              'label'        => __('List', 'wpf'),
              'name'         => 'mail_list',
              'type'         => 'repeater',
              'min'          => 0,
              'max'          => 0,
              'layout'       => 'row',
              'button_label' => __('Add mail', 'wpf'),
              'sub_fields'   => [
                [
                  'key'           => 'field_wpf04dd87c092',
                  'label'         => __('To', 'wpf'),
                  'name'          => 'to',
                  'type'          => 'text',
                  'required'      => 1,
                  'default_value' => 'mail@example.com',
                ],
                [
                  'key'           => 'field_wpf04de47c093',
                  'label'         => __('From', 'wpf'),
                  'name'          => 'from',
                  'type'          => 'text',
                  'required'      => 1,
                  'default_value' => '[name] <[email]>',
                ],
                [
                  'key'           => 'field_wpf04e167c094',
                  'label'         => __('Subject', 'wpf'),
                  'name'          => 'subject',
                  'type'          => 'text',
                  'required'      => 1,
                  'default_value' => __('Message "[subject]"', 'wpf'),
                ],
                [
                  'key'           => 'field_wpf04e247c095',
                  'label'         => __('Additional headers', 'wpf'),
                  'name'          => 'additional_headers',
                  'type'          => 'textarea',
                  'default_value' => 'Reply-To: [email]',
                ],
                [
                  'key'           => 'field_wpf04ed8e95f6',
                  'label'         => __('Message', 'wpf'),
                  'name'          => 'message',
                  'type'          => 'textarea',
                  'default_value' => __("From: [name] <[email]>\nMessage:\n[message]\n\n--\n\nThis email was sent automatically by the form.", 'lang'),
                ],
              ],
            ],
            [
              'key'       => 'field_wpf162da84301',
              'label'     => __('Messages', 'wpf'),
              'type'      => 'tab',
              'placement' => 'top',
              'endpoint'  => 0,
            ],
            [
              'key'           => 'field_wpf162e384302',
              'label'         => __('Send success', 'wpf'),
              'name'          => 'messages_send_success',
              'type'          => 'text',
              'required'      => 1,
              'default_value' => __('Thank you for your message. It has been sent.', 'wpf'),
            ],
            [
              'key'           => 'field_wpf1630884303',
              'label'         => __('Send error', 'wpf'),
              'name'          => 'messages_send_error',
              'type'          => 'text',
              'required'      => 1,
              'default_value' => __('The error occurred while sending your message. Please try again later.', 'wpf'),
            ],
            [
              'key'           => 'field_wpfe2339e5d86',
              'label'         => __('Send validate field', 'wpf'),
              'name'          => 'messages_send_error_field',
              'type'          => 'text',
              'instructions'  => __('(use <strong>%s</strong> for show dynamic value)', 'wpf'),
              'required'      => 1,
              'default_value' => __('The error occurred while validating "%s" field. Enter the value again and try submit form.', 'wpf'),
            ],
            [
              'key'           => 'field_wpf1630f84304',
              'label'         => __('Validation error', 'wpf'),
              'name'          => 'messages_send_validate',
              'type'          => 'text',
              'required'      => 1,
              'default_value' => __('One or more fields have an error. Please check and try again.', 'wpf'),
            ],
            [
              'key'           => 'field_wpf16338149de',
              'label'         => __('Required field', 'wpf'),
              'name'          => 'messages_validate_required',
              'type'          => 'text',
              'required'      => 1,
              'default_value' => __('This field is required.', 'wpf'),
            ],
            [
              'key'           => 'field_wpf163f3149e5',
              'label'         => __('Minimum field length', 'wpf'),
              'name'          => 'messages_validate_value_short',
              'type'          => 'text',
              'instructions'  => __('(use <strong>%s</strong> for show dynamic value)', 'wpf'),
              'required'      => 1,
              'default_value' => __('This field must be at least %s characters.', 'wpf'),
            ],
            [
              'key'           => 'field_wpf16400149e6',
              'label'         => __('Maximum field length', 'wpf'),
              'name'          => 'messages_validate_value_long',
              'type'          => 'text',
              'instructions'  => __('(use <strong>%s</strong> for show dynamic value)', 'wpf'),
              'required'      => 1,
              'default_value' => __('This field must be at maximum %s characters.', 'wpf'),
            ],
            [
              'key'           => 'field_wpf163b5149df',
              'label'         => __('Invalid e-mail', 'wpf'),
              'name'          => 'messages_validate_email',
              'type'          => 'text',
              'required'      => 1,
              'default_value' => __('E-mail address is invalid.', 'wpf'),
            ],
            [
              'key'           => 'field_wpf163bd149e0',
              'label'         => __('Incorrect URL', 'wpf'),
              'name'          => 'messages_validate_url',
              'type'          => 'text',
              'required'      => 1,
              'default_value' => __('URL is incorrect.', 'wpf'),
            ],
            [
              'key'           => 'field_wpf163e2149e3',
              'label'         => __('Incorrect number', 'wpf'),
              'name'          => 'messages_validate_number',
              'type'          => 'text',
              'required'      => 1,
              'default_value' => __('This value must be number.', 'wpf'),
            ],
            [
              'key'           => 'field_wpf163cf149e1',
              'label'         => __('Too small number value', 'wpf'),
              'name'          => 'messages_validate_number_min',
              'type'          => 'text',
              'instructions'  => __('(use <strong>%s</strong> for show dynamic value)', 'wpf'),
              'required'      => 1,
              'default_value' => __('This field value must be %s or more.', 'wpf'),
            ],
            [
              'key'           => 'field_wpf163da149e2',
              'label'         => __('Too large number value', 'wpf'),
              'name'          => 'messages_validate_number_max',
              'type'          => 'text',
              'instructions'  => __('(use <strong>%s</strong> for show dynamic value)', 'wpf'),
              'required'      => 1,
              'default_value' => __('This field value must be %s or less.', 'wpf'),
            ],
            [
              'key'           => 'field_wpf41e4f4766d',
              'label'         => __('Invalid step in number', 'wpf'),
              'name'          => 'messages_validate_number_step',
              'type'          => 'text',
              'instructions'  => __('(use <strong>%s</strong> for show dynamic value)', 'wpf'),
              'required'      => 1,
              'default_value' => __('Step value is %s from minimum value.', 'wpf'),
            ],
            [
              'key'           => 'field_wpf163e9149e4',
              'label'         => __('Invalid date format', 'wpf'),
              'name'          => 'messages_validate_date_format',
              'type'          => 'text',
              'instructions'  => __('(use <strong>%s</strong> for show dynamic value)', 'wpf'),
              'required'      => 1,
              'default_value' => __('Date must be in format %s.', 'wpf'),
            ],
            [
              'key'           => 'field_wpf2f4da9bb91',
              'label'         => __('Too early date in range', 'wpf'),
              'name'          => 'messages_date_start',
              'type'          => 'text',
              'required'      => 1,
              'default_value' => __('Date can not be earlier than other date in range.', 'wpf'),
            ],
            [
              'key'           => 'field_wpf2f4a19bb90',
              'label'         => __('Too late date in range', 'wpf'),
              'name'          => 'messages_date_end',
              'type'          => 'text',
              'required'      => 1,
              'default_value' => __('Date can not be later than other date in range.', 'wpf'),
            ],
            [
              'key'           => 'field_wpf16409149e7',
              'label'         => __('Invalid file extension', 'wpf'),
              'name'          => 'messages_validate_file_extension',
              'type'          => 'text',
              'required'      => 1,
              'default_value' => __('Extension of file is invalid.', 'wpf'),
            ],
            [
              'key'           => 'field_wpf16413149e8',
              'label'         => __('Too large file size', 'wpf'),
              'name'          => 'messages_validate_file_size',
              'type'          => 'text',
              'instructions'  => __('(use <strong>%s</strong> for show dynamic value)', 'wpf'),
              'required'      => 1,
              'default_value' => __('Size of file is larger than allowed %sKB.', 'wpf'),
            ],
            [
              'key'           => 'field_wpf1641d149e9',
              'label'         => __('Regex error', 'wpf'),
              'name'          => 'messages_validate_regex',
              'type'          => 'text',
              'required'      => 1,
              'default_value' => __('Field value is invalid.', 'wpf'),
            ],
          ],
          'location' => [
            [
              [
                'param'    => 'post_type',
                'operator' => '==',
                'value'    => 'wpf-contact-forms',
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

  }