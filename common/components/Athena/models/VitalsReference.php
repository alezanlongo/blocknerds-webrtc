<?php

namespace common\components\Athena\models;

use Yii;

/**
 * This is the model class for table "vitals_reference".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $abbreviation
 * @property string|null $datatype
 * @property string|null $dataset
 * @property string|null $clinicalelementid
 * @property string|null $unit
 * @property string|null $group
 */
class VitalsReference extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vitals_reference';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dataset'], 'safe'],
            [['name', 'abbreviation', 'datatype', 'clinicalelementid', 'unit', 'group'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'abbreviation' => 'Abbreviation',
            'datatype' => 'Datatype',
            'dataset' => 'Dataset',
            'clinicalelementid' => 'Clinicalelementid',
            'unit' => 'Unit',
            'group' => 'Group',
        ];
    }
}
