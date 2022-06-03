<?php

namespace frontend\modules\v1\controllers;

use common\integrations\PaysonApiHandler;
use Payson\Payments\Transport\Connector;
use Payson\Payments\CheckoutClient;
use common\integrations\Payment;
use yii\rest\Controller;
use Yii;

class PaymentController extends Controller
{
    public function actionIndex()
    {
        $apiAgentId = Yii::$app->params['paysonApiAgentId'];
        $apiKey = Yii::$app->params['paysonApiKey'];
        $apiUrl = Yii::$app->params['paysonApiKey'] !== "PROD" ? Connector::TEST_BASE_URL : Connector::PROD_BASE_URL;
        
        $connector = Connector::init($apiAgentId, $apiKey, $apiUrl);
        $checkoutClient = new CheckoutClient($connector);

        $paymentApi = new Payment(new PaysonApiHandler($checkoutClient));

        var_dump($paymentApi->getCheckoutView());
        exit;
    }
}
