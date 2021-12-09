<?php

use common\components\Athena\models\OtherOrderType;
use yii\db\Migration;

/**
 * Class m210705_150004_add_athena_users
 */
class m990101_000000_add_other_order_types extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $other = \Yii::createObject([
            'class'    => OtherOrderType::class,
            'name' => 'blood transfusion platelets*',
            'ordertypeid' => 348396,
        ]);
        $other->insert();

        $other1 = \Yii::createObject([
            'class'    => OtherOrderType::class,
            'name' => 'care plan*',
            'ordertypeid' => 339387,
        ]);
        $other1->insert();

        $other2 = \Yii::createObject([
            'class'    => OtherOrderType::class,
            'name' => 'asthma action plan*',
            'ordertypeid' => 388172,
        ]);
        $other2->insert();

        $other3 = \Yii::createObject([
            'class'    => OtherOrderType::class,
            'name' => 'infusion, normal saline*',
            'ordertypeid' => 336965,
        ]);
        $other3->insert();

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m990101_000000_add_other_order_types cannot be reverted.\n";

        return true;
    }
}