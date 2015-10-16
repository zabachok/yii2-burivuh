<?php

namespace zabachok\burivuh\models;

use yii\base\Model;
use zabachok\burivuh\models\Document;

class Folder extends Model
{

    private $_name;
    private $params;
    public $_path;
    public $basePath;
    public $isDir = true;
    public $folder;

    public function init()
    {
        parent::init();
        $this->basePath = \Yii::$app->getModule('burivuh')->filesPath;
    }
    
    public function rules()
    {
        return [
            [['name'], 'required'],
        ];
    }

    public static function open($path)
    {
        $folderPath        = \Yii::$app->getModule('burivuh')->filesPath . $path;
        $list              = scandir($folderPath);
        $return            = [];
        $folderList        = [];
        $isDirMultisort    = [];
        $filenameMultisort = [];
        foreach($list as $key => $file)
        {
            if($file == '..' || $file == '.') continue;
            $isDir                   = is_dir($folderPath . '/' . $file);
            $folderList[$key]        = [
                'isDir' => $isDir,
                'name'  => $file,
            ];
            $filenameMultisort[$key] = $file;
            $isDirMultisort[$key]    = $isDir;
        }

        array_multisort($isDirMultisort, SORT_DESC, SORT_NUMERIC, $filenameMultisort, SORT_ASC, SORT_STRING, $folderList);
        foreach($folderList as $file)
        {

            if($file['isDir']) $return[] = Folder::read($path . '/' . $file['name']);
            else $return[] = Document::read($path . '/' . $file['name']);
        }
        return $return;
    }

    public static function read($path)
    {
        $model       = new Folder;
        $model->path = $path;
        
        return $model;
    }
    
    public function setPath($value)
    {
        $this->_path = $value;
        $len               = (mb_strlen($this->name, 'utf8') + 1) * -1;
        $this->folder      = substr($this->path, 0, $len);
        $this->basePath = $this->basePath . $this->path;
    }
    
    public function getPath()
    {
        return $this->_path;
    }

    public function getName()
    {
        if(empty($this->_name))
        {
            $this->_name = end(explode('/', $this->path));
        }
        return $this->_name;
    }
    
    public function setName($value)
    {
        $this->_name = $value;
    }

    public function save()
    {
        $result = (bool) mkdir($this->basePath . $this->folder . '/' . $this->name);
        return $result;
    }

    public function delete()
    {
        $result = (bool) rmdir($this->basePath);
    }

    public static function pathToBreadcrumbs($path)
    {
        $list = explode('/', $path);
        $links = [];
        $storage = [];
        foreach($list as $key=>$link)
        {
            $storage[] = $link;
            $links[] = [
                'label' => $key == 0 ? 'Корень' : $link,
                'url' => ['/burivuh/main/index', 'path'=>  implode('/', $storage)],

            ];
        }
        unset($links[$key]['url']);
        return $links;
    }

}
