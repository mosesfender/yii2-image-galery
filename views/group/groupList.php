<?php

/* @var $this yii\web\View */
/* @var $model \mosesfender\galery\models\StorageGroups */

use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $module mosesfender\galery\Module */
$module = $this->context->module;

$this->title = "Группы файлов хранилища «{$module->id}»";

$dataProvider = new ActiveDataProvider([
    'query' => $model->find(),
    'pagination' => [
        'pageSize' => 10,
    ],
        ]);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'title',
        'description',
        [
            'class' => 'yii\grid\ActionColumn',
        ]
    ]
]);
