<?php
use Controller\Employer\Detail;
$emp = Detail::getDetails($_SESSION['emp_id']);
?>
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <form id="<?=$type?>editor" class="form" method="post">

      <div class="form-group">
        <input id="<?=$type?>" name="<?=$type?>" class="form-control" value="<?=$emp[$type]?>">
      </div>

      <div class="form-group pull-right">
        <button type="submit" class="btn btn-primary" id="btnEdit<?=$type?>">แก้ไข</button>
        <button type="button" class="btn btn-default" id="btnCancel<?=$type?>">ยกเลิก</button>
      </div>

    </form>
  </div>
</div>

<script type="text/javascript">
  $("#btnCancel<?=$type?>").click(function(){
    setTimeout(function(){ window.location.reload(); }, 100);
  })

  $("#<?=$type?>editor").submit(function(event) {
    event.preventDefault();
    var field = "<?=$type?>";
    var data = $('input#<?=$type?>').val();
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
