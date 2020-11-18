<?php

  $color    = get_field('product_color');
  $sections = get_field('sections');

  if ($sections) :

?>
  <section class="productInfo productInfo--<?= $color; ?> section">
    <div class="productInfo__inner">
      <div class="container">
        <div class="productInfo__items">
          <?php foreach ($sections as $index => $section) : ?>
            <?php if ($section['acf_fc_layout'] == 'text') : ?>
              <div class="productInfo__item hideScroll hideScroll--<?= ($index % 2 == 0) ? 'left' : 'right'; ?>">
                <div class="productInfo__text wysiwyg wysiwyg--large wysiwyg--white"><?= $section['content']; ?></div>
              </div>
            <?php elseif ($section['acf_fc_layout'] == 'table') : ?>
              <div class="productInfo__item hideScroll hideScroll--<?= ($index % 2 == 0) ? 'left' : 'right'; ?>">
                <div class="productInfo__tableWrapper">
                  <ul class="productInfo__table">
                    <?php foreach ($section['items'] as $item) : ?>
                      <li class="productInfo__tableCell"><?= $item['text']; ?></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>
            <?php elseif ($section['acf_fc_layout'] == 'stats') : ?>
              <div class="productInfo__item">
                <ul class="productInfo__stats">
                  <?php foreach ($section['items'] as $item) : ?>
                    <li class="productInfo__stat hideScroll" data-animation-number>
                      <div class="productInfo__statNumber" data-number="<?= $item['value']; ?>" data-suffix="<?= $item['suffix']; ?>"></div>
                      <h5 class="productInfo__statTitle"><?= $item['title']; ?></h5>
                    </li>
                  <?php endforeach; ?>
                </div>
              </ul>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>
<?php endif;