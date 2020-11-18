<?php if ($section['items']) : ?> 
  <section class="animatedIcons section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
    <div class="animatedIcons__inner">
      <div class="container">
        <div class="row row--flex">
          <div class="col-6 col-mdl-12">
            <div class="animatedIcons__circleWrapper hideScroll hideScroll--left">
              <div class="animatedIcons__circleInner">
                <div class="animatedIcons__items">
                  <?php foreach ($section['items'] as $index => $item) : ?>
                    <a href="#" class="animatedIcons__item <?= ($index == 0) ? 'animatedIcons__item--active' : ''; ?> icon-<?= $item['icon']; ?>" data-hover="blue"></a>
                  <?php endforeach; ?>
                </div>
                <div class="animatedIcons__arrows">
                  <?php foreach ($section['items'] as $index => $item) : ?>
                    <a href="#" class="animatedIcons__arrow <?= ($index == 0) ? 'animatedIcons__arrow--active' : ''; ?>"></a>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
          <div class="animatedIcons__contentWrapper col-6 col-mdl-12">
            <?php foreach ($section['items'] as $index => $item) : ?>
              <div class="animatedIcons__content <?= ($index == 0) ? 'animatedIcons__content--active' : ''; ?> hideScroll">
                <div class="wysiwyg wysiwyg--large"><?= $item['content']; ?></div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>