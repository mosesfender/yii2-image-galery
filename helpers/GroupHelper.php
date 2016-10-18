<?php

namespace mosesfender\galery\helpers;

class GroupHelper {
    const RETURN_DEFAULT = 1;
    const RETURN_IDS_ONLY = 2;
    const RETURN_IDS_IMPLODE = 4;
    
    /**
     * @param integer $groupID
     * @param integer $returnMode
     * @return mosesfender\galery\models\StorageImagesByGroups if $returnMode == 1
     * @return array if $returnMode == 2 Array of cells column 'image_id'
     * @return string if $returnMode == 4 Implode array of return mode aka 2
     */
    public static function getGroupFiles($groupID, $returnMode = self::RETURN_DEFAULT){
        $model = \mosesfender\galery\models\StorageImagesByGroups::find()->where(["=", "group_id", $groupID]);
        switch($returnMode){
            case self::RETURN_DEFAULT:
                return $model->all();
                break;
            case self::RETURN_IDS_ONLY:
                return $model->column();
                break;
            case self::RETURN_IDS_IMPLODE:
                return implode(",",$model->column());
                break;
        }
    }
}