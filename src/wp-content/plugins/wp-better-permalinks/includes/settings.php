<form method="post">
  <table class="widefat">
    <thead>
      <tr>
        <th><?= __('Post type', 'wp-better-permalinks'); ?></th>
        <th><?= sprintf(__('Taxonomy %s(set empty to disable)%s', 'wp-better-permalinks'), '<i>', '</i>'); ?></i></th>
        <th><?= __('Current path', 'wp-better-permalinks'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($list as $index => $element) : ?>
        <tr>
          <td>
            <label for="wbp_<?= $index; ?>">
              <?= $element['label']; ?>
            </label>
          </td>
          <td>
            <select id="wbp_<?= $index; ?>" name="wpbs_<?= $element['slug']; ?>_taxonomy">
              <option></option>
              <?php foreach ($element['terms'] as $taxonomy) : ?>

                <option value="<?= $taxonomy['slug']; ?>" <?= ($taxonomy['slug'] == $element['active']) ? 'selected' : ''; ?>>
                  <?= $taxonomy['label']; ?>
                </option>

              <?php endforeach; ?>
            </select>
          </td>
          <td>
            <p>
              <span>/</span><?= implode('<span>/</span>', $element['path']); ?>
            </p>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <input type="submit" class="button button-primary" name="wbp_save" value="<?= __('Save Changes', 'wp-better-permalinks'); ?>">
</form>