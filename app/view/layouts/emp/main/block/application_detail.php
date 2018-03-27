<?php
use App\Controller\Employer\Detail;
use App\Controller\Job\JobController;
use App\Controller\Job\Employer;
use App\Controller\User\Profile;
use App\Controller\User\Experiences;
use App\Controller\User\Educations;
use App\Controller\User\Skills;

JobController::setApplicationStatus($variables[2], 1);
$application = Detail::getApplicationDetails($variables[2]);

$row = JobController::loadJobPosting($application['job_id']);
$emp = Employer::loadEMP($row['company_id']);
$emp = mysqli_fetch_array($emp);

$currentuser = Profile::profileLoad($application['user_id']);
$currentuser = mysqli_fetch_array($currentuser);

$edu = Educations::eduLoad($application['user_id']);
$exp = Experiences::expLoad($application['user_id']);
$skill = Skills::skillLoad($application['user_id']);
?>

<div class="portlet margin-bottom-30">
  <div class="portlet-title">
      <i class="fa fa-pencil" aria-hidden="true"></i>
      <span class="caption-subject text-uppercase"> จัดการใบสมัครงาน</span>
  </div>
  <div class="portlet-body">
    <?php
      if ($application['status'] > 3) {
    ?>
    <div class="row">
      <div class="col-sm-12">
        สถานะใบสมัครงาน: <?=$lang[Detail::getApplyStatus($application['status'])]?>
      </div>
    </div>
    <?php } else { ?>
    <div class="row">
      <div class="col-sm-12">
        <button class="btn btn-success" onclick="updateStatus(5)"><em class="fa fa fa-check"></em> ตอบรับ</button>
        <button class="btn btn-danger" onclick="updateStatus(4)"><em class="fa fa fa-times"></em> ปฏิเสธ</button>
        <!-- <a class="btn btn-info" data-title="Reply" data-toggle="modal" data-target="#reply"><em class="fa fa-paper-plane"></em> ส่งข้อความ</a> -->
      </div>
    </div>
    <?php } ?>
  </div>
</div>

<!-- <div class="portlet margin-bottom-30">
  <div class="portlet-title">
      <i class="fa fa-comments" aria-hidden="true"></i>
      <span class="caption-subject text-uppercase"> การสนทนา</span>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-sm-12">
      </div>
    </div>
  </div>
</div> -->

<div class="portlet margin-bottom-30">
  <div class="portlet-title">
    <div class="caption caption-green">
      <i class="fa fa-paper-plane" aria-hidden="true"></i>
      <span class="caption-subject text-uppercase"> <?=$lang['Applications']?></span>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">

        <div>
          <label><?=$lang['ApplyTitle']?> :</label>
          <span><?=$lang['WantToApplyFor']?> <?=$row['name']?></span>
        </div>

        <div>
          <label><?=$lang['To']?> :</label>
          <span><?=$emp['name']?></span>
        </div>

        <div>
          <label><?=$lang['From']?> :</label>
          <span><?=$currentuser['first_name']?> <?=$currentuser['last_name']?> (<?=$currentuser['email']?>)</span>
        </div>

      </div>

    </div>
  </div>
</div>

<div class="portlet margin-bottom-30">
  <div class="portlet-title">
    <div class="caption caption-green">
      <i class="fa fa-comment" aria-hidden="true"></i>
      <span class="caption-subject text-uppercase"> <?=$lang['Messages']?></span>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
      <?=$application['message']?>  
      </div>
    </div>
  </div>
</div>

