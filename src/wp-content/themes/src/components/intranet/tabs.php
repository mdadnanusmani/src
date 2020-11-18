<div class="intranetProfile__tabsList">
  <?php foreach ($data as $category) : ?>
    <a href="#" class="intranetProfile__tabsItem" data-category="<?= $category['id']; ?>"><?= $category['title']; ?></a>
  <?php endforeach; ?>
</div>
<div class="intranetProfile__tabsNewsItems" data-page-limit="4">
  <?php foreach ($data as $categoryIndex => $category) : ?>
    <?php foreach ($category['items'] as $itemIndex => $item) : ?>
      <a href="<?= $item['url']; ?>" target="_blank" class="intranetProfile__tabsNewsItem <?= (($categoryIndex == 0) && ($itemIndex < 4)) ? 'intranetProfile__tabsNewsItem--active' : ''; ?> contentBox" data-category="<?= $category['id']; ?>">
        <div class="contentBox__outer">
          <?php if ($item['logo']) : ?>
            <div class="contentBox__bg" style="background-image: url(<?= $item['logo']; ?>);"></div>
          <?php endif; ?>
          <div class="contentBox__inner">
            <div class="contentBox__header">
              <div class="contentBox__category icon-<?= $category['icon']; ?>"><?= $category['title']; ?></div>
              <?php if (isset($item['date']) && $item['date']) : ?>
                <div class="contentBox__date"><?= $item['date']; ?></div>
              <?php endif; ?>
            </div>
            <h4 class="contentBox__title"><?= $item['title']; ?></h4>
            <?php if (isset($item['desc']) && $item['desc']) : ?>
              <div class="contentBox__desc">Internal Audit Manager, Secretery of Audit and Compliance Comitte</div>
            <?php endif; ?>
          </div>
        </div>
      </a>
    <?php endforeach; ?>
  <?php endforeach; ?>
</div>
<div class="intranetProfile__tabsMoreWrapper">
  <a href="#" class="intranetProfile__tabsMore <?= (count($data[0]['items']) > 4) ? 'intranetProfile__tabsMore--active' : ''; ?> button button--border button--blue"><?= __('Load more', 'lang'); ?></a>
</div>