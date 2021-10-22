<?php

use yii\helpers\Html;
?>
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <ul class="nav nav-pills mb-3 d-flex justify-content-around" id="pills-tab" role="tablist">
        <li class="nav-item option-side" role="presentation" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Settings">
            <button class="nav-link" id="pills-settings-tab" data-bs-toggle="pill" data-bs-target="#pills-settings" type="button" role="tab" aria-controls="pills-settings" aria-selected="true"><i class="fas fa-cog icon-menu"></i></button>
        </li>
        <li class="nav-item option-side" role="presentation" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Participant">
            <button class="nav-link" id="pills-attendees-tab" data-bs-toggle="pill" data-bs-target="#pills-attendees" type="button" role="tab" aria-controls="pills-attendees" aria-selected="false"><i class="fas fa-users icon-menu"></i></button>
        </li>
        <li class="nav-item option-side" role="presentation" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Chat">
            <button class="nav-link" id="pills-chat-tab" data-bs-toggle="pill" data-bs-target="#pills-chat" type="button" role="tab" aria-controls="pills-chat" aria-selected="false"><i class="fas fa-comments icon-menu"></i></button>
        </li>
    </ul>
    <div class="tab-content position-relative" id="pills-tabContent">
        <div class="tab-pane fade option-content" id="pills-settings" role="tabpanel" aria-labelledby="pills-settings-tab">
            <?= Html::tag('h3', 'Settings section', ['class' => 'text-center']) ?>
        </div>
        <div class="tab-pane fade option-content show active" id="pills-attendees" role="tabpanel" aria-labelledby="pills-attendees-tab">
            <?= Html::tag('h3', 'Participants', ['class' => 'text-center']) ?>

            <ul class="list-group bg-dark list-attendees">
                <li class="list-group-item list-group-item-light bg-dark position-relative" data-user-id="<?= Yii::$app->getUser()->getId() ?>" data-index="0">
                    <span class="p-1 username-member text-success"><?= Yii::$app->getUser()->getIdentity()->username ?> (myself)</span>
                </li>
                <?php for ($i = 1; $i < $limit_members; $i++) {
                    $member = (count($members) > $i) ? $members[$i] : null;
                ?>
                    <li class="list-group-item list-group-item-light bg-dark position-relative <?= ($member) ? 'profile_id_' . $member['id'] : 'd-none' ?>" id="attendee_<?= $i ?>" data-index="<?= $i ?>">
                        <span class="p-1 username-member usernameFeed<?= $i ?>"><?= ($member) ? $member['username'] : '' ?></span>
                        <?php if ($is_owner) { ?>
                            <div class="position-absolute pt-1 top-0 end-0 member-controls d-none">
                                <button class="btn btn-link text-light btn-remote-mute" onclick="moderateAudioToggle(this,<?= $i ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Mute/Unmute member audio">
                                    <i class="fas fa-microphone icon-option-member"></i></button> |
                                <button class="btn btn-link text-light btn-remote-video" onclick="moderateVideoToggle(this,<?= $i ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Mute/Unmute member video">
                                    <i class="fas fa-video icon-option-member"></i></button> |
                                <button class="btn btn-link text-light btn-remote-kick" data-bs-toggle="tooltip" data-bs-placement="top" title="Kick member">
                                    <i class="fas fa-user-times icon-option-member"></i></button>
                            </div>
                        <?php } ?>
                    </li>
                <?php  } ?>
            </ul>
        </div>
        <div class="tab-pane fade option-content" id="pills-chat" role="tabpanel" aria-labelledby="pills-chat-tab">
            <?= Html::tag('h3', 'Chat section', ['class' => 'text-center']) ?>
        </div>
    </div>

</aside>