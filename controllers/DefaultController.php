<?php

namespace zabachok\burivuh\controllers;

use Yii;

class DefaultController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}