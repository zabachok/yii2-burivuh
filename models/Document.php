<?php

namespace zabachok\burivuh\models;

use Yii;
use yii\base\Model;
use yii\helpers\Markdown;

class Document extends Model
{

    private $_path;
    private $_content;
    private $isNewRecord = true;
    private $params;
    public $name;
    public $basePath;
    public $folder;
    public $timeAgo;
    public $prettySize;
    public $isDir        = false;
    public $data         = [];
    public $stat;
    public $fileExists;

    public function init()
    {
        parent::init();
        $this->basePath = \Yii::$app->getModule('burivuh')->filesPath;
    }

    public function rules()
    {
        return [
            [['name', 'content'], 'required'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name'    => 'Filename',
            'content' => 'Content',
        ];
    }

    public static function read($filepath)
    {
        $model       = new Document();
        $model->path = $filepath;
        if(!$model->fileExists) return null;
        return $model;
    }

    public function getPath()
    {
        return $this->_path;
    }

    public function setPath($value)
    {
        if(!is_null($this->_path)) throw new \yii\base\ErrorException('You can not use this object for another document');
        $this->_path       = $value;
        $this->basePath    = $this->basePath . $this->path;
        $this->isNewRecord = false;
        $this->name        = end(explode('/', $this->path));
        $len               = (mb_strlen($this->name, 'utf8') + 1) * -1;
        $this->folder      = mb_substr($this->path, 0, $len, 'utf8');
        $this->fileExists  = file_exists($this->basePath);
        if(!$this->fileExists) return;
        $this->stat        = stat($this->basePath);
        $this->prettySize  = $this->getPrettySize($this->stat['size']);
        $this->timeAgo     = $this->getTimeAgo($this->stat['mtime']);
    }

    public function getContent()
    {
        if(empty($this->_content))
        {
            if($this->isNewRecord) $this->_content = '';
            else $this->_content = file_get_contents($this->basePath);
        }
        return $this->_content;
    }

    public function setContent($value)
    {
        $this->_content = $value;
    }

    public function getMarkdown()
    {
        return Markdown::process($this->content, 'gfm');
    }

    public function save()
    {
        if($this->isNewRecord) $path = $this->folder . '/' . $this->name;
        else $path = $this->path;
        $path = $this->basePath . $path;


        $result = (bool) file_put_contents($path, $this->content);
        if($result)
        {
            $this->isNewRecord = false;
            if($this->isNewRecord) $this->path        = $path;
        }

        return $result;
    }

    public function delete()
    {
        unlink($this->basePath);
    }

    public function getPrettySize($size)
    {
        return Yii::$app->formatter->asSize($size);
    }

    public function getTimeAgo($date)
    {
        return Yii::$app->formatter->asRelativeTime($date);
    }
    
}
