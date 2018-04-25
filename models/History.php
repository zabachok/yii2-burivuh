<?php

namespace zabachok\burivuh\models;

use DiffMatchPatch\DiffMatchPatch;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "burivuh_history".
 *
 * @property integer $document_hystory_id
 * @property integer $document_id
 * @property string $created_at
 * @property string $content
 * @property string $title
 */
class History extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'burivuh_history';
    }

    public static function findByDocument($document_id)
    {
        return self::find()
            ->where(['document_id' => $document_id])
            ->orderBy('created_at DESC')
            ->one();
    }

    public static function getDB()
    {
        return \Yii::$app->{\Yii::$app->getModule('burivuh')->db};
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['document_id', 'content', 'title'], 'required'],
            [['document_id', 'user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['content', 'diff'], 'string'],
            [['title'], 'string', 'max' => 255],
            ['diff', 'default', 'value' => '0:0'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'document_history_id' => 'Document History ID',
            'document_id' => 'Document ID',
            'created_at' => 'Created At',
            'content' => 'Content',
            'title' => 'Title',
            'user_id' => 'User id',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function renderDiff($lastEdit)
    {
        $dmp = new DiffMatchPatch();
        $diffs = $dmp->diff_main($this->content, $lastEdit->content, false);
        $added = 0;
        $deleted = 0;
        foreach ($diffs as $diff) {
            $length = mb_strlen($diff[1], 'utf-8');
            if ($diff[0] == 1) {
                $added += $length;
            }
            if ($diff[0] == -1) {
                $deleted += $length;
            }
        }
        $this->diff = $added . ':' . $deleted;
    }
}