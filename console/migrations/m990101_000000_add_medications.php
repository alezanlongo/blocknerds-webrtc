<?php

use common\components\Athena\models\MedicationReference;
use yii\db\Migration;

/**
 * Class m210705_150004_add_athena_users
 */
class m990101_000000_add_medications extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $medication = \Yii::createObject([
            'class'    => MedicationReference::class,
            'medication' => 'abacavir',
            'medicationid' => 310417,

        ]);
        $medication->insert();

        $medication1 = \Yii::createObject([
            'class'    => MedicationReference::class,
            'medication' => 'bolus insulin pump, 200 unit',
            'medicationid' => 383891,

        ]);
        $medication1->insert();

        $medication2 = \Yii::createObject([
            'class'    => MedicationReference::class,
            'medication' => 'Ca carb-magnesium-caps-ginge',
            'medicationid' => 367175,

        ]);
        $medication2->insert();

        $medication3 = \Yii::createObject([
            'class'    => MedicationReference::class,
            'medication' => 'dabigatran etexilate',
            'medicationid' => 357878,

        ]);
        $medication3->insert();

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m990101_000000_add_medications cannot be reverted.\n";

        return true;
    }
}
