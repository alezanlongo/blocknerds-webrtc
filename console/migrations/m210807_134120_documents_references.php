<?php

use yii\db\Migration;

/**
 * Class m210808_134120_documents_references
 */
class m210807_134120_documents_references extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('documents_references', [
            'id'                        => $this->primaryKey(),
            'authenticator__display'    => $this->string(255)->null(),
            'authenticator__reference'  => $this->string(255)->null(),
            'description'               => $this->string(255)->null(),
            'docstatus__coding'         => $this->json()->null(),
            'docstatus__text'           => $this->text()->null(),
            'ext_id'                    => $this->string(255)->null(),
            'indexed'                   => $this->string(255)->null(),
            'meta__lastupdated'         => $this->string(255)->null(),
            'meta__profile'             => $this->json()->null(), //in Athena it is an array
            'meta__security'            => $this->json()->null(),
            'meta__tag'                 => $this->json()->null(),
            'meta__versionid'           => $this->string(255)->null(),
            'resourcetype'              => $this->string(255)->null(),
            'status'                    => $this->string(255)->null(),
            'subject__display'          => $this->string(255)->null(),
            'subject__reference'        => $this->string(255)->null(),
            'type__coding'              => $this->string(255)->null(),
            'type__text'                => $this->string(255)->null(),
        ]);

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
        echo "m210808_134120_documents_references cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210808_134120_documents_references cannot be reverted.\n";

        return false;
    }
    */
}
