<?php

namespace zabachok\burivuh\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
/**
 * This is the model class for table "burivuh_category".
 *
 * @property integer $category_id
 * @property string $title
 * @property string $created_at
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'burivuh_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            ['created_at', 'safe'],
            ['title', 'string', 'max' => 255],
            ['parent_id', 'integer'],
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
            'category_id' => 'Category ID',
            'title' => 'Title',
            'created_at' => 'Created At',
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

    public function getBreadcrumbs($iterator = 0)
    {
        $breadcrumbs = ['label'=>$this->title,];
        if($iterator != 0) $breadcrumbs['url'] = ['/burivuh/main/index', 'title'=>$this->title];

        if($this->parent_id == 0) return [$breadcrumbs];
        else return array_merge($this->parent->getBreadcrumbs(++$iterator), [$breadcrumbs]);
    }

    public function getParent()
    {
        return $this->hasOne(Category::className(), ['category_id' =>'parent_id']);
    }

    public static function getDB()
    {
        return \Yii::$app->getModule('burivuh')->db;
    }
}