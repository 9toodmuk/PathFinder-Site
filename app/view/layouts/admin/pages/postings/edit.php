<?php
use App\Controller\Admin\Postings;

$postings = Postings::getPosting($variables[2]);
?>

      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-sm-6 col-sm-offset-2">

              <div class="alert alert-danger" id="errorbox" style="display:none;">
                <strong>Error!</strong> Something went wrong
              </div>

                <form role="form" id="editpostingsform" class="form-horizontal" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                      <label for="" class="col-sm-2 control-label">รหัส</label>
                      <div class="col-sm-10">
                        <input type="text" name="jid" id="jid" class="form-control" value="<?=$postings['id']?>" placeholder="รหัส" disabled>
                        <input type="hidden" name="pid" id="pid" class="form-control" value="<?=$postings['id']?>">
                      </div>
                  </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">ชื่อตำแหน่ง</label>
                        <div class="col-sm-10">
                          <input type="text" name="name" id="name" class="form-control" value="<?=$postings['name']?>" placeholder="ชื่อตำแหน่ง" required>
                        </div>
                    </div>

                    <div class="form-group float-label-control">
                        <label for="company" class="col-sm-2 control-label">บริษัท</label>
                        <div class="col-sm-4">
                          <select name="company" id="company" class="form-control" required>
                            <option value="">กรุณาเลือก</option>
                            <?php
                              $conn = Config\Database::connection();
                              $sql = "SELECT * FROM company;";
                              $query = $conn->query($sql);
                              while ($row = $query->fetch_assoc()) {
                                if($row["id"] == $postings['company_id']){
                                  echo '<option value="'.$row["id"].'" selected>'.$row["name"].'</option>';
                                }else{
                                  echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                                }
                              }
                            ?>
                          </select>
                        </div>

                        <label for="parent" class="col-sm-2 control-label">หมวดหมู่</label>
                        <div class="col-sm-4">
                          <select name="parent" id="parent" class="form-control" required>
                            <option value="">กรุณาเลือก</option>
                            <?php
                              $conn = Config\Database::connection();
                              $sql = "SELECT * FROM job_categories;";
                              $query = $conn->query($sql);
                              while ($row = $query->fetch_assoc()) {
                                if($row["id"] == $postings['category_id']){
                                  echo '<option value="'.$row["id"].'" selected>'.$row["name"].'</option>';
                                }else{
                                  echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                                }
                              }
                            ?>
                          </select>
                        </div>
                    </div>

                    <div class="form-group float-label-control">
                        <label for="responsibility" class="col-sm-2 control-label">ความรับผิดชอบ</label>
                        <div class="col-sm-10">
                          <textarea name="responsibility" id="responsibility"><?=$postings['responsibilities']?>
                          </textarea>
                        </div>
                    </div>

                    <div class="form-group float-label-control">
                        <label for="qualification" class="col-sm-2 control-label">คุณสมบัติ</label>
                        <div class="col-sm-10">
                          <textarea name="qualification" id="qualification"><?=$postings['qualification']?>
                          </textarea>
                        </div>
                    </div>

                    <div class="form-group float-label-control">
                        <label for="benefit" class="col-sm-2 control-label">สวัสดิการ</label>
                        <div class="col-sm-10">
                          <textarea name="benefit" id="benefit"><?=$postings['benefit']?>
                          </textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">จำนวนอัตรา</label>
                        <div class="col-sm-10">
                          <div class="input-group">
                            <input type="text" name="capacity" id="capacity" class="form-control" placeholder="จำนวนอัตรา" value="<?=$postings['capacity']?>" required>
                            <span class="input-group-addon"><label class="checkbox-inline" style="padding-top:0px;">
                              <input type="checkbox" name="many" id="many" <?php if($postings['cap_type'] == 1) echo "checked"; ?>>หลายอัตรา</label>
                            </span>
                          </div>
                        </div>
                    </div>

                    <div class="form-group float-label-control">
                        <label for="location" class="col-sm-2 control-label">จังหวัดที่ตั้งสถานที่ทำงาน</label>
                        <div class="col-sm-10">
                          <input type="text" name="location" id="location" class="form-control" value="<?=$postings['location']?>" placeholder="จังหวัดที่ตั้งสถานที่ทำงาน" required>
                        </div>
                    </div>

                    <div class="form-group float-label-control">
                        <label for="joblevel" class="col-sm-2 control-label">ระดับตำแหน่งงาน</label>
                        <div class="col-sm-4">
                          <select name="joblevel" id="joblevel" class="form-control" required>
                            <option value="">กรุณาเลือก</option>
                            <?php
                            for ($i=0; $i < 5 ; $i++) {
                              if($i == $postings['level']){
                                echo '<option value="'.$i.'" selected>';
                              }else{
                                echo '<option value="'.$i.'">';
                              }
                              App\Controller\Admin\Postings::jobLevel($i);
                              echo '</option>';
                            }
                            ?>
                          </select>
                        </div>

                        <label for="eduLevel" class="col-sm-2 control-label">ระดับการศึกษา</label>
                        <div class="col-sm-4">
                          <select name="eduLevel" id="eduLevel" class="form-control" required>
                            <option value="">กรุณาเลือก</option>
                            <?php
                            for ($i=0; $i < 6 ; $i++) {
                              if($i == $postings['edu_req']){
                                echo '<option value="'.$i.'" selected>';
                              }else{
                                echo '<option value="'.$i.'">';
                              }
                              App\Controller\Admin\Postings::eduLevel($i);
                              echo '</option>';
                            }
                            ?>
                          </select>
                        </div>
                    </div>

                    <div class="form-group float-label-control">
                        <label for="exp" class="col-sm-2 control-label">อายุงาน</label>
                        <div class="col-sm-4">
                          <div class="input-group">
                            <input type="number" value="<?=$postings['exp_req']?>" name="exp" id="exp" class="form-control" min="0" max="21" required>
                            <span class="input-group-addon">ปี</span>
                          </div>
                        </div>
                        <label for="type" class="col-sm-2 control-label">ประเภทการจ้าง</label>
                        <div class="col-sm-4">
                          <?php
                            $arr = Postings::allPostingsType();
                            $arr2 = explode(',', $postings['type']);
                          ?>
                          <select id="type" name="type[]" multiple="multiple" class="form-control" required>
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

                    <div class="form-group salary-range">
                        <label for="salary" class="col-sm-2 control-label">รายได้</label>
                        <div class="col-sm-10">
                          <div class="input-group">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span id="salarytype"><?=$lang[Postings::salaryType($postings['salary_type'])]?></span> <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="#1"><?=$lang['Monthly']?></a></li>
                                <li><a href="#2"><?=$lang['Hourly']?></a></li>
                              </ul>
                              <input type="hidden" name="salary_type" value="<?=$postings['salary_type']?>" id="salary_type">
                            </span>
                            <input type="text" class="form-control" name="salary" placeholder="รายได้" value="<?=$postings['salary']?>" aria-describedby="basic-addon1">
                            <span class="input-group-addon">บาท</span>
                            <span class="input-group-addon"><label class="checkbox-inline" style="padding-top:0px;">
                              <input type="checkbox" name="negetiable" <?php if($postings['negetiable'] == 1) echo "checked"; ?>>ต่อรองได้</label>
                            </span>
                          </div>
                        </div>
                    </div>

                    <div class="form-group float-label-control">
                      <button id="btnEdit" type="submit" class="btn btn-primary btn-block" data-loading-text="<?=$lang['processing']?>">แก้ไขตำแหน่งงาน</button>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>

  <script type="text/javascript">
  $(function() {
    $("#errorbox").hide();

    $('#type').multiselect({
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

    $('#type').multiselect('updateButtonText');

    $(".multiselect .caret").css('float', 'right');
    $(".multiselect .caret").css('margin-top', '8px');

    $('.salary-range .dropdown-menu').find('a').click(function(e) {
      e.preventDefault();
      var param = $(this).attr("href").replace("#", "");
      var concept = $(this).text();
      $('.salary-range span#salarytype').text(concept);
      $('.input-group #salary_type').val(param);
    });
  });

  $('#many').change(function(){
    this.checked ? $('#capacity').prop('disabled', true) : $('#capacity').prop('disabled', false);
  });

  ClassicEditor
    .create( document.querySelector( '#responsibility' ) , {
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
    .create( document.querySelector( '#qualification' ) , {
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
    .create( document.querySelector( '#benefit' ) , {
      removePlugins: [ 'Heading', 'Link' ],
      toolbar: [ 'bold', 'italic', 'bulletedList' ]
    } )
    .then( editor => {
        console.log( editor );
    } )
    .catch( error => {
        console.error( error );
    } );

    $("#editpostingsform").submit(function(e){
      e.preventDefault();
      editpostings();
    });

    function editpostings(){
      var $button = $('#btnEdit');
      $button.button('loading');

      $.ajax({
        url: '/admin/postings/update/',
        type: 'POST',
        data: $("#editpostingsform").serialize(),
        success: function (result) {
          if(result == "Error"){
            $('#errorbox').fadeIn();
            $('#errorbox').delay(5000).fadeOut(1000);
            $button.button('reset');
          }else if(result == "Success"){
            $("#errorbox").removeClass("alert-danger");
            $("#errorbox").addClass("alert-success");
            $("#errorbox").html("<strong>Success!</success> Edit postings successfully.");
            $("#errorbox").fadeIn();
            setTimeout(function(){ window.location = "/admin/postings/"; }, 3000);
          }
        }
      });
    }
  </script>
