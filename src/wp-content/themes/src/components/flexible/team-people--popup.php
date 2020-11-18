<div class="peoplePopup">
  <div class="peoplePopup__outer">
    <div class="container">
      <div class="peoplePopup__inner">
        <div class="peoplePopup__side">
          <div class="peoplePopup__image" style="background-image: url(<?= $item['image']; ?>);"></div>
          <div class="peoplePopup__socialsTitle"><?= __('Contact', 'lang'); ?></div>
          <?php if ($item['contacts']) : ?>
            <ul class="peoplePopup__socials">
              <?php foreach ($item['contacts'] as $contact) : ?>
                <li class="peoplePopup__social icon-<?= $contact['icon']; ?>">
                  <a href="<?= $contact['link']['url']; ?>" target="<?= $contact['link']['target']; ?>" class="peoplePopup__socialLink"><?= $contact['link']['title']; ?></a>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
        <div class="peoplePopup__content">
          <h4 class="peoplePopup__title"><?= $item['title']; ?></h4>
          <div class="peoplePopup__position"><?= $item['position']; ?></div>
          <div class="peoplePopup__desc"><?= $item['content']; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>