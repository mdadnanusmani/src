<header class="header <?= (is_post_type_archive('intranet') || is_singular('intranet')) ? 'header--intranet' : ''; ?>">
  <div class="header__inner">
    <div class="container">
      <div class="header__wrapper">
        <?php

          get_template_part('components/layout/header/logo');

          if (!is_post_type_archive('intranet') && !is_singular('intranet'))
            get_template_part('components/layout/header/menu');
          else
            get_template_part('components/layout/header/intranet');

        ?>
      </div>
    </div>
  </div>
</header>