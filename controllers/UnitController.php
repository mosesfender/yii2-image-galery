<?php

namespace mosesfender\galery\controllers;

class UnitController extends \yii\web\Controller {

    public function init() {
        parent::init();
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionStorageGrid() {
        $model = new \mosesfender\galery\models\StorageImages();
        return $this->render("imageList", ["model" => $model, "module" => $this->module]);
    }

    public function actionStorageFile() {
        $this->module->storageFile();
        exit();
    }
    
    public function actionDelete(){
        \mosesfender\galery\helpers\UnitHelper::deleteFile($this->module);
        \yii::$app->response->redirect(\yii\helpers\Url::toRoute("storage-grid"));
    }

}
