<?php
use Controller\Employer\Detail;
use Controller\Job\JobController;

$compid = Detail::getEmpId($_SESSION['emp_id']);
$location = Detail::getLocation($compid);
?>

<div id="posting-modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body" style="padding: 20px;">

        <script type="text/javascript" src="https://cdn.ckeditor.com/ckeditor5/1.0.0-alpha.1/classic/ckeditor.js"></script>

        <div class="alert alert-danger" id="errorbox" style="display:none;"></div>

        <form role="form" id="addpostingsform" class="form-horizontal" method="post" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id" value="<?=$compid?>" class="form-control">
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">ชื่อตำแหน่ง</label>
                <div class="col-sm-10">
                  <input type="text" name="name" id="name" class="form-control" placeholder="ชื่อตำแหน่ง" required>
                </div>
            </div>

            <div class="form-group float-label-control">
                <label for="parent" class="col-sm-2 control-label">หมวดหมู่</label>
                <div class="col-sm-10">
                  <select name="parent" id="parent" class="form-control" required>
                    <option value="">กรุณาเลือก</option>
                    <?php
                      $conn = Config\Database::connection();
                      $sql = "SELECT * FROM job_categories;";
                      $query = $conn->query($sql);
                      while ($row = $query->fetch_assoc()) {
                          echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                      }
                    ?>
                  </select>
                </div>
            </div>

            <div class="form-group float-label-control">
                <label for="responsibility" class="col-sm-2 control-label">ความรับผิดชอบ</label>
                <div class="col-sm-10">
                  <textarea name="responsibility" id="responsibility">
                  </textarea>
                </div>
            </div>

            <div class="form-group float-label-control">
                <label for="qualification" class="col-sm-2 control-label">คุณสมบัติ</label>
                <div class="col-sm-10">
                  <textarea name="qualification" id="qualification">
                  </textarea>
                </div>
            </div>

            <div class="form-group float-label-control">
                <label for="benefit" class="col-sm-2 control-label">สวัสดิการ</label>
                <div class="col-sm-10">
                  <textarea name="benefit" id="benefit">
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
                          echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                      }
                    ?>
                  </select>
                </div>
            </div>

            <div class="form-group">
                <label for="" class="col-sm-2 control-label">จำนวนอัตรา</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <input type="text" name="capacity" id="capacity" class="form-control" placeholder="จำนวนอัตรา" required>
                    <span class="input-group-addon"><label class="checkbox-inline" style="padding-top:0px;">
                      <input type="checkbox" name="many" id="many">ไม่จำกัด</label>
                    </span>
                  </div>
                </div>
            </div>

            <div class="form-group">
                <label for="" class="col-sm-2 control-label">จำกัดผู้พิการ</label>
                <div class="col-sm-10">
                <select name="disability_req" id="disability_req" class="form-control" required>
                  <option value="">กรุณาเลือก</option>
                  <option value="0">ไม่จำกัด</option>
                    <?php
                    $disability = JobController::getAllDisabilityType();
                    while($row = $disability->fetch_assoc()){
                      echo "<option value='".$row['id']."'>".$row['name']."</option>";
                    }
                    ?>
                  </select>
                </div>
            </div>

            <div class="form-group float-label-control">
                <label for="joblevel" class="col-sm-2 control-label">ระดับตำแหน่งงาน</label>
                <div class="col-sm-4">
                  <select name="joblevel" id="joblevel" class="form-control" required>
                    <option value="">กรุณาเลือก</option>
                    <?php
                    for ($i=0; $i < 5 ; $i++) {
                        echo '<option value="'.$i.'">';
                        Controller\Admin\Postings::jobLevel($i);
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
                        echo '<option value="'.$i.'">';
                        Controller\Admin\Postings::eduLevel($i);
                        echo '</option>';
                    }
                    ?>
                  </select>
                </div>
            </div>

            <div class="form-group float-label-control">
                <label for="exp" class="col-sm-2 control-label">อายุงาน</label>
                <div class="col-sm-4">
                  <select name="exp" class="form-control" id="exp" required>
                    <option value="">กรุณาเลือก</option>
                    <option value="0">ไม่จำกัด</option>
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
                <label for="type" class="col-sm-2 control-label">ประเภทการจ้าง</label>
                <div class="col-sm-4">
                  <select id="type" name="type[]" multiple="multiple" class="form-control" required>
                    <option value="full">เต็มเวลา</option>
                    <option value="part">นอกเวลา</option>
                    <option value="permanent">งานประจำ</option>
                    <option value="temporary">งานชั่วคราว</option>
                    <option value="contract">สัญญาจ้าง</option>
                    <option value="internship">ฝึกงาน</option>
                    <option value="freelance">งานอิสระ</option>
                  </select>
                </div>
            </div>

            <div class="form-group salary-range">
                <label for="salary" class="col-sm-2 control-label">รายได้</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span id="salarytype"><?=$lang['Monthly']?></span> <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="#1"><?=$lang['Monthly']?></a></li>
                        <li><a href="#2"><?=$lang['Hourly']?></a></li>
                      </ul>
                      <input type="hidden" name="salary_type" value="1" id="salary_type">
                    </span>
                    <input type="text" class="form-control" name="salary" placeholder="รายได้" aria-describedby="basic-addon1">
                    <span class="input-group-addon">บาท</span>
                    <span class="input-group-addon"><label class="checkbox-inline" style="padding-top:0px;">
                      <input type="checkbox" name="negetiable">ต่อรองได้</label>
                    </span>
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
        </script>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-lg btn-block">เพิ่ม</button>
      </div>
      </form>
    </div>
  </div>
</div>
