<?php

  $title = get_field('contact_text',  'option');
  $items = get_field('contact_items', 'option');

  if ($items) :

?> 
  <section class="contactData section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
    <div class="contactData__inner">
      <div class="container">
        <div class="row row--flex">
          <div class="col-4 col-mdl-12 contactData__content hideScroll hideScroll--left">
            <div class="wysiwyg wysiwyg--large"><?= $title; ?></div>
          </div>
          <div class="col-6 offset-col-2 col-mdl-12 contactData__data">
            <div class="contactData__items hideScroll">
              <?php foreach ($items as $index => $item) : ?>
                <?php if($item['icon']=="letter"){ ?>
              <a href="mailto:info@srco.com.sa" target="<?= $item['link']['target']; ?>" class="contactData__item">
                  <div class="contactData__itemIcon icon-<?= $item['icon']; ?>"></div>
                  <div <?php if($item['icon']=="phone"){ ?> style="direction: ltr;" <?php } ?> class="contactData__itemValue">info@srco.com.sa</div>
                </a>
              
              <?php } else { ?>
                <a href="<?= $item['link']['url']; ?>" target="<?= $item['link']['target']; ?>" class="contactData__item">
                  <div class="contactData__itemIcon icon-<?= $item['icon']; ?>"></div>
                  <div <?php if($item['icon']=="phone"){ ?> style="direction: ltr;" <?php } ?> class="contactData__itemValue"><?= $item['link']['title']; ?></div>
                </a>
                <?php } ?>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>