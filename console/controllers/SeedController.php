<?php

namespace console\controllers;

use common\models\User;
use Throwable;
use yii\base\Exception;
use yii\console\Controller;

class SeedController extends Controller {

    /**
     * Create admin user
     */
    public function actionUser(): bool 
    {    
        $user = new User([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'status' => User::STATUS_ACTIVE,
        ]);
        
        $user->setPassword('admin');
        $user->generateAuthKey();

        if ($user->validate() && $user->save()) {
            echo "User created" . PHP_EOL;
            return true;
        }

        echo "An error has occurred" . PHP_EOL;
        
        foreach ($user->getFirstErrors() as $error) {
            echo $error . PHP_EOL;
        }
        
        return false;
    }
}