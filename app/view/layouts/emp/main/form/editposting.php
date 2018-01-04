<?php
use Controller\Job\JobController;
use Controller\Employer\Detail;
use Controller\Admin\Postings;
use Controller\View\Language;

if(!isset($_SESSION['language'])){
  $language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
  $_SESSION['language'] = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : '';
}else{
  $language = $_SESSION['language'];
}
$lang = Language::loadLanguage($language);

$compid = Detail::getEmpId($_SESSION['emp_id']);
$postings = Postings::getPosting($id);
$location = Detail::getLocation($compid);
?>

        <script type="text/javascript" src="https://cdn.ckeditor.com/ckeditor5/1.0.0-alpha.1/classic/ckeditor.js"></script>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title custom_align" id="Heading">แก้ไขใบประกาศ</h4>
        </div>
        <div class="modal-body" >
        <div class="alert alert-danger" id="editerrorbox" style="display:none;"></div>

        <form role="form" id="editpostingsform" class="form-horizontal" method="post" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id" value="<?=$compid?>" class="form-control">
          <input type="hidden" name="jid" id="jid" value="<?=$id?>" class="form-control">
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">ชื่อตำแหน่ง</label>
                <div class="col-sm-10">
                  <input type="text" name="editname" id="editname" class="form-control" placeholder="ชื่อตำแหน่ง" value="<?=$postings['name']?>" required>
                </div>
            </div>

            <div class="form-group float-label-control">
                <label for="parent" class="col-sm-2 control-label">หมวดหมู่</label>
                <div class="col-sm-10">
                  <select name="editparent" id="editparent" class="form-control" required>
                    <option value="">กรุณาเลือก</option>
                    <?php
                      $conn = Config\Database::connection();
                      $sql = "SELECT * FROM job_categories;";
                      $query = $conn->query($sql);
                      while ($row = $query->fetch_assoc()) {
                        if($postings['category_id'] == $row['id']){
                          echo '<option value="'.$row['id'].'" selected>';
                        }else{
                          echo '<option value="'.$row['id'].'">';
                        }
                          echo $row["name"];
                          echo '</option>';
                      }
                    ?>
                  </select>
                </div>
            </div>

            <div class="form-group float-label-control">
                <label for="responsibility" class="col-sm-2 control-label">ความรับผิดชอบ</label>
                <div class="col-sm-10">
                  <textarea name="editresponsibility" id="editresponsibility">
                    <?=$postings['responsibilities']?>
                  </textarea>
                </div>
            </div>

            <div class="form-group float-label-control">
                <label for="qualification" class="col-sm-2 control-label">คุณสมบัติ</label>
                <div class="col-sm-10">
                  <textarea name="editqualification" id="editqualification">
                    <?=$postings['qualification']?>
                  </textarea>
                </div>
            </div>

            <div class="form-group float-label-control">
                <label for="benefit" class="col-sm-2 control-label">สวัสดิการ</label>
                <div class="col-sm-10">
                  <textarea name="editbenefit" id="editbenefit">
                    <?=$postings['benefit']?>
                  </textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="" class="col-sm-2 control-label">สถานที่ทำงาน</label>
                <div class="col-sm-10">
                  <select name="location" id="location" class="form-control" required>
                    <option value="">กรุณาเลือก</option>
                    <?php
                      while ($row = mysqli_fetch_assoc($location)) {
                          echo '<option value="'.$row["id"].'"';
                          if($postings['location'] == $row["id"]) echo "selected";
                          echo '>'.$row["name"];
                          echo '</option>';
                      }
                    ?>
                  </select>
                </div>
            </div>

            <div class="form-group">
                <label for="" class="col-sm-2 control-label">จำนวนอัตรา</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <input type="text" name="editcapacity" id="editcapacity" class="form-control" placeholder="จำนวนอัตรา" value="<?=$postings['capacity']?>" required>
                    <span class="input-group-addon"><label class="checkbox-inline" style="padding-top:0px;">
                      <input type="checkbox" name="editmany" id="editmany" <?php if($postings['cap_type'] == 1) echo "checked"; ?>>หลายอัตรา</label>
                    </span>
                  </div>
                </div>
            </div>

            <div class="form-group">
                <label for="" class="col-sm-2 control-label">จำกัดผู้พิการ</label>
                <div class="col-sm-10">
                <select name="editdisability_req" id="editdisability_req" class="form-control" required>
                  <option value="">กรุณาเลือก</option>
                  <option value="0">ไม่จำกัด</option>
                    <?php
                    $disability = JobController::getAllDisabilityType();
                    while($row = $disability->fetch_assoc()){
                      echo "<option value='".$row['id']."'";
                      if($postings['disability_req'] == $row['id']){
                        echo " selected";
                      }
                      if($language == 'th'){
                        echo ">".$row['name']."</option>";
                      }else{
                        echo ">".$row['name_eng']."</option>";
                      }
                    }
                    ?>
                  </select>
                </div>
            </div>

            <div class="form-group float-label-control">
                <label for="joblevel" class="col-sm-2 control-label">ระดับงาน</label>
                <div class="col-sm-4">
                  <select name="editjoblevel" id="editjoblevel" class="form-control" required>
                    <option value="">กรุณาเลือก</option>
                    <?php
                    for ($i=0; $i < 5 ; $i++) {
                      if($postings['level'] == $i){
                        echo '<option value="'.$i.'" selected>';
                      }else{
                        echo '<option value="'.$i.'">';
                      }
                        Postings::jobLevel($i);
                        echo '</option>';
                    }
                    ?>
                  </select>
                </div>

                <label for="eduLevel" class="col-sm-2 control-label">ระดับการศึกษา</label>
                <div class="col-sm-4">
                  <select name="editeduLevel" id="editeduLevel" class="form-control" required>
                    <option value="">กรุณาเลือก</option>
                    <?php
                    for ($i=0; $i < 6 ; $i++) {
                      if($postings['edu_req'] == $i){
                        echo '<option value="'.$i.'" selected>';
                      }else{
                        echo '<option value="'.$i.'">';
                      }
                        Postings::eduLevel($i);
                        echo '</option>';
                    }
                    ?>
                  </select>
                </div>
            </div>

            <div class="form-group float-label-control">
                <label for="exp" class="col-sm-2 control-label">อายุงาน</label>
                <div class="col-sm-4">
                  <select name="editexp" class="form-control" id="editexp" required>
                    <option value="">กรุณาเลือก</option>
                    <option value="0" <?php if($postings['exp_req'] == 0) echo 'selected'; ?>>ไม่จำกัด</option>
                    <?php
                      for ($x = 1; $x<=20; $x++) {
                        if($postings['exp_req'] == $x){
                          echo '<option value="'.$x.'" selected>'.$x." ปี</option>";
                        }else{
                          echo '<option value="'.$x.'">'.$x." ปี</option>";
                        }
                      }
                    ?>
                    <option value="21">มากกว่า 20 ปี</option>
                  </select>
                </div>
                <label for="edittype" class="col-sm-2 control-label">ประเภทการจ้าง</label>
                <div class="col-sm-4">
                  <?php
                    $arr = Postings::allPostingsType();
                    $arr2 = explode(',', $postings['type']);
                  ?>
                  <select id="edittype" name="edittype[]" multiple="multiple" class="form-control" required>
                    <?php
                      foreach ($arr as $key => $value) {
                        for ($i=0; $i <= count($arr2); $i++) {
                          if($value == $arr2[$i]){
                            echo "<option value='$value' selected>";
                            unset($arr2[$i]);
                            $arr2 = array_values($arr2);
                            break;
                          }else{
                            echo "<option value='$value'>";
                            break;
                          }
                        }
                        echo $lang[Postings::employmentConverter($value)];
                        echo "</option>";
                      }
                    ?>
                  </select>
                </div>
            </div>

            <div class="form-group editsalary-range">
                <label for="editsalary" class="col-sm-2 control-label">รายได้</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span id="editsalarytype"><?=$lang[Postings::salaryType($postings['salary_type'])]?></span> <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="#1"><?=$lang['Monthly']?></a></li>
                        <li><a href="#2"><?=$lang['Hourly']?></a></li>
                      </ul>
                      <input type="hidden" name="editsalary_type" value="<?=$postings['salary_type']?>" id="editsalary_type">
                    </span>
                    <input type="text" class="form-control" name="editsalary" placeholder="รายได้" value="<?=$postings['salary']?>" aria-describedby="basic-addon1">
                    <span class="input-group-addon">บาท</span>
                    <span class="input-group-addon"><label class="checkbox-inline" style="padding-top:0px;">
                      <input type="checkbox" name="editnegetiable" <?php if($postings['negetiable'] == 1) echo "checked"; ?>>ต่อรองได้</label>
                    </span>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button id="btnEdit" type="submit" class="btn btn-primary btn-lg btn-block">แก้ไข</button>
            </div>
          </form>
        </div>


  <script type="text/javascript">
  $(function() {
    $("#editerrorbox").hide();

    $('#edittype').multiselect({
      includeSelectAllOption: true,
      maxHeight: 150,
      buttonWidth: '100%',
      numberDisplayed: 2,
      buttonContainer: '<div></div>',
      buttonClass: 'form-control text-left',
      nSelectedText: 'รายการ',
      nonSelectedText: 'กรุณาเลือก',
      allSelectedText: 'ทั้งหมด',
      selectAllText: 'ทั้งหมด'
    });

    $('#edittype').multiselect('updateButtonText');

    $(".multiselect .caret").css('float', 'right');
    $(".multiselect .caret").css('margin-top', '8px');

    $('.editsalary-range .dropdown-menu').find('a').click(function(e) {
      e.preventDefault();
      var param = $(this).attr("href").replace("#", "");
      var concept = $(this).text();
      $('.editsalary-range span#editsalarytype').text(concept);
      $('.input-group #editsalary_type').val(param);
    });
  });

  $('#editmany').change(function(){
    this.checked ? $('#editcapacity').prop('disabled', true) : $('#editcapacity').prop('disabled', false);
  });

  ClassicEditor
    .create( document.querySelector( '#editresponsibility' ) , {
      removePlugins: [ 'Heading', 'Link' ],
      toolbar: [ 'bold', 'italic', 'bulletedList' ],
    } )
    .then( editor => {
        console.log( editor );
    } )
    .catch( error => {
        console.error( error );
    } );

  ClassicEditor
    .create( document.querySelector( '#editqualification' ) , {
      removePlugins: [ 'Heading', 'Link' ],
      toolbar: [ 'bold', 'italic', 'bulletedList' ]
    } )
    .then( editor => {
        console.log( editor );
    } )
    .catch( error => {
        console.error( error );
    } );

  ClassicEditor
    .create( document.querySelector( '#editbenefit' ) , {
      removePlugins: [ 'Heading', 'Link' ],
      toolbar: [ 'bold', 'italic', 'bulletedList' ]
    } )
    .then( editor => {
        console.log( editor );
    } )
    .catch( error => {
        console.error( error );
    } );
  </script>

  <script type="text/javascript">
      $("#editpostingsform").submit(function(e){
        e.preventDefault();
        $.ajax({
          url: '/employer/editpostings/',
          type: 'POST',
          data: $("#editpostingsform").serialize(),
          success: function(result){
            if(result == "Error"){
              $('#editerrorbox').fadeIn();
              $('#editerrorbox').delay(5000).fadeOut(1000);
            }else if(result == "Success"){
              $("#editerrorbox").removeClass("alert-danger");
              $("#editerrorbox").addClass("alert-success");
              $("#editerrorbox").html("<strong>Success!</success> Add new postings successfully.");
              $("#editerrorbox").fadeIn();
              setTimeout(function(){ window.location = "/employer/postings/"; }, 3000);
            }
          }
        });
      });
  </script>
