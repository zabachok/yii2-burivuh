<?php

namespace zabachok\burivuh\controllers;


use Yii;
use zabachok\burivuh\models\Document;
use zabachok\burivuh\models\Folder;
use zabachok\burivuh\models\History;
use DiffMatchPatch\DiffMatchPatch;

class HistoryController extends Controller
{


    public function actionIndex($title)
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
            $diffs = $dmp->diff_main($previous->content, $model->content, false);
        }

        return $this->render('diff', [
            'document' => $document,
            'model'    => $model,
            'previous' => $previous,
            'diffs'    => $diffs,
        ]);
    }
}