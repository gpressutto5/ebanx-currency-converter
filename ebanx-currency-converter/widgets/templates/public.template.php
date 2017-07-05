<?= $args['before_widget'] ?>
<?php if (!empty($title)) {
    echo $args['before_title'] . $title . $args['after_title'];
} ?>

<!-- WIDGET BODY-->
<ul>
    <?php foreach ($countries as $country => $enabled): ?>
        <?php if ($enabled): ?>
            <li>
                <a href="#"><?= ucfirst($country) ?></a>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
<!-- /WIDGET BODY-->

<?= $args['after_widget'] ?>
