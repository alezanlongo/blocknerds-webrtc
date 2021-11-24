<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "photo".
 *
 * @property int $id
 * @property int $set_id
 * @property string $photo_id
 * @property string $url
 * @property string $title
 * @property string|null $description
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Set $set
 */
class Photo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photo';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['set_id', 'url'], 'required'],
            [['set_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['set_id', 'created_at', 'updated_at'], 'integer'],
            [['description', 'alt_description'], 'string'],
            // [['url', 'alt_description', 'description'], 'string', 'max' => 255],
            [['set_id'], 'exist', 'skipOnError' => true, 'targetClass' => Set::class, 'targetAttribute' => ['set_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'set_id' => 'Set ID',
            'photo_id' => 'Photo ID',
            'url' => 'Url',
            'title' => 'Title',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Set]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSet()
    {
        return $this->hasOne(Set::className(), ['id' => 'set_id']);
    }
}
