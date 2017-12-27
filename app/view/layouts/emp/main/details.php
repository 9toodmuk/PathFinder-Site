<?php
use Controller\Utils\Utils;
use Controller\Employer\Detail;
use Controller\Job\JobController;
use Controller\Utils\Address;

$emp = Detail::getDetails($_SESSION['emp_id']);
$cid = Detail::getEmpId($_SESSION['emp_id']);
$location = Detail::getLocation($cid);
$category = JobController::getEmpCatName($emp['category_id']);
if($language == "en"){
  $thai = false;
}else{
  $thai = true;
}
?>

<div class="row">
  <div class="col-12">
    <div class="portlet margin-bottom-30">
      <div class="portlet-title">
        <div class="caption caption-green">
          <i class="fa fa-building" aria-hidden="true"></i>
          <span class="caption-subject text-uppercase"> รายละเอียดบริษัท</span>
        </div>
      </div>
      <div class="portlet-body">

        <table class="table table-bordered">
          <tr>
            <th width="15%">รูปภาพบริษัท</th>
            <td id="logo"><img src="/uploads/logo_images/<?=$emp['logo']?>" style="margin-top:5px;width: 180px; height:180px; object-fit: contain;"> <a class="btn btn-edit pull-right" onclick="edit(this)"><em class="fa fa-pencil"></em> แก้ไข</a></td>
          </tr>
          <tr>
            <th width="15%">ชื่อบริษัท</th>
            <td id="name"><?=$emp['name']?> <a class="btn btn-edit pull-right" onclick="edit(this)"><em class="fa fa-pencil"></em> แก้ไข</a></td>
          </tr>
          <tr>
            <th>รายละเอียด</th>
            <td id="about">
            <div class="pull-left">
              <?=$emp['about']?>
            </div> <a class="btn btn-edit pull-right" onclick="edit(this)"><em class="fa fa-pencil"></em> แก้ไข</a></td>
          </tr>
          <tr>
            <th>หมวดหมู่</th>
            <td id="category"><?=$category?> <a class="btn btn-edit pull-right" onclick="edit(this)"><em class="fa fa-pencil"></em> แก้ไข</a></td>
          </tr>
        </table>

      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="portlet margin-bottom-30">
      <div class="portlet-title">
        <div class="caption caption-green">
          <i class="fa fa-user" aria-hidden="true"></i>
          <span class="caption-subject text-uppercase"> รายละเอียดผู้ติดต่อ</span>
        </div>
      </div>
      <div class="portlet-body">

        <table class="table table-bordered">
          <tr>
            <th width="15%">ชื่อผู้ติดต่อ</th>
            <td id="contact_name"><?=$emp['contact_name']?> <a class="btn btn-edit pull-right" onclick="edit(this)"><em class="fa fa-pencil"></em> แก้ไข</a></td>
          </tr>
          <tr>
            <th>แผนก</th>
            <td id="section"><?=$emp['section']?> <a class="btn btn-edit pull-right" onclick="edit(this)"><em class="fa fa-pencil"></em> แก้ไข</a></td>
          </tr>
          <tr>
            <th>อีเมล์สำหรับติดต่อ</th>
            <td id="contact_email"><?=$emp['contact_email']?> <a class="btn btn-edit pull-right" onclick="edit(this)"><em class="fa fa-pencil"></em> แก้ไข</a></td>
          </tr>
          <tr>
            <th>หมายเลขโทรศัพท์</th>
            <td id="telephone"><?=$emp['telephone']?> <a class="btn btn-edit pull-right" onclick="edit(this)"><em class="fa fa-pencil"></em> แก้ไข</a></td>
          </tr>
        </table>

      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="portlet margin-bottom-30">
      <div class="portlet-title">
        <div class="caption caption-green">
          <i class="fa fa-map-marker" aria-hidden="true"></i>
          <span class="caption-subject text-uppercase"> ที่ตั้งบริษัท</span>
        </div>
        <div class="actions">
          <a data-title="New" data-toggle="modal" data-target="#locationmodal" data-post-name="new" class="btn btn-primary"><em class="fa fa-plus"></em> เพิ่ม</a>
        </div>
      </div>
      <div class="portlet-body">
        <?php if(mysqli_num_rows($location) >= 1){ ?>
        <table class="table">
          <tr>
            <th width="5%">ลำดับ</th>
            <th>ชื่อ</th>
            <th>จังหวัด</th>
            <th width="20%" class="text-center"><em class="fa fa-cog"></em></th>
          </tr>
          <?php
            $i = 1;
            while($row = mysqli_fetch_assoc($location)){
          ?>
          <tr id="<?=$row['id']?>">
            <td><?=$i?></td>
            <td><?=$row['name']?></td>
            <td><?=Address::getProvinceName($row['province'], $thai)?></td>
            <td class="text-center">
              <?php
                $main = Detail::getLocation($row['id'], true, false);
                if(mysqli_num_rows($main) >= 1) {
                  echo '<a class="btn btn-warning">เป็นที่ตั้งหลักแล้ว</a>';
                }else{
                  echo '<a class="btn btn-default" onclick="setMainLocation(this)"><em class="fa fa-plus"></em> ใช้เป็นที่ตั้งหลัก</a>';
                }
              ?>
              <a class="btn btn-edit" data-title="New" data-toggle="modal" data-target="#locationmodal" data-post-name="edit" data-post-id="<?=$row['id']?>"><em class="fa fa-pencil"></em> แก้ไข</a>
              <a class="btn btn-remove" data-title="Delete" data-toggle="modal" data-target="#delete" data-post-id="<?=$row['id']?>"><em class="fa fa-trash"></em> นำออก</a>
            </td>
          </tr>
          <?php
              $i++;
            }
          }else{
            echo '<div class="row text-center">';
            echo '<h3>คุณยังไม่ได้เพิ่มที่ตั้งบริษัท</h3>';
            echo '</div>';
          }
          ?>
        </table>

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="locationmodal" tabindex="-1" role="dialog" aria-labelledby="newlocation" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="editorcontent">

    </div>
  </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title custom_align" id="Heading">ลบที่อยู่นี้</h4>
      </div>
      <div class="modal-body">

        <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> แน่ใจหรือไม่ว่าต้องการลบที่อยู่นี้?</div>

      </div>
      <div class="modal-footer">
        <a onclick="remove(this)" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> ใช่</a>
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> ไม่ใช่</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  var id = <?=$_SESSION['emp_id']?>;

  $("#delete").on("show.bs.modal", function(e) {
    var id = $(e.relatedTarget).data('post-id');
    $(e.currentTarget).find('a.btn-success').attr("id", id);
  });

  function remove(element){
    var id = $(element).attr('id');
    $.ajax({
      url: '/employer/removelocation/',
      type: 'POST',
      data: {id: id},
      dataType: "json",
      success: function(result){
        if(result.status){
          setTimeout(function(){ window.location.reload(); }, 100);
        }
      }
    });
  }

  $('#locationmodal').on("show.bs.modal", function(e){
    var name = $(e.relatedTarget).data('post-name');

    switch(name){
      case "new":
        loadnewlocationeditor();
        break;
      case "edit":
        var id = $(e.relatedTarget).data('post-id');
        loadeditlocationeditor(id);
        break;
    }
  });

  function setMainLocation(element){
    var id = $(element).parents('tr').attr('id');
    $.ajax({
      url: '/employer/setMainLocation/',
      type: 'POST',
      data: {id: id},
      dataType: "json",
      success: function(result){
        if(result.status){
          setTimeout(function(){ window.location.reload(); }, 100);
        }
      }
    });
  }

  function loadnewlocationeditor(){
    $.ajax({
      url: '/utilities/locationeditor/',
      type: 'POST',
      data: {formname: "newlocation"},
      success: function(result){
        $('#editorcontent').html(result);
      }
    });
  }

  function loadeditlocationeditor(id){
    $.ajax({
      url: '/utilities/locationeditor/',
      type: 'POST',
      data: {id:id, formname: "editlocation"},
      success: function(result){
        $('#editorcontent').html(result);
      }
    });
  }

  function edit(element){
    var type = $(element).parent().attr('id');
    switch (type) {
      case "about":
        editabout(element);
        break;
      case "category":
        editcat(element);
        break;
      case "logo":
        editlogo(element);
        break;
      default:
        editcomp(element);
        break;
    }
  }

  function editlogo(element){
    var type = $(element).parent().attr('id');
    $.ajax({
      url: '/utilities/emplogoeditor',
      type: 'POST',
      success: function(result){
        $(element).parent().html(result);
      }
    });
  }

  function editcat(element){
    var type = $(element).parent().attr('id');
    $.ajax({
      url: '/utilities/empcateditor',
      type: 'POST',
      success: function(result){
        $(element).parent().html(result);
      }
    });
  }

  function editcomp(element){
    var type = $(element).parent().attr('id');
    $.ajax({
      url: '/utilities/empdetaileditor',
      type: 'POST',
      data: {type: type},
      success: function(result){
        $(element).parent().html(result);
      }
    });
  }

  function editabout(element){
    $.ajax({
      url: '/utilities/compabouteditor',
      type: 'POST',
      success: function(result){
        $(element).parent().html(result);
      }
    });
  }
</script>
