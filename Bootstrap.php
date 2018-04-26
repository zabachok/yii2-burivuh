<?php

namespace zabachok\burivuh;

use Yii;
use yii\base\BootstrapInterface;

/**
 * Users module bootstrap class.
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $route = Yii::$app->getModule('burivuh')->route;
        $app->urlManager->addRules(
            [
                $route . 'category/<id:\d+>-<title:.+>' => 'burivuh/category/index',
                $route . 'doc/<id:\d+>-<title:.+>' => 'burivuh/document/view',

                $route . 'doc/create/<parentId:\d+>' => 'burivuh/document/create',
                $route . 'category/create/<parentId:\d+>' => 'burivuh/category/create',

                $route . 'doc/<action:delete|update>/<id:\d+>-<title:.+>' => 'burivuh/document/<action>',
                $route . 'category/<action:delete|update>/<id:\d+>-<title:.+>' => 'burivuh/category/<action>',

                $route . 'history/<id:\d+>-<title:.+>' => 'burivuh/history/index',
                $route . 'history/diff/<id:\d+>' => 'burivuh/history/diff',

                $route => 'burivuh/category/index',
            ], false
        );

        if (!isset($app->i18n->translations['burivuh']) && !isset($app->i18n->translations['burivuh*'])) {
            $app->i18n->translations['burivuh'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@zabachok/burivuh/messages',
                'forceTranslation' => true,
            ];
        }
    }
}
