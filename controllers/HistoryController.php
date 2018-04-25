<?php

namespace zabachok\burivuh\controllers;

use DiffMatchPatch\DiffMatchPatch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use zabachok\burivuh\models\Document;
use zabachok\burivuh\models\History;

class HistoryController extends Controller
{
    /**
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionIndex(string $id)
    {
        $model = Document::findOne($id);
        if (is_null($model)) {
            throw new NotFoundHttpException(Yii::t('burivuh', 'The document does not exist'));
        }
        $list = History::find()
            ->select(['document_history_id', 'document_id', 'created_at', 'user_id', 'title', 'diff'])
            ->where(['document_id' => $model->document_id])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        return $this->render('history', [
            'model' => $model,
            'list' => $list,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDiff(int $id)
    {
        $model = History::findOne($id);
        if (is_null($model)) {
            throw new NotFoundHttpException(Yii::t('burivuh', 'Record in the history does not exist'));
        }

        $document = Document::findOne($model->document_id);
        $previous = History::find()
            ->where(['document_id' => $model->document_id])
            ->andWhere(['<', 'created_at', $model->created_at])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(1)
            ->one();

        $diffs = [];
        if (!is_null($previous)) {
            $dmp = new DiffMatchPatch();
            $diffs = $dmp->diff_main($previous->content, $model->content, false);
        }

        return $this->render('diff', [
            'document' => $document,
            'model' => $model,
            'previous' => $previous,
            'diffs' => $diffs,
        ]);
    }
}