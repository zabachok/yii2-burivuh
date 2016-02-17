<?php

namespace zabachok\burivuh\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\HttpException;
use zabachok\burivuh\models\Category;
use zabachok\burivuh\models\Document;
use zabachok\burivuh\models\DocumentEdit;
use zabachok\burivuh\models\Folder;
use zabachok\burivuh\models\History;
use zabachok\burivuh\models\Home;
use DiffMatchPatch\DiffMatchPatch;
use yii\helpers\Markdown;

class MainController extends \yii\web\Controller
{

    protected $path;

    public function behaviors()
    {
        return array(
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        );
    }

    public function beforeAction($action)
    {
        $this->path = Yii::$app->request->get('path', '');
        if (strpos($this->path, '..'))
        {
            throw new \yii\web\HttpException(404);
        }

        return parent::beforeAction($action);
    }

    public function actionIndex($title = null)
    {
        if (is_null($title))
        {
            $category = new Home();
        } else
        {
            $category = Category::find()->where(['title' => $title])->one();
        }

        if ($category->category_id != 0 && is_null($category))
        {
            throw new HttpException(404);
        }

        $categories = Category::find()
            ->where(['parent_id' => $category->category_id])
            ->orderBy('title')
            ->all();
        $documents = Document::find()
            ->where(['category_id' => $category->category_id])
            ->orderBy('title')
            ->all();
        $readme = Document::find()->where(['title' => $category->title])->one();

        return $this->render('index', [
            'category'   => $category,
            'categories' => $categories,
            'documents'  => $documents,
            'readme'     => $readme,
        ]);

    }

    public function actionCreate($parent_id)
    {
        $model = new DocumentEdit();
        $model->category_id = $parent_id;
        $category = Category::findOne($parent_id);
        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $this->redirect(['view', 'title' => $model->title]);
        }

        return $this->render('create', [
            'model'    => $model,
            'category' => $category,
        ]);
    }

    public function actionUpdate($title)
    {
        $model = DocumentEdit::find()->where(['title' => $title])->one();
        if (is_null($model))
        {
            throw new \yii\web\HttpException(404, Yii::t('burivuh', 'The document does not exist'));
        }
        $category = Category::findOne($model->category_id);
        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $this->redirect(['view', 'title' => $model->title]);
        }

        return $this->render('update', [
            'model'    => $model,
            'category' => $category,
        ]);
    }

    public function actionView($title)
    {
        $model = Document::find()->where(['title' => $title])->one();
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

    public function actionDelete($title)
    {
        $model = Document::find()->where(['title' => $title])->one();
        if (is_null($model))
        {
            throw new \yii\web\HttpException(404, Yii::t('burivuh', 'The document does not exist'));
        }
        $category = Category::findOne($model->category_id);
        $model->delete();
        $this->redirect(['index', 'title' => $category->title]);
    }

    public function actionCreateCategory($parent_id)
    {
        $model = new Category();
        $model->parent_id = $parent_id;

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $this->redirect(['index', 'title' => $model->title]);
        }

        return $this->render('createCategory', [
            'model' => $model,
        ]);
    }

    public function actionDeleteFolder()
    {
        $model = Folder::read($this->path);
        $model->delete();
        $this->redirect(['index', 'path' => $model->folder]);
    }

    public function actionHistory($title)
    {
        $model = Document::find()->where(['title' => $title])->one();
        if (is_null($model))
        {
            throw new \yii\web\HttpException(404, Yii::t('burivuh', 'The document does not exist'));
        }
        $list = History::find()
            ->select('document_history_id, document_id, created_at, user_id, title, diff')
            ->where(['document_id' => $model->document_id])
            ->orderBy('created_at DESC')
            ->all();

        return $this->render('history', [
            'model' => $model,
            'list'  => $list,
        ]);
    }

    public function actionDiff($document_history_id)
    {
        $model = History::findOne($document_history_id);
        if (is_null($model))
        {
            throw new \yii\web\HttpException(404, Yii::t('burivuh', 'Record in the history does not exist'));
        }
        $document = Document::findOne($model->document_id);
        $previous = History::find()
            ->where(['document_id' => $model->document_id])
            ->andWhere('created_at<:created_at', [':created_at' => $model->created_at])
            ->orderBy('created_at DESC')
            ->limit(1)
            ->one();

        $diffs = [];
        if (!is_null($previous))
        {
            $dmp = new DiffMatchPatch();
            $diffs = $dmp->diff_main(Markdown::process($previous->content, 'gfm'), Markdown::process($model->content, 'gfm'), false);
        }

        return $this->render('diff', [
            'document' => $document,
            'model'    => $model,
            'previous' => $previous,
            'diffs'    => $diffs,
        ]);

    }

}
