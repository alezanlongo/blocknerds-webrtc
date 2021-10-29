<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "chat_message".
 *
 * @property int $id
 * @property int $chat_id
 * @property string|null $message
 * @property string|null $file_url
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Chat $chat
 */
class ChatMessage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chat_id'], 'required'],
            [['chat_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['chat_id'], 'integer'],
            [['message', 'file_url'], 'string', 'max' => 255],
            [['chat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Chat::class, 'targetAttribute' => ['chat_id' => 'id']],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chat_id' => 'Chat ID',
            'message' => 'Message',
            'file_url' => 'File Url',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Chat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChat()
    {
        return $this->hasOne(Chat::className(), ['id' => 'chat_id']);
    }
}
