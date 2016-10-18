<?php

namespace mosesfender\galery\helpers;

class UnitHelper {

    public static function deleteFile(&$module) {
        /**
         * @param mosesfender\galery\Module $module
         */
        $id = \yii::$app->request->get();
        $model = \mosesfender\galery\models\StorageImages::findOne($id);
        if ($model) {
            self::deleteFileFromGroups($model->id);
            if (file_exists("{$module->storage}/{$model->filename}")) {
                unlink("{$module->storage}/{$model->filename}");
            }
            $model->delete();
            $model->trigger(\mosesfender\galery\Module::EVENT_DELETE_IMAGE, new \mosesfender\galery\DeleteImage($id));
        }
    }

    public static function deleteFileFromGroups($id) {
        $model = \mosesfender\galery\models\StorageImagesByGroups::find("image_id = {$id}")->all();
        if ($model) {
            /* @var mosesfender\galery\models\StorageImagesByGroups $el */
            foreach ($model as $el) {
                $el->delete();
            }
        }
    }
    
    public static function moveFileToGroup(&$model, $groupID){
        \yii::info(sprintf("%d %d", $groupID, $model->id), "group");
        $groupModel = new \mosesfender\galery\models\StorageImagesByGroups;
        $groupModel->group_id = $groupID;
        $groupModel->image_id = $model->id;

        \yii::info(sprintf("%d %d %d", $groupID, $model->id, $groupModel->save()), "group");
    }

}
