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
        // Add module URL rules.
        $app->urlManager->addRules(
            [
                \Yii::$app->getModule('burivuh')->route . '/category/<title:.*>'                                            => 'burivuh/main/index',
                \Yii::$app->getModule('burivuh')->route . '/doc/<title:.*>'                                                 => 'burivuh/main/view',
                \Yii::$app->getModule('burivuh')->route . '/<action:create|delete|update|create-folder|delete-folder>/<title:.*>' => 'burivuh/main/<action>',
                \Yii::$app->getModule('burivuh')->route                                                                => 'burivuh/main/index',
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
