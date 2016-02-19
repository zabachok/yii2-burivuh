Burivuh - markdown editor
=========================
Simple markdown editor for yii2 for your notes

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

Run module migration:
```
php yii migrate --migrationPath=@vendor/zabachok/burivuh/migrations
```


Activating
-----

Add to you config file:

```php
'modules' => [
    ...
    'burivuh'     => [
        'class'     => 'zabachok\burivuh\Module',
        'db'=>'db', //db component
        'usernameCallback' => function($user_id){
            return $user_id;
        }, //callback to print username
        'route' => 'burivuh', //url to module
    ],
]
```


Usage
-----
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
