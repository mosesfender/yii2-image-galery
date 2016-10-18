<?php

namespace mosesfender\galery;

use Yii;
use mosesfender\galery\models\StorageImages;

class ThumbnailComponent extends \yii\base\Component {

    const PROP_IS_PORTRAIT = "portrait";
    const PROP_IS_LANSCAPE = "landscape";
    const PROP_IS_QUADRANT = "quadrant";

    /**
     *
     * @var \mosesfender\galery\GaleryComponent 
     */
    public $parentComponent;
    protected $origMime;
    protected $origSizeX;
    protected $origSizeY;
    protected $origFilename;
    protected $origFilesize;
    protected $origProp = [];
    protected $ret;
    protected $cantCache = false;
    public $maxSide = 0;
    public $maxWidth = 400;
    public $maxHeight = 300;
    public $mime;
    public $compression = 80;
    public $exportTo;
    public $cache;

    public function init() {
        parent::init();
        if ($this->cache) {
            $this->cache = \yii::getAlias($this->cache);
            if (!is_dir($this->cache)) {
                \yii\helpers\BaseFileHelper::createDirectory($this->cache);
            }
        }
    }

    protected function setImage() {
        switch ($this->origMime) {
            case "image/jpeg":
                $this->ret = imagecreatefromjpeg($this->origFilename);
                break;
            case "image/png":
                $this->ret = imagecreatefrompng($this->origFilename);
                break;
            case "image/gif":
                $this->ret = imagecreatefromgif($this->origFilename);
                break;
        }
    }

    public function isCache() {
        return !is_null($this->cache) && is_dir($this->cache);
    }

    public function cacheName(&$model) {
        return \yii\helpers\FileHelper::normalizePath(sprintf("%s/%s", $this->cache, $model->filename));
    }

    public function getThumbFromStorage($id) {
        $model = StorageImages::findOne($id);
        if ($model) {
            if ($this->isCache()) {
                if (file_exists($cacheFile = $this->cacheName($model))) {
                    $fi = getimagesize($cacheFile);
                    header("Content-type: {$fi["mime"]}");
                    exit(file_get_contents($cacheFile));
                } else {
                    $this->cantCache = true;
                    $this->exportTo = $cacheFile;
                }
            }
            $this->origFilename = \yii\helpers\FileHelper::normalizePath(sprintf("%s/%s", $this->parentComponent->storage, $model->filename));
            $fi = getimagesize($this->origFilename);
            $this->origFilesize = filesize($this->origFilename);
            $this->origMime = $fi["mime"];
            $this->origSizeX = $fi[0];
            $this->origSizeY = $fi[1];
            if (!$this->mime) {
                $this->mime = $this->origMime;
            }
            $this->setProportions();
            $this->setImage();
            $this->resize();
            $this->export();
        }
    }

    protected function resize() {
        $orig = $this->ret;
        if ($this->maxSide) {
            switch ($this->origProp[1]) {
                case self::PROP_IS_LANSCAPE:
                    $w = $this->maxSide;
                    $h = $this->maxSide / $this->origProp[0];
                    break;
                case self::PROP_IS_PORTRAIT:
                    $w = $this->maxSide * $this->origProp[0];
                    $h = $this->maxSide;
                    break;
                case self::PROP_IS_QUADRANT:
                    $w = $this->maxSide;
                    $h = $this->maxSide;
                    break;
            }
        } else {
            
        }
        $this->ret = imagecreatetruecolor($w, $h);
        imagealphablending($this->ret, false);
        imagesavealpha($this->ret, true);
        imagecopyresampled($this->ret, $orig, 0, 0, 0, 0, $w, $h, $this->origSizeX, $this->origSizeY);
    }

    protected function export() {
        header("Content-type: {$this->mime}");
        switch ($this->mime) {
            case "image/jpeg":
                if ($this->cantCache) {
                    imagejpeg($this->ret, $this->exportTo, $this->compression);
                }
                imagejpeg($this->ret, null, $this->compression);
                break;
            case "image/png":
                if ($this->cantCache) {
                    imagepng($this->ret, $this->exportTo);
                }
                imagepng($this->ret, null);
                break;
            case "image/gif":
                if ($this->cantCache) {
                    imagegif($this->ret, $this->exportTo);
                }
                imagegif($this->ret, null);
                break;
        }
    }

    protected function setProportions() {
        $this->origProp[0] = $this->origSizeX / $this->origSizeY;
        if ($this->origSizeX == $this->origSizeY) {
            $this->origProp[1] = self::PROP_IS_QUADRANT;
        } else if ($this->origSizeX > $this->origSizeY) {
            $this->origProp[1] = self::PROP_IS_LANSCAPE;
        } else if ($this->origSizeX < $this->origSizeY) {
            $this->origProp[1] = self::PROP_IS_PORTRAIT;
        }
    }

}
