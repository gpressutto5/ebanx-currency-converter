<?= $args['before_widget'] ?>
<?php if (!empty($title)) {
    echo $args['before_title'] . $title . $args['after_title'];
} ?>

<!-- WIDGET BODY-->
<div class="ebanx-currency-converter--body">
    <ul class="ebanx-currency-converter ebanx-currency-converter--flag-list">
        <?php foreach ($countries as $country):
            if ($country['enabled']): ?>
                <li class="ebanx-currency-converter--flag-item">
                    <a href="#" class="ebanx-currency-converter--flag-link" data-country="<?= $country['code'] ?>">
                        <img class="ebanx-currency-converter--flag-image"
                             src="<?= EBANX_CURRENCY_CONVERTER_PLUGIN_DIR_URL ?>assets/images/<?= $country['code'] ?>.svg"
                             alt="<?= $country['name'] ?>">
                    </a>
                </li>
            <?php endif;
        endforeach; ?>
    </ul>
</div>
<!-- /WIDGET BODY-->

<?= $args['after_widget'] ?>
