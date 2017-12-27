<?php
  include_once $_SERVER['DOCUMENT_ROOT'].'/dist/config.php';

  $id = $_POST['id'];

  $sql = "SELECT * FROM company WHERE id = '$id';";
  $query = $conn->query($sql);
  $rows = mysqli_fetch_array($query);
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h4 class="modal-title custom_align" id="Heading">แก้ไขบริษัท</h4>
</div>
<div class="modal-body">

  <form role="form" action="/admin/employer/edit/<?=$rows['id']?>" method="post" enctype="multipart/form-data">
      <div class="form-group float-label-control">
        <label for="">รหัส</label>
        <input type="text" class="form-control" placeholder="รหัส" value="<?=$rows['id']?>" disabled>
        <input type="hidden" name="eid" class="form-control" value="<?=$rows['id']?>">
      </div>

      <div class="form-group float-label-control">
          <label for="">ชื่อบริษัท</label>
          <input type="text" id="ename" name="name" class="form-control" placeholder="ชื่อบริษัท" value="<?=$rows['name']?>" required>
      </div>

      <div class="form-group float-label-control">
          <label for="parent">หมวดหมู่บริษัท</label>
          <select name="parent" class="form-control" required>
            <?php
              $sql = "SELECT * FROM company_categories;";
              $query = $conn->query($sql);
              while($row = $query->fetch_assoc()) {
                if($rows['category_id'] == $row["id"]){
                  echo '<option value="'.$row["id"].'" selected>'.$row["name"].'</option>';
                }else{
                  echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                }
              }
            ?>
          </select>
      </div>

      <div class="form-group float-label-control">
          <label for="location">ที่ตั้ง</label>
          <input type="text" id="elocation" name="location" class="form-control" placeholder="ที่ตั้ง" value="<?=$rows['province']?>" required>
      </div>

      <div class="form-group float-label-control">
          <label for="country">ประเทศ</label>
          <input type="text" id="ecountry" name="country" class="form-control" placeholder="ประเทศ" value="<?=$rows['country']?>" required>
      </div>

      <div class="form-group float-label-control">
          <label for="telephone">หมายเลขโทรศัพท์</label>
          <input type="text" id="ephone" name="telephone" class="form-control" placeholder="หมายเลขโทรศัพท์" value="<?=$rows['telephone']?>" required>
      </div>

      <div class="form-group float-label-control">
          <label for="logo">สัญลักษณ์</label>
          <br/>
          <img src="/uploads/logo_images/<?=$rows['logo']?>" width="250px" >
          <input type="file" name="logo" accept="image/*">
      </div>

  <input type="submit" class="btn btn-primary btn-block" value="แก้ไข">

</form>
