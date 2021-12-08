<?php

use common\components\Athena\models\PatientInfoHandout;
use yii\db\Migration;

/**
 * Class m210705_150004_add_athena_users
 */
class m990101_000000_add_patient_info_handouts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $handout = \Yii::createObject([
            'class'    => PatientInfoHandout::class,
            'name' => 'learning about fever',
            'ordertypeid' => 282284,

        ]);
        $handout->insert();

        $handout1 = \Yii::createObject([
            'class'    => PatientInfoHandout::class,
            'name' => 'heart-healthy diet: care instructions',
            'ordertypeid' => 281913,

        ]);
        $handout1->insert();

        $handout2 = \Yii::createObject([
            'class'    => PatientInfoHandout::class,
            'name' => 'anxiety disorder: care instructions',
            'ordertypeid' => 282621,

        ]);
        $handout2->insert();

        $handout3 = \Yii::createObject([
            'class'    => PatientInfoHandout::class,
            'name' => 'saline nasal washes: care instruction',
            'ordertypeid' => 282628,

        ]);
        $handout3->insert();

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m990101_000000_add_patient_info_handouts cannot be reverted.\n";

        return true;
    }
}