<?php

  namespace Framework\Translate;

  class Js {

    private $list;

    public function __construct() {

      add_action('admin_head', [$this, 'showFrameworkPhrases']);

    }

    /* ---
      Actions
    --- */

      public function translateJs($list) {

        $this->list = $list;

        add_action('wp_head',    [$this, 'showTranslatedPhrases']);
        add_action('admin_head', [$this, 'showTranslatedPhrases']);

      }

    /* ---
      Functions
    --- */

      public function showFrameworkPhrases() {

        $translate = [
          'acf_flexible_expand' => __('Expand', 'wpf'),
          'polylang_switcher'   => __('Are you sure you want to change language of this page? If you want to only edit translation of current page for another language, go to post archive and choose variant in different language there.', 'wpf')
        ];

        ?>
          <script>
            if (typeof wpF === 'undefined')
              var wpF = {};

            wpF.adminTranslate = JSON.parse('<?= json_encode($translate); ?>');
          </script>
        <?php

      }

      public function showTranslatedPhrases() {

        ?>
          <script>
            if (typeof wpF === 'undefined')
              var wpF = {};

            wpF.translate = JSON.parse('<?= json_encode($this->list); ?>');
          </script>
        <?php

      }

  }