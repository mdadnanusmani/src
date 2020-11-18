<?php if ($section['items']) : ?> 
  <section class="iconsPath section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
    <div class="iconsPath__inner">
      <div class="container">
        <div class="iconsPath__items">
          <?php foreach ($section['items'] as $index => $item) : ?>
          <div class="iconsPath__item">
              <div class="iconsPath__itemIconWrapper hideScroll">
                <div class="iconsPath__itemIcon icon-<?= $item['icon']; ?>" data-hover="blue"></div>
              </div>
              <div class="iconsPath__itemContentWrapper">
                <div class="iconsPath__itemContent hideScroll hideScroll--right">
                  <div class="wysiwyg">
                    <?= $item['content']; ?>
                  </div>
                  <a href="<?= $item['link']['url']; ?>" target="<?= $item['link']['target']; ?>" class="iconsPath__itemButton button--border button--blue"><?= $item['link']['title']; ?></a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>