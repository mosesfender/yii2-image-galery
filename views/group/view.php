<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model \mosesfender\galery\models\StorageGroups */
/* @var $imagesModel \yii\db\ActiveQuery */
/* @var $controller \mosesfender\galery\controllers\GroupController */
$controller = $this->context;
/* @var $module mosesfender\galery\Module */
$module = $controller->module;

mosesfender\galery\StorageAsset::register($this);

$this->title = Yii::t('galery', 'Group «{group_title}»', ["group_title" => $model->title]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('galery', 'Storage «{storage_id}»', ["storage_id" => $module->id]), 'url' => ["/{$module->id}"]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('galery', 'Storage Groups «{storage_id}»', ["storage_id" => $module->id]), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="storage-groups-view">
    <script>
        window.groupID = <?php echo $model->id; ?>
    </script>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('galery', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a(Yii::t('galery', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('galery', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description',
        ],
    ])
    ?>
    <div class="storage-groups-manipulator container-fluid">
        <div class="row">
            <div class="storage-groups-sources col-md-4">
                <div class="tabbable" id="source-tab">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#panel-load" data-toggle="tab">Загрузка</a>
                        </li>
                        <li>
                            <a href="#panel-storage" data-toggle="tab">Хранилище</a>
                        </li>
                        <li>
                            <a href="#panel-groups" data-toggle="tab">Группы</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="panel-load">
                            <?php echo $this->render("formUpload", ["groupID" => $model->id]); ?>
                        </div>
                        <div class="tab-pane" id="panel-storage">
                            
                        </div>
                        <div class="tab-pane" id="panel-groups">
                            <?php echo $this->render("_groupImageCollapse", ["modelGroupList" => $modelGroupList]); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="storage-groups-images col-md-8">
                <?php echo $grid; ?>
            </div>
        </div>
    </div>
</div>
