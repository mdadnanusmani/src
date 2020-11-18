<?php if ($section['table']) : ?> 
  <section class="table section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
    <div class="table__inner">
      <div class="container">
        <div class="table__rows hideScroll">
          <?php if ($section['table']['header']) : ?>
            <div class="table__row">
              <?php foreach ($section['table']['header'] as $cell) : ?>
                <div class="table__cell">
                  <span><?= $cell['c']; ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          <?php if ($section['table']['body']) : ?>
            <?php foreach ($section['table']['body'] as $row) : ?>
              <div class="table__row">
                <?php foreach ($row as $cell) : ?>
                  <div class="table__cell">
                    <span><?= $cell['c']; ?></span>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>