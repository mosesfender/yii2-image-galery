<?php

namespace mosesfender\galery\models;

/**
 * This is the ActiveQuery class for [[StorageGroups]].
 *
 * @see StorageGroups
 */
class StorageGroupsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return StorageGroups[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return StorageGroups|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
