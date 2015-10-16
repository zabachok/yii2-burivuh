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


Usage
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