<?php

namespace mosesfender\galery\models;

/**
 * This is the ActiveQuery class for [[StorageImages]].
 *
 * @see StorageImages
 */
class StorageImagesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return StorageImages[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return StorageImages|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
