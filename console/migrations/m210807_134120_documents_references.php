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
