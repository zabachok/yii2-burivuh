<?php

use yii\db\Migration;

class m160217_142502_create_tables extends Migration
{
    public function up()
    {
        $this->createTable('burivuh_document', [
            'document_id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->notNull(),
            'content' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
        $this->createTable('burivuh_category', [
            'category_id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->notNull(),
            'created_at' => $this->dateTime(),
        ]);
        $this->createTable('burivuh_history', [
            'document_history_id' => $this->primaryKey(),
            'document_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime(),
            'title' => $this->string(255)->notNull(),
            'content' => $this->text(),
            'user_id' => $this->integer(),
            'diff' => $this->string(50),
        ]);
    }

    public function down()
    {
        $this->dropTable('burivuh_document');
        $this->dropTable('burivuh_category');
        $this->dropTable('burivuh_history');
    }
}
