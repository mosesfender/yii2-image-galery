<?php

/* @var $this yii\web\View */
/* @var $model \mosesfender\galery\models\StorageImages */
/* @var $module \mosesfender\galery\Module */

//use kartik\grid\GridView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

$this->title = "Коллекция файлов";

echo $this->renderFile(realpath(__DIR__ . "/../topmenu.php"));

$dataProvider = new ActiveDataProvider([
    'query' =>  $model->find(),
    'pagination' => [
        'pageSize' => 10,
    ],
        ]);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        [
            'format' => 'raw',
            'value' => function($d)use($module) {
                return \yii\helpers\Html::img( yii\helpers\Url::toRoute("storage/grid-thumb/{$d->id}"));
            }
        ],
        'filesize',
        [
            'class' => 'yii\grid\ActionColumn',
        ]
    ]
]);

echo $this->render("formUpload");
