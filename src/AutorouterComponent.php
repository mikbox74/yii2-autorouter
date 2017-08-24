<?php

/**
 * @link http://github.com/mikbox74
 * @copyright Copyright (c) 2017 Michail Urakov
 * @license MIT
 */

namespace mikbox74\Autorouter;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Module;

/**
 * This component allows modules to create rules for UrlManager by method.
 *
 * Step 1: add the component in bootstrap list of your application (main.php, main-local.php)
 * like here:
 *
 * ```php
 * return [
 *     // ...
 *      'bootstrap' => [
 *          [
 *              'class' => \mikbox74\Autorouter\AutorouterComponent::class,
 *          ],
 *          //...
 *      ],
 * ];
 * ```
 *
 * Step 2: make your module class to implement \mikbox74\Autorouter\AutorouterInterface
 * then add a method getUrlRules() and make it returning a rule array as if you configure
 * the module's rules in main.php or main-local.php,
 * like in the example:
 *
 * ```php
 *  public static function getUrlRules()
 *  {
 *      return [
 *          [
 *              'class' => 'yii\rest\UrlRule',
 *              'controller' => [
 *                  'mymodule/controller',
 *              ],
 *          ],
 *
 *          'GET  mymodule/controller/<id:\d+>'   => 'mymodule/controller/view',
 *          'POST mymodule/controller'            => 'mymodule/controller/create',
 *          'PUT mymodule/controller/<id:\d+>'    => 'mymodule/controller/update',
 *          'DELETE mymodule/controller/<id:\d+>' => 'mymodule/controller/delete',
 *      ];
 *  }
 * ```
 * @author Michail Urakov <mikbox74@gmail.com>
 */
class AutorouterComponent extends \yii\base\Component implements BootstrapInterface
{

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->on(Application::EVENT_BEFORE_REQUEST, [$this, 'processModuleUrlRules']);
    }

    /**
     * Adds rules in getUrlManager
     *
     * @param $event
     * @return bool
     */
    public function processModuleUrlRules($event)
    {
        foreach (Yii::$app->modules as $module) {
            $class = Module::class;
            if (is_array($module)) {
                $class = $module['class'];
            } else if (is_string($module)) {
                $class = $module;
            } else if (is_a($module, Module::class)) {
                $class = $module::className();
            }
            if (!is_subclass_of($class, AutorouterInterface::class)) {
                continue;
            }
            $urlManager = Yii::$app->getUrlManager();
            $urlManager->addRules($class::getUrlRules());
        }
        return true;
    }
}