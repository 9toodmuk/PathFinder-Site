<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <div class="row">
                <div class="col col-xs-6">
                  <h3 class="panel-title">รายชื่อบริษัททั้งหมด</h3>
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
                    <th width="40%">ชื่อ</th>
                    <th>หมวดหมู่</th>
                    <th>ที่ตั้ง</th>
                    <th>ประเทศ</th>
                    <th>หมายเลขโทรศัพท์</th>
                    <th>สัญลักษณ์</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $conn = Config\Database::connection();
                    $sql = "SELECT * FROM company";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()) {
                  ?>
                  <tr id="g<?php echo $row['id'] ?>">
                    <td align="center">
                      <a class="btn btn-default btn-edit" data-title="Edit" data-toggle="modal" data-target="#edit" data-book-id="<?php echo $row['id'] ?>"><em class="fa fa-pencil"></em></a>
                      <a class="btn btn-danger" data-title="Delete" data-toggle="modal" data-target="#delete" data-book-id="<?php echo $row['id'] ?>"><em class="fa fa-trash"></em></a>
                    </td>
                    <td class="hidden-xs" id="tid<?php echo $row['id'] ?>"><?php echo $row["id"] ?></td>
                    <td id="nm<?php echo $row['id'] ?>"><?php echo $row["name"] ?></td>
                    <td id="cat<?php echo $row['id'] ?>"><?php $catname = Controller\Admin\Categories\EmployerController::loadCategories($row["category_id"]); echo $catname['name']; ?></td>
                    <td id="pro<?php echo $row['id'] ?>"><?php echo $row["province"] ?></td>
                    <td id="ct<?php echo $row['id'] ?>"><?php echo $row["country"] ?></td>
                    <td id="tp<?php echo $row['id'] ?>"><?php echo $row["telephone"] ?></td>
                    <td id="logo<?php echo $row['id'] ?>" class="text-center"><img src="/uploads/logo_images/<?php echo $row['logo'] ?>" width="100px"/></td>
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

<div class="modal fade" id="new" tabindex="-1" role="dialog" aria-labelledby="new" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title custom_align" id="Heading">เพิ่มบริษัทใหม่</h4>
      </div>
      <div class="modal-body">

        <form role="form" action="/admin/employer/add/" method="post" enctype="multipart/form-data">
            <div class="form-group float-label-control">
                <label for="">ชื่อบริษัท</label>
                <input type="text" name="name" class="form-control" placeholder="ชื่อบริษัท" required>
            </div>

            <div class="form-group float-label-control">
                <label for="parent">หมวดหมู่บริษัท</label>
                <select name="parent" class="form-control" required>
                  <?php
                    $conn = Config\Database::connection();
                    $sql = "SELECT * FROM company_categories;";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()) {
                      echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                    }
                  ?>
                </select>
            </div>

            <div class="form-group float-label-control">
                <label for="location">ที่ตั้ง</label>
                <input type="text" name="location" class="form-control" placeholder="ที่ตั้ง" required>
            </div>

            <div class="form-group float-label-control">
                <label for="country">ประเทศ</label>
                <input type="text" name="country" class="form-control" placeholder="ประเทศ" required>
            </div>

            <div class="form-group float-label-control">
                <label for="telephone">หมายเลขโทรศัพท์</label>
                <input type="text" name="telephone" class="form-control" placeholder="หมายเลขโทรศัพท์" required>
            </div>

            <div class="form-group float-label-control">
                <label for="logo">สัญลักษณ์</label>
                <input type="file" name="logo" accept="image/*" required>
            </div>


      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-primary btn-block" value="เพิ่มบริษัท">
      </div>

      </form>
    </form>
    </div>
  </div>
</div>

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="editbody">

    </div>
  </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h4 class="modal-title custom_align" id="Heading">ลบบริษัทนี้</h4>
    </div>
    <div class="modal-body">

      <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> แน่ใจหรือไม่ว่าต้องการลบบริษัทนี้?</div>

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
    $(e.currentTarget).find('a.btn-success').attr("href","/admin/employer/delete/"+id+"/");
  });

  $('#edit').on('show.bs.modal', function(e) {

    var id = $(e.relatedTarget).data('book-id');

    $.ajax({
      url: '/dist/admin/employer/loader.php',
      type: 'POST',
      data: {id:id},
      success: function(result){
        $("#editbody").html(result);
      }
    });

    $(e.currentTarget).find('input#eid','input#edd').val(id);
  });
</script>
