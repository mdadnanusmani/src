<?php

  namespace Framework\Forms;

  class Ajax {

    private $core;

    public function __construct($core) {

      $this->core = $core;

      add_action('wp_ajax_wpf_forms',        [$this, 'sendForm']);
      add_action('wp_ajax_nopriv_wpf_forms', [$this, 'sendForm']);

    }

    /* ---
      Functions
    --- */

      public function sendForm() {

        $formID = isset($_POST['wpf_form_id']) ? $_POST['wpf_form_id'] : null;

        try {

          /* ---
            Check form ID
          --- */

            if (!$formID || is_integer($formID))
              throw new \Exception(sprintf('Undefined form ID', $formID));

          /* ---
            Check form fields
          --- */

            $fields = get_field('fields', $formID);

            if (!$fields)
              throw new \Exception(sprintf('Form [#%s] not found', $formID));

          /* ---
            Fields validation
          --- */

            $data = new Data();
            $list = $data->getFormValues($formID, $fields);

            if (!is_array($list)) {

              $e = new \Exception(sprintf('Data validation', $formID));
              $e->data = $list;
              throw $e;

            }

          /* ---
            Send actions
          --- */

            $response = $this->initActions($formID, $fields, $list);
            $data->clearFormData();

            if ($response === true)
              wp_send_json_success();
            else
              wp_send_json_error($response);

        } catch (\Exception $error) {

          error_log(sprintf(
            'WordPress Framework: error `%s` when sending form in Framework\\Forms\\Ajax',
            $error->getMessage()
          ));

          $response = isset($error->data) ? $error->data : get_field('messages_send_error', $formID);
          wp_send_json_error($response);

        }

      }

      private function initActions($formID, $fields, $values) {

        $error  = get_field('messages_send_error', $formID);
        $filter = $this->sendFilters($formID, $fields, $values);

        if (!is_null($filter) && ($filter !== true))
          return $filter;

        $email    = $this->sendEmails($formID, $values);
        $response = ((($filter === true) && ($email !== false)) || ($email === true));

        if ($response === true)
          return true;
        else
          return get_field('messages_send_error', $formID);

      }

      private function sendFilters($formID, $fields, $values) {

        $status  = null;
        $filters = [
          'wpf_forms_send_' . $formID,
          'wpf_forms_send'
        ];

        foreach ($filters as $filter) {

          if (!has_filter($filter))
            continue;

          $status = apply_filters($filter, $formID, $fields, $values);
          $status = is_null($status) ? false : $status;

          if ($status !== true)
            return $status;

        }

        return $status;

      }

      private function sendEmails($formID, $values) {
        
        $list = get_field('mail_list', $formID);

        if (!$list)
          return null;

        foreach ($list as $email) {

          $mail = new Email($formID, $values, $email);

          if (!$mail->sendEmail())
            return false;

        }

        return true;

      }

  }