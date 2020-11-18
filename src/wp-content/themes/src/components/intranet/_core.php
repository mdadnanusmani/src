<?php

  $data  = apply_filters('intranet_data',  null);
  $user  = apply_filters('intranet_user',  wp_get_current_user());
  $users = apply_filters('intranet_users', null);

?>
<section class="intranetProfile">
  <div class="intranetProfile__inner">
    <div class="container">
      <div class="row row--flex">
        <div class="col-8 col-lg-6 col-mdl-12">
          <div class="intranetProfile__content">
            <?php

              include 'news.php';
              include 'links.php';
              include 'tabs.php';

            ?>
          </div>
        </div>
        <div class="col-4 col-lg-6 col-mdl-12">
          <div class="intranetProfile__side">
            <div class="intranetProfile__sideOuter">
              <div class="intranetProfile__sideInner">
                <div class="intranetProfile__profile">
                  <?php include 'profile.php'; ?>
                </div>
                <?php if ($users) : ?>
                  <div class="intranetProfile__search">
                    <form action="" class="intranetProfile__searchForm">
                      <input type="text" class="intranetProfile__searchInput" placeholder="<?= __('Search...' ,'lang'); ?>">
                      <button type="submit" class="intranetProfile__searchButton"></button>
                    </form>
                  </div>
                  <div class="intranetProfile__contactItems">
                    <?php foreach ($users as $user) : ?>
                      <div class="intranetProfile__contactItem">
                        <?php include 'profile.php'; ?>
                      </div>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>