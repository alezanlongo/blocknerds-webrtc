<?php

use yii\db\Migration;

/**
 * Class m210705_150004_add_athena_users
 */
class m990101_000000_add_vaccine_declined_reason extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        Yii::$app->db->createCommand()->batchInsert('vaccine_declined_reasons', ['declinedreason', 'active','declinedreasonid'], [
            [
                "Religious exemption",
                "true",
                "24"
            ],
            [
                "Patient decision",
                "true",
                "70"
            ],
            [
                "Parental decision",
                "true",
                "73"
            ],
            [
                "Contraindication > Allergy - rodent or neural",
                "true",
                "101"
            ],
            [
                "Contraindication > Allergy - 2-phenoxyethanol",
                "true",
                "102"
            ],
            [
                "Contraindication > Allergy - aluminum",
                "true",
                "103"
            ],
            [
                "Contraindication > Allergy - baker's yeast",
                "true",
                "104"
            ],
            [
                "Contraindication > Allergy - eggs",
                "true",
                "105"
            ],
            [
                "Contraindication > Allergy - vaccine or components",
                "true",
                "106"
            ],
            [
                "Contraindication > Allergy - thimerosal",
                "true",
                "107"
            ],
            [
                "Contraindication > Chronic disease",
                "true",
                "108"
            ],
            [
                "Contraindication > Illness",
                "true",
                "109"
            ],
            [
                "Contraindication > Fever",
                "true",
                "110"
            ],
            [
                "Contraindication > Encephalopathy with previous DTP/DTaP",
                "true",
                "111"
            ],
            [
                "Contraindication > Allergy - gelatin",
                "true",
                "112"
            ],
            [
                "Contraindication > Purpura",
                "true",
                "113"
            ],
            [
                "Contraindication > Arthus Reaction to tetanus",
                "true",
                "114"
            ],
            [
                "Contraindication > Immunodeficiency",
                "true",
                "115"
            ],
            [
                "Contraindication > Allergy - latex",
                "true",
                "116"
            ],
            [
                "Contraindication > Allergy - neomycin",
                "true",
                "117"
            ],
            [
                "Contraindication > Pregnant",
                "true",
                "118"
            ],
            [
                "Contraindication > Allergy - polymyxin B",
                "true",
                "119"
            ],
            [
                "Contraindication > Intussusception history",
                "true",
                "120"
            ],
            [
                "Contraindication > Allergy - streptomycin",
                "true",
                "121"
            ],
            [
                "Contraindication > Thrombocytopenic",
                "true",
                "122"
            ],
            [
                "Contraindication > Neurologic disorder",
                "true",
                "123"
            ],
            [
                "Reaction > Anaphylaxis",
                "true",
                "124"
            ],
            [
                "Reaction > Shock - 48 hrs of dose",
                "true",
                "125"
            ],
            [
                "Reaction > Shock - 72 hrs of dose",
                "true",
                "126"
            ],
            [
                "Reaction > Brain disorder",
                "true",
                "127"
            ],
            [
                "Reaction > Fever - 48 hrs of dose",
                "true",
                "128"
            ],
            [
                "Reaction > Guillain-Barre - 6 weeks of dose",
                "true",
                "129"
            ],
            [
                "Reaction > Intussusception  - 30 days of dose",
                "true",
                "130"
            ],
            [
                "Reaction > Persistent crying - 48hrs of dose",
                "true",
                "131"
            ],
            [
                "Reaction > Rash - 14 days of dose",
                "true",
                "132"
            ],
            [
                "Immunity presumed > Acute poliomyelitis",
                "true",
                "133"
            ],
            [
                "Immunity presumed > Anthrax",
                "true",
                "134"
            ],
            [
                "Immunity presumed > Diphtheria",
                "true",
                "135"
            ],
            [
                "Immunity presumed > Rotavirus",
                "true",
                "136"
            ],
            [
                "Immunity presumed > Haemophilus influenzae",
                "true",
                "137"
            ],
            [
                "Immunity presumed > Human papilloma virus",
                "true",
                "138"
            ],
            [
                "Immunity presumed > Influenza",
                "true",
                "139"
            ],
            [
                "Immunity presumed > Japanese encephalitis",
                "true",
                "140"
            ],
            [
                "Immunity presumed > Measles",
                "true",
                "141"
            ],
            [
                "Immunity presumed > Meningococcal",
                "true",
                "142"
            ],
            [
                "Immunity presumed > Mumps",
                "true",
                "143"
            ],
            [
                "Immunity presumed > Pertussis",
                "true",
                "144"
            ],
            [
                "Immunity presumed > Rabies",
                "true",
                "145"
            ],
            [
                "Immunity presumed > Rubella",
                "true",
                "146"
            ],
            [
                "Immunity presumed > Tetanus",
                "true",
                "147"
            ],
            [
                "Immunity presumed > Type B hepatitis",
                "true",
                "148"
            ],
            [
                "Immunity presumed > Typhoid fever",
                "true",
                "149"
            ],
            [
                "Immunity presumed > Vaccinia",
                "true",
                "150"
            ],
            [
                "Immunity presumed > Varicella",
                "true",
                "151"
            ],
            [
                "Immunity presumed > Type A hepatitis",
                "true",
                "152"
            ],
            [
                "Immunity presumed > Yellow fever",
                "true",
                "153"
            ],
            [
                "Immunity serologic > Hepatitis A",
                "true",
                "154"
            ],
            [
                "Immunity serologic > Hepatitis B",
                "true",
                "155"
            ],
            [
                "Immunity serologic > Measles",
                "true",
                "156"
            ],
            [
                "Immunity serologic > Mumps",
                "true",
                "157"
            ],
            [
                "Immunity serologic > Rubella",
                "true",
                "158"
            ],
            [
                "Immunity serologic > Varicella",
                "true",
                "159"
            ],
            [
                "Special indication > Special risk",
                "true",
                "160"
            ],
            [
                "Special indication > Rabies exposed last 10 days",
                "true",
                "161"
            ],
            [
                "Not available",
                "true",
                "181"
            ]
        ])->execute();

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m990101_000000_add_vaccine_declined_reason cannot be reverted.\n";

        return true;
    }
}