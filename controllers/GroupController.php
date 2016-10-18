<?php

namespace mosesfender\galery\controllers;

use Yii;
use mosesfender\galery\models\StorageGroups;
use mosesfender\galery\models\StorageGroupsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GroupController implements the CRUD actions for StorageGroups model.
 */
class GroupController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'delete-image' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all StorageGroups models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new StorageGroupsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StorageGroups model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = StorageGroups::find()->where(["=", "id", $id])->one();
        $grid = $this->actionGroupFiles($model->id);
        $modelGroupList = StorageGroups::find()->where(["!=", "id", $id])->all();
        return $this->render('view', [
                    'model' => $model, 'grid' => $grid, 'modelGroupList' => $modelGroupList
        ]);
    }

    /**
     * Creates a new StorageGroups model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new StorageGroups();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing StorageGroups model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing StorageGroups model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the StorageGroups model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StorageGroups the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = StorageGroups::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Удаляет файл из группы. Не из хранилища.
     */
    public function actionDeleteImage() {
        $iid = \yii::$app->request->get("id");
        $gid = \yii::$app->request->get("group");
        $qq = \yii::$app->db->createCommand()->delete(\mosesfender\galery\models\StorageImagesByGroups::tableName(), "image_id = {$iid} AND group_id = {$gid}");
        if ($qq->execute()) {
            \yii::trace("Из группы {$gid} удалено изображние {$iid}.");
        } else {
            \yii::trace("Не удалось удалить изображние {$iid} из группы {$gid}.");
        }
        //return $this->actionGroupFiles($gid);
    }

    /**
     * Возвращает HTML-код GridView группы $id
     * @param integer $id ID of group
     * @return string HTML code
     */
    public function actionGroupFiles($id) {
        $model = $this->findModel($id);
        $includes = \mosesfender\galery\helpers\GroupHelper::getGroupFiles($model->id, \mosesfender\galery\helpers\GroupHelper::RETURN_IDS_IMPLODE);
        if($includes){
            $imagesModel = \mosesfender\galery\models\StorageImages::find()->where("id IN ({$includes})");
        } else {
            $imagesModel = \mosesfender\galery\models\StorageImages::find()->where(["=", "id", 0]);
        }
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $imagesModel,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->renderPartial("_fileList", ["dataProvider" => $dataProvider, "model" => $model]);
    }
    
    
    /**
     * Возвращает HTML-код изображений группы $id
     * @param integer $id ID of group
     * @param integer|boolean $diffGroupID Группа, изображения которой не должны присутствовать в выборке
     * @param boolean $canDublicate Флаг, сообщающий о том, что в выборке не должно быть рядов из группы $diffGroupID
     * @return string HTML code
     */
    public function actionGroupThumbs($id, $diffGroupID = false, $canDublicate = false){
        
        $model = $this->findModel($id);
        $imagesIds = $model->images;
        $ids = [];
        if (count($imagesIds)) {
            foreach ($imagesIds as $val) {
                $ids[] = $val->image_id;
            }
            $ids = implode(",", $ids);
            $imagesModel = \mosesfender\galery\models\StorageImages::find()->where("id IN ({$ids})")->all();
        } else {
            $imagesModel = \mosesfender\galery\models\StorageImages::find()->where(["=", "id", 0])->all();
        }
        return $this->renderPartial("_thumbList", ["model" => $imagesModel]);
    }
    
    public function beforeAction($action) {
//        if (\yii::$app->request->isAjax) {
//            \yii::$app->assetManager->bundles = [
//                'yii\web\JqueryAsset' => false
//            ];
//        }
//        
        file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . $action->actionMethod . ".txt", json_encode(\yii::$app->request->post()));
        return parent::beforeAction($action);
    }

}
