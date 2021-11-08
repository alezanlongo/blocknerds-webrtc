<?php

use yii\db\Migration;

/**
 * Class m211005_150140_VitalsReference
 */
class m211028_000004_VitalsReference extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211005_150140_VitalsReference cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('vitals_reference', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'abbreviation' => $this->string(),
            'datatype' => $this->string(),
            'dataset' => $this->json(),
            'clinicalelementid' => $this->string(),
            'unit' => $this->string(),
            'group' => $this->string()
        ]);

        $this->batchInsert('vitals_reference', ['name', 'abbreviation', 'clinicalelementid', 'datatype','dataset', 'unit', 'group'], [
            ['Blood Pressure Systolic', 'BP Systolic', 'VITALS.BLOODPRESSURE.SYSTOLIC', 'NUMERIC', null, null, 'BLOOD PRESSURE' ],
            ['Blood Pressure Diastolic', 'BP Diastolic', 'VITALS.BLOODPRESSURE.DIASTOLIC', 'NUMERIC', null, null, 'BLOOD PRESSURE' ],
            ['Blood Pressure Site', 'BP Site', 'VITALS.BLOODPRESSURE.SITE', 'SET', '{"L arm":"L arm", "R arm":"R arm", "L leg":"L leg", "R leg":"R leg",  "L wrist":"L wrist", "R wrist":"R wrist"}', null, 'BLOOD PRESSURE' ],
            ['Blood Pressure Type', 'BP Type', 'VITALS.BLOODPRESSURE.TYPE', 'SET', '{"sitting":"sitting", "standing":"standing", "supine":"supine", "lying on side":"lying on side", "prone":"prone"}', null, 'BLOOD PRESSURE' ],
            ['Blood Pressure Cuff Size', 'BP Cuff Size', 'VITALS.BLOODPRESSURECUFFSIZE', 'SET', '{"neonatal":"neonatal", "infant":"infant", "small pediatric":"small pediatric", "pediatric":"pediatric", "small adult":"small adult", "adult":"adult", "large adult":"large adult", "child thigh":"child thigh", "adult thigh":"adult thigh"}', null, 'BLOOD PRESSURE' ],
            ['Blood Pressure Not Performed', 'Not Performed', 'VITALS.BLOODPRESSURE.REFUSED', 'CHECKBOX', null, null, 'BLOOD PRESSURE' ],
            ['Blood Pressure Not Performed Reason', 'Not Performed Reason', 'VITALS.BLOODPRESSURE.REFUSEDREASON', 'SET', '{"Not indicated":"Not indicated", "Not tolerated":"Not tolerated", "Patient refused":"Patient refused"}', null, 'BLOOD PRESSURE' ],
            ['Blood Pressure Systolic Not Performed', 'Not Performed', 'VITALS.BLOODPRESSURE.SYSTOLICREFUSED', 'CHECKBOX', null, null, 'BLOOD PRESSURE' ],
            ['Blood Pressure Diastolic Not Performed', 'Not Performed', 'VITALS.BLOODPRESSURE.DIASTOLICREFUSED', 'CHECKBOX', null, null, 'BLOOD PRESSURE' ],
            ['BMI', 'BMI', 'VITALS.BMI', 'NUMERIC', null, null, 'BMI' ],
            ['BMI percentile: Age and sex', 'BMI %ile: Age & sex', 'VITALS.BMI.PERCENTILE', 'NUMERIC', null, null, 'BMI' ],
            ['BMI Not Performed', 'Not Performed', 'VITALS.BMI.REFUSED', 'CHECKBOX', null, null, 'BMI' ],
            ['Height', 'Ht', 'VITALS.HEIGHT', 'NUMERIC', null, 'cm', 'HEIGHT'],
            ['Height type', 'Ht type', 'VITALS.HEIGHT.TYPE', 'SET', '{"Height":"Height", "Stated":"Stated", "Lying":"Lying", "Standing":"Standing", "Preoperative":"Preoperative"}', null, 'HEIGHT'],
            ['Height Not Performed', 'Not Performed', 'VITALS.HEIGHT.REFUSED', 'CHECKBOX', null, null, 'HEIGHT' ],
            ['Height Not Performed Reason', 'Not Performed Reason', 'VITALS.HEIGHT.REFUSEDREASON', 'SET', '{"Not indicated" : "Not indicated", "Not tolerated" :"Not tolerated", "Patient refused":"Patient refused"}', null, 'HEIGHT'],
            ['Weight', 'Wt', 'VITALS.WEIGHT', 'NUMERIC', null, 'g', 'WEIGHT'],
            ['Weight Not Performed', 'Not Performed', 'VITALS.WEIGHT.REFUSED', 'CHECKBOX', null, null, 'WEIGHT' ],
            ['Weight Out of Range', 'Out of Range', 'VITALS.WEIGHT.OUTOFRANGE', 'CHECKBOX', null, null, 'WEIGHT' ],
            ['Weight Taken Pre/Post Dialysis', 'Weight taken', 'VITALS.WEIGHT.PREPOST', 'SET', '{"Pre-dialysis":"Pre-dialysis", "Post-dialysis":"Post-dialysis"}', null, 'WEIGHT'],
            ['Weight type', 'Wt type', 'VITALS.WEIGHT.TYPE', 'SET', '{"Weight":"Weight", "Stated":"Stated", "Dry":"Dry", "Preoperative":"Preoperative", "With clothes":"With clothes", "Without clothes":"Without clothes", "First":"First"}', null, 'WEIGHT'],
            ['Weight Not Performed Reason', 'Not Performed Reason', 'VITALS.WEIGHT.REFUSEDREASON', 'SET', '{"Not indicated": "Not indicated", "Not tolerated":"Not tolerated", "Patient refused":"Patient refused"}', null, 'WEIGHT'],
            ['Visual Acuity Test OD', 'V OD', 'VITALS.VOD', 'SET', '{"20/10":"20/10", "20/13":"20/13", "20/15":"20/15", "20/20":"20/20", "20/25":"20/25", "20/30":"20/30", "20/40":"20/40", "20/50":"20/50", "20/60":"20/60", "20/70":"20/70", "20/80":"20/80", "20/100":"20/100", "20/200":"20/200", "20/400":"20/400"}', null, 'VOD'],
            ['Visual Acuity Test OS', 'V OS', 'VITALS.VOS', 'SET', '{"20/10":"20/10", "20/13":"20/13", "20/15":"20/15", "20/20":"20/20", "20/25":"20/25", "20/30":"20/30", "20/40":"20/40", "20/50":"20/50", "20/60":"20/60", "20/70":"20/70", "20/80":"20/80", "20/100":"20/100", "20/200":"20/200", "20/400":"20/400"}', null, 'VOD'],
            ['Visual Acuity Test OU', 'V OU', 'VITALS.VOU', 'SET', '{"20/10":"20/10", "20/13":"20/13", "20/15":"20/15", "20/20":"20/20", "20/25":"20/25", "20/30":"20/30", "20/40":"20/40", "20/50":"20/50", "20/60":"20/60", "20/70":"20/70", "20/80":"20/80", "20/100":"20/100", "20/200":"20/200", "20/400":"20/400"}', null, 'VOD'],
            ['Heart Rate', 'HR', 'VITALS.HEARTRATE', 'FREETEXT', null, null, 'HEARTRATE'],
            ['Inhaled Oxygen Concentration', 'Inhaled O2 Concentration', 'VITALS.INHALEDO2CONCENTRATION', 'NUMERIC', null, null, 'INHALEDO2CONCENTRATION'],
            ['Pulse Rate', 'Pulse Rate', 'VITALS.PULSE.RATE', 'NUMERIC', null, null, 'PULSE'],
            ['Pulse Type', 'Pulse type', 'VITALS.PULSE.TYPE', 'SET', '{"regular":"regular", "irregular":"irregular", "regularly irregular":"regularly irregular", "irregularly irregular":"irregularly irregular"}', null, 'PULSE'],
            ['Pulse Location', 'Pulse Location', 'VITALS.PULSE.LOCATION', 'SET', '{"apical":"apical", "brachial":"brachial", "carotid":"carotid", "femoral":"femoral", "pedal":"pedal", "popliteal":"popliteal", "radial":"radial"}', null, 'PULSE'],
            ['Respiration Rate', 'RR', 'VITALS.RESPIRATIONRATE', 'NUMERIC', null, null, 'RESPIRATIONRATE'],
            ['Temperature', 'T', 'VITALS.TEMPERATURE', 'NUMERIC', null, 'F', 'TEMPERATURE'],
            ['Temperature Type', 'T type', 'VITALS.TEMPERATURE.TYPE', 'SET', '{"oral":"oral", "ear":"ear", "axillary":"axillary", "rectal":"rectal", "temporal artery":"temporal artery"}', null, 'TEMPERATURE'],
            ['Birth Length', 'Birth Length', 'VITALS.BIRTHLENGTH', 'FREETEXT', null, null, 'BIRTHLENGTH'],
            ['Birth Weight', 'Birth Weight', 'VITALS.BIRTHWEIGHT', 'FREETEXT', null, null, 'BIRTHWEIGHT'],
            ['Body Surface Area', 'Body Surface Area', 'VITALS.BODYSURFACEAREA', 'NUMERIC', null, null, 'BIRTHWEIGHT'],
            ['with/without correction', 'SC/CC', 'VITALS.CORRECTION', 'SET', '["SC:SC", "CC:CC"]', null, 'CORRECTION'],
            ['Head Circumference', 'HC', 'VITALS.HEADCIRCUMFERENCE', 'NUMERIC', null, 'cm', 'HEADCIRCUMFERENCE'],
            ['Level of Consciousness', 'LOC', 'VITALS.LEVELOFCONSCIOUSNESS', 'SET', '{"Alert":"Alert", "Oriented":"Oriented", "Drowsy":"Drowsy", "Disoriented":"Disoriented", "Sedated":"Sedated"}', null, 'LEVELOFCONSCIOUSNESS'],
            ['Other / Notes', 'Note', 'VITALS.NOTES', 'LARGETEXTAREA', null, null, 'NOTES'],
            ['O2 Saturation', 'O2Sat', 'VITALS.O2SATURATION', 'NUMERIC', null, null, 'O2SATURATION'],
            ['O2 Saturation Air Type', 'O2Sat Air Type', 'VITALS.O2SATURATION.AIRTYPE', 'SET', '{"Room Air at Rest":"Room Air at Rest", "Oxygen":"Oxygen", "Breathing Treatment":"Breathing Treatment", "Room Air with Oxygen":"Room Air with Oxygen", "Room Air with Exercise":"Room Air with Exercise", "Ambulating with Oxygen":"Ambulating with Oxygen", "Ambulating on Room Air":"Ambulating on Room Air", "CPAP":"CPAP"}', null, 'O2SATURATION'],
            ['O2 Saturation Oxygen Quantity', 'O2Sat Oxygen Quantity', 'VITALS.O2SATURATION.OXYGENQUANTITY', 'NUMERIC', null, null, 'O2SATURATION'],
            ['Pain Scale', 'Pain Scale', 'VITALS.PAINSCALE', 'SET', '["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10"]', null, 'PAINSCALE'],
            ['Pain Scale Type', 'Pain Scale Type', 'VITALS.PAINSCALETYPE', 'SET', '{"Numeric":"Numeric", "Wong-Baker FACES":"Wong-Baker FACES", "FLACC":"FLACC"}', null, 'PAINSCALE'],
            ['Waist Circumference', 'WC', 'VITALS.WAISTCIRCUMFERENCE', 'NUMERIC', null, 'cm', 'WAISTCIRCUMFERENCE'],
        ]);

    }

}
