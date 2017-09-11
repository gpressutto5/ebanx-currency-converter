<?= $args['before_widget'] ?>
<?php if (!empty($title)) {
    echo $args['before_title'] . $title . $args['after_title'];
} ?>

<!-- WIDGET BODY-->
<div class="ebanx-currency-converter--clearfix">
  <!-- Button -->
  <button id="ebanx-currency-converter--dropdown-button" class="ebanx-currency-converter--reset-button">
    <img class="ebanx-currency-converter--flag-image"
         src="<?= EBANX_CURRENCY_CONVERTER_PLUGIN_DIR_URL ?>assets/images/br.svg"
         alt="Brazil">
    <span class="ebanx-currency-converter--country-text">BRL - Brazilian Real</span>
    <i class="fa fa-caret-down ebanx-currency-converter--caret"></i>
  </button>
  <!-- /Button -->


  <!-- Content -->
  <div id="ebanx-currency-converter--select-currency" class="ebanx-currency-converter--select-currency ebanx-currency-converter--select-currency--active">
    <ul class="ebanx-currency-converter--items">
        <?php foreach ($countries as $country):
            if ($country['enabled']): ?>
              <li class="ebanx-currency-converter--flag-item">
                <button class="ebanx-currency-converter--flag-link ebanx-currency-converter--reset-button"
                        data-country="<?= $country['country-code'] ?>" data-currency="<?= $country['currency-code'] ?>">
                  <img class="ebanx-currency-converter--flag-image"
                       src="<?= EBANX_CURRENCY_CONVERTER_PLUGIN_DIR_URL ?>assets/images/<?= $country['country-code'] ?>.svg"
                       alt="<?= $country['name'] ?>">
                  <span class="ebanx-currency-converter--country-text">COP - Pesos Colombianos</span>
                </button>
              </li>
            <?php endif;
        endforeach; ?>
    </ul>
  </div>
  <!-- /Content -->
</div>
<!-- /WIDGET BODY-->

<?= $args['after_widget'] ?>
