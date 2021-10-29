<?php

namespace common\models;

use Carbon\Carbon;
use common\models\Chat;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class ChatRepository extends Chat
{

    public static function getRecentChats(int $profileId): array
    {
        $chats = Chat::find()
            ->where(['from_profile_id' => $profileId])
            ->orWhere(['to_profile_id' => $profileId])
            ->orderBy('created_at', 'desc')
            ->all();
        $lastChats = [];
        $ids = [];

        foreach ($chats as $chat) {
            $with = $chat->from_profile_id === $profileId ?  [
                'profile_id' => $chat->to_profile_id,
                'username' => $chat->toProfile->user->username,
            ] :  [
                'profile_id' => $chat->from_profile_id,
                'username' => $chat->fromProfile->user->username,
            ];

            if (!ArrayHelper::isIn($with['profile_id'], $ids)) {
                $ids[] = $with['profile_id'];
                $lastChat = ChatRepository::getChatByRelation($profileId, $with['profile_id']);
                $lastMessage = $lastChat->chatMessages[array_key_last($lastChat->chatMessages)];
                $with['message'] = $lastMessage->message;
                $with['created_at'] = $lastMessage->created_at;

                $lastChats[] = $with;
            }
        }

        return $lastChats;
    }

    public static function getChatByRelation(int $from, int $to)
    {
        return Chat::find()
            ->where(['from_profile_id' => $from, 'to_profile_id' => $to])
            ->orWhere(['from_profile_id' => $to, 'to_profile_id' => $from])
            ->limit(1)->one();
    }

    public static function lastMessage(int $ownerProfileId, int $otherProfileId)
    {
        // VarDumper::dump( [$ownerProfileId, $otherProfileId], $depth = 10, $highlight = true);
        // TODO WITH MAX 
        return  Chat::find()
            ->where(['from_profile_id' => $ownerProfileId, 'to_profile_id' => $otherProfileId])
            ->orWhere(['from_profile_id' => $otherProfileId, 'to_profile_id' => $ownerProfileId])
            ->orderBy('created_at', 'desc')
            ->limit(1)->one();
    }

    public static function getChat(int $ownerProfileId, int $otherProfileId): array
    {
        $chat = ChatRepository::getChatByRelation($ownerProfileId,$otherProfileId);

        if(empty($chat)){
            throw new NotFoundHttpException("Chat not found"); 
        }

        $messages = [];
        $wasMe = $chat->from_profile_id === $ownerProfileId;
        $profile = $wasMe ? $chat->toProfile : $chat->fromProfile;

        foreach ($chat->chatMessages as $msg) {
            $messages[] = [
                'message' => $msg->message,
                'wasMe' => $wasMe,
                'username' => $profile->user->username,
                'img' => $profile->image,
                'sent_at' => Carbon::parse($msg->created_at)->format('l jS \\of F h:i:s A'),
            ];
        }

        return $messages;
    }
}
