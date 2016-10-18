<?php

namespace mosesfender\galery\models;

use Yii;

/**
 * This is the model class for table "{{%storage_groups}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $settings
 */
class StorageGroups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%storage_groups}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'settings'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('galery', 'ID'),
            'title' => Yii::t('galery', 'Title'),
            'description' => Yii::t('galery', 'Description'),
            'settings' => Yii::t('galery', 'Settings'),
        ];
    }

    /**
     * @inheritdoc
     * @return StorageGroupsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StorageGroupsQuery(get_called_class());
    }
    
    public function getImages(){
        return $this->hasMany(StorageImagesByGroups::className(), ['group_id' => 'id']);
    }
}
