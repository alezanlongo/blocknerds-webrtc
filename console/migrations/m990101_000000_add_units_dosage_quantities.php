<?php

use yii\db\Migration;

/**
 * Class m210705_150004_add_athena_users
 */
class m990101_000000_add_units_dosage_quantities extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        Yii::$app->db->createCommand()->batchInsert('dosage_quantity_units', ['quantityunit'], [
        ['L'],
        ['application(s)'],
        ['applicator(s)ful'],
        ['becquerel(s)'],
        ['billion cells(s)'],
        ['caplet(s)'],
        ['capsule(s)'],
        ['cell(s)'],
        ['colony forming unit(s)'],
        ['cream(s)'],
        ['device(s)'],
        ['dose pk(s)'],
        ['drop(s)'],
        ['each'],
        ['film(s)'],
        ['g'],
        ['gigabecquerel(s)'],
        ['gram of carbohydrate(s)'],
        ['implant(s)'],
        ['inch(es)'],
        ['inhalation(s)'],
        ['insert(s)'],
        ['irrigation(s)'],
        ['kg'],
        ['kilobecquerel(s)'],
        ['kilohertz(s)'],
        ['lesion(s)'],
        ['liquid(s)'],
        ['lollipop(s)'],
        ['lozenge(s)'],
        ['mCi'],
        ['mL'],
        ['megabecquerel(s)'],
        ['mg'],
        ['microcurie(s)'],
        ['microgram dietary folate equivalent(s)'],
        ['microgram(s)'],
        ['microliter(s)'],
        ['micromole(s)'],
        ['microunit(s)'],
        ['milliequivalent(s)'],
        ['milligram phenytoin equivalent(s)'],
        ['millimole(s)'],
        ['million cells'],
        ['million metric tons of coal equivalent(s)'],
        ['million plaque forming units(s)'],
        ['million units'],
        ['milliunit(s)'],
        ['nanogram(s)'],
        ['nebule(s)'],
        ['ophthalmic insert(s)'],
        ['ounce(s)'],
        ['package(s)'],
        ['packet(s)'],
        ['pad(s)'],
        ['patch(es)'],
        ['pellet(s)'],
        ['piece(s) of gum'],
        ['plaque forming unit(s)'],
        ['po pk(s)'],
        ['powder(s)'],
        ['puff(s)'],
        ['pump(s)'],
        ['recon(s)'],
        ['sachet(s)'],
        ['scoop(s)'],
        ['sliding scale dose(s)'],
        ['soln(s)'],
        ['solution(s)'],
        ['spray(s)'],
        ['startr pk(s)'],
        ['strip(s)'],
        ['suppositor(y/ies)'],
        ['suspension(s)'],
        ['syrup(s)'],
        ['tablet(s)'],
        ['tbsp'],
        ['thousand unit(s)'],
        ['towelette(s)'],
        ['tsp'],
        ['tube(s)'],
        ['unit(s)'],
        ['vaginal insert(s)'],
        ['vaginal ring(s)'],
        ['vector genome(s)'],
        ['vial(s)'],
        ['viral particle(s)'],
        ['wafer(s)'],
        ['x 10e14 vector genome(s)'],
        ['x 10e6 car-positive viable t cells(s)'],
        ['x 10e8 car-positive viable t cells(s)'],
        ])->execute();

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m990101_000000_add_units_dosage_quantities cannot be reverted.\n";

        return true;
    }
}