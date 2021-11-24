<ul class="list-group">
    <?php foreach ($recentChat as $chat) { ?>
        <li class="list-group-item">
            <button onclick="openChatBox(<?= $chat['profile_id'] ? $chat['profile_id']  : 'null' ?>, '<?= $chat['username'] ?>', <?= $chat['room_id'] ? $chat['room_id'] : 'null' ?>, '<?= $chat['channel'] ?>')" class="list-group-item list-group-item-action">
                <?= $chat['username'] . ($chat['room_id'] ? " (Room)" : null) ?>
                <p class="text-muted text-break fs-6"><?= $chat['message'] ?? '' ?></p>
            </button>

        </li>
    <?php } ?>
</ul>