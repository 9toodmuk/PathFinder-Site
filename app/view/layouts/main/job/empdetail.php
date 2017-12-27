<?php
use Controller\Job\Employer;
use Controller\Employer\Detail;
use Controller\Job\JobController;
use Controller\Utils\Address;

if(!isset($currentjob)){
  $result = Employer::loadEMP($variables[2]);
  $location = Detail::getLocation($variables[2], true, true);
}else{
  $result = Employer::loadEMP($currentjob['company_id']);
  $location = Detail::getLocation($currentjob['company_id'], true, true);
}

$emp = mysqli_fetch_array($result);

$category = JobController::getEmpCatName($emp['category_id']);
?>

<div class="portlet margin-bottom-30">
  <div class="portlet-title">
    <div class="caption caption-green">
      <i class="fa fa-building" aria-hidden="true"></i>
      <span class="caption-subject text-uppercase"> ข้อมูลบริษัท</span>
    </div>
  </div>
  <div class="portlet-body" id="printarea">
    <div class="row">
      <div class="col-md-12">
        <div class="pull-right">
          <img src="/uploads/logo_images/<?=$emp['logo']?>" style="border: 1px solid #ccc; margin-top:5px;width: 180px; height:180px; object-fit: contain;">
        </div>

        <h3><?=$emp['name']?></h3>

        <?php if (!is_null($emp['about']) && $emp['about'] != ""){ ?>
          <div>
            <label>เกี่ยวกับบริษัท :</label>
            <span><?=$emp['about']?></span>
          </div>
        <?php } ?>

        <?php if (mysqli_num_rows($location) >= 1){
          $location = mysqli_fetch_array($location); ?>
          <div>
            <label>ที่อยู่ :</label>
            <span><br/>
                <?=$location['address']?>
                <br/>
                <?=$location['address2'] != "" ? $location['address2']."<br/>" : ""; ?>
                <?=Address::getAmphurName($location['city'])?><?=Address::getProvinceName($location['province'])?> <?=$location['postcode']?>
            </span>
          </div>
        <?php } ?>

        <?php if (!is_null($category) && $category != ""){ ?>
          <div>
            <label>หมวดหมู่บริษัท :</label>
            <span><?=$category?></span>
          </div>
        <?php } ?>

        <?php if (!is_null($emp['contact_name']) && $emp['contact_name'] != ""){ ?>
          <div>
            <label>ชื่อผู้ติดต่อ :</label>
            <span><?=$emp['contact_name']?></span>
          </div>
        <?php } ?>

        <?php if (!is_null($emp['contact_email']) && $emp['contact_email'] != ""){ ?>
          <div>
            <label>อีเมล์สำหรับติดต่อ :</label>
            <span><?=$emp['contact_email']?></span>
          </div>
        <?php } ?>

        <?php if (!is_null($emp['telephone']) && $emp['telephone'] != ""){ ?>
          <div>
            <label>หมายเลขโทรศัพท์ :</label>
            <span><?=$emp['telephone']?></span>
          </div>
        <?php } ?>
        </div>
      </div>

  </div>
</div>
