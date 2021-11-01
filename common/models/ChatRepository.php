<?php

namespace common\models;

use Carbon\Carbon;
use common\models\Chat;
use DateTime;
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

            $with['channel'] = $chat->channel;
            $with['message'] = $chat->text;
            $with['created_at'] = $chat->created_at;

            $lastChats[] = $with;
        }

        return $lastChats;

    }

    public static function getChatsByChannel(string $channel):array
    {
        return Chat::find()->where(['channel'=>$channel])->orderBy('id', 'desc')->all();
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

    public static function getChat(int $ownerProfileId, string $channel): array
    {
        $chats = ChatRepository::getChatsByChannel($channel);

        if (empty($chats)) {
            throw new NotFoundHttpException("Chat not found");
        }

        $messages = [];
        
        
        foreach ($chats as $msg) {
            $wasMe = $msg->from_profile_id === $ownerProfileId;
            $profile = $wasMe ? $msg->toProfile : $msg->fromProfile;
            $messages[] = [
                'message' => $msg->text,
                'wasMe' => $wasMe,
                'username' => $profile->user->username,
                'img' => $profile->image,
                'sent_at' => Carbon::parse($msg->created_at)->format('l jS \\of F h:i:s A'),
            ];
        }

        return $messages;
    }
}
