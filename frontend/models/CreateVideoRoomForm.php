<?php

namespace frontend\models;

/**
 * Description of CreateVideoRoomForm
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
class CreateVideoRoomForm extends \common\models\Room
{

    public $addMembers;
    public $roomMembers = [];

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function addMembers($newUserEmail, $currentRoomMembers)
    {
        if(!empty($currentRoomMembers)){
            $this->roomMembers = $currentRoomMembers;
        }

        $this->roomMembers[] = $newUserEmail;
    }

    public function createCard()
    {
        /*         $orderMax = Card::find()->select('MAX("order")')->where(['column_id' => $this->column_id])->limit(1)->scalar();
        $this->order = $orderMax === null ? 0 : ($orderMax + 1);
        $this->owner_id = Yii::$app->getUser()->getId();
        return $this->save();
 */
    }
}
