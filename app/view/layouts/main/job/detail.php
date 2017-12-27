<?php
use Controller\Config\Database;
use Controller\Job\JobController;
use Controller\Utils\Address;
use Controller\Employer\Detail;

JobController::addCount($variables[2]);

$currentjob = JobController::loadJobPosting($variables[2]);
$location = Detail::getLocation($currentjob['location'], false, false);
$location = mysqli_fetch_array($location);
?>
        <div id="errorbox" class="alert" style="display:none;"></div>

        <?php include_once 'app/view/layouts/main/job/empdetail.php' ?>

        <div class="portlet margin-bottom-30">
          <div class="portlet-title">
            <div class="caption caption-green">
              <i class="fa fa-file" aria-hidden="true"></i>
              <span class="caption-subject text-uppercase"> <?=$lang["JobDetail"]?></span>
            </div>
            <div class="actions">
              <span class="pull-right"><i class="fa fa-calendar" aria-hidden="true"></i> <?=JobController::getPostedTime($currentjob['created_at'])?></span>
            </div>
          </div>
          <div class="portlet-body margin-bottom-10" id="printarea">
            <div class="card horizontal" style="border:0px;margin-top:-1px;">
              <div class="card-image">
                <img src="/uploads/logo_images/<?=JobController::getEmployerLogo($currentjob['company_id'])?>" style="border:0px; object-fit: contain;" />
              </div>
              <div class="card-stacked">
                <div class="card-content job-detail">

                  <h3><?=$currentjob['name']?></h3>
                  <p><i class="fa fa-building" aria-hidden="true"></i> <?=JobController::getEmployerName($currentjob['company_id']);?> <i class="fa fa-map-marker" aria-hidden="true"></i> <?=Address::getProvinceName($location['province'])?></p>
                  <h4><?=$lang["Responsibility"]?></h4>
                  <p><?=$currentjob['responsibilities']?></p>

                  <h4><?=$lang["Qualification"]?></h4>
                  <p><?=$currentjob['qualification']?></p>

                  <h4><?=$lang["Benefit"]?></h4>
                  <p><?=$currentjob['benefit']?></p>

                  <table class="job-detail">
                    <tr><td><strong><?=$lang['capacity']?></strong></td>
                      <td>
                        <?php
                          if(JobController::getJobCapacity($variables[2])) {
                            echo $lang['multirate'];
                          }else{
                            echo $currentjob['capacity']." ".$lang['unit_capacity'];
                          }
                        ?>
                      </td>
                    </tr>
                    <tr><td><strong><?=$lang['jobLevel']?></strong></td><td><?php JobController::getJobLevel($currentjob['level']); ?></td></tr>
                    <tr><td><strong><?=$lang['Wage']?></strong></td><td><?=$currentjob['salary']?> บาท <?=JobController::getGetSalaryType($currentjob['salary_type']);?> <?php if(JobController::isNegetiable($variables[2])) echo "ต่อรองได้" ?></td></tr>
                    <tr><td><strong><?=$lang['Exp_req']?></strong></td><td><?=JobController::getExpRequired($currentjob['exp_req']);?></td></tr>
                    <tr><td><strong><?=$lang['Edu_req']?></strong></td><td><?=JobController::getEducationRequired($currentjob['edu_req']);?></td></tr>
                    <tr><td><strong><?=$lang['job_cat']?></strong></td><td><?=JobController::getJobCatName($currentjob['category_id']);?></td></tr>
                    <tr><td><strong><?=$lang['emp_cat']?></strong></td><td><?=JobController::getEmployerCat($currentjob['company_id']);?></td></tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="portlet-footer">
            <ul class="list-inline list-unstyled">
              <?php if(JobController::getApplyStatus($_SESSION['social_id'], $variables[2]) == 0){ ?>
                <li><a href="/job/apply/<?=$variables[2]?>" class="btn btn-info"><i class="fa fa-paper-plane" aria-hidden="true"></i> <?=$lang["ApplyJob"]?> </a></li>
              <?php }else{ ?>
                <li><a class="btn btn-info"><i class="fa fa-check" aria-hidden="true"></i> <?=$lang["ApplySent"]?> </a></li>
              <?php } ?>
              <?php if(JobController::getSaveStatus($_SESSION['social_id'], $variables[2]) == 0){ ?>
                <li><a id="savebtn" onclick="save()" class="btn btn-info"><i class="fa fa-heart" aria-hidden="true"></i> <?=$lang["Save"]?> </a></li>
              <?php }else{ ?>
                <li><a id="savebtn" onclick="save()" class="btn btn-info"><i class="fa fa-trash" aria-hidden="true"></i> <?=$lang["Remove"]?> </a></li>
              <?php } ?>
              <li><a onclick="window.print()" class="btn btn-info"><i class="fa fa-print" aria-hidden="true"></i> <?=$lang["Print"]?> </a></li>
            </ul>
          </div>
        </div>

        <script type="text/javascript">
          function save(){
            var id = <?=$variables[2]?>;
            $.ajax({
              url: '/job/save/',
              type: 'POST',
              data: {id: id},
              dataType: "json",
              success: function(result){
                if(result.success){
                  $("#errorbox").removeClass('alert-danger');
        					$("#errorbox").addClass('alert-success');
                  $("#errorbox").html("<?=$lang['AlertSuccessText']?>");
                  $("#errorbox").fadeIn();
                  $("#errorbox").delay(3000).fadeOut(300);
                  if(result.add){
                    $('#savebtn').html('<i class="fa fa-trash" aria-hidden="true"></i> <?=$lang["Remove"]?>');
                  }else{
                    $('#savebtn').html('<i class="fa fa-heart" aria-hidden="true"></i> <?=$lang["Save"]?>');
                  }
          			}else{
                  $("#errorbox").removeClass('alert-success');
                  $("#errorbox").addClass('alert-danger');
                  $("#errorbox").html("<?=$lang['AlertErrorText']?>");
                  $("#errorbox").fadeIn();
                  $("#errorbox").delay(3000).fadeOut(300);
                }
              }
            });
          }
        </script>
