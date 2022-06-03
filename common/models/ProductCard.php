<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%product_card}}".
 *
 * @property int $id
 * @property int|null $product_id
 * @property string|null $description
 * @property string|null $subheader
 * @property string|null $note
 *
 * @property Product $product
 */
class ProductCard extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product_card}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id'], 'integer'],
            [['description', 'subheader', 'note'], 'string'],
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
            'description' => Yii::t('app', 'Description'),
            'subheader' => Yii::t('app', 'Subheader'),
            'note' => Yii::t('app', 'Note'),
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id'])->inverseOf('productCard');
    }
}
