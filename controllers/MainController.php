<?php

namespace zabachok\burivuh\controllers;

use Yii;
use zabachok\burivuh\models\Document;
use zabachok\burivuh\models\Folder;

class MainController extends \yii\web\Controller
{

    protected $path;

    public function beforeAction($action)
    {
        $this->path = Yii::$app->request->get('path', '');
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $folder      = Folder::open($this->path);
        $readme      = Document::read($this->path . '/README.md');
        $breadcrumbs = Folder::pathToBreadcrumbs($this->path);

        return $this->render('index', [
                'path'        => $this->path,
                'folder'      => $folder,
                'readme'      => $readme,
                'breadcrumbs' => $breadcrumbs,
        ]);
    }
    
    public function actionCreate()
    {
        $model         = new Document();
        $model->folder = $this->path;
        $breadcrumbs = Folder::pathToBreadcrumbs($this->path);
        if($model->load(Yii::$app->request->post()) && $model->save())
        {
            $this->redirect(['index', 'path' => $model->folder]);
        }
        return $this->render('create', [
                'model' => $model,
                'breadcrumbs' => $breadcrumbs,
        ]);
    }
    
    public function actionUpdate()
    {
        $model = Document::read($this->path);
        $breadcrumbs = Folder::pathToBreadcrumbs($this->path);
        if($model->load(Yii::$app->request->post()) && $model->save())
        {
            $this->redirect(['index', 'path' => $model->folder]);
        }
        return $this->render('update', [
                'model' => $model,
                'breadcrumbs' => $breadcrumbs,
        ]);
    }
    
    public function actionView()
    {
        $model = Document::read($this->path);
        $breadcrumbs = Folder::pathToBreadcrumbs($this->path);
        return $this->render('view', [
                'model' => $model,
                'breadcrumbs' => $breadcrumbs,
        ]);
    }
    
    public function actionDelete()
    {
        $model = Document::read($this->path);
        $model->delete();
        $this->redirect(['index', 'path' => $model->folder]);
    }
    
    public function actionCreateFolder()
    {
        $model = new Folder();
        $model->folder = $this->path;
        
        if($model->load(Yii::$app->request->post()) && $model->save())
        {
            $this->redirect(['index', 'path' => $model->folder]);
        }

        return $this->render('createFolder', [
                'model' => $model,
        ]);
    }

    public function actionDeleteFolder()
    {
        $model = Folder::read($this->path);
        $model->delete();
        $this->redirect(['index', 'path' => $model->folder]);
    }

}
