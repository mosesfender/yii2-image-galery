<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
?>
<div class="formUpload">
    <?php
    echo \kartik\widgets\FileInput::widget([
        'name' => 'attach',
        'options' => [
            'multiple' => true,
            'accept' => 'image/jpeg,image/png'
        ],
        'pluginOptions' => [
            'uploadUrl' => \yii\helpers\Url::to(['storage-file']),
            'previewFileType' => 'image',
            'uploadExtraData' => [
                //'album_id' => 20,
                //'cat_id' => 'Nature'
            ],
            'maxFileCount' => 100
        ],
        'pluginEvents' => [
            'filebatchuploadcomplete' => 'function(event, files, extra) { window.location.reload(); }'
        ]
    ]);
    ?>
</div><!-- formUpload -->
