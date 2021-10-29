<?php 


?>
<ul class="list-group">
    <?php foreach ($recentChat as $chat) { ?>
        <li class="list-group-item">
            <button onclick="openBox(<?= $chat['profile_id'] ?>, '<?= $chat['username'] ?>')" class="list-group-item list-group-item-action">
            <?= $chat['username'] ?>
            <p class="text-muted text-break fs-6"><?= $chat['message'] ?? '' ?></p>
        </button>
            
        </li>
    <?php } ?>
</ul>
