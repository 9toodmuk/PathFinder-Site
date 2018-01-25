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
                <span><?=$user['email']?></span>
              </div>
            </div>

            <legend>ตั้งค่าการสมัครงาน</legend>
            <div class="form-group col-md-12">
              <label class="col-md-4 control-label" for="checkboxes">ตั้งค่าการรับสมัคร</label>
              <div class="col-md-8">

                <div class="input-group">
                  <label for="sendemail">
                    <input type="checkbox" name="sendemail" id="sendemail" value="1" <?php if($settings['sendemail'] == 1) echo "checked" ?>>
                    ส่งอีเมล์แจ้งเตือนเมื่อมีผู้ส่งใบสมัคร
                  </label>
                </div>

                <div class="input-group">
                  <label for="senddetail">
                    <input type="checkbox" name="senddetail" id="senddetail" value="1" <?php if($settings['senddetail'] == 1) echo "checked" ?>>
                    ส่งรายละเอียดผู้สมัครไปที่อีเมล์ของคุณ
                  </label>
                </div>

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