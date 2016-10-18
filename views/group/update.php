<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model mosesfender\galery\models\StorageGroups */

$this->title = Yii::t('galery', 'Update {modelClass}: ', [
    'modelClass' => 'Storage Groups',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('galery', 'Storage Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('galery', 'Update');
?>
<div class="storage-groups-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
