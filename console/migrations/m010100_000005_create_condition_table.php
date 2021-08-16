<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000005_create_condition_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%condition}}', [
            'id' => $this->primaryKey(),
            'ext_id' => $this->integer(),
            'identifier__system' => $this->string(),
            'identifier__use' => $this->string(),
            'identifier__value' => $this->string(),
            'patient__display' => $this->string(),
            'patient__reference' => $this->string(),
            'asserter__display' => $this->string(),
            'asserter__reference' => $this->string(),
            'dateRecorded ' => $this->string(),
            'code__coding' => $this->json(),
            'code__text' => $this->string(),
            'category__coding' => $this->json(),
            'status' => $this->boolean(),
            'clinicalStatus ' => $this->string(),
            'verificationStatus' => $this->string(),
            'severity__coding' => $this->json(),
            'severity__text' => $this->string(),
            'onsetDateTime' => $this->string(),
            'onsetQuantity' => $this->string(),
            'onsetBoolean' => $this->string(),
            'onsetPeriod__start' => $this->string(),
            'onsetPeriod__end' => $this->string(),
            'onsetRange__low' => $this->json(),
            'onsetRange__high' => $this->json(),
            'onsetString' => $this->string(),
            'abatementDateTime' => $this->string(),
            'abatementQuantity' => $this->string(),
            'abatementBoolean' => $this->string(),
            'abatementPeriod__start' => $this->string(),
            'abatementPeriod__end' => $this->string(),
            'abatementRange__low' => $this->json(),
            'abatementRange__high' => $this->json(),
            'abatementString' => $this->string(),
            'onsetDateTime ' => $this->string(),
            'stage__summary__coding' => $this->json(),
            'stage__summary__text' => $this->string(),
            'asserter__display' => $this->string(),
            'asserter__reference' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%condition}}');
    }
}
