<?php

use Carbon\Carbon;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<div class="direct-chat-messages chat-room-messages" style="height: 75vh;">

    <?php
    Pjax::begin(['id' => 'chat-room']);

    foreach ($chats as $chat) {
        $className = ($chat->from_profile_id === Yii::$app->getUser()->getId() ? "float-start" : "float-end");
        $classTimestamp = ($chat->from_profile_id === Yii::$app->getUser()->getId() ? "float-end" : "float-start");
    ?>
        <div class="direct-chat-msg">
            <div class="direct-chat-infos clearfix">
                <span class="direct-chat-name <?= $className ?>">
                    <?php
                    if ($chat->from_profile_id === Yii::$app->getUser()->getId()) {
                        echo $chat->fromProfile->user->username;
                    } else {
                    ?>
                        <a href="#" onclick="openChatBox(<?= $chat->from_profile_id ?>, '<?= $chat->fromProfile->user->username ?>', <?= $room_id ?>)" class="">
                            <?= $chat->fromProfile->user->username ?>
                        </a>
                    <?php
                    }
                    ?>
                </span>
                <span class="direct-chat-timestamp <?= $classTimestamp ?>"><?= Carbon::createFromTimestamp($chat->created_at, $chat->fromProfile->timezone)->format('Y-m-d H:i:s'); ?></span>
            </div>
            <!-- <img class="direct-chat-img" src="./assets/img/user1-128x128.jpg" alt="message user image"> -->
            <div class="direct-chat-text">
                <?= $chat->text ?>
            </div>
        </div>
    <?php
    }
    Pjax::end();
    ?>
</div>

<div class="input-group">
    <input type="hidden" name="room_id" value="<?= $room_id ?>" class="form-control" autocomplete="off">
    <input type="text" name="message-onToRoom" placeholder="Type Message ..." class="form-control" autocomplete="off">
    <span class="input-group-append">
        <button type="button" class="btn btn-primary btn-send" onclick="sendMessageToRoom()">Send</button>
    </span>
</div>