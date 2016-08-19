<?php

namespace zabachok\burivuh\controllers;

use Yii;
use yii\filters\AccessControl;

class Controller extends \yii\web\Controller
{
    public function behaviors()
    {
        return array(
            'access' => [
                'class' => AccessControl::className(),
                'rules' => \Yii::$app->getModule('burivuh')->accessRules,
            ],
        );
    }
}