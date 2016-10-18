<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel mosesfender\galery\models\StorageGroupsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

/* @var $module mosesfender\galery\Module */
$module = $this->context->module;

$this->title = Yii::t('galery', 'Storage Groups «{storage_id}»', ["storage_id" => $module->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('galery', 'Storage «{storage_id}»', ["storage_id" => $module->id]), 'url' => ["/{$module->id}"]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="storage-groups-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('galery', 'Create Storage Groups'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title',
            'description',
            ['class' => 'yii\grid\ActionColumn'],
            'id',
        ],
    ]); ?>
<?php Pjax::end(); ?>
    
</div>


