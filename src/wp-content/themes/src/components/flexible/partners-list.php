<?php if ($section['items']) : ?> 
  <section class="partnersList section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
    <div class="partnersList__inner">
      <div class="container">
        <div class="section__header">
          <h3 class="section__headline hideScroll hideScroll--left"><?= $section['headline']; ?></h3>
        </div>
        <div class="partnersList__items hideScroll">
          <?php foreach ($section['items'] as $index => $item) : ?>
            <a href="<?= $item['url']; ?>" target="_blank" class="partnersList__item">
              <img src="<?= $item['image']['url']; ?>" class="partnersList__itemLogo" alt="<?= $item['image']['alt']; ?>">
              <div class="partnersList__itemHover">
                <div class="button button--border button--blue"><?= $section['hover_button']; ?></div>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>