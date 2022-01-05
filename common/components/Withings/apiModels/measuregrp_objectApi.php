<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $grpid Id of the measure group.
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
 * @property int $date UNIX timestamp when measures were taken.
 * @property int $created UNIX timestamp when measures were stored.
 * @property int $category Category for the measures in the group (see category input parameter).
 * @property string $deviceid ID of device that tracked the data. To retrieve information about this device, refer to : <a href='/api-reference/#operation/userv2-getdevice'>User v2 - Getdevice</a>.
 * @property measure_object[] $measures List of measures in the group.
 * @property string $comment Deprecated. This property will always be empty.
 */
class measuregrp_objectApi extends BaseApiModel
{

    public $grpid;
    public $attrib;
    public $date;
    public $created;
    public $category;
    public $deviceid;
    public $measures;
 
    protected $_measuresAr;
    public $comment;

    public function rules()
    {
        return [
            [['deviceid', 'comment'], 'trim'],
            [['deviceid', 'comment'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->measures) && is_array($this->measures)) {
            foreach($this->measures as $measures) {
                $this->_measuresAr[] = new measure_objectApi($measures);
            }
            $this->measures = $this->_measuresAr;
            $this->_measuresAr = [];//CHECKME
        }
    }

}
