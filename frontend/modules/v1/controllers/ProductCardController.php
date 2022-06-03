<?php

namespace frontend\modules\v1\controllers;

use common\models\ProductCard;
use yii\rest\ActiveController;

class ProductController extends ActiveController
{
    public $modelClass = ProductCard::class;

}
