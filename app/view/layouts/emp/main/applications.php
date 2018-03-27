<?php
use App\Controller\Employer\Detail;
use App\Controller\User\Profile;
use App\Controller\Admin\Users;
use App\Controller\Admin\Postings;
$compid = Detail::getEmpId($_SESSION['emp_id']);

$api_location = getenv('API_LOCATION');
?>

<div class="row">

  <div class="col-12">
    <div id="alertbox" class="alert alert-danger" style="display:none"></div>
    <div class="portlet margin-bottom-30">
      <div class="portlet-title">
        <div class="caption caption-green">
          <i class="fa fa-envelope-open" aria-hidden="true"></i>
          <span class="caption-subject text-uppercase"> ใบสมัครทั้งหมดที่ส่งเข้ามา</span>
        </div>
      </div>
      <div class="portlet-body">
        <?php
          $lastpostings = Detail::getLastApplications($compid);
          if(mysqli_num_rows($lastpostings) < 1){
            echo '<div class="row text-center">';
            echo '<h3>ยังไม่มีผู้ส่งใบสมัครงานเข้ามา</h3>';
            echo '</div>';
          }else{
        ?>
        <div class="row" style="padding:20px;">
        <table class="table no-footer" id="datatables">
          <thead>
            <tr>
              <th width="15%"><em class="fa fa-cog"></em></th>
              <th width="30%">ชื่อผู้สมัคร</th>
              <th width="30%">ชื่อตำแหน่ง</th>
              <th>สถานะ</th>
              <th>วันที่สมัคร</th>
              <th>จัดการ</th>
            </tr>
          </thead>
          <tbody>
            <?php
              while ($row = $lastpostings->fetch_array()){  
                $user = Profile::profileload($row['user_id']);
                $user = mysqli_fetch_assoc($user);
            ?>
            <tr id="<?=$row['id']?>">
              <td style="text-align: center;">
                <a class="btn btn-edit" href="detail/<?=$row['id']?>"><em class="fa fa-envelope-open"></em> รายละเอียด</a>
              </td>
              <td><?=$user['first_name']." ".$user['last_name']." (".$user['email'].")"?></td>
              <td><?=$row['name']?></td>
              <td><?=$lang[Detail::getApplyStatus($row['status'])]?></td>
              <td><?=$row['created_at']?></td>
            </tr>
          <?php } ?>
            </tbody>
          </table>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>

</div>

<script type="text/javascript">
  $(function() {
    $('#datatables').DataTable({
      tabIndex: -1,
      ordering: false,
      bFilter: false,
      bInfo: false,
      bLengthChange: false,
      responsive: true
    });
  });
</script>
