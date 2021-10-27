<ul class="list-group">
    <?php foreach ($users as $user) { ?>
        <li class="list-group-item">
            <button onclick="openBox(<?= $user->id ?>, '<?= $user->username ?>')" class="list-group-item list-group-item-action"><?= $user->username ?></button>
        </li>
    <?php } ?>
</ul>
