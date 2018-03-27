<?php
use App\Controller\Employer\Detail;
use App\Controller\Job\JobController;
use App\Controller\Admin\Postings;
$compid = Detail::getEmpId($_SESSION['emp_id']);
?>

<div class="row">

  <div class="col-12">
    <div id="alertbox" class="alert alert-danger" style="display:none"></div>
    <div class="portlet margin-bottom-30">
      <div class="portlet-title">
        <div class="caption caption-green">
          <i class="fa fa-tasks" aria-hidden="true"></i>
          <span class="caption-subject text-uppercase"> ตำแหน่งงานของคุณทั้งหมด</span>
        </div>
        <div class="actions">
          <a href="#" onclick="newpost()" class="btn btn-primary">
            <i class="fa fa-plus" aria-hidden="true"></i> เพิ่ม
          </a>
        </div>
      </div>
      <div class="portlet-body">
        <?php
          $lastpostings = Detail::getLastPostings($compid);
          if(mysqli_num_rows($lastpostings) < 1){
            echo '<div class="row text-center">';
            echo '<h3>คุณยังไม่มีประกาศรับสมัครงาน</h3>';
            echo '</div>';
          }else{
        ?>
        <div class="row" style="padding:20px;">
        <table class="table no-footer" id="datatables">
          <thead>
            <tr>
              <th width="10%"><em class="fa fa-cog"></em></th>
              <th width="50%">ชื่อตำแหน่ง</th>
              <th width="15%">หมวดหมู่</th>
              <th>อ่าน</th>
              <th>บันทึก</th>
              <th>วันที่ลงประกาศ</th>
            </tr>
          </thead>
          <tbody>
            <?php
              while ($row = $lastpostings->fetch_array()){
            ?>
            <tr id="<?=$row['id']?>">
              <td style="text-align: center;">
                <a class="btn btn-edit" data-title="Edit" data-toggle="modal" data-target="#edit" data-post-id="<?=$row['id']?>"><em class="fa fa-pencil"></em> แก้ไข</a>
                <a class="btn btn-remove" data-title="Delete" data-toggle="modal" data-target="#delete" data-post-id="<?=$row['id']?>"><em class="fa fa-trash"></em> ลบ</a>
              </td>
              <td><?=$row['name']?></td>
              <td><?=JobController::getJobCatName($row['category_id'])?></td>
              <td><?=$row['viewer']?></td>
              <td><?=JobController::getSaveCount($row['id'])?></td>
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

<?php include_once 'app/view/layouts/emp/main/form/addpostings.php' ?>

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="editorbody">
    </div>
  </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title custom_align" id="Heading">ลบใบประกาศนี้</h4>
      </div>
      <div class="modal-body">

        <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> แน่ใจหรือไม่ว่าต้องการลบใบประกาศนี้?</div>

      </div>
      <div class="modal-footer">
        <a onclick="remove(this)" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> ใช่</a>
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> ไม่ใช่</button>
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

  $('#addpostingsform').on('submit', function(e){
    e.preventDefault();
    add();
  });

  $("#edit").on("show.bs.modal", function(e) {
    var id = $(e.relatedTarget).data('post-id');

    $.ajax({
      url: '/utilities/postingeditor/',
      type: 'POST',
      data: {id: id},
      success: function (result) {
        $('#editorbody').html(result);
      }
    });
  });

  $("#delete").on("show.bs.modal", function(e) {
    var id = $(e.relatedTarget).data('post-id');
    $(e.currentTarget).find('a.btn-success').attr("id", id);
  });

  function newpost(){
    $('#posting-modal').modal("show");
  }

  function remove(element){
    var id = $(element).attr('id');
    $.ajax({
      url: '/employer/rempost/',
      type: 'POST',
      data: {id: id},
      dataType: "json",
      success: function (result) {
        if(result.success){
          $('tr#'+id).remove();
          $('#delete').modal("hide");
        }else if(result == "Success"){
          $("#alertbox").html("<?=$lang['AlertErrorText']?>");
          $("#alertbox").fadeIn();
          $('#alertbox').delay(5000).fadeOut(1000);
        }
      }
    });
  }

  function add(){
    $.ajax({
      url: '<?=$_ENV['API_LOCATION']?>/jobs',
      type: 'POST',
      data: $("#addpostingsform").serialize(),
      success: function (result) {
        $("#errorbox").removeClass("alert-danger");
        $("#errorbox").addClass("alert-success");
        $("#errorbox").html("<strong>Success!</success> Add new postings successfully.");
        $("#errorbox").fadeIn();
        setTimeout(function(){ window.location = "/employer/postings/"; }, 3000);
      },
      error: function (result) {
          $('#errorbox').fadeIn();
          $('#errorbox').delay(5000).fadeOut(1000);
      }
    });
  }
</script>
