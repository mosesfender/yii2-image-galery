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
            'accept' => 'image/jpeg,image/png',
            'initialPreviewConfig' => [
                'width' => '50px'
            ],
        ],
        'pluginOptions' => [
            'uploadUrl' => \yii\helpers\Url::toRoute(['unit/storage-file']),
            'previewFileType' => 'image',
            'uploadExtraData' => [
                'group_id' => $groupID,
            ],
            'maxFileCount' => 100
        ],
        'pluginEvents' => [
            'filebatchuploadcomplete' => 'function(event, files, extra) { $.pjax.reload({container: "#gi"}); }'
        ]
    ]);
    ?>
</div>  
