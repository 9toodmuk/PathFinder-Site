<?php
use Controller\Job\JobController;
use Controller\User\Profile;
use Controller\Admin\Postings;

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
          <div class="alert" id="errorbox"></div>
        </div>

        <form id="createProfileForm" method="post" role="form" style="display: block;">

          <input type='hidden' name='id' value='<?=$_SESSION['social_id']?>' />

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
              <label>ชื่อ <span style="color:red">*</span></label>
              <input type="text" name="firstname" id="firstname" class="form-control" placeholder="<?=$lang['name']?>" value="<?=$user['first_name']?>" required>
            </div>

            <div class="col-md-6 form-group">
              <label>นามสกุล <span style="color:red">*</span></label>
              <input type="text" name="lastname" id="lastname" class="form-control" placeholder="<?=$lang['lastname']?>" value="<?=$user['last_name']?>" required>
            </div>

            <div class="col-md-12 form-group">
              <label>เพศ <span style="color:red">*</span></label>
              <select name="gender" class='form-control' required>
                <option value="" disabled selected>กรุณาเลือกเพศ</option>
                <option value="0"><?=$lang['male']?></option>
                <option value="1"><?=$lang['female']?></option>
              </select>
            </div>

            <div class="col-md-12 form-group">
              <label>วันเกิด <span style="color:red">*</span></label>
              <input type='text' name="birthday" class="form-control" placeholder="<?=$lang['Birthdate']?>" value='' id='datetimepicker' data-date-format="yyyy-mm-dd" data-link-field="birthday" data-link-format="yyyy-mm-dd" required/>
            </div>

            <div class="col-md-12 form-group">
              <label>ความบกพร่องในตัวคุณ <span style="color:red">*</span></label>
              <select name="disability" class='form-control' required>
                <option value="" disabled selected>กรุณาเลือก</option>
                  <?php
                    while($row = $disability->fetch_assoc()){
                      echo "<option value='".$row['id']."'>".$row['name']."</option>";
                    }
                  ?>
              </select>
            </div>

            <div class="col-md-12 form-group">
              <label>หมายเลขโทรศัพท์ <span style="color:red">*</span></label>
              <input type="text" name="telephone" id="telephone" class="form-control" placeholder="Telephone" value="" required>
            </div>

            <div class="col-md-12 form-group">
              <label>Facebook</label>
              <input type="text" name="Facebook" id="facebook" class="form-control" placeholder="Facebook" value="">
            </div>

            <div class="col-md-12 form-group">
              <label>Twitter</label>
              <input type="text" name="Twitter" id="twitter" class="form-control" placeholder="Twitter" value="">
            </div>
            
            <div class="col-md-12 form-group">
              <label>LINE</label>
              <input type="text" name="Line" id="line" class="form-control" placeholder="Line" value="">
            </div>

          </div>

          <div class="tab">
            <h3 class="text-center" style="margin-bottom: 40px;">Job Experiences</h3>
            <div class="col-md-12 form-group">
              <label>ประสบการณ์ของคุณ</label>
              <select name="exp" class="form-control" id="exp" required>
                    <option value="" disabled selected>กรุณาเลือก</option>
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

            <div id="expdetail">
              <div class="col-md-12 form-group">
                <label>ตำแหน่งงานล่าสุด</label>
                <input type="text" name="recent_work" id="recent_work" class="form-control" placeholder="ตำแหน่งงานล่าสุด" value="">
              </div>

              <div class="col-md-12 form-group">
                <label>ชื่อบริษัท</label>
                <input type="text" name="recent_emp" id="recent_emp" class="form-control" placeholder="ชื่อบริษัท" value="">
              </div>

              <div class="col-md-12 form-group">
                <label>ระยะเวลา</label>
                <div class="input-group">
                  <input type="text" name="start" id="start" class="form-control" value="" placeholder="<?=$lang['From']?>" data-date-format="yyyy-mm" data-link-field="startdate" data-link-format="yyyy-mm">
                  <span class="input-group-addon"> <?=$lang['To']?> </span>
                  <input type="text" name="end" id="end" class="form-control" value="" placeholder="<?=$lang['To']?>" data-date-format="yyyy-mm" data-link-field="enddate" data-link-format="yyyy-mm">
                  <label class="input-group-addon"><input type="checkbox" name="now" id="now"> <?=$lang['now']?></label>
                </div>
              </div>
            </div>
            
          </div>

          <div class="tab">
            <h3 class="text-center" style="margin-bottom: 40px;">Job Experiences</h3>
            <div class="col-md-12 form-group">
              <label>การศึกษาสูงสุด</label>
              <select name="edu" class="form-control" id="edu" required>
                    <option value="" disabled selected>กรุณาเลือก</option>
                    <option value="0">ไม่มีประวัติการศึกษา</option>
                    <?php
                      for ($i=1; $i <= 5 ; $i++) {
                        echo "<option value=".$i.">";
                        Postings::eduLevel($i);
                        echo "</option>";
                      }
                    ?>
              </select>
            </div>

            <div id="edudetail">
              <div class="col-md-12 form-group">
                <label>ชื่อสถาบัน</label>
                <input type="text" name="highest_insitute" id="highest_insitute" class="form-control" placeholder="ชื่อสถาบัน" value="">
              </div>

              <div class="col-md-12 form-group">
                <label>วิชาเอก</label>
                <input type="text" name="highest_edu_level" id="highest_edu_level" class="form-control" placeholder="วิชาเอก" value="">
              </div>

              <div class="col-md-12 form-group">
                <label>เกรดเฉลี่ย</label>
                <input type="text" name="gpa" id="gpa" class="form-control" placeholder="เกรดเฉลี่ย" value="">
              </div>
            </div>
            
          </div>

          <div class="col-md-12">

            <div class="pull-right">
              <button id="btnPrev" type="button" class="btn btn-primary btn-lg" onclick="nextPrev(-1)">กลับ</button>
              <button id="btnNext" type="button" class="btn btn-primary btn-lg" onclick="nextPrev(1)">ต่อไป</button>
              <button id="btnSubmit" type="submit" class="btn btn-primary btn-lg" data-loading-text="<?=$lang['processing']?>">สร้างโปรไฟล์</button>
            </div>
            
            <div class="pull-left">
              <button id="btnSkip" type="button" class="btn btn-default btn-lg">ข้าม</button>
            </div>

            <div class="pull-mid text-center" style="margin-top:10px;">
              <span class="step"></span>
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

      <div class="text-center">
        <img id="demo">
      </div>

      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-success" onclick="upload()"><i class="fa fa-check" aria-hidden="true"></i> เลือก</a> 
        <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> <?=$lang['Close']?></a>
      </div>
    </div>
  </div>
