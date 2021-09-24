<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "configuration".
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $content
 * @property int|null $practiceId
 */
class Configuration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'configuration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'safe'],
            [['type'], 'string', 'max' => 255],
            [['practiceId'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'type'          => 'Type',
            'content'       => 'Content',
            'practiceId'    => 'Practice',
        ];
    }
}
