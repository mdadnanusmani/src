<?php

  namespace Framework\Forms;

  class Validate {

    /* ---
      Functions
    --- */

      public function getVueValidation($field) {

        $validation = [];

        /* ---
          Required
        --- */

          if (in_array($field['type'], ['recaptcha']) || $field['validate_required'])
            $validation[] = 'required';

        /* ---
          Length
        --- */

          if (in_array($field['type'], ['text', 'textarea'])) {

            if ($field['validate_length_min'] != '')
              $validation[] = 'min:' . $field['validate_length_min'];

            if ($field['validate_length_max'] != '')
              $validation[] = 'max:' . $field['validate_length_max'];

          }

        /* ---
          Number
        --- */

          if (in_array($field['type'], ['number'])) {

            $validation[] = 'numeric';

            if ($field['number_min'] != '')
              $validation[] = 'min_value:' . $field['number_min'];

            if ($field['number_max'])
              $validation[] = 'max_value:' . $field['number_max'];

            if ($field['number_step'])
              $validation[] = 'step:' . implode(',', [$field['number_step'], $field['number_min']]);

          }

        /* ---
          Date
        --- */

          if (in_array($field['type'], ['date', 'time', 'datetime'])) {

            if ($field['type'] == 'date')
              $validation[] = 'date_format:YYYY-MM-DD';
            else if ($field['type'] == 'time')
              $validation[] = 'date_format:HH:ss';
            else if ($field['type'] == 'datetime')
              $validation[] = 'date_format:YYYY-MM-DD HH:ss';

            if ($field['date_before'])
              $validation[] = 'before:' . $field['date_before'] . ',true';

            if ($field['date_after'])
              $validation[] = 'after:' . $field['date_after'] . ',true';

          }

        /* ---
          File
        --- */

          if (in_array($field['type'], ['file'])) {

            if ($field['validate_file_size'])
              $validation[] = 'size:' . $field['validate_file_size'];

            if ($field['validate_file_extensions']) {

              $extensions = [];
              foreach ($field['validate_file_extensions'] as $value)
                $extensions[] = $value['label'];

              $validation[] = 'ext:' . implode(',', $extensions);

            }

          }

        /* ---
          Regex
        --- */

          if (in_array($field['type'], ['text', 'email', 'url', 'tel', 'number', 'range']) && $field['validate_regex'])
            $validation[] = 'regex:\'' . $field['validate_regex'] . '\'';

        /* ---
          File type
        --- */

          if (in_array($field['type'], ['email']))
            $validation[] = 'email';

          if (in_array($field['type'], ['url']))
            $validation[] = 'url';

        return $validation;

      }

      public function validateField($field, $value, $values) {

        /* ---
          Required
        --- */

          if (in_array($field['type'], ['recaptcha']) || $field['validate_required']) {

            if (($value === '') || ($value === []))
              return;

          }

        /* ---
          Length
        --- */

          if (in_array($field['type'], ['text', 'textarea'])) {

            if (!empty($field['validate_length_min']) && (strlen($value) < $field['validate_length_min']))
              return;

            if (!empty($field['validate_length_max']) && (strlen($value) > $field['validate_length_max']))
              return;

          }

        /* ---
          Number
        --- */

          if (in_array($field['type'], ['number'])) {

            if (!preg_match('/^[0-9]+(\.[0-9]+)?$/i', $value))
              return;

            if (!empty($field['number_min']) && ($value < $field['number_min']))
                return;

            if (!empty($field['number_max']) && ($value > $field['number_max']))
                return;

            if ($field['number_step']) {

              $number = ($value - $field['number_min']) * 1e5;
              $step   = $field['number_step'] * 1e5;

              if (fmod($number, $step) != 0)
                return;

            }

          }

        /* ---
          Date
        --- */

          if (in_array($field['type'], ['date'])) {

            if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value) || (\DateTime::createFromFormat('Y-m-d', $value)->format('Y-m-d') !== $value))
              return;

            if (!empty($field['date_before']) && (strtotime($value) > strtotime($values[$field['date_before']])))
              return;

            if (!empty($field['date_after']) && (strtotime($value) < strtotime($values[$field['date_after']])))
              return;

          }

        /* ---
          File
        --- */

          if (in_array($field['type'], ['file'])) {

            foreach ($value as $file) {

              if (!isset($file['tmp_name']) || !isset($file['name']) || !is_readable($file['tmp_name']) || !is_file($file['tmp_name']))
                return;

              if ($field['validate_file_size'] && (filesize($file['tmp_name']) > ($field['validate_file_size'] * 1024)))
                return;

              if ($field['validate_file_extensions']) {

                $types = array_column($field['validate_file_extensions'], 'value');
                $exts  = array_column($field['validate_file_extensions'], 'label');
                $type  = mime_content_type($file['tmp_name']);
                $ext   = pathinfo($file['name'], PATHINFO_EXTENSION);

                if (!in_array($type, $types) || !in_array($ext, $exts))
                  return;

              }

            }

          }

        /* ---
          Regex
        --- */

          if (in_array($field['type'], ['text', 'email', 'url', 'tel', 'number', 'range']) && $field['validate_regex']) {

            if (!preg_match('/' . $field['validate_regex'] . '/', $value))
              return;

          }

        /* ---
          File type
        --- */

          if (in_array($field['type'], ['email']) && !filter_var($value, FILTER_VALIDATE_EMAIL))
            return;

          if (in_array($field['type'], ['url']) && !filter_var($value, FILTER_VALIDATE_URL))
            return;

        /* ---
          reCAPTCHA
        --- */

          if (in_array($field['type'], ['recaptcha'])) {

            $url = sprintf(
              'https://www.google.com/recaptcha/api/siteverify?secret=%s&response=%s&remoteip=%s',
              $field['recapchta_secret'],
              $value,
              isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : ''
            );
            $content  = file_get_contents($url);
            $response = json_decode($content, true);

            if (!isset($response['success']) || !$response['success'])
              return;

          }

        return true;

      }

  }