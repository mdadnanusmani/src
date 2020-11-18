<?php

  $intranet = get_field('intranet_recent', 'option');
  $index    = $intranet['index'] - 1;
  $list     = isset($data[$index]['items']) ? $data[$index] : $data[0];

  if ($intranet && $list) :

?>
  <div class="intranetProfile__newsTitle"><?= __('Recent news', 'lang'); ?></div>
  <div class="intranetProfile__newsItems">
    <div class="row row--flex">
      <?php

        foreach ($list['items'] as $index => $item) :

          if ($index >= 2)
            break;

      ?>
        <div class="col-6 col-lg-12">
          <a href="<?= $item['url']; ?>" class="contentBox contentBox--transparent">
            <div class="contentBox__outer">
              <div class="contentBox__inner">
                <div class="contentBox__header">
                  <div class="contentBox__category icon-<?= $list['icon']; ?>"><?= $list['title']; ?></div>
                  <?php if (isset($item['date']) && $item['date']) : ?>
                    <div class="contentBox__date"><?= $item['date']; ?></div>
                  <?php endif; ?>
                </div>
                <h4 class="contentBox__title"><?= $item['title']; ?></h4>
                <div class="contentBox__button button button--inline"><?= __('See more', 'lang'); ?></div>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
<?php endif;