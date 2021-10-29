<?php

namespace common\models;

use Carbon\Carbon;
use common\models\Chat;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class ChatRepository extends Chat
{

    public static function getRecentChats(int $profileId): array
    {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand(
            "select max(id) as id
        from chat
        where from_profile_id = :profileId or to_profile_id = :profileId
        group by channel 
        order by id desc
        limit 10",
            [':profileId' => $profileId]
        );

        $chatIds = $command->queryAll();

        // $chats = Chat::find()->select(['from_profile_id','to_profile_id', 'channel', 'max(id) as id'])
        //     ->where(['from_profile_id' => $profileId])
        //     ->orWhere(['to_profile_id' => $profileId])
        //     ->groupBy('channel')
        //     ->orderBy('id', 'desc');
        // ->max('id');


        // $chats =   (new \yii\db\Query())
        //     // ->select(['from_profile_id', 'to_profile_id', 'channel', 'id'])
        //     ->from('chat')
        //     ->where(['from_profile_id' => $profileId])
        //     ->orWhere(['to_profile_id' => $profileId])
        //     ->groupBy('channel')
        //     ->max('id')
        //     ->all();
        $lastChats = [];
        $chats = Chat::find()->where(['in', 'id', $chatIds])->all();

        foreach ($chats as $chat) {
            $with = $chat->from_profile_id === $profileId ?  [
                'profile_id' => $chat->to_profile_id,
                'username' => $chat->toProfile->user->username,
            ] :  [
                'profile_id' => $chat->from_profile_id,
                'username' => $chat->fromProfile->user->username,
            ];


            $lastChat = ChatRepository::getChatByRelation($profileId, $with['profile_id']);
            $lastMessage = $lastChat->messages[array_key_last($lastChat->messages)];
            $with['message'] = $lastMessage->text;
            $with['created_at'] = $lastMessage->created_at;

            $lastChats[] = $with;
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
        $chat = ChatRepository::getChatByRelation($ownerProfileId, $otherProfileId);

        if (empty($chat)) {
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
