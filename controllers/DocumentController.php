<?php

namespace zabachok\burivuh\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use zabachok\burivuh\models\Category;
use zabachok\burivuh\models\Document;
use zabachok\burivuh\models\DocumentEdit;

class DocumentController extends Controller
{
    /**
     * @param int $parentId
     * @return string
     */
    public function actionCreate(int $parentId)
    {
        $model = new DocumentEdit();
        $model->category_id = $parentId;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect($model->url);
        }

        $category = Category::findOne($parentId);

        return $this->render('create', [
            'model' => $model,
            'category' => $category,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $model = DocumentEdit::findOne($id);
        if (is_null($model)) {
            throw new NotFoundHttpException(Yii::t('burivuh', 'The document does not exist'));
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect($model->url);
        }

        //TODO check using
        $category = Category::findOne($model->category_id);

        return $this->render('update', [
            'model' => $model,
            'category' => $category,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id)
    {
        $model = Document::findOne($id);
        if (is_null($model)) {
            throw new NotFoundHttpException(Yii::t('burivuh', 'The document does not exist'));
        }

        //TODO check using
        $category = Category::findOne($model->category_id);

        return $this->render('view', [
            'model' => $model,
            'category' => $category,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = Document::findOne($id);
        if (is_null($model)) {
            throw new NotFoundHttpException(Yii::t('burivuh', 'The document does not exist'));
        }

        if (isset($_POST['document_id'])) {
            $category = Category::findOne($model->category_id);
            $model->delete();

            //TODO resolve that shit
            $redirect = ['/burivuh/category/index'];
            if (!is_null($category)) {
                $redirect = $category->url;
            }
            $this->redirect($redirect);
        }

        return $this->render('delete', [
            'model' => $model,
        ]);
    }


}