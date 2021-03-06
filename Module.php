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

    public function __construct($config = array()) {
        parent::__construct($config);
        \yii::info("EVENT UploadEvent", "group");
    }

}

class NewImage extends \yii\base\Event {

    /**
     *
     * @var \mosesfender\galery\models\StorageImages 
     */
    public $imageModel;

    public function __construct($imageModel) {
        $this->imageModel = $imageModel;
        \yii::info("EVENT NewImage", "group");
    }

}

class DeleteImage extends \yii\base\Event {

    public $id;

    public function __construct($id) {
        $this->id = $id;
        \yii::info("EVENT DeleteImage", "group");
    }

}

class Module extends \yii\base\Module implements \yii\base\BootstrapInterface {

    const EVENT_FILE_UPLOADED = 'fileUploaded';
    const EVENT_NEW_IMAGE = 'NewImage';
    const EVENT_DELETE_IMAGE = 'DeleteImage';

    /**
     * @var string A place to store the current component files 
     */
    public $storage;

    /**
     *
     * @var type \mosesfender\galery\ThumbnailComponent
     */
    public $thumb = [];
    public $urlRules;
    public $components = [];
    public $locator;

    /**
     * @param yii\web\Application $app
     */
    public function bootstrap($app) {
        $app->getUrlManager()->addRules([
            "{$this->id}/?" => "{$this->id}/storage/index",
            "{$this->id}/<controller:[\w\-]+>/<action:[\w\-]+>" => "{$this->id}/<controller>/<action>",
            "{$this->id}/<controller:[\w\-]+>/<action:[\w\-]+>/<id:\d+>" => "{$this->id}/<controller>/<action>",
                //["class" => "yii\web\UrlRule", "pattern" => "{$this->id}/<controller:[\w\-]+>/<action:[\w\-]+>", "route" => "{$this->id}/<controller>/<action>"],
                //["class" => "yii\web\UrlRule", "pattern" => "{$this->id}/categories/<id:\w+>", "route" => "{$this->id}/categories/view"],
                //["class" => "yii\web\UrlRule", "pattern" => "{$this->id}/articles/<id:\w+>", "route" => "{$this->id}/articles/view"],
        ]);
    }

    public function init() {
        parent::init();
        $this->storage = \yii::getAlias($this->storage);
        if (!is_dir($this->storage)) {
            \yii\helpers\BaseFileHelper::createDirectory($this->storage);
        }
        $this->on(self::EVENT_FILE_UPLOADED, function($e) {
            $this->registerFile($e);
        });
        \yii::$app->on(self::EVENT_NEW_IMAGE, function($e) {
            
        });
        if(count($this->thumb)){
            foreach ($this->thumb as $thumbname => $thumb){
                $comp = $this->set($thumbname, $thumb);
                $this->get($thumbname)->parentComponent = $this;
            }
        }
        $this->registerTranslations();
        //prer(\yii::$app->i18n->translations,0,1);
    }

    public function registerTranslations() {
        \yii::$app->i18n->translations["{$this->id}"] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@mosesfender/galery/messages',
            'fileMap' => [
                "galery" => "galery.php"
            ],
        ];
    }

    public static function t($category, $message, $params = [], $language = null) {
        return Yii::t('mosesfender/galery/messages' . $category, $message, $params, $language);
    }

    public function beforeAction($action) {
        /* @var $action yii\base\InlineAction */
        return parent::beforeAction($action);
    }

    public function storageFile() {
        /* @todo Надо со всем этим что-то сделать, унести в хэлперы и сделать статичными */
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
                $this->trigger(self::EVENT_FILE_UPLOADED, $ue);
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
        \yii::$app->trigger(self::EVENT_NEW_IMAGE, new NewImage($model));
        if ($groupID = \yii::$app->request->post("group_id")) {
            helpers\UnitHelper::moveFileToGroup($model, $groupID);
        }
    }

}
