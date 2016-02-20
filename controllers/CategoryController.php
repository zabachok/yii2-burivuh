<?php

namespace zabachok\burivuh\controllers;


use Yii;
use zabachok\burivuh\models\Category;
use zabachok\burivuh\models\Document;
use zabachok\burivuh\models\Folder;
use zabachok\burivuh\models\Home;

class CategoryController extends Controller
{

    public function actionIndex($category_id = null)
    {
        if (is_null($category_id))
        {
            $category = new Home();
        } else
        {
            $category = Category::findOne($category_id);
        }

        if ($category->category_id != 0 && is_null($category))
        {
            throw new \yii\web\HttpException(404, Yii::t('burivuh', 'The category does not exist'));
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
            'title'       => $category->title,
            'category_id' => $category->category_id,
        ])->one();

        return $this->render('index', [
            'category'   => $category,
            'categories' => $categories,
            'documents'  => $documents,
            'readme'     => $readme,
        ]);

    }

    public function actionCreate($parent_id)
    {
        $model = new Category();
        $model->parent_id = $parent_id;
        if($parent_id == 0)
        {
            $parent = new Home();
        }else
        {
            $parent = Category::findOne($parent_id);
            if (is_null($parent))
            {
                throw new \yii\web\HttpException(404, Yii::t('burivuh', 'The category does not exist'));
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $this->redirect($model->url);
        }

        return $this->render('create', [
            'model' => $model,
            'parent'=>$parent,
        ]);
    }

    public function actionDelete($category_id)
    {
        $model = Category::findOne($category_id);
        if (is_null($model))
        {
            throw new \yii\web\HttpException(404, Yii::t('burivuh', 'The category does not exist'));
        }
        if (isset($_POST['category_id']))
        {
            $parent = $model->parent;
            $model->delete();
            $redirect = ['index'];
            if (!is_null($parent))
            {
                $redirect = $parent->url;
            }
            $this->redirect($redirect);
        }

        return $this->render('delete', [
            'model' => $model,
        ]);
    }

}