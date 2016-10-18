<?php

use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $module \mosesfender\galery\Module */
/* @var $dataProvider \yii\data\ActiveDataProvider */
$module = $this->context->module;

$pj = Pjax::begin(['id' => 'gi', 'enablePushState' => false, 'enableReplaceState' => true, 'timeout' => 10000000]);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'format' => 'raw',
            'value' => function($d)use($module) {
                return \yii\helpers\Html::img(yii\helpers\Url::toRoute("storage/grid-thumb/{$d->id}"));
            },
            'contentOptions' => ['style' => 'width: 150px; text-align: center;']
        ], [
            'label' => 'Size',
            'value' => 'filesize',
            'contentOptions' => ['style' => 'width: 80px; text-align: right;']
        ], [
            'class' => 'yii\grid\ActionColumn',
            'contentOptions' => ['style' => 'width: 70px;'],
            'buttons' => [
                'delete' => function ($url, $model)use($pj) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => Yii::t('yii', 'Delete'),
                                'data-pjax' => 1,
                                'data-method' => 'GET',
                                'data-anc' => 'action-button-remove-from-group',
                                'data-pj' => "{$pj->id}"
                    ]);
                }
                    ],
                    'urlCreator' => function ($action, $m, $key, $index)use($model) {
                switch ($action) {
                    case 'delete':
                        $url = "delete-image?id={$m->id}&group={$model->id}";
                        return $url;
                        break;
                }
            }
                ],
                'id',
            ]
        ]);
        Pjax::end();


        