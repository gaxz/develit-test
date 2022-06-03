<?php

namespace frontend\modules\v1\controllers;

use frontend\models\ProductImage;
use yii\rest\ActiveController;

class ProductImageController extends ActiveController
{
    public $modelClass = ProductImage::class;

}
