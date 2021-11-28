<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%links}}`.
 */
class m211128_181253_create_links_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%links}}', [
            'id' => $this->primaryKey(),
            'token' => $this->char(8)->notNull()->unique(),
            'full_url' => $this->string(512)->notNull(),
            'limit' => $this->integer()->notNull(),
            'views' => $this->integer()->notNull(),
            'expires_at' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull()
        ]);
        
        $this->createIndex(
            'idx-token',
            '{{%links}}',
            'token'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%links}}');
    }
}
