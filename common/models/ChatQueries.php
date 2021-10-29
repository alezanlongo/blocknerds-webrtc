<?php

namespace common\models;

use Carbon\Carbon;
use common\models\Chat;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class ChatQueries extends Chat
{

    public static function getRecentChats(int $profileId): array
    {
        $chats = Chat::find()
            ->where(['from_profile_id' => $profileId])
            ->orWhere(['to_profile_id' => $profileId])
            ->orderBy('created_at', 'asc')
            ->all();

        $lastChats = [];
        $ids = [];
        foreach ($chats as $chat) {
            $with = $chat->from_profile_id === $profileId ?  [
                'id' => $chat->to_profile_id,
                'username' => $chat->toProfile->user->username,
            ] :  [
                'id' => $chat->from_profile_id,
                'username' => $chat->fromProfile->user->username,
            ];
            if (!ArrayHelper::isIn($with['id'], $ids)) {
                $ids[] = $with['id'];
                // $with['message'] = $chat->message;
                // $with['created_at'] = $chat->created_at;

                $lastChats[] = $with;
            }
        }

        return $lastChats;
    }

    public static function getChat(int $ownerProfileId, int $otherProfileId):array
    {
        $chatsDB = Chat::find()
        ->where(['from_profile_id' => $ownerProfileId,'to_profile_id' => $otherProfileId])
        ->orWhere(['from_profile_id' => $otherProfileId,'to_profile_id' => $ownerProfileId])
        ->all();

        $chats = [];

        foreach ($chatsDB as $chat ) {
            $wasMe = $chat->from_profile_id === $ownerProfileId;
            $profile = $wasMe ? $chat->toProfile : $chat->fromProfile;
            $chats[]= [
                'message'=> $chat->message,
                'wasMe'=> $wasMe,
                'username'=> $profile->user->username,
                'img' => $profile->image,
                'sent_at' => Carbon::parse($chat->created_at)->format('l jS \\of F h:i:s A'),
            ];
        }

        return $chats;
    }
}
