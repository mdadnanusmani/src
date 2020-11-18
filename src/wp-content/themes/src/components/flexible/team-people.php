<?php

  $list = apply_filters('people_list', $section['items']);

  if ($list['cats'] && $list['items']) :

?>
  <section class="teamPeople section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
    <div class="teamPeople__inner">
      <div class="container">
        <div class="teamPeople__header section__header hideScroll hideScroll--left">
          <h3 class="teamPeople__headline section__headline"><?= $section['headline']; ?></h3>
          <div class="teamPeople__categories">
            <?php foreach ($list['cats'] as $index => $item) : ?>
              <a href="#" class="teamPeople__category <?= ($index == 0) ? 'teamPeople__category--active' : ''; ?>"><?= $item['title']; ?></a>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="teamPeople__items">
          <?php foreach ($list['items'] as $index => $group) : ?>
            <div class="teamPeople__item <?= ($index == 0) ? 'teamPeople__item--active' : ''; ?>">
              <div class="teamPeople__slider gSlider hideScroll">
                <div class="gSlider__itemsOuter">
                  <div class="gSlider__items">
                    <?php foreach ($group as $item) : ?>
                      <div class="gSlider__item teamPeople__sliderItem">
                        <a href="#" class="teamPeople__sliderItemInner" style="background-image: url(<?= $item['image']; ?>);">
                          <div class="teamPeople__sliderItemOverlay">
                            <div class="teamPeople__sliderItemOverlayContent">
                              <h4 class="teamPeople__sliderItemOverlayTitle"><?= $item['title']; ?></h4>
                              <p class="teamPeople__sliderItemOverlayPosition"><?= $item['position']; ?></p>
                            </div>
                          </div>
                        </a>
                        <?php include 'team-people--popup.php'; ?>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
                <div class="gSlider__nav">
                  <a href="#" class="gSlider__navPrev gSlider__navPrev--disabled"></a>
                  <a href="#" class="gSlider__navNext"></a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>