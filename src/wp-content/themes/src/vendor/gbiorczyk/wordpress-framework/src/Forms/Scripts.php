<?php

  namespace Framework\Forms;

  class Scripts {

    private $core;
    private $formID, $fields = [], $loadedScripts;

    public function __construct($core, $globalVue = false) {

      $this->core = $core;

      if (!$globalVue)
        return;

      add_action('wp_footer', [$this, 'disableWpEmbed']);
      add_action('wp_footer', [$this, 'loadVueJs'], 77);

    }

    /* ---
      Actions
    --- */

      public function loadScripts($formID, $fields, $loadedVue, $loadedScripts) {

        $this->formID        = $formID;
        $this->fields        = $fields;
        $this->loadedScripts = $loadedScripts;

        if (!$loadedVue && !$loadedScripts) {

          add_action('wp_footer', [$this, 'disableWpEmbed']);
          add_action('wp_footer', [$this, 'loadVueJs'], 77);

        }

        add_action('wp_footer', [$this, 'showScripts'], 77);

      }

    /* ---
      Functions
    --- */

      public function disableWpEmbed() {

        wp_dequeue_script('wp-embed');

      }

      public function loadVueJs() {

        ?>
          <script src="<?= WPF_ASSETS . 'Forms/Scripts.js'; ?>"></script>
        <?php

      }

      public function showScripts() {

        $messages   = $this->getMessages($this->formID);
        $fields     = [];
        $fieldsKeys = [];

        foreach ($this->fields as $field) {

          $key          = $field['name'];
          $fields[$key] = !in_array($field['type'], ['multiselect', 'checkbox', 'file']) ? '' : [];

          if (isset($field['values_default']) && $field['values_default'])
            $fields[$key] = is_array($fields[$key]) ? explode('|', $field['values_default']) : $field['values_default'];

        }

        $config = [
          'is_localhost'   => in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']),
          'ajax_url'       => admin_url('admin-ajax.php') . '?action=wpf_forms',
          'form_id'        => $this->formID,
          'data'           => [
            'form'     => $fields,
            'response' => [
              'submit_error'   => '',
              'submit_success' => ''
            ],
            'status'   => [
              'errors'            => false,
              'errors_validation' => false,
              'errors_response'   => false,
              'sending'           => false,
              'sent'              => false
            ]
          ],
          'fields_keys'    => array_keys($fields),
          'messages'       => $messages,
          'recaptcha_key'  => $this->getRecaptchaField($this->fields),
          'inst_extension' => get_field('settings_instance_extension', $this->formID)
        ];

        ?>
          <script>
            (function() {
              new WordPressFramework_Forms_Scripts(<?= json_encode($config); ?>);
            }());
          </script>
        <?php

      }

      private function getMessages($formID) {

        $list = [
          'send'     => [
            'success'  => get_field('messages_send_success', $formID),
            'error'    => get_field('messages_send_error', $formID),
            'validate' => get_field('messages_send_validate', $formID)
          ],
          'validate' => [
            'after'       => get_field('messages_date_end', $formID),
            'before'      => get_field('messages_date_start', $formID),
            'date_format' => get_field('messages_validate_date_format', $formID),
            'email'       => get_field('messages_validate_email', $formID),
            'ext'         => get_field('messages_validate_file_extension', $formID),
            'max'         => get_field('messages_validate_value_long', $formID),
            'max_value'   => get_field('messages_validate_number_max', $formID),
            'min'         => get_field('messages_validate_value_short', $formID),
            'min_value'   => get_field('messages_validate_number_min', $formID),
            'numeric'     => get_field('messages_validate_number', $formID),
            'regex'       => get_field('messages_validate_regex', $formID),
            'required'    => get_field('messages_validate_required', $formID),
            'size'        => get_field('messages_validate_file_size', $formID),
            'url'         => get_field('messages_validate_url', $formID),
            'step'        => get_field('messages_validate_number_step', $formID)
          ]
        ];

        return $list;

      }

      private function getRecaptchaField($fields) {

        foreach ($fields as $field) {

          if ($field['type'] == 'recaptcha')
            return $field['name'];

        }

        return '';

      }

  }