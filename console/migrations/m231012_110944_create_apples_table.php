<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%apples}}`.
 */
class m231012_110944_create_apples_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%apple}}', [
            'id' => $this->primaryKey(),
            'color' => $this->string()->notNull(),
            'appearance_date' => $this->integer()->notNull(),
            'fall_date' => $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'eaten_percent' => $this->decimal(5, 2)->defaultValue(0),
            'is_rotten' => $this->boolean()->notNull()->defaultValue(false),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%apple}}');
    }
}