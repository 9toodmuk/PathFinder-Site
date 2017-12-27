<?php
  include_once $_SERVER['DOCUMENT_ROOT'].'/dist/config.php';

  $id = $_POST['id'];

  $sql = "SELECT * FROM application_lists WHERE id = '$id';";
  $query = $conn->query($sql);
  $rows = mysqli_fetch_array($query);
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h4 class="modal-title custom_align" id="Heading">แก้ไขใบสมัครงาน</h4>
</div>
<div class="modal-body">
  <form role="form" method="post">
    <div class="form-group float-label-control">
        <label for="user">ชื่อผู้ใช้</label>
        <select name="user" id="user" class="form-control" required>
          <option value="">กรุณาเลือก</option>
          <?php
            $sql = "SELECT * FROM users;";
            $users = $conn->query($sql);
            while($row = $users->fetch_assoc()) {
              echo '<option value="'.$row["id"].'">['.$row["id"].'] '.Users::getUserName($row["id"]).'</option>';
            }
          ?>
        </select>
    </div>

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
                echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';
              }
            ?>
          </select>
      </div>

      <div class="form-group float-label-control">
          <label for="status">สถานะ</label>
          <select name="status" id="status" class="form-control" required>
            <option value="">กรุณาเลือก</option>
            <?php
              $Postings = Postings::getAllPostings();
              while($row = $Postings->fetch_assoc()) {
                echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';
              }
            ?>
          </select>
      </div>
</div>
<div class="modal-footer">
  <a href="#" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> ใช่</a>
  <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> ไม่ใช่</button>
</div>
</form>
