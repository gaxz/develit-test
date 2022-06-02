<?php

use yii\db\Migration;

/**
 * Class m220531_082808_create_table_product
 */
class m220531_082808_create_table_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(),
            'price' => $this->money(15, 2),
            'is_active' => $this->tinyInteger()->defaultValue(0),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createTable('{{%product_card}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->unsigned(),
            'description' => $this->text(),
            'subheader' => $this->text(),
            'note' => $this->text(),
        ]);

        $this->createTable('{{%product_image}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->unsigned(),
            'path' => $this->string(),
        ]);

        $this->addForeignKey('fk-product_card-product', '{{%product_card}}', 'product_id', '{{%product}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-product_image-product', '{{%product_image}}', 'product_id', '{{%product}}', 'id', 'CASCADE');

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-product_card-product', '{{%product_card}}');
        $this->dropForeignKey('fk-product_image-product', '{{%product_image}}');

        $this->dropTable('{{%product_image}}');
        $this->dropTable('{{%product_card}}');
        $this->dropTable('{{%product}}');

        return true;
    }
}
