<?php

/**
 * @author Moses Fender <mosesfender@gmail.com>
 */

namespace mosesfender\galery;

class Component extends \yii\base\Component {

    public $dirs = [];

    public function init() {
        parent::init();
        if (is_array($this->dirs)) {
            foreach ($this->dirs as &$dir) {
                $dir = \yii::getAlias($dir);
                if (!is_dir($dir)) {
                    mkdir($dir);
                }
            }
        } else if (is_string($this->dirs)) {
            $dir = \yii::getAlias($this->dirs);
            $this->dirs = [];
            $this->dirs[] = $dir;
            if (!is_dir($dir)) {
                mkdir($dir);
            }
        }
    }

}
