<?php
use App\Controller\Employer\Detail;
use App\Controller\Job\JobController;
$compid = Detail::getEmpId($_SESSION['emp_id']);
?>
<div class="portlet margin-bottom-30">
  <div class="portlet-title">
    <div class="caption caption-green">
      <i class="fa fa-tasks" aria-hidden="true"></i>
      <span class="caption-subject text-uppercase"> ตำแหน่งงานล่าสุด</span>
    </div>
    <div class="actions">
      <a href="/employer/postings/" class="btn btn-primary">
        <i class="fa fa-plus" aria-hidden="true"></i> เพิ่ม
      </a>
    </div>
  </div>
  <div class="portlet-body">
    <?php
      $lastpostings = Detail::getLastPostings($compid, true, 0, 10);
      if(mysqli_num_rows($lastpostings) < 1){
        echo 'คุณยังไม่มีประกาศรับสมัครงาน';
      }else{
    ?>
    <table class="table">
      <thead>
        <tr>
          <th width="50%">ชื่อตำแหน่ง</th>
          <th>หมวดหมู่</th>
          <th>อ่าน</th>
          <th>บันทึก</th>
          <th>วันที่ลงประกาศ</th>
        </tr>
      </thead>
      <tbody>
        <?php
          while ($row = $lastpostings->fetch_array()){
        ?>
        <tr>
          <td><?=$row['name']?></td>
          <td><?=JobController::getJobCatName($row['category_id'])?></td>
          <td><?=$row['viewer']?></td>
          <td><?=JobController::getSaveCount($row['id'])?></td>
          <td><?=$row['created_at']?></td>
        </tr>
      <?php } } ?>
      </tbody>
    </table>
  </div>
</div>
