<?php

namespace mosesfender\galery\controllers;

class StorageController extends \yii\web\Controller {

    public function init() {
        parent::init();
    }

    public function actionIndex(){
        return $this->render("index");
    }
    
    public function actionGridThumb() {
        $this->module->forgrid->getThumbFromStorage(\yii::$app->request->get());
        exit();
    }

}
