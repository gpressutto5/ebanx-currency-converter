<p>
    <label for="<?= $field['title']['id'] ?>"><?= $field['title']['label'] ?></label>
    <input class="widefat" id="<?= $field['title']['id'] ?>" name="<?= $field['title']['name'] ?>" type="text"
           value="<?= esc_attr($field['title']['value']) ?>"/>
</p>
<p>
    <?= __('Chose the currencies you want this extension to convert to:', 'ebanx-currency-converter') ?>
</p>
<p>
    <!-- Brazil -->
    <input class="checkbox" type="checkbox" <?php checked($field['brazil']['value'], 'on'); ?>
           id="<?= $field['brazil']['id'] ?>" name="<?= $field['brazil']['name'] ?>"/>
    <label for="<?= $field['brazil']['id'] ?>"><?= $field['brazil']['label'] ?></label>
    <br>

    <!-- Mexico -->
    <input class="checkbox" type="checkbox" <?php checked($field['mexico']['value'], 'on'); ?>
           id="<?= $field['mexico']['id'] ?>" name="<?= $field['mexico']['name'] ?>"/>
    <label for="<?= $field['mexico']['id'] ?>"><?= $field['mexico']['label'] ?></label>
    <br>

    <!-- Colombia -->
    <input class="checkbox" type="checkbox" <?php checked($field['colombia']['value'], 'on'); ?>
           id="<?= $field['colombia']['id'] ?>" name="<?= $field['colombia']['name'] ?>"/>
    <label for="<?= $field['colombia']['id'] ?>"><?= $field['colombia']['label'] ?></label>
    <br>

    <!-- Chile -->
    <input class="checkbox" type="checkbox" <?php checked($field['chile']['value'], 'on'); ?>
           id="<?= $field['chile']['id'] ?>" name="<?= $field['chile']['name'] ?>"/>
    <label for="<?= $field['chile']['id'] ?>"><?= $field['chile']['label'] ?></label>
    <br>

    <!-- Peru -->
    <input class="checkbox" type="checkbox" <?php checked($field['peru']['value'], 'on'); ?>
           id="<?= $field['peru']['id'] ?>" name="<?= $field['peru']['name'] ?>"/>
    <label for="<?= $field['peru']['id'] ?>"><?= $field['peru']['label'] ?></label>
</p>
