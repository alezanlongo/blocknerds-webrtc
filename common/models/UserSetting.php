<?php

namespace common\models;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionClassConstant;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_setting".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $group_name
 * @property string|null $name
 * @property string|null $data_type
 * @property string|null $value
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 */
class UserSetting extends \yii\db\ActiveRecord
{
    const GROUP_NAME_CALENDAR = 'calendar';
    const GROUP_NAME_ROOM = 'room';
    const SUPPORTED_DATA_TYPE = [
        "boolean",
        "integer",
        "double",
        "string",
        "array"
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_setting';
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
            [['user_id', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['value'], 'string'],
            [['group_name', 'name', 'data_type'], 'string', 'max' => 255],
            [['group_name', 'name', 'user_id'], 'unique', 'targetAttribute' => ['group_name', 'name', 'user_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'group_name' => 'Group Name',
            'name' => 'Name',
            'data_type' => 'Data Type',
            'value' => 'Value',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function getSetting(int $user_id, string $name, string $group_name): false|null|ActiveRecord
    {
        if (!\in_array($group_name, self::getGroupNames())) {
            //produce error
            return false;
        }
        $res = self::find()->select(['id', 'value', 'data_type'])->where(['user_id' => $user_id, 'name' => $name, 'group_name' => $group_name])->one();
        if (null === $res) {
            return null;
        }
        $res->value = self::getValueByType($res->value);
        return $res;
    }

    public static function setValue(int $user_id, string $name, string $group_name, mixed $value)
    {
        if (!\in_array($group_name, self::getGroupNames())) {
            //produce error
            return false;
        }
        if (preg_match("/[^a-z0-9\_\-]/", $name) == 1) {
            //bad chars. Accept a-z(lowercase), 0-9, _ and -  
            return false;
        }

        if (!self::isValueSupported($value)) {
            //produce error. DataType doesn't supported
            return false;
        }

        $currentSetting = self::getSetting($user_id, $name, $group_name);
        $newValue = self::prepareValueByType($value);
        if (false !== $newValue && !empty($currentSetting)) {
            $currentSetting->value = $newValue;
            $currentSetting->data_type = \gettype($value);
            return $currentSetting->update(false);
        }
        $newSetting = new UserSetting();
        $newSetting->name = $name;
        $newSetting->group_name = $group_name;
        $newSetting->value = $newValue;
        $newSetting->data_type = \gettype($value);
        User::find()->select('id')->where(['id' => $user_id])->limit(1)->one()->link('userSetting', $newSetting);
        return $newSetting->save();
    }

    private static function prepareValueByType($value)
    {
        switch (\gettype($value)) {
            case 'boolean':
            case 'string':
            case 'integer':
            case 'double':
            case 'NULL':
            case 'array':
                return \serialize($value);
            default:
                //unsupported data type
                return false;
        }
    }

    private static function getValueByType($value){
        return \unserialize($value);
    }

    public static function getGroupNames()
    {
        $reflClass = new ReflectionClass(self::class);
        return \array_values(\array_filter($reflClass->getConstants(ReflectionClassConstant::IS_PUBLIC), function ($k) {
            return \preg_match("/^GROUP_NAME_+/", $k);
        }, \ARRAY_FILTER_USE_KEY));
    }

    public static function isValueSupported(mixed $value)
    {
        return \in_array(\gettype($value), self::SUPPORTED_DATA_TYPE);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
