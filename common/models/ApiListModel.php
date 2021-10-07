<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

class ApiListModel extends ApiModel
{
    public $_embedded;
    public $_links;
    public $page;

    public $containerName = '';

    public $embeddedClassName = '';

    protected $_items;
    protected $_limit;
    protected $_count;
    protected $_offset;

    public function init()
    {
        parent::init();

        if(empty($this->_items)) {
            $this->_items = [];

            if(empty($this->_embedded))
                return;

            foreach($this->_embedded[$this->containerName] as $item_id => $item) {
                $obj = \Yii::createObject($this->embeddedClassName, [$item]);

                if(array_key_exists('id', $item)) {
                    $this->_items[$item['id']] = $obj;
                } else {
                    $this->_items[] = $obj;
                }
            }
        }

        $this->_offset = ArrayHelper::getValue($this->page, 'offset');
        $this->_limit  = ArrayHelper::getValue($this->page, 'limit');
        $this->_count  = ArrayHelper::getValue($this->page, 'count');
    }

    public function getItems()
    {
        if(empty($this->containerName))
            return null;

//        return $this->_embedded[$this->container_name];
        return $this->_items;
    }
}