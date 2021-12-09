<?php

use common\components\Athena\models\ReferralOrderType;
use yii\db\Migration;

/**
 * Class m210705_150004_add_athena_users
 */
class m990101_000000_add_referral_order_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $referral = \Yii::createObject([
            'class'    => ReferralOrderType::class,
            'name' => 'substance abuse rehabilitation referral',
            'ordertypeid' => 289677,

        ]);
        $referral->insert();

        $referral1 = \Yii::createObject([
            'class'    => ReferralOrderType::class,
            'name' => 'weight management referral',
            'ordertypeid' => 388782,

        ]);
        $referral1->insert();

        $referral2 = \Yii::createObject([
            'class'    => ReferralOrderType::class,
            'name' => 'weight loss study',
            'ordertypeid' => 336767,

        ]);
        $referral2->insert();

        $referral3 = \Yii::createObject([
            'class'    => ReferralOrderType::class,
            'name' => 'surgery center referral',
            'ordertypeid' => 294980,

        ]);
        $referral3->insert();

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m990101_000000_add_referral_order_type cannot be reverted.\n";

        return true;
    }
}