<?php
use Controller\User\Profile;
use Controller\User\Experiences;
use Controller\User\Educations;
use Controller\User\Skills;
$user = Profile::profileLoad($variables[2]);
$user = mysqli_fetch_array($user);
$relate = Profile::getRelatives($variables[2]);
$exp = Experiences::expLoad($variables[2]);
$edu = Educations::eduLoad($variables[2]);
$skill = Skills::skillLoad($variables[2]);
$pending = Profile::getPendingRelatives($variables[2]);
$request = Profile::getRequestRelatives($variables[2]);
?>

<div class="row" id="about">
  <div class="portlet margin-bottom-30">
    <div class="portlet-title">
      <div class="caption caption-green">
        <i class="fa fa-user" aria-hidden="true"></i>
        <span class="caption-subject text-uppercase"> <?=$lang['EditProfile']?></span>
      </div>
    </div>
    <div class="portlet-body">
      <table class="table table-bordered">
        <tr>
          <td width="30%">
            <strong><?=$lang['name']?></strong>
          </td>
          <td id="name">
            <span><?=$user['first_name']?> <?=$user['last_name']?></span> <a onclick="edit(this)" class="btn btn-edit pull-right"><i class="fa fa-pencil-square-o"></i> <?=$lang['editlocationbtn']?></a>
          </td>
        </tr>
        <tr>
          <td>
            <strong><?=$lang['Gender']?></strong>
          </td>
          <td id="gender">
            <span><?=$lang[Profile::gender($user['sex'])]?></span> <a onclick="edit(this)" class="btn btn-edit pull-right"><i class="fa fa-pencil-square-o"></i> <?=$lang['editlocationbtn']?></a>
          </td>
        </tr>
        <tr>
          <td>
            <strong><?=$lang['Birthdate']?></strong>
          </td>
          <td id="birthdate">
            <span><?=$user['birthdate']?></span> <a onclick="edit(this)" class="btn btn-edit pull-right"><i class="fa fa-pencil-square-o"></i> <?=$lang['editlocationbtn']?></a>
          </td>
        </tr>
        <tr>
          <td>
            <strong><?=$lang['Telephone']?></strong>
          </td>
          <td id="telephone">
            <span><?=$user['telephone']?></span> <a onclick="edit(this)" class="btn btn-edit pull-right"><i class="fa fa-pencil-square-o"></i> <?=$lang['editlocationbtn']?></a>
          </td>
        </tr>
        <tr>
          <td>
            <strong>Facebook</strong>
          </td>
          <td id="facebook">
              <span><?=$user['facebook']?></span> <a onclick="edit(this)" class="btn btn-edit pull-right"><i class="fa fa-pencil-square-o"></i> <?=$lang['editlocationbtn']?></a>
          </td>
        </tr>
        <tr>
          <td>
            <strong>Twitter</strong>
          </td>
          <td id="twitter">
              <span><?=$user['twitter']?></span> <a onclick="edit(this)" class="btn btn-edit pull-right"><i class="fa fa-pencil-square-o"></i> <?=$lang['editlocationbtn']?></a>
          </td>
        </tr>
        <tr>
          <td>
            <strong>Line</strong>
          </td>
          <td id="line">
              <span><?=$user['line']?></span> <a onclick="edit(this)" class="btn btn-edit pull-right"><i class="fa fa-pencil-square-o"></i> <?=$lang['editlocationbtn']?></a>
          </td>
        </tr>
        <tr>
          <td>
            <strong><?=$lang['Others']?></strong>
          </td>
          <td id="other_link">
              <span><?=$user['other_link']?></span> <a onclick="edit(this)" class="btn btn-edit pull-right"><i class="fa fa-pencil-square-o"></i> <?=$lang['editlocationbtn']?></a>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
<!--
<div class="row" id="relative">
  <div class="portlet margin-bottom-30">
    <div class="portlet-title">
      <div class="caption caption-green">
        <i class="fa fa-users" aria-hidden="true"></i>
        <span class="caption-subject text-uppercase"> <?=$lang['Relatives']?></span>
      </div>
    </div>
    <div class="portlet-body">
      <div class="row" id="relativeblock">
        <?php
          if(sizeof($relate) > 0){
            foreach($relate as $value){
              $ruser = Profile::profileLoad($value);
              $ruser = mysqli_fetch_array($ruser);
              $type = Profile::getRelateType($variables[2], $value);
              include 'app/view/layouts/main/user/block/relateblock.php';
            }
          }

          if(sizeof($pending) > 0){
            foreach ($pending as $value) {
              $ruser = Profile::profileLoad($value);
              $ruser = mysqli_fetch_array($ruser);
              $type = Profile::getRelateType($variables[2], $value);
              $onpending = 1;
              include 'app/view/layouts/main/user/block/relateblock.php';
            }
          }

          if(sizeof($request) > 0){
            foreach ($request as $value) {
              $ruser = Profile::profileLoad($value);
              $ruser = mysqli_fetch_array($ruser);
              $type = Profile::getRelateType($value, $variables[2]);
              $onrequest = 1;
              include 'app/view/layouts/main/user/block/relateblock.php';
            }
          }
        ?>
      </div>
      <div class="row">
        <div class="col-md-12" id="relateblock">
          <button type="button" onclick="newrelative()" class="btn btn-primary btn-lg btn-block"><?=$lang['newlocationbtn']?></button>
        </div>
      </div>
    </div>
  </div>
