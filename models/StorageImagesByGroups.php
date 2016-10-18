<?php

namespace mosesfender\galery\models;

use Yii;

/**
 * This is the model class for table "storage_images_by_groups".
 *
 * @property string $image_id
 * @property integer $group_id
 * @property integer $flags
 * @property integer $priority
 * @property \mosesfender\galery\models\StorageImages $file
 */
class StorageImagesByGroups extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'storage_images_by_groups';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['image_id'], 'required'],
            [['image_id', 'group_id', 'flags', 'priority'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'image_id' => Yii::t('galery', 'Image ID'),
            'group_id' => Yii::t('galery', 'Group ID'),
            'flags' => Yii::t('galery', 'Flags'),
            'priority' => Yii::t('galery', 'Priority'),
        ];
    }

    /**
     * @inheritdoc
     * @return StorageImagesByGroupsQuery the active query used by this AR class.
     */
    public static function find() {
        return new StorageImagesByGroupsQuery(get_called_class());
    }

    /**
     * @inheritdoc
     * @return \mosesfender\galery\models\StorageImages
     */
    public function getFile() {
        return $this->hasOne(\mosesfender\galery\models\StorageImages::className(), ["id" => "image_id"]);
    }

}
