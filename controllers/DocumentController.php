<?php

namespace zabachok\burivuh\controllers;


use Yii;
use zabachok\burivuh\models\Category;
use zabachok\burivuh\models\Document;
use zabachok\burivuh\models\DocumentEdit;
use zabachok\burivuh\models\Folder;

class DocumentController extends Controller
{


    public function actionCreate($parent_id)
    {
        $model = new DocumentEdit();
        $model->category_id = $parent_id;
        $category = Category::findOne($parent_id);
        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $this->redirect($model->url);
        }

        return $this->render('create', [
            'model'    => $model,
            'category' => $category,
        ]);
    }

    public function actionUpdate($document_id)
    {
        $model = DocumentEdit::findOne($document_id);
        if (is_null($model))
        {
            throw new \yii\web\HttpException(404, Yii::t('burivuh', 'The document does not exist'));
        }
        $category = Category::findOne($model->category_id);
        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $this->redirect($model->url);
        }

        return $this->render('update', [
            'model'    => $model,
            'category' => $category,
        ]);
    }

    public function actionView($document_id)
    {
        $model = Document::findOne($document_id);
        if (is_null($model))
        {
            throw new \yii\web\HttpException(404, Yii::t('burivuh', 'The document does not exist'));
        }
        $category = Category::findOne($model->category_id);

        return $this->render('view', [
            'model'    => $model,
            'category' => $category,
        ]);
    }

    public function actionDelete($document_id)
    {
        $model = Document::findOne($document_id);
        if (is_null($model))
        {
            throw new \yii\web\HttpException(404, Yii::t('burivuh', 'The document does not exist'));
        }
        if (isset($_POST['document_id']))
        {

            $category = Category::findOne($model->category_id);
            $model->delete();
            $redirect = ['/burivuh/category/index'];
            if (!is_null($category))
            {
                $redirect = $category->url;
            }
            $this->redirect($redirect);
        }

        return $this->render('delete', [
            'model' => $model,
        ]);
    }


}