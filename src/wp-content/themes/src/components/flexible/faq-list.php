<?php if ($section['items']) : ?> 
  <section class="faqTabs section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
    <div class="faqTabs__inner">
      <div class="container">
        <h3 class="section__headline hideScroll hideScroll--left"><?= $section['headline']; ?></h3>
        <div class="faqTabs__wrapper">
          <div class="row">
            <div class="col-4 col-mdl-12">
              <ul class="faqTabs__categories hideScroll">
                <?php foreach ($section['items'] as $index => $item) : ?>
                  <li class="faqTabs__category">
                    <a href="#" class="faqTabs__categoryLink <?= ($index == 0) ? 'faqTabs__categoryLink--active' : ''; ?>"><?= $item['category']; ?></a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
            <div class="col-8 col-mdl-12">
              <ul class="faqTabs__items hideScroll hideScroll--right">
                <?php foreach ($section['items'] as $index => $item) : ?>
                  <li class="faqTabs__item <?= ($index == 0) ? 'faqTabs__item--active' : ''; ?>">
                    <ul class="faqTabs__questions">
                      <?php foreach ($item['questions'] as $question) : ?>
                        <li class="faqTabs__question">
                          <a href="#" class="faqTabs__questionToggle"></a>
                          <h5 class="faqTabs__questionTitle"><?= $question['question']; ?></h5>
                          <div class="faqTabs__questionWrapper">
                            <div class="faqTabs__questionDesc wysiwyg"><?= $question['answer']; ?></div>
                          </div>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>