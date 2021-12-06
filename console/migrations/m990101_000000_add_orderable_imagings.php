<?php

use common\components\Athena\models\OrderableImaging;
use yii\db\Migration;

/**
 * Class m210705_150004_add_athena_users
 */
class m990101_000000_add_orderable_imagings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $imaging = \Yii::createObject([
            'class'    => OrderableImaging::class,
            'name' => 'US, abdomen',
            'ordertypeid' => 392625,

        ]);
        $imaging->insert();

        $imaging1 = \Yii::createObject([
            'class'    => OrderableImaging::class,
            'name' => 'XR, chest',
            'ordertypeid' => 392532,

        ]);
        $imaging1->insert();

        $imaging2 = \Yii::createObject([
            'class'    => OrderableImaging::class,
            'name' => 'MRI, brain + internal auditory canal, w/wo contrast',
            'ordertypeid' => 395077,

        ]);
        $imaging2->insert();

        $imaging3 = \Yii::createObject([
            'class'    => OrderableImaging::class,
            'name' => 'US, obstetric, nuchal translucency, single gestation',
            'ordertypeid' => 408789,

        ]);
        $imaging3->insert();

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m990101_000000_add_orderable_imagings cannot be reverted.\n";

        return true;
    }
}