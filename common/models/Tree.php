<?php
namespace common\models;

use Yii;
use kartik\tree\models\Tree as TreeKartik;
use creocoder\nestedsets\NestedSetsBehavior;

class Tree extends TreeKartik
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tree';
    }    


    // /**
    //  * Override isDisabled method if you need as shown in the  
    //  * example below. You can override similarly other methods
    //  * like isActive, isMovable etc.
    //  */
    // public function isDisabled()
    // {
    //     if (Yii::$app->user->username !== 'admin') {
    //         return true;
    //     }
    //     return parent::isDisabled();
    // }
}