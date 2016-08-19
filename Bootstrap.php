<?php

namespace zabachok\burivuh;

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
        $route = \Yii::$app->getModule('burivuh')->route;
        $app->urlManager->addRules(
            [
                $route . '/category/<category_id:\d+>-<title:.+>' => 'burivuh/category/index',
                $route . '/doc/<document_id:\d+>-<title:.+>'      => 'burivuh/document/view',

                $route . '/doc/<action:create|delete|update>/<document_id:\d+>-<title:.+>' => 'burivuh/document/<action>',
                $route . '/category/create'                                                => 'burivuh/category/create',
                $route . '/category/<action:delete|update>/<category_id:\d+>-<title:.+>'   => 'burivuh/category/<action>',

                $route . '/history/<document_id:\d+>-<title:.+>'   => 'burivuh/history/index',
                $route . '/history/diff/<document_history_id:\d+>' => 'burivuh/history/diff',
                $route                                             => 'burivuh/category/index',
            ], false
        );

        if (!isset($app->i18n->translations['burivuh']) && !isset($app->i18n->translations['burivuh*']))
        {
            $app->i18n->translations['burivuh'] = [
                'class'            => 'yii\i18n\PhpMessageSource',
                'basePath'         => '@zabachok/burivuh/messages',
                'forceTranslation' => true,
            ];

        }
    }

}
