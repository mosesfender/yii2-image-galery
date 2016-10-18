<?php

namespace mosesfender\galery\models;

use Yii;

/**
 * This is the model class for table "{{%storage_images_meta}}".
 *
 * @property string $id
 * @property integer $group_id
 * @property string $title
 * @property string $alt
 * @property string $description
 */
class StorageImagesMeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%storage_images_meta}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'group_id'], 'integer'],
            [['title', 'alt', 'description'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Group ID',
            'title' => 'Title',
            'alt' => 'Alt',
            'description' => 'Description',
        ];
    }
}