</div> -->

<div class="row" id="exp">
  <div class="portlet margin-bottom-30">
    <div class="portlet-title">
      <div class="caption caption-green">
        <i class="fa fa-user" aria-hidden="true"></i>
        <span class="caption-subject text-uppercase"> <?=$lang['Experiences']?></span>
      </div>
    </div>
    <div class="portlet-body">
      <?php if(mysqli_num_rows($exp) > 0){
        while($row = $exp->fetch_array()){
          include 'app/view/layouts/main/user/block/expblock.php';
        }
      } ?>
      <div class="row">
        <div class="col-md-12" id="expblock">
          <button type="button" onclick="newexp()" class="btn btn-primary btn-lg btn-block"><?=$lang['newlocationbtn']?></button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row" id="edu">
  <div class="portlet margin-bottom-30">
    <div class="portlet-title">
      <div class="caption caption-green">
        <i class="fa fa-user" aria-hidden="true"></i>
        <span class="caption-subject text-uppercase"> <?=$lang['Educations']?></span>
      </div>
    </div>
    <div class="portlet-body">
      <?php if(mysqli_num_rows($edu) > 0){
        while($row = $edu->fetch_array()){
          include 'app/view/layouts/main/user/block/edublock.php';
        }
      } ?>
      <div class="row">
        <div class="col-md-12" id="edublock">
          <button type="button" onclick="newedu()" class="btn btn-primary btn-lg btn-block"><?=$lang['newlocationbtn']?></button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row" id="skill">
  <div class="portlet margin-bottom-30">
    <div class="portlet-title">
      <div class="caption caption-green">
        <i class="fa fa-user" aria-hidden="true"></i>
        <span class="caption-subject text-uppercase"> <?=$lang['Skills']?></span>
      </div>
    </div>
    <div class="portlet-body">
      <div class="row">
        <div class="col-md-12" id="skilllist">
      <?php if(mysqli_num_rows($skill) > 0){ ?>
        <table class="table table-bordered">
          <tr>
            <th width="10%">#</th>
            <th><?=$lang['name']?></th>
          </tr>

          <?php
            $i = 1;
            while($row = $skill->fetch_array()){ ?>
            <tr id="<?=$row['id']?>">
              <td><?=$i?></td>
              <td><?=$row['name']?>
                <div class="pull-right">
                  <a onclick="editskill(this)" class="btn btn-edit"><i class="fa fa-pencil-square-o"></i> <?=$lang['editlocationbtn']?></a> <a onclick="removeskill(this)" class="btn btn-remove"><i class="fa fa-trash"></i> <?=$lang['RemoveBtn']?></a>
                </div>
              </td>
            </tr>
          <?php $i++; } ?>

        </table>

      <?php } ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12" id="skillblock">
          <button type="button" onclick="newskill()" class="btn btn-primary btn-lg btn-block"><?=$lang['newlocationbtn']?></button>
        </div>
      </div>
    </div>
  </div>
</div>

<input type="hidden" value="<?=$_SESSION['social_id']?>" id="uid"/>
<script src="/themes/js/editprofile.js"></script>
<script type="text/javascript">
  function acceptrelative(element){
    var user2 = $(element).parents('.margin-bottom-10').parent().attr('id');
    var user1 = <?=$_SESSION['social_id']?>;
    var relationship = $(element).attr('id');
    $.ajax({
      url: '/user/addRelative/',
      data: {user1: user1, user2: user2, relationship: relationship},
      type: 'POST',
      dataType: "json",
      success: function(result){
        if(result.status){
          alert("Success");
          setTimeout(function(){ window.location.reload(); }, 100);
        }
      }
    });
  }

  function <?=$lang['RemoveBtn']?>relative(element){
    var user1 = <?=$_SESSION['social_id']?>;
    var user2 = $(element).parents('.margin-bottom-10').parent().attr('id');
    $.ajax({
      url: '/user/removeRelative/',
      data: {user1: user1, user2: user2},
      type: 'POST',
      dataType: "json",
      success: function(result){
        if(result.status){
          alert("Success");
          setTimeout(function(){ window.location.reload(); }, 100);
        }
      }
    });
  }
</script>
