<?php

namespace zabachok\burivuh\models;

use yii\helpers\Markdown;

class DocumentEdit extends Document
{
    protected $historyTemp;

    public function afterFind()
    {
        $lastEdit = $this->lastEdit;
        $this->title = $lastEdit->title;
        $this->content = $lastEdit->content;
    }

    public function beforeSave($insert)
    {
        parent::beforeSave($insert);

        $this->historyTemp = new History();
        $this->historyTemp->attributes = [
            'title' => $this->title,
            'content' => $this->content,
//            'user_id'=>\Yii::$app->user->id,
            'user_id' => 1,
        ];
        $this->content = Markdown::process($this->content, 'gfm');
        if (!$this->isNewRecord) {
            $this->historyTemp->renderDiff($this->lastEdit);
        }
        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->historyTemp->document_id = $this->document_id;
        $this->historyTemp->save();
        return true;
    }
}