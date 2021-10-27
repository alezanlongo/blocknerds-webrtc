<ul class="list-group">
    <?php foreach ($recentChat as $chat) { ?>
        <li class="list-group-item">
            <button onclick="openBox(<?= $chat['id'] ?>, '<?= $chat['chat_with'] ?>')" class="list-group-item list-group-item-action">
            <?= $chat['chat_with'] ?>
            <p class="text-muted text-break fs-6">Last message...</p>
        </button>
            
        </li>
    <?php } ?>
</ul>
