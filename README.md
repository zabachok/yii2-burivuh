# Burivuh - notepad with markdown editor
Simple notepad with markdown editor for yii2
[Все это на русском](https://zabachok.net/repositories/burivuh)

## Installation

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

Run module migration:
```
php yii migrate --migrationPath=@vendor/zabachok/yii2-burivuh/migrations
```


## Activating

Add to you config file:

```php
'modules' => [
    ...
    'burivuh' => [
        'class' => zabachok\burivuh\Module::class,
    ],
]
```
and to bootstrapping:

```php
'bootstrap' => [..., zabachok\burivuh\Bootstrap::class],
```

## Options

1. `db` - name of database component: 
```php
'burivuh' => [
        'class' => zabachok\burivuh\Module::class,
        'db'=>'db',
    ...
    ],
```
1. `usernameCallback` - anonymous function for generate username:
```php
'burivuh' => [
        'class' => zabachok\burivuh\Module::class,
        'usernameCallback'	=>function($user_id)
            {
                $user = \common\models\user\User::findIdentity($user_id);
                return is_null($user) ? 'Undefined' : $user->username;
            },
    ...
    ],
```
1. `route` - you can use custom route to this module. For example:
```php
'burivuh' => [
        'class' => zabachok\burivuh\Module::class,
        'route' => 'wiki',
    ...
    ],
```
It will be generate links like `example.com/wiki/doc/mydoc`
1. `accessRules` - this option configuring [AccessControl::rules](http://www.yiiframework.com/doc-2.0/yii-filters-accesscontrol.html) component. For example:
```php
'burivuh' => [
        'class' => zabachok\burivuh\Module::class,
        'as access' => [
            'class' => yii\filters\AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['?'],
                ],
            ],
        ],
    ...
    ],
```

## Usage

Open url: http://your-site.com/burivuh  
You can create, update and delete categories and documents. All actions is available only for authorized users.


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

**Text formatting**
Ctrl + h - make this line a header
