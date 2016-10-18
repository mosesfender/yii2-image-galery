<?php
foreach ($model as $image):
    /* @var $image \mosesfender\galery\models\StorageImages */
    ?>
    <img src="<?php echo "/{$this->context->module->id}/storage/grid-thumb/{$image->id}" ?>" alt="" data-initid="<?php echo $image->id; ?>" />
<?php endforeach; ?>
