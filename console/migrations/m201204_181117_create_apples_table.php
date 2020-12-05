<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%apples}}`.
 */
class m201204_181117_create_apples_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%apple_state}}', [
            'id'   => $this->primaryKey(),
            'name' => $this->string(),
        ]);
        
        $this->createTable('{{%apple}}', [
            'id'              => $this->primaryKey(),
            'color'           => $this->text(),
            'appearance_date' => $this->dateTime(),
            'fall_date'       => $this->dateTime(),
            'state'           => $this->integer(), // ref
            'eaten'           => $this->float(),
        ]);
        $this->addForeignKey('forkey_state', '{{%apple}}', 'state', '{{%apple_state}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%apple}}');
        $this->dropTable('{{%apple_state}}');
    }
}
