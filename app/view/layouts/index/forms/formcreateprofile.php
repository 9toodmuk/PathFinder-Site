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

            <div class="col-md-12 form-group text-center" style="margin-bottom: 40px;">
              <h3 style="margin-bottom: 40px;">Profile Picture</h3>
              <img src="/uploads/profile_image/<?=$user['profile_image']?>" id="finalmyimage" style="border: 2px solid white; margin-right:10px;" class="img-circle" width="150px" /> <button id="btnChangePic" type="submit" class="btn btn-success btn-lg" onclick="uploadProfilePic()">Change</button>
              <div class="hiddenfile">
                <input name="profilepic" type="file" id="profilepic" accept="image/*"/>
              </div>
            </div>
            
          </div>
          
          <div class="tab">
            <h3 class="text-center" style="margin-bottom: 40px;">Personal Details</h3>
            <div class="col-md-6 form-group">
              <label>ชื่อ</label>
              <input type="text" name="firstname" id="firstname" class="form-control" placeholder="<?=$lang['name']?>" value="<?=$user['first_name']?>" required>
            </div>

            <div class="col-md-6 form-group">
              <label>นามสกุล</label>
              <input type="text" name="lastname" id="lastname" class="form-control" placeholder="<?=$lang['lastname']?>" value="<?=$user['last_name']?>" required>
            </div>

            <div class="col-md-12 form-group">
              <label>เพศ</label>
              <select name="gender" class='form-control' required>
                <option value="">กรุณาเลือกเพศ</option>
                <option value="0" <?=$user['sex'] == 0 ? "selected" : "" ?>><?=$lang['male']?></option>
                <option value="1" <?=$user['sex'] == 1 ? "selected" : "" ?>><?=$lang['female']?></option>
              </select>
            </div>

            <div class="col-md-12 form-group">
              <label>วันเกิด</label>
              <input type='text' class="form-control" value='<?=$user['birthdate']?>' id='datetimepicker' data-date-format="yyyy-mm-dd" data-link-field="birthday" data-link-format="yyyy-mm-dd"/>
              <input type="hidden" name="birthday" id="birthday" value="<?=$user['birthdate']?>"/>
            </div>

            <div class="col-md-12 form-group">
              <label>ความบกพร่องในตัวคุณ</label>
              <select name="gender" class='form-control' required>
                <option value="">กรุณาเลือก</option>
                <option value="0" <?=$user['disability'] == 0 ? "selected" : "" ?>>ไม่มีความบกพร่อง</option>
                  <?php
                    while($row = $disability->fetch_assoc()){
                      $selected = $user['disability'] == $row['id'] ? "selected" : "";
                      echo "<option value='".$row['id']."' ".$selected.">".$row['name']."</option>";
                    }
                  ?>
              </select>
            </div>

            <div class="col-md-12 form-group">
              <label>หมายเลขโทรศัพท์</label>
              <input type="text" name="telephone" id="telephone" class="form-control" placeholder="Telephone" value="<?=$user['telephone']?>">
            </div>

            <div class="col-md-12 form-group">
              <label>Facebook</label>
              <input type="text" name="Facebook" id="facebook" class="form-control" placeholder="Facebook" value="<?=$user['facebook']?>">
            </div>

            <div class="col-md-12 form-group">
              <label>Twitter</label>
              <input type="text" name="Twitter" id="twitter" class="form-control" placeholder="Twitter" value="<?=$user['twitter']?>">
            </div>
            
            <div class="col-md-12 form-group">
              <label>LINE</label>
              <input type="text" name="Line" id="line" class="form-control" placeholder="Line" value="<?=$user['line']?>">
            </div>

          </div>

          <div class="tab">
            <h3 class="text-center" style="margin-bottom: 40px;">Job Experiences</h3>
            <div class="col-md-12 form-group">
              <label>ประสบการณ์ของคุณ</label>
              <select name="exp" class="form-control" id="exp" required>
                    <option value="">กรุณาเลือก</option>
                    <option value="-1">ไม่มีประสบการณ์</option>
                    <option value="0">น้อยกว่า 1 ปี</option>
                    <?php
                      for ($x = 1; $x<=20; $x++) {
                        if ($x > 1) {
                          echo "<option value=".$x.">".$x." ปี</option>";
                        } else {
                          echo "<option value=".$x.">".$x." ปี</option>";
                        }
                    }
                  ?>
                <option value="21">มากกว่า 20 ปี</option>
              </select>
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

<div class="modal fade" id="editprofilepic" tabindex="-1" role="dialog" aria-labelledby="editprofilepic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title custom_align" id="Heading"> แก้ไขรูปโปรไฟล์</h4>
      </div>
      <div class="modal-body">

      <div class="demo"></div>

      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-success" onclick="upload()"><i class="fa fa-check" aria-hidden="true"></i> Upload</a>
        <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> <?=$lang['Close']?></a>
      </div>
    </div>
  </div>
</div>

<script src="/themes/js/createprofile.js"></script>

<script type="text/javascript">
	function readURL(input){
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				$('.demo').croppie({
          url: e.target.result,
          viewport: { width: 280, height: 280, type: 'square' },
          boundary: { width: 300, height: 300 },
          showZoomer: true,
          setZoom: 0.2,
          enableOrientation: true
        });
			}
		}

		reader.readAsDataURL(input.files[0]);
	}

	function uploadProfilePic(){
		var picture = $("input#profilepic");

		picture.click();

		picture.change(function(){
			readURL(this);
      console.log(profilepic.files.length);
      $('#editprofilepic').modal('show');
		});
  }
</script>