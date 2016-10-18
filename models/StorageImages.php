<?php

namespace mosesfender\galery\models;

use Yii;

/**
 * This is the model class for table "storage_images".
 *
 * @property string $id
 * @property string $filename
 * @property string $mime
 * @property integer $sizeX
 * @property integer $sizeY
 * @property integer $filesize
 */
class StorageImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%storage_images}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sizeX', 'sizeY', 'filesize'], 'integer'],
            [['filename'], 'string', 'max' => 255],
            [['mime'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filename' => 'Filename',
            'mime' => 'Mime',
            'sizeX' => 'Size X',
            'sizeY' => 'Size Y',
            'filesize' => 'Filesize',
        ];
    }
}
