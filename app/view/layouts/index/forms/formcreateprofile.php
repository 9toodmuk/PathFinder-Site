<?php
use Controller\Job\JobController;
use Controller\User\Profile;

$disability = JobController::getAllDisabilityType();
$user = Profile::profileLoad($_SESSION['social_id']);
$user = mysqli_fetch_assoc($user);
?>
<div class="row">
  <div class="col-sm-8 col-sm-offset-2 form-box">
    <div class="form-top">
      <div class="form-top-left">
        <h1>CREATE PROFILE</h1>
      </div>
      <div class="form-top-right">
        <i class="fa fa-key"></i>
      </div>
    </div>
    <div class="form-bottom">

      <div class="row">

        <div class="col-md-12">
          <div class="alert alert-danger" id="errorbox"></div>
        </div>

        <form id="createProfileForm" method="post" role="form" style="display: block;">

          <input type='hidden' name='id' value='<?=$_POST['id']?>' />

          <div class="tab">

            <div class="col-md-12 form-group text-center">
              <h3>Profile Picture</h3>
              <img src="/uploads/profile_image/default.png" style="border: 2px solid white; margin-right:10px;" class="img-circle" width="150px" /> <button id="btnChangePic" type="submit" class="btn btn-success btn-lg">Upload</button>
            </div>
            
          </div>
          
          <div class="tab">

            <div class="col-md-6 form-group">
              <input type="text" name="firstname" id="firstname" class="form-control" placeholder="<?=$lang['name']?>" value="<?=$user['first_name']?>" required>
            </div>

            <div class="col-md-6 form-group">
              <input type="text" name="lastname" id="lastname" class="form-control" placeholder="<?=$lang['lastname']?>" value="<?=$user['last_name']?>" required>
            </div>

            <div class="col-md-12 form-group">
              <select name="gender" class='form-control' required>
                <option value="">กรุณาเลือกเพศ</option>
                <option value="0"><?=$lang['male']?></option>
                <option value="1"><?=$lang['female']?></option>
              </select>
            </div>

            <div class="col-md-12 form-group">
              <input type='text' class="form-control" value='<?=$user['birthdate']?>' id='datetimepicker' data-date-format="yyyy-mm-dd" data-link-field="birthday" data-link-format="yyyy-mm-dd"/>
              <input type="hidden" name="birthday" id="birthday" value="<?=$user['birthdate']?>"/>
            </div>

            <div class="col-md-12 form-group">
              <select name="gender" class='form-control' required>
                <option value="">ความบกพร่องในตัวคุณ</option>
                <option value="0">ไม่มีความบกพร่อง</option>
                  <?php
                    while($row = $disability->fetch_assoc()){
                      echo "<option value='".$row['id']."'>".$row['name']."</option>";
                    }
                  ?>
              </select>
            </div>

            <div class="col-md-12 form-group">
              <input type="text" name="telephone" id="telephone" class="form-control" placeholder="Telephone" value="">
            </div>

            <div class="col-md-12 form-group">
              <input type="text" name="Facebook" id="facebook" class="form-control" placeholder="Facebook" value="">
            </div>

            <div class="col-md-12 form-group">
              <input type="text" name="Twitter" id="twitter" class="form-control" placeholder="Twitter" value="">
            </div>

            <div class="col-md-12 form-group">
              <input type="text" name="Line" id="line" class="form-control" placeholder="Line" value="">
            </div>

          </div>

          <div class="col-md-12">

            <div class="pull-right">
              <button id="btnPrev" type="button" class="btn btn-primary btn-lg" onclick="nextPrev(-1)">กลับ</button>
              <button id="btnNext" type="button" class="btn btn-primary btn-lg" onclick="nextPrev(1)">ต่อไป</button>
            </div>
            
            <div class="pull-left">
              <button id="btnSkip" type="button" class="btn btn-default btn-lg">ข้าม</button>
            </div>

            <div class="pull-mid text-center" style="margin-top:10px;">
              <span class="step"></span>
              <span class="step"></span>
              <span class="step"></span>
            </div>
            
          </div>
  
        </form>

      </div>
    </div>
  </div>
</div>

<script src="/themes/js/createprofile.js"></script>