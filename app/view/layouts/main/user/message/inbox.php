<?php
use App\Controller\User\Profile;
use App\Controller\Message\Message;

$messages = Message::getInbox($_SESSION['social_id']);

$user = Profile::profileLoad($_SESSION['social_id']);
$user = mysqli_fetch_array($user);

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
          <li class="active">
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
          <h2 style="margin: 0"><?=$lang['Inbox']?></h2>
        </div>
        <div class="inbox-body">
          <div class="mail-option">

            <div class="btn-group">
              <a data-original-title="Refresh" data-placement="top" data-toggle="dropdown" href="#" class="btn mini tooltips">
                <i class=" fa fa-refresh"></i>
              </a>
            </div>

            <ul class="unstyled inbox-pagination">
              <li>
                <span>1-<?=count($messages) > 10 ? 10 : count($messages)?> of <?=count($messages)?></span>
              </li>
              <li>
                <a class="np-btn" href="#">
                  <i class="fa fa-angle-left  pagination-left"></i>
                </a>
              </li>
              <li>
                <a class="np-btn" href="#">
                  <i class="fa fa-angle-right pagination-right"></i>
                </a>
              </li>
            </ul>
          </div>
          <table class="table table-inbox table-hover">
            <tbody>
              <?php
                foreach($messages as $message) {
              ?>
              <tr data-href="./reader/<?=$message['id']?>" <?=$message['isReaded'] ? '':'class="unread"'?>>
                <td class="view-message dont-show"><?=$message['sender']?></td>
                <?php
                  if ($message['type'] == 1) {
                    echo '<td class="view-message">'.$message['title'].'</td>';
                  } else if ($message['type'] == 2) {
                    echo '<td class="view-message">'.$lang[$message['title']].'</td>';
                  }
                ?>
                <td class="view-message inbox-small-cells">
                  <i class="fa fa-paperclip"></i>
                </td>
                <td class="view-message  text-right">
                <?php
                  if($message['sentAt'] == "justnow"){
                    echo $lang[$message['sentAt']];
                  }else{
                    $date = explode(" ", $message['sentAt']);
                    echo $date[0]." ".$lang[$date[1]].$lang[$date[2]];
                  }
                ?>
                </td>
              </tr>
              <?php
                }
              ?>
            </tbody>
          </table>
        </div>
      </aside>
    </div>
  </div>

  <script>
    $('tr[data-href]').on('click', function (e) {
      document.location = $(this).data('href');
    });
  </script>