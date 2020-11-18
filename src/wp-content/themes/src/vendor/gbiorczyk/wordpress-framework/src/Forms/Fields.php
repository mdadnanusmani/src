<?php

  namespace Framework\Forms;

  class Fields {

    /* ---
      Functions
    --- */

      public function printFields($content, $fields, $settings, $formID) {

        $fields = $this->checkFields($fields);

        foreach ($fields as $field) {

          $content = str_replace(
            '[' . $field['name'] . ']',
            $this->getField($field, $settings, $formID),
            $content
          );

          $this->fields[$field['name']] = ($field['type'] != 'file') ? '' : [];

        }

        $content = str_replace(
          '[submit_error]',
          sprintf(
            '<div class="%s" v-show="status.errors && response.submit_error">{{ response.submit_error }}</div>',
            $settings['classes']['submit_error']
          ),
          $content
        );

        $content = str_replace(
          '[submit_success]',
          sprintf(
            '<div class="%s" v-show="!status.errors && response.submit_success">{{ response.submit_success }}</div>',
            $settings['classes']['submit_success']
          ),
          $content
        );

        return $content;

      }

      private function checkFields($fields) {

        $uniqueNames     = [];
        $recaptchaExists = false;

        foreach ($fields as $key => $field) {

          if ($field['type'] == 'recaptcha') {

            if ($recaptchaExists) {

              unset($fields[$key]);
              error_log(sprintf(
                'WordPress Framework: duplicated reCAPTCHA field named `%s` in Framework\\Forms\\Form',
                $field['name']
              ));

            }

            $recaptchaExists = true;

          }

          if (in_array($field['name'], $uniqueNames)) {

            unset($fields[$key]);
            error_log(sprintf(
              'WordPress Framework: duplicated field name `%s` in Framework\\Forms\\Form',
              $field['name']
            ));

          }

          $uniqueNames[] = $field['name'];

        }

        return $fields;

      }

    /* ---
      Field
    --- */

      private function getField($field, $settings, $formID) {

        $html     = '';
        $validate = new Validate();
        $validate = $validate->getVueValidation($field);
        $inputID  = sprintf('wpf-%s-%s', $formID, $field['name']);

        if (in_array($field['type'], ['text', 'email', 'url', 'tel'])) {

          $html = sprintf(
            '<input type="%s" id="%s" name="%s" v-model="form.%s" ref="%s" class="%s" placeholder="%s" v-validate="\'%s\'">',
            $field['type'],
            $inputID,
            $field['name'],
            $field['name'],
            $field['name'],
            $field['classes'],
            $field['placeholder'],
            implode('|', $validate)
          );

        } else if (in_array($field['type'], ['number'])) {

          $html = sprintf(
            '<input type="%s" id="%s" name="%s" v-model="form.%s" ref="%s" class="%s" placeholder="%s" v-validate="\'%s\'" min="%s" max="%s" step="%s">',
            $field['type'],
            $inputID,
            $field['name'],
            $field['name'],
            $field['name'],
            $field['classes'],
            $field['placeholder'],
            implode('|', $validate),
            $field['number_min'],
            $field['number_max'],
            $field['number_step']
          );

        } else if (in_array($field['type'], ['date', 'time', 'datetime'])) {

          $html = sprintf(
            '<input type="text" id="%s" name="%s" v-model="form.%s" ref="%s" class="%s" v-validate="\'%s\'" autocomplete="off">',
            $inputID,
            $field['name'],
            $field['name'],
            $field['name'],
            $field['classes'],
            implode('|', $validate)
          );

        } else if ($field['type'] == 'textarea') {

          $html = sprintf(
            '<textarea id="%s" name="%s" v-model="form.%s" ref="%s" class="%s" placeholder="%s" v-validate="\'%s\'"></textarea>',
            $inputID,
            $field['name'],
            $field['name'],
            $field['name'],
            $field['classes'],
            $field['placeholder'],
            implode('|', $validate)
          );

        } else if (in_array($field['type'], ['select', 'multiselect'])) {

          $html = sprintf(
            '<select id="%s" name="%s" v-model="form.%s" ref="%s" class="%s" v-validate="\'%s\'"%s>%s</select>',
            $inputID,
            $field['name'],
            $field['name'],
            $field['name'],
            $field['classes'],
            implode('|', $validate),
            ($field['type'] == 'multiselect') ? ' multiple' : '',
            implode(PHP_EOL, $this->getSelectOptions($field))
          );

        } else if (in_array($field['type'], ['checkbox', 'radio'])) {

          foreach ($field['values'] as $index => $value) {

            $html .= sprintf(
              '<input type="%s" id="%s" name="%s" v-model="form.%s" ref="%s" class="%s" value="%s" v-validate="\'%s\'">
              <label for="%s">%s</label>',
              $field['type'],
              sprintf('%s-%s', $inputID, $index),
              $field['name'],
              $field['name'],
              $field['name'],
              $field['classes'],
              $value['value'],
              implode('|', $validate),
              sprintf('%s-%s', $inputID, $index),
              (($field['type'] == 'radio') && $value['label']) ? $value['label'] : $value['value']
            );

          }

        } else if ($field['type'] == 'file') {

          $extensions = [];
          foreach ($field['validate_file_extensions'] as $value)
            $extensions[] = $value['value'];

          $html = sprintf(
            '<input type="file" id="%s" name="%s" ref="%s" class="%s" v-validate="\'%s\'" accept="%s" %s v-on:change="uploadFiles(\'%s\', %s)">',
            $inputID,
            $field['name'],
            $field['name'],
            $field['classes'],
            implode('|', $validate),
            implode(',', $extensions),
            $field['validate_file_multiple'] ? 'multiple' : '',
            $field['name'],
            $field['validate_file_multiple'] ? 'true' : 'false'
          );

        } else if ($field['type'] == 'recaptcha') {

          $html = sprintf(
            '<vue-recaptcha ref="%s" class="%s" @verify="onCaptchaVerified" @expired="onCaptchaExpired" sitekey="%s"></vue-recaptcha>
            <input type="hidden" ref="%s" name="%s" v-validate="\'%s\'">',
            $field['name'] . '-widget',
            $field['classes'],
            $field['recapchta_site_key'],
            $field['name'],
            $field['name'],
            implode('|', $validate)
          );

        }

        if (!$html)
          return '';

        $html .= PHP_EOL;
        $html .= sprintf(
          '<div class="%s" v-show="errors.has(\'%s\')">{{ errors.first(\'%s\') }}</div>',
          $settings['classes']['input_error'],
          $field['name'],
          $field['name']
        );

        return $html;
      }

      private function getSelectOptions($field) {

        $options = [];

        if ($field['select_first_empty']) {

          $options[] = sprintf(
            '<option disabled value="">%s</option>',
            $field['placeholder']
          );

        }

        if (!$field['is_values_group']) {

          $options = array_merge($options, $this->getSelectOptionsList($field, $field['values']));

        } else {

          foreach ($field['values'] as $value) {

            $options[] = sprintf(
              '<optgroup label="%s">%s</optgroup>',
              $value['value'],
              implode(PHP_EOL, $this->getSelectOptionsList($field, $value['list']))
            );

          }

        }

        return $options;

      }

      private function getSelectOptionsList($field, $list) {

        $options  = [];
        $isLabels = (isset($field['is_different_labels']) && $field['is_different_labels']);

        foreach ($list as $value) {

          $options[] = sprintf(
            '<option value="%s">%s</option>',
            $value['value'],
            (($field['type'] == 'select') && $isLabels && $value['label']) ? $value['label'] : $value['value']
          );

        }

        return $options;

      }

  }