<?php

namespace mosesfender\galery\models;

/**
 * This is the ActiveQuery class for [[StorageImagesByGroups]].
 *
 * @see StorageImagesByGroups
 */
class StorageImagesByGroupsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return StorageImagesByGroups[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return StorageImagesByGroups|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
