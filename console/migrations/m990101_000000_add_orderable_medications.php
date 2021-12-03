<?php

use common\components\Athena\models\OrderableMedication;
use yii\db\Migration;

/**
 * Class m210705_150004_add_athena_users
 */
class m990101_000000_add_orderable_medications extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $medication = \Yii::createObject([
            'class'    => OrderableMedication::class,
            'name' => 'Abilify 5 mg tablet',
            'ordertypeid' => 243397,

        ]);
        $medication->insert();

        $medication1 = \Yii::createObject([
            'class'    => OrderableMedication::class,
            'name' => 'Basaglar KwikPen U-100 Insulin 100 unit/mL (3 mL) subcutaneous',
            'ordertypeid' => 398550,

        ]);
        $medication1->insert();

        $medication2 = \Yii::createObject([
            'class'    => OrderableMedication::class,
            'name' => 'Lasix 40 mg tablet',
            'ordertypeid' => 193583,

        ]);
        $medication2->insert();

        $medication3 = \Yii::createObject([
            'class'    => OrderableMedication::class,
            'name' => 'diclofenac sodium 75 mg tablet,delayed release',
            'ordertypeid' => 212070,

        ]);
        $medication3->insert();

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m990101_000000_add_orderable_medications cannot be reverted.\n";

        return true;
    }
}