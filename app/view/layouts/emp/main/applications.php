<?php
use App\Controller\Employer\Detail;
use App\Controller\User\Profile;
use App\Controller\Admin\Users;
use App\Controller\Admin\Postings;
$compid = Detail::getEmpId($_SESSION['emp_id']);

$api_location = getenv('API_LOCATION');
?>

<div class="row">

  <div class="col-12">
    <div id="alertbox" class="alert alert-danger" style="display:none"></div>
    <div class="portlet margin-bottom-30">
      <div class="portlet-title">
        <div class="caption caption-green">
          <i class="fa fa-envelope-open" aria-hidden="true"></i>
          <span class="caption-subject text-uppercase"> ใบสมัครทั้งหมดที่ส่งเข้ามา</span>
        </div>
      </div>
      <div class="portlet-body">
        <?php
          $lastpostings = Detail::getLastApplications($compid);
          if(mysqli_num_rows($lastpostings) < 1){
            echo '<div class="row text-center">';
            echo '<h3>ยังไม่มีผู้ส่งใบสมัครงานเข้ามา</h3>';
            echo '</div>';
          }else{
        ?>
        <div class="row" style="padding:20px;">
        <table class="table no-footer" id="datatables">
          <thead>
            <tr>
              <th width="15%"><em class="fa fa-cog"></em></th>
              <th width="30%">ชื่อผู้สมัคร</th>
              <th width="30%">ชื่อตำแหน่ง</th>
              <th>สถานะ</th>
              <th>วันที่สมัคร</th>
            </tr>
          </thead>
          <tbody>
            <?php
              while ($row = $lastpostings->fetch_array()){  
                $user = Profile::profileload($row['user_id']);
                $user = mysqli_fetch_assoc($user);
            ?>
            <tr id="<?=$row['id']?>">
              <td style="text-align: center;">
                <a class="btn btn-info" href="detail/<?=$row['id']?>"><em class="fa fa-envelope-open"></em> รายละเอียด</a>
                <a class="btn btn-success" data-title="Reply" data-toggle="modal" data-target="#reply" data-post-id="<?=$row['id']?>" data-post-reciever="<?=$user['id']?>"><em class="fa fa-reply"></em> ตอบกลับ</a>
              </td>
              <td><?=$user['first_name']." ".$user['last_name']." (".$user['email'].")"?></td>
              <td><?=$row['name']?></td>
              <td><?=$lang[Detail::getApplyStatus($row['status'])]?></td>
              <td><?=$row['created_at']?></td>
            </tr>
          <?php } ?>
            </tbody>
          </table>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>

</div>

<div class="modal fade" id="reply" tabindex="-1" role="reply" aria-labelledby="delete" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title custom_align" id="Heading">ตอบกลับ</h4>
      </div>
      <div class="modal-body">
      <div class="alert alert-danger" id="errorbox" style="display:none;"></div>

        <form role="form" id="replyapplyform" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">ข้อความ</label>
            <div class="col-sm-10">
              <div id='message'></div>
            </div>
            <input type="hidden" id="sender" value="<?=$_SESSION['emp_id']?>">
            <input type="hidden" id="receiver">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <a onclick="reply(this)" class="btn btn-success"><span class="fa fa-reply"></span> ตอบกลับ</a>
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-times"></span> ยกเลิก</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  $(function() {
    $('#datatables').DataTable({
      tabIndex: -1,
      ordering: false,
      bFilter: false,
      bInfo: false,
      bLengthChange: false,
      responsive: true
    });

    $('div#message').summernote({
      height: 150,
      disableDragAndDrop: true,
      dialogsFade: true,
      tabsize: 2,
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
      ]
    });
  });

  $("#reply").on("show.bs.modal", function(e) {
    var id = $(e.relatedTarget).data('post-id');
    var reciever = $(e.relatedTarget).data('post-reciever');
    $(e.currentTarget).find('a.btn-success').attr("id", id);
    $(e.currentTarget).find('input#receiver').val(reciever);
  });

  function reply(element){
    var id = $(element).attr('id');
    var message = $('div#message').summernote('code');
    var sender = $('input#sender').val();
    var reciever = $('input#receiver').val();
    $.ajax({
      url: '<?=$api_location?>/messages',
      type: 'POST',
      data: {title: 'JOBREPLY', text: message, sender: sender, reciever: reciever, type: 2},
      dataType: "json",
      success: function (result) {
        swal({
          type: 'success',
          title: '<?=$lang['Success']?>',
          timer: 3000,
          showConfirmButton: false,
        });
        setTimeout(function(){ window.location = "/employer/applications/"; }, 3000);
      },
      error: function (result) {
        swal({
          type: 'error',
          title: '<?=$lang['AlertErrorText']?>',
          timer: 1000
        });
      }
    });
  }
</script>
