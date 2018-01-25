<?php
use Controller\User\Profile;
$user = Profile::profileLoad($_SESSION['social_id']);
$user = mysqli_fetch_array($user);
?>

<div class="row" id="exp">
  <div class="portlet margin-bottom-30">
    <div class="portlet-title">
      <div class="caption caption-green">
        <i class="fa fa-cogs" aria-hidden="true"></i>
        <span class="caption-subject text-uppercase"> <?=$lang['Settings']?></span>
      </div>
    </div>
    <div class="portlet-body">
    <form id="settingsform" class="form" method="post">
        <div class="row">
          <div class="col-md-12">
            <div id='errorbox'></div>

            <legend>ตั้งค่าบัญชีผู้ใช้</legend>
            <div class="form-group col-md-12">
              <label class="col-md-4 control-label" for="newpassword">อีเมล์สำหรับเข้าใช้</label>
              <div class="col-md-8">
                <span><?=$user['email']?></span>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-md-4 control-label" for="newpassword">เปลี่ยนรหัสผ่าน</label>
              <div class="col-md-8">
                <div class="form-group">
                  <input id="password" name="password" type="password" placeholder="รหัสผ่านใหม่" class="form-control input-md">
                </div>
                <div class="form-group">
                  <input id="password-confirm" name="password-confirm" type="password" placeholder="ยืนยันรหัสผ่านใหม่" class="form-control input-md">
                </div>
              </div>
            </div>

            <legend>ตั้งค่าเว็บไซต์</legend>
            <div class="form-group col-md-12">
              <label class="col-md-4 control-label" for="newpassword">ตัวเลือกสำหรับตาบอดสี</label>
              <div class="col-md-8">
                <select name="" class="form-control" id="">
                  <option value="">ปิด</option>
                  <option value="">DEUTERANOPIA</option>
                  <option value="">PROTANOPIA</option>
                  <option value="">TRITANOPIA</option>
                </select>
              </div>
            </div>
            <div class="form-group col-md-12">
              <label class="col-md-4 control-label" for="newpassword">ขนาดตัวอักษร</label>
              <div class="col-md-8">
                <select name="" class="form-control" id="">
                  <option value="">ปกติ</option>
                  <option value="">เล็กที่สุด</option>
                  <option value="">เล็ก</option>
                  <option value="">ใหญ่</option>
                  <option value="">ใหญ่ที่สุด</option>
                </select>
              </div>
            </div>

            <legend>ยืนยันรหัสผ่าน</legend>
            <div class="form-group col-md-12">
              <label class="col-md-4 control-label" for="confirm-password">รหัสผ่านเดิม</label>
              <div class="col-md-8">
                <input id="oldpassword" name="oldpassword" type="password" placeholder="รหัสผ่านเดิม" class="form-control input-md" required>
              </div>
            </div>

            <div class="form-group col-md-12">
              <button type="submit" id="btnEdit" class="btn btn-primary btn-lg btn-block">ยืนยัน</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>