<div class="portlet margin-bottom-30">
  <div class="portlet-title">
    <div class="caption caption-green">
      <i class="fa fa-user" aria-hidden="true"></i>
      <span class="caption-subject text-uppercase"> <?=$lang['Resume']?></span>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12" >
        <div class="resume">
          <div class="pull-right">
            <img src="/uploads/profile_image/<?=$currentuser['profile_image']?>" style="border: 1px solid #ccc; margin-top:5px;width: 120px; height:120px; object-fit: fill;">
          </div>

          <div class="detail-block">
            <h2><i class="fa fa-user"></i> <?=$lang['PersonalDetail']?></h2>

            <div>
              <span><h3><?=$currentuser['first_name']?> <?=$currentuser['last_name']?></h3></span>
            </div>

            <div>
              <label><?=$lang['Birthdate']?> :</label>
              <?php
                $date = date("d M Y", strtotime($currentuser['birthdate']));
              ?>
              <span><?=$date?></span>
            </div>

            <div>
              <label><?=$lang['Gender']?> :</label>
              <span><?=$lang[Profile::gender($currentuser['sex'])]?></span>
            </div>

          </div>

          <div class="detail-block">
            <h2><i class="fa fa-address-book"></i> <?=$lang['Contact']?></h2>

            <div class="row" style="margin:0;">
              <div class="col-md-6" style="margin:0;">
                <div style="margin:0;">
                  <label><?=$lang['email']?> :</label>
                  <span><?=$currentuser['email']?></span>
                </div>
                <?php if($currentuser['telephone'] != NULL || $currentuser['telephone'] != ""){ ?>
                <div style="margin:0;">
                  <label><?=$lang['Telephone']?> :</label>
                  <span><?=$currentuser['telephone']?></span>
                </div>
                <?php } ?>
                <?php if($currentuser['facebook'] != NULL || $currentuser['facebook'] != ""){ ?>
                <div style="margin:0;">
                  <label>Facebook :</label>
                  <span><?=$currentuser['facebook']?></span>
                </div>
                <?php } ?>
              </div>
              <div class="col-md-5">
                <?php if($currentuser['twitter'] != NULL || $currentuser['twitter'] != ""){ ?>
                <div>
                  <label>Twitter :</label>
                  <span><?=$currentuser['twitter']?></span>
                </div>
                <?php } ?>
                <?php if($currentuser['line'] != NULL || $currentuser['line'] != ""){ ?>
                <div>
                  <label>Line :</label>
                  <span><?=$currentuser['line']?></span>
                </div>
                <?php } ?>
                <?php if($currentuser['other_link'] != NULL || $currentuser['other_link'] != ""){ ?>
                <div>
                  <label>Link :</label>
                  <span><?=$currentuser['other_link']?></span>
                </div>
                <?php } ?>
              </div>
            </div>


          </div>

          <?php if(mysqli_num_rows($edu) > 0){ ?>
          <div class="detail-block">
            <h2><i class="fa fa-book"></i> <?=$lang['Educations']?></h2>
            <?php while($row = $edu->fetch_array()){ ?>
              <div>
                <label><?=JobController::getEducationRequired($row['background']);?> | <?=$row['major']?> | <?=$row['gpa']?></label><br/>
                <span><?=$row['institute_name']?></span>
              </div>
            <?php } ?>
          </div>
          <?php } ?>

          <?php if(mysqli_num_rows($exp) > 0){ ?>
          <div class="detail-block">
            <h2><i class="fa fa-tasks"></i> <?=$lang['Experiences']?> </h2>
            <?php while($row = $exp->fetch_array()){ ?>
              <div>
                <label>
                  <?=$row['name']?> |
                  <?php
                    $startdate = date("M Y", strtotime($row['start_at']));
                    echo $startdate;
                    if($row['status'] == 0){
                      $enddate = date("M Y", strtotime($row['end_at']));
                      echo " - ".$enddate;
                    }else if($row['status'] == 1){
                      echo " - ".$lang['now'];
                    }
                  ?>
                </label><br/>
                <span><?=$row['company']?></span>
              </div>
            <?php } ?>
          </div>
          <?php } ?>

          <?php if(mysqli_num_rows($skill) > 0){ ?>
          <div class="detail-block">
            <h2><i class="fa fa-tags"></i> <?=$lang['Skills']?> </h2>
            <?php
              echo '<ul>';
              while($row = $skill->fetch_array()){
                echo "<li>".$row['name']."</li>";
              }
              echo '</ul>';
            ?>
          </div>
          <?php } ?>

        </div>

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
          <div class="form-group margin-bottom-20">
            <label for="" class="col-sm-2 control-label">ชื่อเรื่อง</label>
            <div class="col-sm-10">
              <?=$lang['JOBREPLY']?>
            </div>
          </div>

          <div class="form-group margin-bottom-20">
            <label for="" class="col-sm-2 control-label">ถึง</label>
            <div class="col-sm-10">
              <?=$currentuser['first_name']?> <?=$currentuser['last_name']?> (<?=$currentuser['email']?>)
            </div>
          </div>
          
          <div class="form-group margin-bottom-20">
            <label for="" class="col-sm-2 control-label">ข้อความ</label>
            <div class="col-sm-10">
              <div id='message'></div>
            </div>
          </div>
          
          <input type="hidden" id="sender" value="<?=$_SESSION['emp_id']?>">
          <input type="hidden" id="receiver" value="<?=$application['user_id']?>">
          <input type="hidden" id="job_id" value="<?=$variables[2]?>">
        </form>
      </div>
      <div class="modal-footer">
        <a onclick="reply(this)" class="btn btn-success"><span class="fa fa-reply"></span> ตอบกลับ</a>
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-times"></span> ยกเลิก</button>
      </div>
    </div>
  </div>
</div>

<script>
$(function() {
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


function updateStatus(status) {
  $.ajax({
    url: '<?=$_ENV['API_LOCATION']?>/applications/<?=$variables[2]?>/status',
    type: 'PUT',
    data: {status: status},
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
  })
}

function reply(element){
  var id = $(element).attr('id');
  var message = $('div#message').summernote('code');
  var sender = $('input#sender').val();
  var reciever = $('input#receiver').val();
  var jobid = $('input#receiver').val();
  $.ajax({
    url: '<?=$_ENV['API_LOCATION']?>/messages',
    type: 'POST',
    data: {title: 'JOBREPLY', text: message, sender: sender, reciever: reciever, type: 2, job_id: jobid},
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