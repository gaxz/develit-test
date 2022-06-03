<?php

namespace frontend\models;

class Product extends \common\models\Product
{
    public function extraFields()
    {
        return ['productCard', 'productImage'];
    }
}