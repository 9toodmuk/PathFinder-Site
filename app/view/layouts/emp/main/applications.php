<?php
use Controller\Employer\Detail;
use Controller\User\Profile;
use Controller\Admin\Users;
use Controller\Admin\Postings;
$compid = Detail::getEmpId($_SESSION['emp_id']);
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
                <a class="btn btn-success" data-title="Reply" data-toggle="modal" data-target="#reply" data-post-id="<?=$row['id']?>"><em class="fa fa-reply"></em> ตอบกลับ</a>
              </td>
              <td><?=$user['first_name']." ".$user['last_name']?></td>
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
            </div>

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
    $(e.currentTarget).find('a.btn-success').attr("id", id);
  });

  function reply(element){
    var id = $(element).attr('id');
    var message = $('div#message').summernote('code');
    $.ajax({
      url: '/employer/replyapply/',
      type: 'POST',
      data: {id: id, message: message},
      dataType: "json",
      success: function (result) {
        if(!result.status){
          $('#errorbox').fadeIn();
          $('#errorbox').delay(5000).fadeOut(1000);
        }else{
          $("#errorbox").removeClass("alert-danger");
          $("#errorbox").addClass("alert-success");
          $("#errorbox").html("<strong>Success!</success> Replied the application.");
          $("#errorbox").fadeIn();
          setTimeout(function(){ window.location = "/employer/applications/"; }, 3000);
        }
      }
    });
  }
</script>
