<?php

/* @var $this yii\web\View */
/* @var $model \mosesfender\galery\models\StorageGroups */
/* @var $imagesModel \yii\db\ActiveQuery */
/* @var $controller \mosesfender\galery\controllers\GroupController */
$controller = $this->context;
/* @var $module mosesfender\galery\Module */
$module = $controller->module;

mosesfender\galery\StorageAsset::register($this);

$this->title = Yii::t('galery', 'Storage «{storage_id}»', ["storage_id" => $module->id]);
$this->params['breadcrumbs'][] = $this->title;

/* @var $this yii\web\View */
echo $this->renderFile(realpath(__DIR__ . "/../topmenu.php"));
?>