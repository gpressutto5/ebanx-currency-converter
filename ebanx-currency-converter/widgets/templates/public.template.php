<?= $args['before_widget'] ?>
<?php if (!empty($title)) {
    echo $args['before_title'] . $title . $args['after_title'];
} ?>

<!-- WIDGET BODY-->
<div class="ebanx-currency-converter--body">
    <?php foreach ($countries as $country):
        if ($country['enabled']): ?>
            <a class="ebanx-currency-converter--flag-link" href="#">
                <img class="ebanx-currency-converter--flag"
                     src="<?= EBANX_CURRENCY_CONVERTER_PLUGIN_DIR_URL ?>assets/images/<?= $country['code'] ?>.svg"
                     alt="<?= $country['name'] ?>">
            </a>
        <?php endif;
    endforeach; ?>
</div>
<!-- /WIDGET BODY-->

<?= $args['after_widget'] ?>
