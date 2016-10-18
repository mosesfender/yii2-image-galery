<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model mosesfender\galery\models\StorageGroups */

$this->title = Yii::t('galery', 'Create Storage Groups');
$this->params['breadcrumbs'][] = ['label' => Yii::t('galery', 'Storage Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="storage-groups-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
