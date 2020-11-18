<?php if ($section['items']) : ?> 
  <section class="textCircle section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
    <div class="textCircle__inner">
      <div class="container">
        <h3 class="section__headline hideScroll hideScroll--left"><?= $section['headline']; ?></h3>
        <div class="textCircle__wrapper">
          <div class="textCircle__items">
            <div class="textCircle__item textCircle__item--blank textCircle__item--topLeft hideScroll hideScroll--left">
              <img src="<?= get_template_directory_uri(); ?>/assets/img/circle-top-left.png" class="textCircle__itemArrows" alt="">
            </div>
            <div class="textCircle__item hideScroll">
              <h3 class="textCircle__itemTitle"><?= $section['items'][0]['title']; ?></h3>
              <div class="textCircle__itemDesc"><?= $section['items'][0]['desc']; ?></div>
            </div>
            <div class="textCircle__item textCircle__item--blank textCircle__item--topRight hideScroll hideScroll--right">
              <img src="<?= get_template_directory_uri(); ?>/assets/img/circle-top-right.png" class="textCircle__itemArrows" alt="">
            </div>
            <div class="textCircle__item hideScroll hideScroll--left">
              <h3 class="textCircle__itemTitle"><?= $section['items'][1]['title']; ?></h3>
              <div class="textCircle__itemDesc"><?= $section['items'][1]['desc']; ?></div>
            </div>
            <div class="textCircle__item textCircle__item--blank hideScroll">
              <img src="<?= $section['image_in_middle']['url']; ?>" class="textCircle__itemLogo" alt="">
            </div>
            <div class="textCircle__item hideScroll hideScroll--right">
              <h3 class="textCircle__itemTitle"><?= $section['items'][2]['title']; ?></h3>
              <div class="textCircle__itemDesc"><?= $section['items'][2]['desc']; ?></div>
              </div>
            <div class="textCircle__item textCircle__item--blank textCircle__item--bottomLeft hideScroll hideScroll--left">
              <img src="<?= get_template_directory_uri(); ?>/assets/img/circle-bottom-left.png" class="textCircle__itemArrows" alt="">
            </div>
            <div class="textCircle__item hideScroll">
              <h3 class="textCircle__itemTitle"><?= $section['items'][3]['title']; ?></h3>
              <div class="textCircle__itemDesc"><?= $section['items'][3]['desc']; ?></div>
            </div>
            <div class="textCircle__item textCircle__item--blank textCircle__item--bottomRight hideScroll hideScroll--right">
              <img src="<?= get_template_directory_uri(); ?>/assets/img/circle-bottom-right.png" class="textCircle__itemArrows" alt="">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>