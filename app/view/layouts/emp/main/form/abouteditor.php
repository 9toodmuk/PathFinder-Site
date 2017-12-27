<?php
use Controller\Employer\Detail;
$emp = Detail::getDetails($_SESSION['emp_id']);
?>
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <form id="abouteditor" class="form" method="post">

      <div class="form-group">
        <div id="about"><?=$emp['about']?></div>
      </div>

      <div class="form-group pull-right">
        <button type="submit" class="btn btn-primary" id="btnAboutEdit">แก้ไข</button>
        <button type="button" class="btn btn-default" id="btnAboutCancel">ยกเลิก</button>
      </div>

    </form>
  </div>
</div>

<script type="text/javascript">
  $(function() {
    $('div#about').summernote({
      height: 150,
      disableDragAndDrop: true,
      dialogsFade: true,
      tabsize: 2,
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['image', ['picture', 'link']]
      ]
    });
  });

  $("#btnAboutCancel").click(function(){
    setTimeout(function(){ window.location.reload(); }, 100);
  })

  $("#abouteditor").submit(function(event) {
    event.preventDefault();
    var field = "about";
    var data = $('div#about').summernote('code');
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
