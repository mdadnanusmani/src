<?php

  namespace Framework\Translate;

  class Optionspages {

    public $notranslate;

    public function __construct() {

      add_filter('acf/settings/current_language', [$this, 'getCurrentLang'],  77);
      add_filter('acf/load_value',                [$this, 'setDefaultValue'], 10, 3);
      add_action('admin_notices',                 [$this, 'showAdminNotice'], 77);
      add_action('init',                          [$this, 'disableTranslate']);

    }

    /* ---
      Functions
    --- */

      public function getCurrentLang() {

        $lang = pll_current_language('locale');
        return $lang ? $lang : get_locale();

      }

      public function setDefaultValue($value, $postID, $field) {

        if (strpos($postID, 'options') === false)
          return $value;

        if (!is_null($value)) {

          if (is_array($value)) {

            $isEmpty = array_filter($value, function($content) {
              return $content !== '';
            });

            if (!empty($isEmpty))
              return $value;

          } else {

            if ($value !== '')
              return $value;

          }

        }

        remove_filter('acf/settings/current_language', [$this, 'getCurrentLang'],  77);
        remove_filter('acf/load_value',                [$this, 'setDefaultValue'], 10);

        $value = get_field($field['name'], 'options');

        add_filter('acf/settings/current_language', [$this, 'getCurrentLang'],  77);
        add_filter('acf/load_value',                [$this, 'setDefaultValue'], 10, 3);

        $this->disableTranslate();

        return $value;

      }

      public function showAdminNotice() {

        if (!isset($_GET['page']) || ((substr($_GET['page'], 0, 8) != 'options-') && (substr($_GET['page'], 0, 4) != 'wpf-')))
          return;

        ?>
          <div class="notice notice-info">
            <p><?= __('Remember that settings saved on this page apply only to currently selected language. Change it using switch on top bar to configure settings for other languages.', 'wpf'); ?></p>
          </div>
        <?php

      }

      public function disableTranslate() {

        if (!$this->notranslate || !is_admin() || !isset($_GET['page']) || !in_array($_GET['page'], $this->notranslate))
          return;

        remove_all_filters('acf/settings/current_language', 77);
        remove_all_filters('admin_notices', 77);

      }

  }