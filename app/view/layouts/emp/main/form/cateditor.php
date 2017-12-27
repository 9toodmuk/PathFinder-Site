<?php
use Controller\Employer\Detail;
use Controller\Job\Employer;
use Controller\Job\JobController;
$emp = Detail::getDetails($_SESSION['emp_id']);
?>
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <form id="cateditor" class="form" method="post">

      <div class="form-group">
        <select class="form-control" name="cat" id="cat">
          <?php
            $result = Employer::getAllCategory();
            while($row = $result->fetch_array()){
              echo '<option value="'.$row['id'].'"';
              if($row['id'] == $emp['category_id']){
                echo ' selected';
              }
              echo '>';
              echo $row['name'];
              echo '</option>';
            }
          ?>
        </select>
      </div>

      <div class="form-group pull-right">
        <button type="submit" class="btn btn-primary" id="btnCatEdit">แก้ไข</button>
        <button type="button" class="btn btn-default" id="btnCatCancel">ยกเลิก</button>
      </div>

    </form>
  </div>
</div>

<script type="text/javascript">

  $("#btnCatCancel").click(function(){
    setTimeout(function(){ window.location.reload(); }, 100);
  })

  $("#cateditor").submit(function(event) {
    event.preventDefault();
    var field = "category_id";
    var data = $('select#cat').val();
    $.ajax({
      url: "/employer/edit/",
      type: "post",
      data: {field: field, data: data},
      dataType: "json",
      success: function(result){
        if(result.status){
          setTimeout(function(){ window.location.reload(); }, 100);
        }
      }
    });
  });
</script>
