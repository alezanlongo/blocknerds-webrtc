<?php

use yii\db\Migration;

/**
 * Class m210705_150004_add_athena_users
 */
class m990101_000000_add_dosage_frequencies extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        Yii::$app->db->createCommand()->batchInsert('frequencies', ['frequency'], [
            ['every 4 weeks'],
            ['every 24 hours'],
            ['every 2 months'],
            ['every 8 hours'],
            ['2 times a day'],
            ['every 12 hours'],
            ['every 6-8 hours'],
            ['every 3 months'],
            ['every 4-6 hours'],
            ['every 2 day'],
            ['every day'],
            ['6 times a day'],
            ['4 times a day'],
            ['every 72 hours'],
            ['every 3 weeks'],
            ['5 times a day'],
            ['2 times a week'],
            ['every 2 weeks'],
            ['3 times a week'],
            ['as needed'],
            ['every 2 hours'],
            ['every 3 hours'],
            ['every week'],
            ['every 4 hours'],
            ['every month'],
            ['every hour'],
            ['every 6 hours'],
            ['3 times a day'],
            ['every 3-4 hours']
        ])->execute();

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m990101_000000_add_dosage_frequencies cannot be reverted.\n";

        return true;
    }
}