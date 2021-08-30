<?php

namespace common\models;

use yii\db\ActiveRecord;
use common\models\Room;
use common\models\RoomMember;
use common\models\User;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;
use yii\db\Exception;
use yii\base\InvalidArgumentException;
use Exception as GlobalException;

class RoomMemberRepository extends Room
{
    /**
     * Get user token of a room by userId & roomUuid
     * @param int $userId
     * @param string $roomUuid
     * @return array|null
     */
    static public function getMemberTokenByRoom(int $userId, $roomUuid): ?ActiveRecord
    {
        $room = parent::find()->select(['id'])->where(['uuid' => $roomUuid])->limit(1);
        return RoomMember::find()->where(['room_id' => $room, 'user_id' => $userId])->one();
    }


    /**
     * Return database user form token/tokes passed by reference
     * @param array|string $membersTokens Users tokens 
     * @return array 
     */
    static public function getMembersByTokens(array|string $membersTokens): array
    {
        $uProfileId = RoomMember::find()->select(['user_profile_id'])->where(['token' => $membersTokens]);
        return UserProfile::find()->select(['id', 'first_name', 'last_name'])->where(['id' => $uProfileId])->all();
    }

    /**
     * 
     * @param string $roomUuid 
     * @return array 
     */
    static public function getMembersByRoom(string $roomUuid)
    {
        $room = parent::find()->select(['id'])->where(['uuid' => $roomUuid])->limit(1);
        return RoomMember::find()->where(['room_id' => $room])->all();
    }


    public static function getOwnerByRoom($roomUuid): ActiveRecord|array|null
    {
        $meetingId = parent::find()->select(['meeting_id'])->where(['uuid' => $roomUuid])->limit(1);
        return Meeting::find()->select(['id', 'owner_id'])->where(['id' => $meetingId])->limit(1)->one();
    }
}
