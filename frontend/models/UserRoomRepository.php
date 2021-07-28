<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use common\models\Member;
use common\models\Room;


class UserRoomRepository extends Room
{
    /**
     * 
     * @param int $userId
     * @param string $roomUuid
     * @return array|null
     */
    static public function getUserTokenByRoom(int $userId, $roomUuid): ?ActiveRecord
    {
        $room = parent::find()->select(['id'])->where(['uuid' => $roomUuid])->limit(1);
        return Member::find()->where(['room_id' => $room, 'user_id' => $userId])->one();
    }
}
