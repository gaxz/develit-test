<?php

namespace frontend\modules\v1\controllers;

use frontend\models\Product;
use yii\rest\ActiveController;

class ProductController extends ActiveController
{
    public $modelClass = Product::class;

}
