<div class="personInfo <?= $user['favorite'] ? 'personInfo--favorite' : ''; ?>" data-user-id="<?= $user['id']; ?>">
  <div class="personInfo__image" style="background-image: url(<?= $user['image']; ?>);"></div>
  <div class="personInfo__content">
    <div class="personInfo__title"><?= $user['name']; ?></div>
    <div class="personInfo__position"><?= $user['position']; ?></div>
    <div class="personInfo__contactItems">
      <?php if ($user['email']) : ?>
      <div class="personInfo__contactItem icon-email">
        <a href="mailto:<?= $user['email']; ?>"><?= $user['email']; ?></a>
      </div>
      <?php endif; ?>
      <?php if ($user['phone']) : ?>
        <div class="personInfo__contactItem icon-phone">
          <a href="tel:<?= preg_replace('/[^0-9]/', '', $user['phone']); ?>"><?= $user['phone']; ?></a>
        </div>
      <?php endif; ?>
    </div>
    <div class="personInfo__socialItems">
      <?php if ($user['linkedin']) : ?>
        <a href="<?= $user['linkedin']; ?>" class="personInfo__socialItem button button--border button--blue"><?= __('LinkedIn' ,'lang'); ?></a>
      <?php endif; ?>
      <?php if ($user['skype']) : ?>
        <a href="<?= $user['skype']; ?>" class="personInfo__socialItem button button--border button--blue"><?= __('Skype' ,'lang'); ?></a>
      <?php endif; ?>
    </div>
  </div>
  <?php if ($user['id'] != get_current_user_id()) : ?>
    <a href="#" class="personInfo__star"></a>
  <?php endif; ?>
</div>