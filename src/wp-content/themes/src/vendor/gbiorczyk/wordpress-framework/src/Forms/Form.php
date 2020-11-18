<?php

  namespace Framework\Forms;

  class Form {

    private $core, $globalVue, $loadedScripts;

    public function __construct($core, $globalVue = false) {

      $this->core      = $core;
      $this->globalVue = $globalVue;

      add_filter('wpf_contact_form', [$this, 'loadForm'], 10, 1);

    }

    /* ---
      Functions
    --- */

      public function loadForm($formID) {

        if (!$formID)
          return;

        $fields   = get_field('fields',   $formID);
        $content  = get_field('template', $formID);
        $settings = [
          'classes' => [
            'input_error'    => get_field('settings_class_input_error', $formID),
            'submit_error'   => get_field('settings_class_submit_error', $formID),
            'submit_success' => get_field('settings_class_submit_success', $formID)
          ]
        ];

        if (!$fields || !$content)
          return;

        $fieldsClass = new Fields();
        $content     = $fieldsClass->printFields($content, $fields, $settings, $formID);

        $scriptsClass = new Scripts($this->core);
        $scriptsClass->loadScripts($formID, $fields, $this->globalVue, $this->loadedScripts);

        $this->globalVue     = false;
        $this->loadedScripts = true;

        $output = '<div id="wpf-contact-form-' . $formID . '" data-form-id="' . $formID . '">';
          $output .= '<form class="vue-form" v-on:submit.prevent="onSubmit" novalidate>';
            $output .= $content;
          $output .= '</form>';
        $output .= '</div>';

        return $output;

      }

  }