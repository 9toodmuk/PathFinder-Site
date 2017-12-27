<?php
use Config\Database;
use Controller\Admin\Applications;
use Controller\Admin\Users;
use Controller\Admin\Postings;
?>

      <div class="row">
          <div class="col-lg-12">
              <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="row">
                      <div class="col col-xs-6">
                        <h3 class="panel-title">รายชื่อประกาศรับสมัครงาน</h3>
                      </div>
                      <div class="col col-xs-6 text-right">
                          <a class="btn btn-primary" data-title="Add" data-toggle="modal" data-target="#add"><em class="fa fa-plus"></em> เพิ่ม</a>
                      </div>
                    </div>
                  </div>
                  <div class="panel-body">
                    <table width="100%" class="table table-hover" id="datatables">
                      <thead>
                        <tr>
                          <th width="8%"><em class="fa fa-cog"></em></th>
                          <th class="hidden-xs" width="8%">ID</th>
                          <th>ชื่อผู้ใช้</th>
                          <th>ชื่อตำแหน่ง</th>
                          <th>สถานะ</th>
                          <th>วันที่ส่งใบสมัคร</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $query = Applications::loadAllApplication();
                          while($row = $query->fetch_assoc()){
                        ?>
                        <tr>
                          <td align="center">
                            <a class="btn btn-danger" data-title="Delete" data-toggle="modal" data-target="#delete" data-book-id="<?php echo $row['id'] ?>"><em class="fa fa-trash"></em></a>
                          </td>
                          <td class="hidden-xs"><?php echo $row["id"] ?></td>
                          <td>[<?php echo $row["user_id"] ?>] <?php echo Users::getUserName($row["user_id"]) ?></td>
                          <td>[<?php echo $row["job_id"] ?>] <?php echo Postings::getPostingName($row["job_id"]) ?></td>
                          <td><?php echo $row["status"] ?></td>
                          <td width="200px"><?php echo $row["created_at"] ?></td>
                        </tr>
                        <?php
                          }
                        ?>
                      </tbody>
              </table>
              </div>
              <div class="panel-footer">
                <div class="row">
              </div>
            </div>
          </div>
        </div>
      </div>

    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title custom_align" id="Heading">เพิ่มใบสมัครงาน</h4>
          </div>
          <div class="modal-body">
            <div class="alert" id="errorbox" style="display:none;">
            </div>
            <form role="form" method="post" id="newapplication">
                <div class="form-group float-label-control">
                    <label for="user">ชื่อผู้ใช้</label>
                    <select name="user" id="user" class="form-control" required>
                      <option value="">กรุณาเลือก</option>
                      <?php
                        $users = Users::getAllUsers();
                        while($row = $users->fetch_assoc()) {
                          echo '<option value="'.$row["id"].'">['.$row["id"].'] '.Users::getUserName($row["id"]).'</option>';
                        }
                      ?>
                    </select>
                </div>

                <div class="form-group float-label-control">
                    <label for="job">ตำแหน่งงาน</label>
                    <select name="job" id="job" class="form-control" required>
                      <option value="">กรุณาเลือก</option>
                      <?php
                        $Postings = Postings::getAllPostings();
                        while($row = $Postings->fetch_assoc()) {
                          echo '<option value="'.$row["id"].'">['.$row["id"].'] '.$row["name"].'</option>';
                        }
                      ?>
                    </select>
                </div>

                <div class="form-group float-label-control">
                    <label for="status">สถานะ</label>
                    <select name="status" id="status" class="form-control" required>
                      <option value="">กรุณาเลือก</option>
                      <option value="0">ส่งใบสมัคร</option>
                      <option value="1">กำลังพิจารณา</option>
                      <option value="2">ตอบรับ</option>
                      <option value="3">ปฏิเสธ</option>
                    </select>
                </div>
          </div>
          <div class="modal-footer">
            <button type="submit" href="#" class="btn btn-success" id="btnAdd" data-loading-text="<?=$lang['processing']?>"><span class="glyphicon glyphicon-ok-sign"></span> ใช่</button>
            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> ไม่ใช่</button>
          </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title custom_align" id="Heading">ลบใบสมัครงานนี้</h4>
          </div>
          <div class="modal-body">

            <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> แน่ใจหรือไม่ว่าต้องการลบใบสมัครงานนี้?</div>

          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> ใช่</a>
            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> ไม่ใช่</button>
          </div>
        </div>
      </div>
    </div>

  <script>

  $('#delete').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('book-id');
    $(e.currentTarget).find('a.btn-success').attr("href","/admin/applications/delete/"+id+"/");
  });

  $('#newapplication').submit(function(e){
    e.preventDefault();
    var $button = $('#btnAdd');
    $button.button('loading');
    addApplication();
  });

  function addApplication(){
    var button = $('#btnAdd');
    button.button('loading');
    $.ajax({
      url: '/admin/applications/add/',
      type: 'POST',
      data: $("#newapplication").serialize(),
      success: function (result) {
        if(result == "Success"){
          $('#errorbox').addClass("alert-success");
          $('#errorbox').html("<?=$lang['NewApplicationSuccess']?>");
          $('#errorbox').fadeIn();
          setTimeout(function(){ window.location = "/admin/applications/"; }, 3000);
        }else if(result == "Error"){
          button.button('reset');
          $('#errorbox').addClass("alert-danger");
          $('#errorbox').html("<?=$lang['NewApplicationError']?>");
          $('#errorbox').fadeIn();
        }
      }
    });
  }
  </script>
