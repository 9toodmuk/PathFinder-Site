<?php
use Controller\User\Profile;
use Controller\User\Experiences;
use Controller\User\Educations;
use Controller\User\Skills;
use Controller\Admin\Postings;
$user = Profile::profileLoad($variables[2]);
$user = mysqli_fetch_array($user);
$relate = Profile::getRelatives($variables[2]);
$exp = Experiences::expLoad($variables[2]);
$edu = Educations::eduLoad($variables[2]);
$skill = Skills::skillLoad($variables[2]);
?>

<div class="row" id="about">
  <div class="portlet margin-bottom-30">
    <div class="portlet-title">
      <div class="caption caption-green">
        <i class="fa fa-user" aria-hidden="true"></i>
        <span class="caption-subject text-uppercase"> About me</span>
      </div>
    </div>
    <div class="portlet-body">
      <table class="table table-bordered">
        <tr><td width="30%"><strong><?=$lang['name']?></strong></td><td><?=$user['first_name']?> <?=$user['last_name']?></td></tr>
          <tr><td><strong><?=$lang['Gender']?></strong></td><td><?=$lang[Profile::gender($user['sex'])]?></td></tr>
          <?php if($user['birthdate'] != '1900-01-01') { ?><tr><td><strong><?=$lang['Birthdate']?></strong></td><td><?=$user['birthdate']?></td></tr><?php } ?>
          <?php if($user['telephone'] != '') { ?><tr><td><strong><?=$lang['Telephone']?></strong></td><td><?=$user['telephone']?></td></tr><?php } ?>
          <?php if($user['facebook'] != '') { ?><tr><td><strong>Facebook</strong></td><td><?=$user['facebook']?></td></tr><?php } ?>
          <?php if($user['twitter'] != '') { ?><tr><td><strong>Twitter</strong></td><td><?=$user['twitter']?></td></tr><?php } ?>
          <?php if($user['line'] != '') { ?><tr><td><strong>Line</strong></td><td><?=$user['line']?></td></tr><?php } ?>
          <?php if($user['other_link'] != '') { ?><tr><td><strong><?=$lang['Others']?></strong></td><td><?=$user['other_link']?></td></tr><?php } ?>
      </table>
    </div>
  </div>
</div>

<!-- <?php if(sizeof($relate) > 0){ ?>
<div class="row" id="exp">
  <div class="portlet margin-bottom-30">
    <div class="portlet-title">
      <div class="caption caption-green">
        <i class="fa fa-users" aria-hidden="true"></i>
        <span class="caption-subject text-uppercase"> <?=$lang['Relatives']?></span>
      </div>
    </div>
    <div class="portlet-body">
      <div class="row">
        <?php foreach($relate as $value){
          $ruser = Profile::profileLoad($value);
          $ruser = mysqli_fetch_array($ruser);
        ?>
          <div class="col-md-6 margin-bottom-10">
            <div>
              <div class="pull-left" style="margin-right: 20px;">
                <a href="/user/<?=$ruser['id']?>"><img src="/uploads/profile_image/<?=$ruser['profile_image']?>" width="80px" alt=""></a>
              </div>
              <div class="pull-left" style="margin-top: 20px;">
                <h4 style="padding: 0; margin: 0"><a href="/user/<?=$ruser['id']?>"><?=$ruser['first_name']?> <?=$ruser['last_name']?></a></h4>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php } ?> -->

<?php if(mysqli_num_rows($exp) > 0){ ?>
<div class="row" id="exp">
  <div class="portlet margin-bottom-30">
    <div class="portlet-title">
      <div class="caption caption-green">
        <i class="fa fa-user" aria-hidden="true"></i>
        <span class="caption-subject text-uppercase"> <?=$lang['Experiences']?></span>
      </div>
    </div>
    <div class="portlet-body">
      <?php while($row = $exp->fetch_array()){ ?>
        <table class="table table-bordered">
          <tr><th colspan="2"><strong><?=$row['company']?></strong></th></tr>
          <tr><td width="20%"><strong><?=$lang['Title']?></strong></td><td><?=$row['name']?></td></tr>
          <tr>
            <td><strong><?=$lang['Durations']?></strong></td>
            <td>
              <?php
                $startdate = date("M Y", strtotime($row['start_at']));
                echo $startdate;
                if($row['status'] == 0){
                  $enddate = date("M Y", strtotime($row['end_at']));
                  echo " - ".$enddate;
                }else if($row['status'] == 1){
                  echo " - Now";
                }
              ?>
            </td>
          </tr>
        </table>
      <?php } ?>
    </div>
  </div>
</div>
<?php } ?>

<?php if(mysqli_num_rows($edu) > 0){ ?>
<div class="row" id="edu">
  <div class="portlet margin-bottom-30">
    <div class="portlet-title">
      <div class="caption caption-green">
        <i class="fa fa-user" aria-hidden="true"></i>
        <span class="caption-subject text-uppercase"> <?=$lang['Educations']?></span>
      </div>
    </div>
    <div class="portlet-body">
      <?php while($row = $edu->fetch_array()){ ?>
        <table class="table table-bordered">
          <tr><th colspan="2"><strong><?=$row['institute_name']?></strong></th></tr>
          <tr><td width="20%"><strong><?=$lang['Background']?></strong></td><td><?=Postings::eduLevel($row['background'])?></td></tr>
          <tr><td><strong><?=$lang['Major']?></strong></td><td><?=$row['major']?></td></tr>
          <tr><td><strong><?=$lang['GPA']?></strong></td><td><?=$row['gpa']?></td></tr>
        </table>
      <?php } ?>
    </div>
  </div>
</div>
<?php } ?>

<?php if(mysqli_num_rows($skill) > 0){ ?>
<div class="row" id="skills">
  <div class="portlet margin-bottom-30">
    <div class="portlet-title">
      <div class="caption caption-green">
        <i class="fa fa-user" aria-hidden="true"></i>
        <span class="caption-subject text-uppercase"> <?=$lang['Skills']?></span>
      </div>
    </div>
    <div class="portlet-body">
      <table class="table table-bordered">
        <tr><th colspan="1"><strong><?=$lang['Skills']?></strong></th></tr>
        <tr>
          <td>
            <?php
              while($row = $skill->fetch_array()){
                echo $row['name'].', ';
              }
            ?>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
<?php } ?>

<input type="hidden" value="<?=$_SESSION['social_id']?>" id="uid"/>
<input type="hidden" value="<?=$variables[2]?>" id="pid"/>

<script src="/themes/js/userpage.js"></script>
