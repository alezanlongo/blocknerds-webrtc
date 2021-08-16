<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use common\models\Room;
use common\models\RoomMember;
use common\models\User;

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
        return RoomMember::find()->where(['room_id' => $room, 'user_id' => $userId])->one();
    }


    static public function getUsersByTokens(array|string $usersTokens): array
    {
        $usersId = RoomMember::find()->select(['user_id'])->where(['token' => $usersTokens]);
        return User::find()->select(['id', 'username', 'email'])->where(['id' => $usersId])->all();
    }
}
