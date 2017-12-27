<div class="row">
  <div class="col-lg-12">
    <div class="row">
      <div class="col-sm-4 col-sm-offset-2">
          <?php
            $data = Controller\Admin\Categories\JobController::loadCategories($variables[2]);
          ?>
          <form role="form" action="/admin/categories/edit/job/" method="post">
            <div class="form-group float-label-control">
                <label for="">รหัส</label>
                <input type="text" class="form-control" placeholder="รหัส" value="<?=$data['id']?>" disabled>
                <input type="hidden" name="cid" value="<?=$data['id']?>">
            </div>

              <div class="form-group float-label-control">
                  <label for="">ชื่อหมวดหมู่</label>
                  <input type="text" name="name" class="form-control" placeholder="ชื่อหมวดหมู่" value="<?=$data['name']?>" required>
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
                        if($row["id"] == $data["parent_id"]){
                          echo '<option value="'.$row["id"].'" selected>'.$row["name"].'</option>';
                        }else{
                          echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                        }
                      }
                    ?>
                  </select>
              </div>

              <div class="form-group float-label-control">
                  <label for="icon">รูปภาพ</label>
                  <input type="text" name="icon" class="form-control" placeholder="รูปภาพ" value="<?=$data['icon']?>">
              </div>

              <div class="form-group float-label-control">
                  <input type="submit" class="btn btn-primary btn-block" value="แก้ไขหมวดหมู่">
              </div>
          </form>

      </div>
      <div class="col-sm-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">การเพิ่มและแก้ไขชื่อหมวดหมู่</h3>
          </div>
          <div class="panel-body">
            <ul>
              <li>ใส่ชื่อที่เข้าใจง่าย</li>
              <li>หากไม่มีหมวดหมู่หลักกรุณาเลือก "ไม่มี"</li>
              <li>รูปภาพคือภาพที่ใช้แสดงด้านหน้าชื่อหมวดหมู่</li>
              <li>รูปภาพสามารถได้จาก <a href="http://fontawesome.io/icons/" target="_blank">ที่นี่</a></li>
              <li>รูปภาพควรอยู่ในรูปแบบ "fa fa-building"</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
