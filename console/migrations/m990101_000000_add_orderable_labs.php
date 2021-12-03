<?php

use common\components\Athena\models\OrderableLab;
use yii\db\Migration;

/**
 * Class m210705_150004_add_athena_users
 */
class m990101_000000_add_orderable_labs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $imaging = \Yii::createObject([
            'class'    => OrderableLab::class,
            'name' => 'SARS CoV 2 RNA (COVID-19), QL, rRT-PCR, respiratory specimen',
            'ordertypeid' => 430580,

        ]);
        $imaging->insert();

        $imaging1 = \Yii::createObject([
            'class'    => OrderableLab::class,
            'name' => 'HIV (1+2) Ab screen, serum',
            'ordertypeid' => 342158,

        ]);
        $imaging1->insert();

        $imaging2 = \Yii::createObject([
            'class'    => OrderableLab::class,
            'name' => 'glucose, fingerstick, blood (glucometer)',
            'ordertypeid' => 342050,

        ]);
        $imaging2->insert();

        $imaging3 = \Yii::createObject([
            'class'    => OrderableLab::class,
            'name' => 'Hepatitis B virus, DNA, quant, viral load, PCR, serum or plasma',
            'ordertypeid' => 351258,

        ]);
        $imaging3->insert();

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m990101_000000_add_orderable_labs cannot be reverted.\n";

        return true;
    }
}