<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $category Category of workout: 
 * 
 * 
 * | Value | Description|
 * |---|---|
 * |1 | Walk|
 * |2 | Run|
 * |3 | Hiking|
 * |4 | Skating|
 * |5 | BMX|
 * |6 | Bicycling|
 * |7 | Swimming|
 * |8 | Surfing|
 * |9 | Kitesurfing|
 * |10 | Windsurfing|
 * |11 | Bodyboard|
 * |12 | Tennis|
 * |13 | Table tennis|
 * |14 | Squash|
 * |15 | Badminton|
 * |16 | Lift weights|
 * |17 | Calisthenics|
 * |18 | Elliptical|
 * |19 | Pilates|
 * |20 | Basket-ball|
 * |21 | Soccer|
 * |22 | Football|
 * |23 | Rugby|
 * |24 | Volley-ball|
 * |25 | Waterpolo|
 * |26 | Horse riding|
 * |27 | Golf|
 * |28 | Yoga|
 * |29 | Dancing|
 * |30 | Boxing|
 * |31 | Fencing|
 * |32 | Wrestling|
 * |33 | Martial arts|
 * |34 | Skiing|
 * |35 | Snowboarding|
 * |36 | Other|
 * |128 | No activity|
 * |187 | Rowing|
 * |188 | Zumba|
 * |191 | Baseball|
 * |192 | Handball|
 * |193 | Hockey|
 * |194 | Ice hockey|
 * |195 | Climbing|
 * |196 | Ice skating|
 * |272 | Multi-sport|
 * |306 | Indoor walk|
 * |307 | Indoor running|
 * |308 | Indoor cycling|
 * @property string $timezone Timezone for the date.
 * @property int $model Source for the workout. Value can be:
 * 
 * 
 * | Value | Description|
 * |---|---|
 * |1 | Withings WBS01, type: 1|
 * |2 | Withings WBS03, type: 1|
 * |3 | Kid Scale, type: 1|
 * |4 | Withings WBS02, type: 1|
 * |5 | Body+, type: 1|
 * |6 | Body Cardio, type: 1|
 * |7 | Body, type: 1|
 * |21 | Smart Baby Monitor, type: 2|
 * |22 | Withings Home, type: 2|
 * |41 | Withings Blood Pressure V1, type: 4|
 * |42 | Withings Blood Pressure V2, type: 4|
 * |43 | Withings Blood Pressure V3, type: 4|
 * |44 | BPM Core, type: 4|
 * |45 | BPM Connect, type: 4|
 * |51 | Pulse, type: 16|
 * |52 | Activite, type: 16|
 * |53 | Activite (Pop, Steel), type: 16|
 * |54 | Withings Go, type: 16|
 * |55 | Activite Steel HR, type: 16|
 * |58 | Pulse HR, type: 16|
 * |59 | Activite Steel HR Sport Edition, type: 16|
 * |60 | Aura dock, type: 32|
 * |61 | Aura sensor, type: 32|
 * |62 | Aura dock, type: 32|
 * |63 | Sleep sensor, type: 32|
 * |70 | Thermo, type: 64|
 * |91 | Move ECG|
 * |92 | Move ECG|
 * |1051 | iOS step tracker, type 16|
 * |1052 | iOS step tracker, type 16|
 * |1053 | Android step tracker, type 16|
 * |1054 | Android step tracker, type 16|
 * |1055 | GoogleFit tracker, type 16|
 * |1056 | Samsung Health tracker, type 16|
 * |1057 | HealthKit step iPhone tracker, type 16|
 * |1058 | HealthKit step Apple Watch tracker, type 16|
 * |1059 | HealthKit other step tracker, type 16|
 * @property int $attrib The way the measure was attributed to the user:
 * 
 * 
 * | Value | Description|
 * |---|---|
 * |0 | The measuregroup has been captured by a device and is known to belong to this user (and is not ambiguous)|
 * |1 | The measuregroup has been captured by a device but may belong to other users as well as this one (it is ambiguous)|
 * |2 | The measuregroup has been entered manually for this particular user|
 * |4 | The measuregroup has been entered manually during user creation (and may not be accurate)|
 * |5 | Measure auto, it's only for the Blood Pressure Monitor. This device can make many measures and computed the best value|
 * |7 | Measure confirmed. You can get this value if the user confirmed a detected activity|
 * |8 | Same as attrib 0|
 * @property int $startdate The starting datetime for workouts data.
 * @property int $enddate The ending datetime for workouts data.
 * @property string $date Date at which the measure was taken or entered.
 * @property int $modified The timestamp of the last modification.
 * @property string $deviceid ID of device that tracked the data. To retrieve information about this device, refer to : <a href='/api-reference/#operation/userv2-getdevice'>User v2 - Getdevice</a>.
 * @property integer $data_id Details of workout.
 * @property workout_object_data $data Details of workout.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class workout_object extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%workout_objects}}';
    }

    public function rules()
    {
        return [
            [['timezone', 'date', 'deviceid'], 'trim'],
            [['timezone', 'date', 'deviceid'], 'string'],
            [['category', 'model', 'attrib', 'startdate', 'enddate', 'modified', 'data_id', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getData()
    {
        return $this->hasOne(workout_object_data::class, ['id' => 'data_id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($category = ArrayHelper::getValue($apiObject, 'category')) {
            $this->category = $category;
        }
        if($timezone = ArrayHelper::getValue($apiObject, 'timezone')) {
            $this->timezone = $timezone;
        }
        if($model = ArrayHelper::getValue($apiObject, 'model')) {
            $this->model = $model;
        }
        if($attrib = ArrayHelper::getValue($apiObject, 'attrib')) {
            $this->attrib = $attrib;
        }
        if($startdate = ArrayHelper::getValue($apiObject, 'startdate')) {
            $this->startdate = $startdate;
        }
        if($enddate = ArrayHelper::getValue($apiObject, 'enddate')) {
            $this->enddate = $enddate;
        }
        if($date = ArrayHelper::getValue($apiObject, 'date')) {
            $this->date = $date;
        }
        if($modified = ArrayHelper::getValue($apiObject, 'modified')) {
            $this->modified = $modified;
        }
        if($deviceid = ArrayHelper::getValue($apiObject, 'deviceid')) {
            $this->deviceid = $deviceid;
        }
        if($data_id = ArrayHelper::getValue($apiObject, 'data_id')) {
            $this->data_id = $data_id;
        }
        if($data = ArrayHelper::getValue($apiObject, 'data')) {
            $this->data = $data;
        }
        if($externalId = ArrayHelper::getValue($apiObject, 'externalId')) {
            $this->externalId = $externalId;
        }
        if($id = ArrayHelper::getValue($apiObject, 'id')) {
            $this->id = $id;
        }

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
    /* FIXME link doesn't work
    public function save($runValidation = true, $attributeNames = null) {
        $saved = parent::save($runValidation, $attributeNames);

        return $saved;
    }
    */
}
