# yii2-autorouter
This component allows modules to create rules for UrlManager by method.

Step 1: add the component in bootstrap list of your application (main.php, main-local.php)
like here:

```php
return [
    // ...
     'bootstrap' => [
         [
             'class' => \mikbox74\Autorouter\AutorouterComponent::class,
         ],
         //...
     ],
];
```

Step 2: make your module class to implement \mikbox74\Autorouter\AutorouterInterface
then add a method getUrlRules() and make it returning a rule array as if you configure
the module's rules in main.php or main-local.php,
like in the example:

```php
 public static function getUrlRules()
 {
     return [
         [
             'class' => 'yii\rest\UrlRule',
             'controller' => [
                 'mymodule/controller',
             ],
         ],

         'GET  mymodule/controller/<id:\d+>'   => 'mymodule/controller/view',
         'POST mymodule/controller'            => 'mymodule/controller/create',
         'PUT mymodule/controller/<id:\d+>'    => 'mymodule/controller/update',
         'DELETE mymodule/controller/<id:\d+>' => 'mymodule/controller/delete',
     ];
 }
```
