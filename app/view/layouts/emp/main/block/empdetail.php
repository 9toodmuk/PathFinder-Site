<?php
use App\Controller\Utils\Utils;
use App\Controller\Employer\Detail;
use App\Controller\Job\JobController;
use App\Controller\Utils\Address;

$emp = Detail::getDetails($_SESSION['emp_id']);
$cid = Detail::getEmpId($_SESSION['emp_id']);
$location = Detail::getLocation($cid, true);
$category = JobController::getEmpCatName($emp['category_id']);

if($language == "en"){
  $thai = false;
}else{
  $thai = true;
}
?>
<div class="portlet margin-bottom-30">
  <div class="portlet-title">
    <div class="caption caption-green">
      <i class="fa fa-building" aria-hidden="true"></i>
      <span class="caption-subject text-uppercase"> ข้อมูลบริษัท</span>
    </div>
    <div class="actions">
      <a href="/employer/details/" class="btn btn-primary">
        <i class="fa fa-pencil" aria-hidden="true"></i> แก้ไข
      </a>
    </div>
  </div>
  <div class="portlet-body">
      <div class="card horizontal">
        <div class="card-stacked">
          <div class="card-content" style="padding:0px;">
            <div class="row">
              <div class="col-md-2 card-image">
                <img src="/uploads/logo_images/<?=$emp['logo']?>" style="margin-top:5px;width: 180px; height:180px; object-fit: contain;">
              </div>
              <div class="col-md-10" style="padding-left: 50px;margin-top:10px;">
                <div class="row">
                  <div class="col-md-6">
                    <h1><?=$emp['name']?></h1>
                    <div>
                      <label>รายละเอียด :</label>
                        <?php if (is_null($emp['about']) || $emp['about'] == ""){
                          echo "<span>คุณยังไม่ได้เพิ่มข้อมูล</span>";
                          }else{
                        ?>
                        <span><?=$emp['about']?></span>
                      <?php } ?>
                    </div>
                    <div>
                      <label>ที่อยู่ :</label>
                      <?php if (mysqli_num_rows($location) < 1){
                        echo "<span>คุณยังไม่ได้เพิ่มที่ตั้งบริษัท</span>";
                        }else{
                          $location = mysqli_fetch_array($location);
                      ?>
                      <span><br/>
                          <?=$location['address']?>
                          <br/>
                          <?=$location['address2']?> <?=Address::getAmphurName($location['city'], $thai)?><br/>
                          <?=Address::getProvinceName($location['province'], $thai)?> <?=$location['postcode']?>
                      </span>
                    <?php } ?>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div>
                      <label>หมวดหมู่บริษัท :</label>
                      <span><?=$category?></span>
                    </div>
                    <div>
                      <label>อีเมล์สำหรับเข้าระบบ :</label>
                      <span><?=$emp['email']?></span>
                    </div>
                    <div>
                      <label>ชื่อผู้ติดต่อ :</label>
                      <span><?=$emp['contact_name']?></span>
                    </div>
                    <div>
                      <label>แผนก :</label>
                      <span><?=$emp['section']?></span>
                    </div>
                    <div>
                      <label>อีเมล์สำหรับติดต่อ :</label>
                      <span><?=$emp['contact_email']?></span>
                    </div>
                    <div>
                      <label>หมายเลขโทรศัพท์ :</label>
                      <span><?=$emp['telephone']?></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
