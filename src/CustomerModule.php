<?php

namespace modava\customer;

use yii\base\BootstrapInterface;
use Yii;
use yii\base\Event;
use \yii\base\Module;
use yii\web\Application;
use yii\web\Controller;

/**
 * customer module definition class
 */
class CustomerModule extends Module implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modava\customer\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        // custom initialization code goes here
        $this->registerTranslations();
        parent::init();
        Yii::configure($this, require(__DIR__ . '/config/customer.php'));
        $handler = $this->get('errorHandler');
        Yii::$app->set('errorHandler', $handler);
        $handler->register();
        $this->layout = 'customer';
    }



    public function bootstrap($app)
    {
        $app->on(Application::EVENT_BEFORE_ACTION, function () {

        });
        Event::on(Controller::class, Controller::EVENT_BEFORE_ACTION, function (Event $event) {
            $controller = $event->sender;
        });
    }

    public function registerTranslations()
    {
        Yii::$app->i18n->translations['customer/messages/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath' => '@modava/customer/messages',
            'fileMap' => [
                'customer/messages/customer' => 'customer.php',
            ],
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('customer/messages/' . $category, $message, $params, $language);
    }
}
