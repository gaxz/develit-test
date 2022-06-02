<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $product backend\models\Product */
/* @var $productCard backend\models\ProductCard */
/* @var $productImage backend\models\ProductImage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($product, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($product, 'price')->textInput() ?>

    <?= $form->field($productCard, 'description')->textArea() ?>

    <?= $form->field($productCard, 'subheader')->textInput() ?>

    <?= $form->field($productCard, 'note')->textInput() ?>

    <p>
        <?php if (!empty($productImage)) : ?>
            <p>
                <?= Html::img($productImage->getImageUrl(), ['width' => '30%']) ?>
            <p>
        <?php endif; ?>
        <?= $form->field($productImage, 'path')->fileInput() ?>
    </p>

    <p>
        <?= $form->field($product, 'is_active')->checkbox() ?>
    </p>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>