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
    public $oldFilename;
    public $filename;
    public $basePath;
    public $filesPath;
    public $folder;
    public $timeAgo;
    public $prettySize;
    public $isDir        = false;
    public $data         = [];
    public $stat;
    public $fileExists;
    public $extension = 'md';

    public function init()
    {
        parent::init();
        $this->filesPath = \Yii::$app->getModule('burivuh')->filesPath;
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

    public function setName($value)
    {
        $value = preg_replace('|[^\d\w_\-]|u', '', $value);
        $this->filename = $value . '.' . $this->extension;
    }

    public function getName()
    {
        return basename($this->filename, '.' . $this->getExtension($this->filename));
    }

    public function getExtension($filepath)
    {
        return strtolower(substr(strrchr($filepath, '.'), 1));
    }

    public function setPath($value)
    {
        if(!is_null($this->_path)) throw new \yii\base\ErrorException('You can not use this object for another document');
        $this->_path       = $value;
        $this->basePath    = $this->filesPath . $this->path;
        $this->isNewRecord = false;
        $filenameArray = explode('/', $this->path);
        $this->filename    = end($filenameArray);
        $this->oldFilename = $this->filename;
        $this->extension   = $this->getExtension($this->filename);
        $this->folder      = dirname($this->path);
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
        if(!$this->validate()) return false;
        $path = $this->filesPath . $this->folder . '/' . $this->filename;

        $result = (bool) file_put_contents($path, $this->content);
        if($result)
        {
            if(!$this->isNewRecord && $this->filename != $this->oldFilename) unlink($this->filesPath . $this->folder . '/' . $this->oldFilename);
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
