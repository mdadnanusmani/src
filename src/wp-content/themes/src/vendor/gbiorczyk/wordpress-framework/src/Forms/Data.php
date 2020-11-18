<?php

  namespace Framework\Forms;

  class Data {

    private $files;
    private $filesList = [];

    public function __construct() {

      $this->files = new Files();

    }

    /* ---
      Functions
    --- */

      public function getFormValues($formID, $fields) {

        $list = $this->getValuesList($fields);

        try {

          if (!is_array($list)) {

            $message = sprintf(get_field('messages_send_error_field', $formID), $list);
            throw new \Exception($message);

          }

          /* ---
            Validate filters
          --- */

            $filters = $this->validateFilters($formID, $fields, $list);

            if ($filters !== true)
              throw new \Exception($filters);

          /* ---
            Values filters
          --- */

            if (has_filter('wpf_forms_values_' . $formID))
              $list = apply_filters('wpf_forms_values_' . $formID, $formID, $fields, $list);

            if (has_filter('wpf_forms_values'))
              $list = apply_filters('wpf_forms_values', $formID, $fields, $list);

          return $list;

        } catch (\Exception $error) {

          $this->clearFormData();

          $message = $error->getMessage();
          $message = $message ? $message : get_field('messages_send_validate', $formID);
          return $message;

        }

      }

      private function getValuesList($fields) {

        $validate = new Validate();
        $values   = $this->getFormData($fields);
        $list     = [
          'fields' => [],
          'files'  => []
        ];

        foreach ($fields as $field) {

          $key = $field['name'];

          if (!$validate->validateField($field, $values[$key], $values))
            return $key;

          if (in_array($field['type'], ['recaptcha']))
            continue;

          $data = $values[$key];

          if ($field['type'] == 'file') {

            $files           = $this->files->uploadFiles($values[$key]);
            $data            = array_column($files, 'file');
            $list['files']   = array_merge($list['files'], array_column($files, 'path'));
            $this->filesList = array_merge($this->filesList, array_column($files, 'path'));

          }

          if (in_array($field['type'], ['select', 'radio'])) {

            foreach ($field['values'] as $value) {

              if ($value['value'] == $data)
                $list['fields'][$key . '__label'] = $value['label'];

            }

          }

          $list['fields'][$key] = $data;

        }

        return $list;

      }

      private function getFormData($fields) {

        $list = [];

        foreach ($fields as $field) {

          $key = $field['name'];
        
          if (!in_array($field['type'], ['file']))
            $list[$key] = isset($_POST[$key]) ? $_POST[$key] : '';
          else
            $list[$key] = $this->files->getFieldFiles($key);

        }

        return $list;

      }

      private function validateFilters($formID, $fields, $list) {

        if (has_filter('wpf_forms_validation_' . $formID)) {

          $response = apply_filters('wpf_forms_validation_' . $formID, $formID, $fields, $list);

          if ($response !== true)
            return $response;

        }

        if (has_filter('wpf_forms_validation')) {

          $response = apply_filters('wpf_forms_validation', $formID, $fields, $list);

          if ($response !== true)
            return $response;

        }

        return true;

      }

      public function clearFormData() {

        $this->files->removeFiles($this->filesList);

      }

  }