<?php

  namespace Framework\Forms;

  class Email {

    private $data;

    public function __construct($formID, $values, $config) {

      $this->data = $this->getEmailData($formID, $values, $config);

    }

    /* ---
      Data
    --- */

      private function getEmailData($formID, $values, $config) {

        $data = [
          'to'          => $this->printData($config['to'], $values),
          'subject'     => $this->printData($config['subject'], $values),
          'message'     => $this->printData($config['message'], $values),
          'headers'     => $this->getHeaders($config, $values),
          'attachments' => $values['files']
        ];

        if (has_filter('wpf_forms_email_' . $formID))
          $data = apply_filters('wpf_forms_email_' . $formID, $formID, $values, $data);

        if (has_filter('wpf_forms_email'))
          $data = apply_filters('wpf_forms_email', $formID, $values, $data);

        return $data;

      }

      private function printData($content, $values) {

        foreach ($values['fields'] as $key => $value) {

          if (is_array($value)) {

            if (count($value) > 1)
              $value = '- ' . implode(PHP_EOL . '- ', $value);
            else
              $value = implode(PHP_EOL, $value);

          }

          $content = str_replace('[' . $key . ']', $value, $content);

        }

        return $content;

      }

      private function getHeaders($email, $values) {

        $list = [];

        $list[] = 'From: ' . $email['from'];
        $list   = array_merge($list, explode(PHP_EOL, $email['additional_headers']));

        foreach ($list as $key => $header)
          $list[$key] = $this->printData($header, $values);

        $list = implode(PHP_EOL, $list);

        return $list;

      }

    /* ---
      Sending
    --- */

      public function sendEmail() {

        if (!$this->data)
          return;

        $response = wp_mail(
          $this->data['to'],
          $this->data['subject'],
          $this->data['message'],
          $this->data['headers'],
          $this->data['attachments']
        );

        return $response;

      }

  }