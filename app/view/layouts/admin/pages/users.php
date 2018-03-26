      <div class="row">
          <div class="col-lg-12">
              <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="row">
                      <div class="col col-xs-6">
                        <h3 class="panel-title">รายชื่อผู้ใช้ทั้งหมด</h3>
                      </div>
                      <div class="col col-xs-6 text-right">
                          <a data-title="New" data-toggle="modal" data-target="#new" class="btn btn-primary"><em class="fa fa-plus"></em> เพิ่ม</a>
                      </div>
                    </div>
                  </div>
                  <div class="panel-body">
                    <table width="100%" class="table table-hover" id="datatables">
                      <thead>
                        <tr>
                          <th width="8%"><em class="fa fa-cog"></em></th>
                          <th class="hidden-xs" width="8%">ID</th>
                          <th>ชื่อ</th>
                          <th>นามสกุล</th>
                          <th>ที่อยู่อีเมล์</th>
                          <th>กลุ่มผู้ใช้</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $conn = Config\Database::connection();
                          $sql = "SELECT * FROM users, personal_details WHERE users.id = personal_details.user_id GROUP BY users.id;";
                          $query = $conn->query($sql);
                          while($row = $query->fetch_assoc()) {
                        ?>
                        <tr id="g<?php echo $row['id'] ?>">
                          <td align="center">
                            <!-- <a class="btn btn-default btn-edit" data-title="Edit" data-toggle="modal" data-target="#edit" data-book-id="<?php echo $row['user_id'] ?>"><em class="fa fa-pencil"></em></a> -->
                            <a class="btn btn-danger" data-title="Delete" data-toggle="modal" data-target="#delete" data-book-id="<?php echo $row['user_id'] ?>"><em class="fa fa-trash"></em></a>
                          </td>
                          <td class="hidden-xs" id="tid<?php echo $row['user_id'] ?>"><?php echo $row["user_id"] ?></td>
                          <td><?php echo $row["first_name"] ?></td>
                          <td><?php echo $row["last_name"] ?></td>
                          <td><?php echo $row["email"] ?></td>
                          <td><?php echo App\Controller\Admin\Users::getGroupName($row["user_group"]); ?></td>
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
    </div>

    <div class="modal fade" id="new" tabindex="-1" role="dialog" aria-labelledby="new" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title custom_align" id="Heading">เพิ่มผู้ใช้ใหม่</h4>
          </div>
          <div class="modal-body">
            <div class="alert" id="errorbox" style="display:none;">
            </div>
            <form role="form" id="addAccount" method="post" enctype="multipart/form-data">
              <div class="form-group float-label-control">
                  <label for="email">ที่อยู่อีเมล์</label>
                  <input type="email" id="email" name="email" class="form-control" placeholder="ที่อยู่อีเมล์" required>
                  <div class="help-block with-errors"></div>
              </div>

              <div class="form-group float-label-control">
                  <label for="password">รหัสผ่าน</label>
                  <input type="password" id="password" name="password" class="form-control" placeholder="รหัสผ่าน" required>
              </div>

                <div class="form-group float-label-control">
                    <label for="fname">ชื่อ</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="ชื่อ" required>
                </div>

                <div class="form-group float-label-control">
                    <label for="lname">นามสกุล</label>
                    <input type="text" id="lname" name="lname" class="form-control" placeholder="นามสกุล" required>
                </div>

                <div class="form-group float-label-control">
                    <label for="group">กลุ่มผู้ใช้</label>
                    <select class="form-control" name="group" id="group">
                      <?php
                        $group = App\Controller\Admin\Users::getAllGroup();
                        while ($row = $group->fetch_assoc()){
                          echo '<option value='.$row['id'].'>'.$row['name'].'</option>';
                        }
                      ?>
                    </select>
                </div>
          </div>
          <div class="modal-footer">
            <button type="submit" href="#" class="btn btn-primary btn-block" id="btnAdd" data-loading-text="<?=$lang['processing']?>"><i class="fa fa-plus" aria-hidden="true"></i></span> เพิ่มผู้ใช้</button>
          </div>
          </form>
        </div>
      </div>
    </div>

  <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title custom_align" id="Heading">ลบผู้ใช้นี้</h4>
        </div>
        <div class="modal-body">

          <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> แน่ใจหรือไม่ว่าต้องการลบผู้ใช้นี้?</div>

        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> ใช่</a>
          <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> ไม่ใช่</button>
        </div>
      </div>
    </div>
  </div>

  <script>

    $('#addAccount input#email').on("click input", function(){
      validate($(this).val());
    });

    $('#addAccount').submit(function(e){
      e.preventDefault();
      var $button = $('#btnAdd');
      $button.button('loading');
      createNewUser();
    });

    function validate(target){
      $.ajax({
        url: '/dist/admin/users/emailcheck.php',
        type: 'POST',
        data: {email:target},
        success: function(result){
          if(result >= 1){
            $('#addAccount input#email').parent().addClass("has-error");
            $('#addAccount input#email').next(".help-block").html("อีเมล์ถูกใช้แล้ว");
            $("#addbtn").prop('disabled', true);
          }else{
            $('#addAccount input#email').parent().removeClass("has-error");
            $('#addAccount input#email').next(".help-block").html("");
            $("#addbtn").prop('disabled', false);
          }
        }
      });
    }

    function createNewUser(){
      var $button = $('#btnAdd');
      $button.button('loading');
      $.ajax({
        url: '/admin/users/add/',
        type: 'POST',
        data: $("#addAccount").serialize(),
        success: function (result) {
          if(result == "Success"){
            $('#errorbox').addClass("alert-success");
            $('#errorbox').html("<?=$lang['NewApplicationSuccess']?>");
            $('#errorbox').fadeIn();
            setTimeout(function(){ window.location = "/admin/users/"; }, 3000);
          }else{
            $button.button('reset');
            $('#errorbox').addClass("alert-danger");
            $('#errorbox').html("<?=$lang['NewApplicationError']?>");
            $('#errorbox').fadeIn();
          }
        }
      });
    }

    $('#delete').on('show.bs.modal', function(e) {

      var id = $(e.relatedTarget).data('book-id');
      $(e.currentTarget).find('a.btn-success').attr("href","/admin/users/delete/"+id+"/");
    });
  </script>
