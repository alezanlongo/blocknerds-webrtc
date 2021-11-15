<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $status Will return one of following statuses: ACTIVE, INACTIVE, or PARTIAL. The PARTIAL status means that not all events are subscribed to. In the event of a problem, UNKNOWN may be returned.
 * @property LabResultSuscription[] $subscriptions List of events you are subscribed to.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class LabResultSuscriptionEvent extends \yii\db\ActiveRecord
{
 
    protected $_subscriptionsAr;

    public static function tableName()
    {
        return '{{%lab_result_suscription_events}}';
    }

    public function rules()
    {
        return [
            [['status'], 'trim'],
            [['status'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getSubscriptions()
    {
        return $this->hasMany(LabResultSuscription::class, ['lab_result_suscription_event_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($status = ArrayHelper::getValue($apiObject, 'status')) {
            $this->status = $status;
        }
        if($subscriptions = ArrayHelper::getValue($apiObject, 'subscriptions')) {
            $this->_subscriptionsAr = $subscriptions;
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
        if( !empty($this->_subscriptionsAr) and is_array($this->_subscriptionsAr) ) {
            foreach($this->_subscriptionsAr as $subscriptionsApi) {
                $labresultsuscription = new LabResultSuscription();
                $labresultsuscription->loadApiObject($subscriptionsApi);
                $labresultsuscription->link('labResultSuscriptionEvent', $this);
                $labresultsuscription->save();
            }
        }

        return $saved;
    }
    */
}
