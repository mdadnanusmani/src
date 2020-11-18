<?php if ($section['items']) : ?> 
  <section class="filesList section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
    <div class="filesList__inner">
      <div class="container">
        <div class="filesList__items hideScroll">
          <div class="row row--flex row--fluid">
            <?php foreach ($section['items'] as $index => $item) : ?>
              <a href="#" class="contentBox col-4 col-4 col-md-12">
                <div class="contentBox__outer">
                  <div class="contentBox__inner">
                    <div class="contentBox__header">
                      <div class="contentBox__category icon-pdf">PDF</div>
                      <div class="contentBox__date">11.7 MB</div>
                    </div>
                    <h4 class="contentBox__title"><?= $item['title']; ?></h4>
                    <div class="contentBox__button button"><?= __('Download file', 'lang'); ?></div>
                  </div>
                </div>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>