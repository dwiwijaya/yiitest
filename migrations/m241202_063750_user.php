<?php

use yii\db\Migration;

/**
 * Class m241202_063750_user
 */
class m241202_063750_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sys_user', [
            'iduser' => $this->primaryKey(),
            'name' => $this->string(100)->defaultValue(null),
            'email' => $this->string(100)->defaultValue(null),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=latin1');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241202_063750_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241202_063750_user cannot be reverted.\n";

        return false;
    }
    */
}
