<section class="textSection section">
  <div class="textSection__inner">
    <div class="container">
      <div class="wysiwyg wysiwyg--large hideScroll">
        <?php if ($wp_query->found_posts) : ?>
          <h1><?= sprintf(__('Search results for "%s"', 'lang'), get_search_query()); ?></h1>
        <?php else : ?>
          <h1><?= __('Sorry, no posts were found. Please try again.', 'lang'); ?></h1>
          <p>
            <a href="<?= home_url('/') ?>"><?= __('Back to homepage'); ?></a>
          </p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>