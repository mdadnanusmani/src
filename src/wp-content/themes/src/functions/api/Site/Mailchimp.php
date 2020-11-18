<?php

  namespace SiteManagement\Site;

  class Mailchimp {

    public function __construct() {

      $this->initIntegration();

    }

    /* ---
      Functions
    --- */

      private function initIntegration() {

        $settings = get_field('mailchimp', 'option');
        $formID   = (isset($settings['newsletter_id']) && $settings['newsletter_id']) ? $settings['newsletter_id'] : false;

        if (!$formID)
          return;

        add_filter('wpf_forms_send_' . $formID, [$this, 'mailchimpIntegration'], 10, 3);

      }

      public function mailchimpIntegration($formID, $fields, $values) {

        $settings = get_field('mailchimp', 'option');

        if (($settings['newsletter_id'] != $formID) || !isset($values['fields']['email']))
          return;

        $ch   = curl_init();
        $data = json_encode([
          'email_address' => $values['fields']['email'],
          'status'        => 'pending'
        ]);
        $headers = [
          'Content-Type: application/json',
          'Authorization: Basic ' . $settings['api_key']
        ];

        curl_setopt($ch, CURLOPT_URL, $settings['url']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result   = curl_exec($ch);
        $response = json_decode($result, true);

        if (!$response || !isset($response['status']))
          return;

        if ($response['status'] === 400)
          return sprintf(__('%s is already a list member.', 'lang'), $values['fields']['email']);

        return ($response['status'] === 'pending');

      }

  }