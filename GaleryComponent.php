<?php

/**
 * @author Moses Fender <mosesfender@gmail.com>
 */

namespace mosesfender\galery;

class UploadEvent extends \yii\base\Event {

    public $filename;
    public $sizeX;
    public $sizeY;
    public $filesize;
    public $mime;

}

class NewImage extends \yii\base\Event {

    /**
     *
     * @var \mosesfender\galery\models\StorageImages 
     */
    public $imageModel;

    public function __construct($imageModel) {
        $this->imageModel = $imageModel;
    }

}

class GaleryComponent extends \yii\base\Component implements \yii\base\BootstrapInterface {

    /**
     * @var string A place to store the current component files 
     */
    public $storage;

    /**
     *
     * @var type \mosesfender\galery\ThumbnailComponent
     */
    public $thumb;
    public $urlRules;
    public $components;
    public $locator;
    public $id;

    public function bootstrap($app) {
        \yii::$app->controllerMap = array_merge(\yii::$app->controllerMap, [
            'storage' => [
                'class' => 'mosesfender\galery\controllers\StorageController',
                'viewPath' => '@mosesfender/galery/views',
                'component' => $this->id
            ],
        ]);
        \yii::$app->getUrlManager()->addRules([
            "{$this->id}/?" => "{$this->id}/storage/index",
            "{$this->id}/<controller:\w+>/?" => "{$this->id}/<controller>/index",
                //["class" => "yii\web\UrlRule", "pattern" => "{$this->id}/<controller:[\w\-]+>/<action:[\w\-]+>", "route" => "{$this->id}/<controller>/<action>"],
                //["class" => "yii\web\UrlRule", "pattern" => "{$this->id}/categories/<id:\w+>", "route" => "{$this->id}/categories/view"],
                //["class" => "yii\web\UrlRule", "pattern" => "{$this->id}/articles/<id:\w+>", "route" => "{$this->id}/articles/view"],
        ]);
    }

    public function init() {
        parent::init();
        $this->locator = new \yii\di\ServiceLocator();
        $this->locator->setComponents($this->components);
        $this->storage = \yii::getAlias($this->storage);
        if (!is_dir($this->storage)) {
            \yii\helpers\BaseFileHelper::createDirectory($this->storage);
        }
        $this->on('fileUploaded', function($e) {
            $this->registerFile($e);
        });
        \yii::$app->on("NewImage", function($e) {
            //prer($e);
        });
        $this->thumb = $this->locator->thumb;
        $this->thumb->parentComponent = $this;
    }

    public function storageFile() {
        $maxFileSize = ini_get('upload_max_filesize');
        if (isset($_FILES['attach'])) {
            $fileinfo = getimagesize($_FILES["attach"]["tmp_name"]);
            if (($fileinfo["mime"] != "image/jpeg") && ($fileinfo["mime"] != "image/png") && ($fileinfo["mime"] != "image/gif")) {
                echo \yii\helpers\Json::encode(["error" => "Файл {$_FILES["attach"]["name"]} не может быть загружен. Это не изображение."]);
                exit();
            }
            $filesize = filesize($_FILES["attach"]["tmp_name"]);

            $ext = end(\yii\helpers\FileHelper::getExtensionsByMimeType(\yii\helpers\FileHelper::getMimeType($_FILES["attach"]["tmp_name"])));
            $name = md5(time() . rand(1000, 9999) . "_" . rand(10000, 99999));
            $fullname = "{$this->storage}/{$name}.{$ext}";
            if (move_uploaded_file($_FILES["attach"]["tmp_name"], $fullname)) {
                $ue = new UploadEvent();
                $ue->filename = $fullname;
                $ue->mime = $fileinfo["mime"];
                $ue->sizeX = $fileinfo[0];
                $ue->sizeY = $fileinfo[1];
                $ue->filesize = $filesize;
                $this->trigger("fileUploaded", $ue);
                echo \yii\helpers\Json::encode(["out" => ["filename" => $_FILES["attach"]["name"]]]);
                exit();
            }
        } else {
            echo \yii\helpers\Json::encode(["error" => "Файл не может быть загружен. Вероятно, это не изображение JPEG, PNG или GIF, либо слишком большой объём (более {$maxFileSize})"]);
            exit();
        }
    }

    /**
     * 
     * @param \mosesfender\galery\UploadEvent $e
     */
    public function registerFile($e) {
        $model = new models\StorageImages();
        $model->mime = $e->mime;
        $model->sizeX = $e->sizeX;
        $model->sizeY = $e->sizeY;
        $model->filename = basename($e->filename);
        $model->filesize = $e->filesize;
        $model->save();
        \yii::$app->trigger('NewImage', new NewImage($model));
    }

}
