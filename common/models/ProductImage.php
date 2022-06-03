<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%product_image}}".
 *
 * @property int $id
 * @property int|null $product_id
 * @property string|null $path
 *
 * @property Product $product
 */
class ProductImage extends \yii\db\ActiveRecord
{
    const IMAGE_DIRECTORY = 'uploads/images/products';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product_image}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id'], 'integer'],
            [['path'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'path' => Yii::t('app', 'Path'),
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery|ProductQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id'])->inverseOf('productImage');
    }

    /**
     * {@inheritdoc}
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

    public function getImagePath(): string
    {
        return self::IMAGE_DIRECTORY . '/' . $this->product_id;
    }

    public function getImageUrl(): string
    {
        return "/" . $this->path;
    }
}