</div>

<script src="/themes/js/createprofile.js"></script>

<script type="text/javascript">
  var formData = new FormData();

  var image = document.getElementById('demo');
  var myimage = document.getElementById('finalmyimage');

  var cropper = new Cropper(image, {
    minContainerWidth: 350,
    minContainerHeight: 350,
    aspectRatio: 1/1,
    viewMode: 1
  });

	function readURL(input){
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
        setPicture(e.target.result);
			}
		}

		reader.readAsDataURL(input.files[0]);
  }
  
  function setPicture(picture){
    cropper.replace(picture);
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

  function upload(){
    $('#editprofilepic').modal('hide');

    var newimage = cropper.getCroppedCanvas().toDataURL('image/jpeg');

    myimage.src = newimage;

    cropper.getCroppedCanvas().toBlob(function (blob) {
      var fileext = blob.type;
      var filetype = fileext.replace("image/","");
      var filename = "profilePic."+filetype;
      formData.append('file', blob, filename);
    });
  }

  $('#btnSkip').click(function(){
    $.ajax({
      url: "/user/skipCreateProfile/",
      type: "POST",
      dataType: 'json',
      success: function(result){
        console.log(result);

        if(result.status){
          setTimeout(function(){ window.location = "/home/"; }, 100);
        }else{
          $('#btnSubmit').button('reset');
          $("#errorbox").addClass("alert-danger");
          $("#errorbox").removeClass("alert-success");
          $("#errorbox").html("<?=$lang['AlertErrorText']?>");
          $("#errorbox").fadeIn();
          $("div#errorbox").delay(3000).fadeOut(300);
        }
        
      }
    });
  })

  $('#createProfileForm').submit(function(e){
    e.preventDefault();

    $.each($(this).serializeArray(), function(_, field) { formData.append(field.name, field.value); });

    console.log(formData);

    $('#btnSubmit').button('loading');

    $.ajax({
      url: "/user/createprofile/",
      type: "POST",
      dataType: 'json',
      data: formData,
      contentType: false,
      processData: false,
      success: function(result){
        console.log(result);

        if(result.status){
          $("#errorbox").removeClass("alert-danger");
          $("#errorbox").addClass("alert-success");
          $("#errorbox").html("<?=$lang['AlertSuccessText']?>");
          $("#errorbox").fadeIn();
          setTimeout(function(){ window.location = "/home/"; }, 3000);
        }else{
          $('#btnSubmit').button('reset');
          $("#errorbox").addClass("alert-danger");
          $("#errorbox").removeClass("alert-success");
          $("#errorbox").html("<?=$lang['AlertErrorText']?>");
          $("#errorbox").fadeIn();
          $("div#errorbox").delay(3000).fadeOut(300);
        }
        
      }
    });
  });
</script>