<?php
use Controller\Employer\Detail;
use Controller\Admin\Users;
use Controller\Admin\Postings;
$compid = Detail::getEmpId($_SESSION['emp_id']);
?>
<div class="portlet margin-bottom-30">
  <div class="portlet-title">
    <div class="caption caption-green">
      <i class="fa fa-envelope-open" aria-hidden="true"></i>
      <span class="caption-subject text-uppercase"> ใบสมัครงานล่าสุด</span>
    </div>
  </div>
  <div class="portlet-body">
    <?php
      $lastapp = Detail::getLastApplications($compid, true, 0, 10);
      if(mysqli_num_rows($lastapp) < 1){
        echo 'คุณยังไม่ได้รับใบสมัครงาน';
      }else{
    ?>
    <table class="table">
      <thead>
        <tr>
          <th>ผู้ใช้</th>
          <th>ตำแหน่งงาน</th>
          <th>สถานะ</th>
          <th>วันที่สมัคร</th>
        </tr>
      </thead>
      <tbody>
        <?php
          while ($row = $lastapp->fetch_array()){
        ?>
        <tr>
            <td>[<?php echo $row["user_id"] ?>] <?php echo Users::getUserName($row["user_id"]) ?></td>
            <td>[<?php echo $row["job_id"] ?>] <?php echo Postings::getPostingName($row["job_id"]) ?></td>
            <td><?php echo $row["status"] ?></td>
            <td><?php echo $row["created_at"] ?></td>
        </tr>
      <?php } } ?>
      </tbody>
    </table>
  </div>
</div>
