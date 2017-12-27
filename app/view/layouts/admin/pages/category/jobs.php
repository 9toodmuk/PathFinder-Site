<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <div class="row">
                <div class="col col-xs-6">
                  <h3 class="panel-title">รายชื่อหมวดหมู่งานทั้งหมด</h3>
                </div>
                <div class="col col-xs-6 text-right">
                  <a class="btn btn-primary btn-create" data-title="New" data-toggle="modal" data-target="#new"><em class="fa fa-plus"></em> เพิ่ม</a>
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
                    <th>หมวดหมู่หลัก</th>
                    <th>สัญลักษณ์</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $conn = Config\Database::connection();
                    $sql = "SELECT * FROM job_categories";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()) {
                  ?>
                  <tr>
                    <td align="center">
                      <a class="btn btn-default" href="/admin/categories/job/edit/<?php echo $row['id'] ?>"><em class="fa fa-pencil"></em></a>
                      <a class="btn btn-danger" data-title="Delete" data-toggle="modal" data-target="#delete" data-book-id="<?php echo $row['id'] ?>"><em class="fa fa-trash"></em></a>
                    </td>
                    <td class="hidden-xs"><?php echo $row["id"] ?></td>
                    <td><?php echo $row["name"] ?></td>
                    <?php
                      if($row["parent_id"] == NULL){
                        echo '<td>-</td>';
                      }else{
                        $sql = "SELECT * FROM job_categories WHERE id = ".$row["parent_id"].";";
                        $catsql = $conn->query($sql);
                        $cat = $catsql->fetch_assoc();
                        echo '<td>'.$cat["name"].'</td>';
                      }
                    ?>
                    <td><i class="<?php echo $row["icon"] ?>" aria-hidden="true"></i></td>
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
        <h4 class="modal-title custom_align" id="Heading">เพิ่มหมวดหมู่</h4>
      </div>
      <div class="modal-body">
        <form role="form" action="/admin/categories/add/job/" method="post">
            <div class="form-group float-label-control">
                <label for="">ชื่อหมวดหมู่</label>
                <input type="text" name="name" class="form-control" placeholder="ชื่อหมวดหมู่" required>
            </div>

            <div class="form-group float-label-control">
                <label for="parent">หมวดหมู่หลัก</label>
                <select name="parent" class="form-control">
                  <option value="">ไม่มี</option>
                  <?php
                    $conn = Config\Database::connection();
                    $sql = "SELECT * FROM job_categories WHERE parent_id IS NULL;";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()) {
                      echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                    }
                  ?>
                </select>
            </div>

            <div class="form-group float-label-control">
                <label for="icon">สัญลักษณ์</label>
                <input type="text" name="icon" class="form-control" placeholder="สัญลักษณ์">
            </div>

      </div>
      <div class="modal-footer ">
        <input type="submit" class="btn btn-primary btn-block" value="เพิ่มหมวดหมู่">
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
        <h4 class="modal-title custom_align" id="Heading">ลบหมวดหมู่นี้</h4>
      </div>
      <div class="modal-body">

        <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> แน่ใจหรือไม่ว่าต้องการลบหมวดหมู่นี้?</div>

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
    $(e.currentTarget).find('a.btn-success').attr("href","/admin/categories/job/delete/"+id);
  });
</script>
