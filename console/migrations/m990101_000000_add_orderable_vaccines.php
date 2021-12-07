<?php

use common\components\Athena\models\OrderableVaccine;
use yii\db\Migration;

/**
 * Class m210705_150004_add_athena_users
 */
class m990101_000000_add_orderable_vaccines extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $vaccine = \Yii::createObject([
            'class'    => OrderableVaccine::class,
            'name' => 'Moderna COVID-19 Vaccine (PF) 100 mcg/0.5 mL intramuscular susp. (EUA)',
            'ordertypeid' => 439573,

        ]);
        $vaccine->insert();

        $vaccine1 = \Yii::createObject([
            'class'    => OrderableVaccine::class,
            'name' => 'Pfizer-BioNTech COVID-19 Vaccine (PF) 30 mcg/0.3 mL IM suspension(EUA)',
            'ordertypeid' => 439569,

        ]);
        $vaccine1->insert();

        $vaccine2 = \Yii::createObject([
            'class'    => OrderableVaccine::class,
            'name' => 'Afluria Qd 2021-22 (36 mos up)(PF)60 mcg (15 mcg x4)/0.5 mL IM syringe',
            'ordertypeid' => 443554,

        ]);
        $vaccine2->insert();

        $vaccine3 = \Yii::createObject([
            'class'    => OrderableVaccine::class,
            'name' => 'adenovirus vaccine live type-7 tablet, delayed release',
            'ordertypeid' => 341953,

        ]);
        $vaccine3->insert();

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m990101_000000_add_orderable_vaccines cannot be reverted.\n";

        return true;
    }
}