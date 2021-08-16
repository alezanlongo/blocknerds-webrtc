<?php

use yii\db\Migration;

/**
 * Class m210808_133416_documents_references_securities_labels
 */
class m210808_133416_documents_references_securities_labels extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('documents_references_securities_labels', [
            'id'                    => $this->primaryKey(),
            'coding'                => $this->json()->null(),
            'text'                  => $this->text()->null(),
            'document_reference_id' => $this->integer()->null()
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            'idx_documents_references_securities_labels_01',
            'documents_references_securities_labels',
            'document_reference_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk_documents_references_securities_labels_01',
            'documents_references_securities_labels',
            'document_reference_id',
            'documents_references',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210808_133416_documents_references_securities_labels cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210808_133416_documents_references_securities_labels cannot be reverted.\n";

        return false;
    }
    */
}
