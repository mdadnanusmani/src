<?php

  $user = apply_filters('intranet_user', wp_get_current_user());

?>
<a href="<?= wp_logout_url(home_url('/')); ?>" class="header__logout"><?= __('Log out'); ?></a>
<?php if ($user) : ?>
  <a href="<?= get_post_type_archive_link('intranet'); ?>" class="header__profile">
    <div class="header__profileImage" style="background-image: url(<?= $user['image']; ?>);"></div>
    <div class="header__profileText"><?= sprintf(__('Welcome, %s!', 'lang'), $user['name']); ?></div>
  </a>
<?php endif;