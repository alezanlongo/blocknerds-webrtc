<?php

use Carbon\Carbon;

?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Component</th>
            <th scope="col">Type</th>
            <th scope="col">Foundation</th>
            <th scope="col">Protocol</th>
            <th scope="col">Address</th>
            <th scope="col">Port</th>
            <th scope="col">Priority</th>
            <th scope="col">Mid</th>
            <th scope="col">MLine Index</th>
            <th scope="col">Username Fragment</th>
            <th scope="col">createdAt</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($logs as $log) {
            $candidate = $log['candidate'];
        ?>
            <tr>
                <th scope="row"><?= $log['id'] ?></th>
                <td><?= $candidate['component'] ?></td>
                <td><?= $candidate['type'] ?></td>
                <td><?= $candidate['foundation'] ?></td>
                <td><?= $candidate['protocol'] ?></td>
                <td><?= $candidate['address'] ?></td>
                <td><?= $candidate['port'] ?></td>
                <td><?= $candidate['priority'] ?></td>
                <td><?= $candidate['sdpMid'] ?></td>
                <td><?= $candidate['sdpMLineIndex'] ?></td>
                <td><?= $candidate['usernameFragment'] ?></td>
                <td><?= Carbon::createFromTimestamp($log['created_at'])->format('Y-m-d H:i:s') ?></td>
                <td>
                    <button type="button" class="btn btn-primary btn-open-detail" onclick="openModal(<?= $log['id'] ?>)">
                        sdp Details
                    </button>
                </td>
            </tr>
        <?php  } ?>
    </tbody>
</table>