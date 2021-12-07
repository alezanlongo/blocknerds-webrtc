<?php

use common\components\Athena\models\OrderableDme;
use yii\db\Migration;

/**
 * Class m210705_150004_add_athena_users
 */
class m990101_000000_add_orderable_dmes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $imaging = \Yii::createObject([
            'class'    => OrderableDme::class,
            'name' => 'Cotton Balls',
            'ordertypeid' => 187995,

        ]);
        $imaging->insert();

        $imaging1 = \Yii::createObject([
            'class'    => OrderableDme::class,
            'name' => 'athletic tape',
            'ordertypeid' => 336714,

        ]);
        $imaging1->insert();

        $imaging2 = \Yii::createObject([
            'class'    => OrderableDme::class,
            'name' => 'Face mask',
            'ordertypeid' => 353836,

        ]);
        $imaging2->insert();

        $imaging3 = \Yii::createObject([
            'class'    => OrderableDme::class,
            'name' => 'breast pump',
            'ordertypeid' => 250224,

        ]);
        $imaging3->insert();

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m990101_000000_add_orderable_dmes cannot be reverted.\n";

        return true;
    }
}