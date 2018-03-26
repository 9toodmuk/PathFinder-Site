<?php
use Controller\Job\JobController;
use Controller\Job\Employer;
use Controller\User\Profile;
use Controller\User\Experiences;
use Controller\User\Educations;
use Controller\User\Skills;

$row = JobController::loadJobPosting($variables[2]);
$emp = Employer::loadEMP($row['company_id']);
$emp = mysqli_fetch_array($emp);

$currentuser = Profile::profileLoad($_SESSION['social_id']);
$currentuser = mysqli_fetch_array($currentuser);

$edu = Educations::eduLoad($_SESSION['social_id']);
$exp = Experiences::expLoad($_SESSION['social_id']);
$skill = Skills::skillLoad($_SESSION['social_id']);
?>

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

        <div id='message'></div>

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
    <div class="actions">
      <a href="/user/edit/" class="btn btn-primary">
        <?=$lang['editlocationbtn']?>
      </a>
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

<div class="portlet margin-bottom-30">
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <button type="button" onclick="applyjob(<?=$variables[2]?>)" class="btn btn-primary btn-block btn-lg"><?=$lang['ApplyJob']?></button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
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

  function applyjob(id){
    var uid = <?=$_SESSION['social_id']?>;
    var message = $('div#message').summernote('code');
    $.ajax({
      url: "/job/sendapply/",
      data: {id: id, message: message, uid: uid},
      dataType: "json",
      type: "post",
      success: function(result){
        if(result.success){
          swal({
            type: 'success',
            title: '<?=$lang['Success']?>',
            showConfirmButton: false,
            timer: 1500
          });
          setTimeout(function(){ window.location.replace("/job/"); }, 1500);
        }
      }
    });
  }
</script>
