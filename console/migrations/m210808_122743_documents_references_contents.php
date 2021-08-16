<?php

use yii\db\Migration;

/**
 * Class m210808_122743_documents_references_contents
 */
class m210808_122743_documents_references_contents extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('documents_references_contents', [
            'id'                        => $this->primaryKey(),
            'attachment_conttentype'    => $this->text()->null(),
            'attachment_creation'       => $this->text()->null(),
            'attachment_data'           => $this->text()->null(),
            'attachment_hash'           => $this->text()->null(),
            'attachment_language'       => $this->text()->null(),
            'attachment_size'           => $this->integer()->null(),
            'attachment_title'          => $this->text()->null(),
            'attachment_url'            => $this->text()->null(),
            'format'                    => $this->json()->null(),
            'document_reference_id'     => $this->integer()->null()
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            'idx_documents_references_contents_01',
            'documents_references_contents',
            'document_reference_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk_documents_references_contents_01',
            'documents_references_contents',
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
        echo "m210808_122743_documents_references_contents cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210808_122743_documents_references_contents cannot be reverted.\n";

        return false;
    }
    */
}
