<?php

namespace zabachok\burivuh\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use zabachok\burivuh\models\History;

/**
 * This is the model class for table "burivuh_document".
 *
 * @property integer $document_id
 * @property string $title
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property Category $category
 */
class Document extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'burivuh_document';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            ['title', 'match', 'pattern'=>'|[\w\d\-\ ]|u'],
            ['title', 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'document_id' => 'Document ID',
            'title' => 'Title',
            'content' => 'Content',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function getTimeAgo()
    {
        return Yii::$app->formatter->asRelativeTime(strtotime($this->updated_at));
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['category_id'=>'category_id']);
    }

    public function getLastEdit()
    {
        return $this->hasOne(History::className(), ['document_id'=>'document_id'])
            ->orderBy('created_at DESC');
    }

    public function getBreadcrumbs($iterator = 0)
    {
        $breadcrumbs = ['label'=>$this->title,];
        if($iterator != 0) $breadcrumbs['url'] = ['/burivuh/main/view', 'title'=>$this->title];
        if($this->category_id == 0) return [$breadcrumbs];
        return array_merge($this->category->getBreadcrumbs($iterator), [$breadcrumbs]);
    }

    public static function getDB()
    {
        return \Yii::$app->{\Yii::$app->getModule('burivuh')->db};
    }
}
