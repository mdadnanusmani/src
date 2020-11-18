<?php

  $header = get_field('header');
  $news   = apply_filters('news_list', 'date', 3);

  if ($header) :

?>
  <section class="slider">
    <div class="slider__outer">
      <div class="slider__bg" style="background-image: url(<?= $header['bg_image']['sizes']['image-full']; ?>);"></div>
      <div class="slider__inner">
        <div class="slider__content">
          <div class="container">
            <div class="slider__contentInner">
              <h2 class="slider__title hideScroll"><?= strip_tags($header['title'], '<strong>'); ?></h2>
              <a href="#" class="slider__scroll hideScroll hideScroll--left">
                <div class="slider__scrollIcon"></div>
                <div class="slider__scrollText"><?= __('Scroll down', 'lang'); ?></div>
              </a>
            </div>
          </div>
        </div>
        <?php if ($news) : ?>
          <div class="slider__box hideScroll">
            <div class="slider__boxInner">
              <h3 class="slider__boxTitle"><?= $header['news_headline']; ?></h3>
              <div class="slider__boxItems">
                <?php foreach ($news as $index => $item) : ?>
                  <div class="slider__boxItem">
                    <a href="<?= $item['url']; ?>" class="slider__boxItemInner">
                      <?php if (($index == 0) && $item['image']) : ?>
                        <div class="slider__boxItemImage" style="background-image: url(<?= $item['image']; ?>);"></div>
                      <?php endif; ?>
                      <div class="slider__boxItemContent">
                        <div class="slider__boxItemTop">
                          <div class="slider__boxItemCategory"><?= __('News', 'lang'); ?></div>
                          <div class="slider__boxItemDate"><?= $item['date']; ?></div>
                        </div>
                        <h4 class="slider__boxItemTitle"><?= $item['title']; ?></h4>
                        <?php if ($index == 0) : ?>
                          <div class="slider__boxItemDesc"><?= $item['desc']; ?></div>
                        <?php endif; ?>
                        <div class="slider__boxItemButton button--inline button--white"><?= __('Read more', 'lang'); ?></div>
                      </div>
                    </a>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
<?php endif;