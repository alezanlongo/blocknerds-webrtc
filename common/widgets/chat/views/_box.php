<!-- DIRECT CHAT -->
<div class="card direct-chat direct-chat-primary">
    <?php if (!$isNew) { ?>
        <div class="card-header">
            <h3 class="card-title">Direct Chat</h3>

            <div class="card-tools">
                <span title="3 New Messages" class="badge bg-primary">3</span>
                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" title="Contacts" data-lte-toggle="chat-pane">
                    <i class="fas fa-comments"></i>
                </button>
                <button type="button" class="btn btn-tool" data-lte-dismiss="card-remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <!-- Conversations are loaded here -->
            <div class="direct-chat-messages">
                <?php foreach ($chats as $chat) { ?>
                    <?php if ($chat["from"] === Yii::$app->getUser()->getId()) { ?>
                        <!-- Message. Default to the start -->
                        <div class="direct-chat-msg">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-start">Alexander Pierce</span>
                                <span class="direct-chat-timestamp float-end">23 Jan 2:00 pm</span>
                            </div>
                            <!-- /.direct-chat-infos -->
                            <img class="direct-chat-img" src="./assets/img/user1-128x128.jpg" alt="message user image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                                Is this template really for free? That's unbelievable!
                            </div>
                            <!-- /.direct-chat-text -->
                        </div>
                    <?php } else { ?>
                        <!-- Message to the end -->
                        <div class="direct-chat-msg end">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-end">Sarah Bullock</span>
                                <span class="direct-chat-timestamp float-start">23 Jan 2:05 pm</span>
                            </div>
                            <!-- /.direct-chat-infos -->
                            <img class="direct-chat-img" src="./assets/img/user3-128x128.jpg" alt="message user image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                                You better believe it!
                            </div>
                            <!-- /.direct-chat-text -->
                        </div>
                        <!-- /.direct-chat-msg -->
                    <?php } ?>
                <?php } ?>

                <!-- /.direct-chat-msg -->

            </div>
            <!--/.direct-chat-messages-->
        </div>
    <?php } ?>
    <!-- /.card-body -->
    <div class="card-footer">
        <?php if ($isNew) { ?>
            <select class="form-select" aria-label="select users" name="user_target">
                <option selected>Select user to init the chat</option>
                <!-- TODO: change User to USerProfile -->
                <?php foreach ($users as $userProf) { ?>
                    <option value="<?= $userProf->id ?>"><?= $userProf->user->username ?></option>
                <?php } ?>
            </select>
        <?php } ?>
        <div class="input-group">
            <input type="text" name="message" placeholder="Type Message ..." class="form-control message-onToOne" autocomplete="off">
            <span class="input-group-append">
                <button type="button" class="btn btn-primary btn-send" onclick="initChatWithUser();">Send</button>
            </span>
        </div>
    </div>
    <!-- /.card-footer-->
</div>