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
                'burivuh' => 'burivuh/main/index',
            ],
            false
        );
    }
}