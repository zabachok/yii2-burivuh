<?php

namespace zabachok\burivuh\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use zabachok\burivuh\models\Category;
use zabachok\burivuh\models\Document;
use zabachok\burivuh\models\Home;

class CategoryController extends Controller
{
    /**
     * @param integer|null $id
     * @return mixed
     * @throws HttpException
     */
    public function actionIndex(?int $id = null)
    {
        if (is_null($id)) {
            $category = new Home();
        } else {
            $category = Category::findOne($id);
        }

        if ($category->category_id != 0 && is_null($category)) {
            throw new NotFoundHttpException(Yii::t('burivuh', 'The category does not exist'));
        }

        $categories = Category::find()
            ->where(['parent_id' => $category->category_id])
            ->orderBy('title')
            ->all();
        $documents = Document::find()
            ->where(['category_id' => $category->category_id])
            ->orderBy('title')
            ->all();
        $readme = Document::find()->where([
            'title' => $category->title,
            'category_id' => $category->category_id,
        ])->one();

        return $this->render('index', [
            'category' => $category,
            'categories' => $categories,
            'documents' => $documents,
            'readme' => $readme,
        ]);

    }

    /**
     * @param int $parentId
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCreate(int $parentId = 0)
    {
        $model = new Category();
        $model->parent_id = $parentId;
        
        if ($parentId == 0) {
            $parent = new Home();
        } else {
            $parent = Category::findOne($parentId);
            if (is_null($parent)) {
                throw new NotFoundHttpException(Yii::t('burivuh', 'The category does not exist'));
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect($model->url);
        }

        return $this->render('create', [
            'model' => $model,
            'parent' => $parent,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $model = Category::findOne($id);
        if (is_null($model)) {
            throw new NotFoundHttpException(Yii::t('burivuh', 'The category does not exist'));
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect($model->url);
        }

        $parent = Category::findOne($model->parent_id);

        return $this->render('update', [
            'model' => $model,
            'parent' => $parent,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws HttpException
     */
    public function actionDelete(int $id)
    {
        $model = Category::findOne($id);
        if (is_null($model)) {
            throw new HttpException(404, Yii::t('burivuh', 'The category does not exist'));
        }

        if (isset($_POST['category_id'])) {
            //TODO resolve that shit
            $parent = $model->parent;

            $model->delete();
            $redirect = ['index'];
            if (!is_null($parent)) {
                $redirect = $parent->url;
            }

            $this->redirect($redirect);
        }

        return $this->render('delete', [
            'model' => $model,
        ]);
    }
}
