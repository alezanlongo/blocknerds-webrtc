<?php

use yii\helpers\Html;
use common\widgets\chat\ChatBoxRoomWidget;

?>
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <ul class="nav nav-pills mb-3 d-flex justify-content-around" id="pills-tab" role="tablist">
        <li class="nav-item option-side" role="presentation" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Settings">
            <button class="nav-link" id="pills-settings-tab" data-bs-toggle="pill" data-bs-target="#pills-settings" type="button" role="tab" aria-controls="pills-settings" aria-selected="true"><i class="fas fa-cog icon-menu"></i></button>
        </li>
        <li class="nav-item option-side " role="presentation" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Participant">
            <button class="nav-link active" id="pills-attendees-tab" data-bs-toggle="pill" data-bs-target="#pills-attendees" type="button" role="tab" aria-controls="pills-attendees" aria-selected="false"><i class="fas fa-users icon-menu"></i></button>
        </li>
        <li class="nav-item option-side" role="presentation" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Chat">
            <button class="nav-link" id="pills-chat-tab" data-bs-toggle="pill" data-bs-target="#pills-chat" type="button" role="tab" aria-controls="pills-chat" aria-selected="false"><i class="fas fa-comments icon-menu"></i></button>
        </li>
    </ul>
    <div class="tab-content position-relative" id="pills-tabContent">
        <div class="tab-pane fade option-content" id="pills-settings" role="tabpanel" aria-labelledby="pills-settings-tab">
            <?= Html::tag('h3', 'Settings section', ['class' => 'text-center']) ?>
            <div>
                <form onsubmit="return false" class="p-3">
                    <div class="form-group">
                        <select name="audioSelect" class="form-select">
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <select name="videoSelect" class="form-select">
                        </select>
                    </div>
                    <div class="form-group text-center mt-3">
                        <button type="submit" class="btn btn-primary w-100" onclick="subm(this.form)">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="tab-pane fade option-content show active" id="pills-attendees" role="tabpanel" aria-labelledby="pills-attendees-tab">
            <?= Html::tag('h3', 'Participants', ['class' => 'text-center']) ?>

            <ul class="list-group bg-dark list-attendees">
                <li class="list-group-item list-group-item-light bg-dark position-relative" data-user-id="<?= Yii::$app->getUser()->getId() ?>" data-index="0">
                    <span class="p-1 username-member text-success"><?= Yii::$app->getUser()->getIdentity()->username ?> (myself)</span>
                </li>
                <?php
                $i = 1;
                foreach ($members as $member) {
                    if ($member->user_profile_id != $user_profile_id) {
                ?>
                        <li class="list-group-item list-group-item-light bg-dark position-relative profile_id_-<?= $member->user_profile_id ?>" id="attendee_<?= $i ?>" data-index="<?= $i ?>">
                            <span class="p-1 username-member usernameFeed<?= $i ?>"><?= $member->user->username ?></span>
                            <div class="position-absolute pt-1 top-0 end-0 member-controls">
                                <button class="btn btn-link text-light btn-remote-chat" data-bs-toggle="tooltip" data-bs-placement="top" title="Chat with member">
                                    <i class="fas fa-comment-dots icon-option-member" onclick="openChatBox(parseInt(<?= $member->user_profile_id ?>), '<?= $member->user->username ?>', parseInt(<?= $room_id ?>))"></i>
                                </button>
                                <?php if ($is_owner) { ?>
                                    <button class="btn btn-link text-light btn-remote-mute" onclick="moderateAudioToggle(this,<?= $i ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Mute/Unmute member audio">
                                        <i class="fas fa-microphone icon-option-member"></i></button>
                                    <button class="btn btn-link text-light btn-remote-video" onclick="moderateVideoToggle(this,<?= $i ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Mute/Unmute member video">
                                        <i class="fas fa-video icon-option-member"></i></button>
                                    <button class="btn btn-link text-light btn-remote-kick" data-bs-toggle="tooltip" data-bs-placement="top" title="Kick member">
                                        <i class="fas fa-user-times icon-option-member"></i></button>
                                    <button class="btn btn-link text-light" onclick="roomImageCapture(<?= $i ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Take a snapshoot of this participant">
                                        <i class="fas fa-camera icon-option-member"></i></button>
                                <?php } ?>
                            </div>
                        </li>
                <?php
                    }
                    $i++;
                } ?>
            </ul>
        </div>
        <div class="tab-pane fade option-content" id="pills-chat" role="tabpanel" aria-labelledby="pills-chat-tab">
            <?= Html::tag('h3', 'Chat section', ['class' => 'text-center']) ?>

            <?= ChatBoxRoomWidget::widget(['chats' => $chats, 'room_id' => $room_id]); ?>

        </div>
    </div>

</aside>