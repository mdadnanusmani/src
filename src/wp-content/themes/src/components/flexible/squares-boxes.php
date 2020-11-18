<?php if ($section['items']) : ?> 
  <section class="squaresBoxes section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
    <div class="squaresBoxes__inner">
      <div class="container">
        <h3 class="section__headline hideScroll hideScroll--left"><?= $section['headline']; ?></h3>
        <div class="squaresBoxes__wrapper">
          <div class="squaresBoxes__items">
            <?php foreach ($section['items'] as $index => $item) : ?>
              <div class="squaresBoxes__item squaresBoxes__item--<?= $item['bg_color']; ?>">
                <div class="squaresBoxes__itemOuter hideScroll">
                  <div class="squaresBoxes__itemInner">
                    <div class="squaresBoxes__itemIcon icon-<?= $item['icon']; ?>"></div>
                    <h5 class="squaresBoxes__itemTitle"><?= $item['title']; ?></h5>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>