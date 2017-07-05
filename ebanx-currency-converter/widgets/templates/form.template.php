<p>
    <label for="<?= $field['title']['id'] ?>"><?php _e('Title:'); ?></label>
    <input class="widefat" id="<?= $field['title']['id'] ?>" name="<?= $field['title']['name'] ?>" type="text"
           value="<?= esc_attr($field['title']['value']) ?>"/>
</p>

