<?php
use Controller\User\Profile;
use Controller\Message\Message;

$messages = Message::getMessage($variables[2]);

if ($messages['sender'] == $_SESSION['social_id']) {
  $sender = array(
    'name' => $lang['You']
  );
} else {
  $sender = Message::getFullSender($messages['sender'], $messages['type']);
}

$readed = Message::setAsReaded($variables[2]);

$user = Profile::profileLoad($_SESSION['social_id']);
$user = mysqli_fetch_array($user);

if ($messages['reciever'] == $_SESSION['social_id']) {
  $receiver = array(
    'name' => $lang['You']
  );
} else {
  $receiver = Message::getFullSender($messages['receiver'], 1);
}

$count = Message::count($_SESSION['social_id']);
?>
  <div class="container">
    <div class="mail-box">
      <aside class="sm-side">
        <div class="user-head">
          <a class="inbox-avatar" href="javascript:;">
            <img width="60" hieght="60" src="/uploads/profile_image/<?=$currentuser['profile_image']?>">
          </a>
          <div class="user-name">
            <h5>
              <a href="#"><?=$user['first_name']?> <?=$user['last_name']?></a>
            </h5>
            <span>
              <a href="#"><?=$user['email']?></a>
            </span>
          </div>
        </div>
        <div class="inbox-body">
          <a href="#myModal" data-toggle="modal" title="Compose" class="btn btn-primary btn-block btn-lg">
            <?=$lang['Compose']?>
          </a>
          <!-- Modal -->
          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                  <h4 class="modal-title"><?=$lang['Compose']?></h4>
                </div>
                <div class="modal-body">
                  <form role="form" class="form-horizontal">
                    <div class="form-group">
                      <label class="col-lg-2 control-label">To</label>
                      <div class="col-lg-10">
                        <input type="text" placeholder="" id="inputEmail1" class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Cc / Bcc</label>
                      <div class="col-lg-10">
                        <input type="text" placeholder="" id="cc" class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Subject</label>
                      <div class="col-lg-10">
                        <input type="text" placeholder="" id="inputPassword1" class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Message</label>
                      <div class="col-lg-10">
                        <textarea rows="10" cols="30" class="form-control" id="" name=""></textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <span class="btn green fileinput-button">
                          <i class="fa fa-plus fa fa-white"></i>
                          <span>Attachment</span>
                          <input type="file" name="files[]" multiple="">
                        </span>
                        <button class="btn btn-send" type="submit">Send</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->
        </div>
        <ul class="inbox-nav inbox-divider">
          <li>
            <a href="/home/messages/inbox">
              <i class="fa fa-inbox"></i> <?=$lang['Inbox']?>
              <?php
                if ($count['inbox'] >= 1) {
                  echo '<span class="label label-danger pull-right">'.$count['inbox'].'</span>';
                }
              ?>
            </a>

          </li>
          <li>
            <a href="/home/messages/sent">
              <i class="fa fa-paper-plane"></i> <?=$lang['SentBox']?></a>
          </li>
          <li>
            <a href="/home/messages/drafts">
              <i class=" fa fa-external-link"></i> <?=$lang['Drafts']?>
              <span class="label label-info pull-right">30</span>
            </a>
          </li>
          <li>
            <a href="/home/messages/trash">
              <i class=" fa fa-trash-o"></i> <?=$lang['Trash']?></a>
          </li>
        </ul>
      </aside>
      <aside class="lg-side">
        <div class="inbox-head">
          <h2 style="margin: 0">
          <?php
            if ($messages['type'] == 1) {
              echo $messages['title'];
            } else {
              echo $lang[$messages['title']];
            }
          ?>
          </h2>
        </div>
        <div class="inbox-body">
          <div class="panel panel-default">
            <div class="panel-heading">
            <div class="profile-image"></div>
              <div class="message-title">
                <?php
                  if ($messages['type'] == 1) {
                    echo 'Title: '.$messages['title'].'<br/>';
                  } else {
                    echo 'Title: '.$lang[$messages['title']].'<br/>';
                  }
                ?>
                From: <?=$sender['name']?> <?=$sender['lastName'] ? $sender['lastName']: ''?></br>
                To: <?=$receiver['name']?>
              </div>
            </div>
            <div class="panel-body">
              <?=$messages['text']?>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Reply</div>
            <div class="panel-body">
              <form role="form" class="form-horizontal">
                <div class="form-group">
                  <label class="col-lg-2 control-label">Message</label>
                  <div class="col-lg-10">
                    <textarea rows="10" cols="30" class="form-control" id="" name=""></textarea>
                  </div>
                </div>

                <input type="hidden" id="sender" value="<?=$_SESSION['social_id']?>">
                <input type="hidden" id="receiver" value="<?=$messages['sender']?>">
                <input type="hidden" id="type" value="<?=$messages['type']?>">

                <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                    <button class="btn btn-send" type="submit">Send</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </aside>
    </div>
  </div>

  <script>
    $('tr[data-href]').on('click', function (e) {
      document.location = $(this).data('href');
    });
  </script>