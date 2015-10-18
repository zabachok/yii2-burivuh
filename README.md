Burivuh - markdown editor
=========================
Simple markdown editor for yii2 using filesystem

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist zabachok/yii2-burivuh "*"
```

or add

```
"zabachok/yii2-burivuh": "*"
```

to the require section of your `composer.json` file.


Activating
-----

Add to you config file:

```php
'modules' => [
    ...
    'burivuh' => [
            'class' => 'zabachok\burivuh\Module',
            'filesPath' => dirname(__DIR__) . '/data/burivuh',
        ],
]
```


Usage
-----
Open url: http://your-site.com/burivuh  
You can create, update and delete .md documents. All actions is available only for authorized users.


## Hot keys
### In list
Arrow up and arrow down - moving up and down in list  
Enter - open dir or file  
Backspace - up in filesystem tree  
### In view
Ctrl + e - edit the document  
### In write
Ctrl + s - save document  
Shift + Enter - new line  
Tab - four spaces  
