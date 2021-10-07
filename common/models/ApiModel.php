<?php
namespace common\models;

use yii\base\Model;
//use common\components\Util;
use yii\helpers\VarDumper;

class ApiModel extends Model
{
    public function __construct(array $config = [])
    {
        if (empty($config)) {
            parent::__construct($config);
            return;
        }

        $vars = \Yii::getObjectVars($this);
        $keys = array_keys($config);

        // array_diff(A,B) = A \ B for indexed arrays (A[...] without B[...])
        $extras = array_diff($keys, array_keys($vars));

        // if we have extras, an API field has been passed as a config var this object lacks
        // log this occurrence but don't throw an exception like standard model class
        if(!empty($extras)) {
            \Yii::error(['API MISMATCH: Got extra fields while loading API!',
                VarDumper::dumpAsString($config),
                VarDumper::dumpAsString($extras),
                VarDumper::dumpAsString(array_keys($vars)),
                VarDumper::dumpAsString($keys),
            ]);
        }

        // now filter the config array keys A ∩ B and then call parent
        parent::__construct(array_intersect_key($config, $vars));
        return;
    }

    public function array_filter_recursive($input)
    {
        foreach ($input as &$value)
        {
            if (is_array($value))
            {
                $value = $this->array_filter_recursive($value);
            }
        }

        return array_filter($input);
    }

	public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        //return Util::array_filter_recursive(parent::toArray($fields, $expand, $recursive));//FIXME needs Util library
		return $this->array_filter_recursive(parent::toArray($fields, $expand, $recursive));
    }

}