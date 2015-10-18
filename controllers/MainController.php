<?php

namespace zabachok\burivuh\controllers;

use Yii;
use yii\filters\AccessControl;
use zabachok\burivuh\models\Document;
use zabachok\burivuh\models\Folder;

class MainController extends \yii\web\Controller
{

    protected $path;

    public function behaviors()
    {
        return array(
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
        );
    }

    public function beforeAction($action)
    {
        $this->path = Yii::$app->request->get('path', '');
        if(strpos($this->path, '..')) throw new \yii\web\HttpException(404);
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        if($this->path == '/') $this->redirect(['/burivuh/main/index', 'path'=>'']);
        $folder      = Folder::open($this->path);
        $readme      = Document::read($this->path . '/README.md');
        $breadcrumbs = Folder::pathToBreadcrumbs($this->path);
        if($this->path == '') $backDir     = null;
        else $backDir     = dirname($this->path);

        if($backDir == '/') $backDir = '';
        var_dump($backDir);
        return $this->render('index', [
                'path'        => $this->path,
                'folder'      => $folder,
                'readme'      => $readme,
                'breadcrumbs' => $breadcrumbs,
                'backDir'     => $backDir,
        ]);
    }

    public function actionCreate()
    {
        $model         = new Document();
        $model->folder = $this->path;
        $breadcrumbs   = Folder::pathToBreadcrumbs($this->path);
        if($model->load(Yii::$app->request->post()) && $model->save())
        {
            $this->redirect(['index', 'path' => $model->folder]);
        }
        return $this->render('create', [
                'model'       => $model,
                'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function actionUpdate()
    {
        $model       = Document::read($this->path);
        if(is_null($model)) throw new \yii\web\HttpException(404);
        $breadcrumbs = Folder::pathToBreadcrumbs($this->path);
        if($model->load(Yii::$app->request->post()) && $model->save())
        {
            $this->redirect(['index', 'path' => $model->folder]);
        }
        return $this->render('update', [
                'model'       => $model,
                'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function actionView()
    {
        $model       = Document::read($this->path);
        if(is_null($model) || $model->extension != 'md') throw new \yii\web\HttpException(404, 'File dosn\'t exists');
        $breadcrumbs = Folder::pathToBreadcrumbs($this->path);
        return $this->render('view', [
                'model'       => $model,
                'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function actionDelete()
    {
        $model = Document::read($this->path);
        if(is_null($model)) throw new \yii\web\HttpException(404);
        $model->delete();
        $this->redirect(['index', 'path' => $model->folder]);
    }

    public function actionCreateFolder()
    {
        $model         = new Folder();
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
