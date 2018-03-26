<?php
use App\Controller\Employer\Detail;
$emp = Detail::getDetails($_SESSION['emp_id']);
?>
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <form id="logoeditor" class="form" method="post">

      <div class="form-group text-center">
        <img src="/uploads/logo_images/<?=$emp['logo']?>" id="images" style="margin-top:10px;margin-bottom:10px;width: 180px; height:180px; object-fit: contain;">
        <input id="logo" name="logo" type="file" class="form-control" accept="image/*"/>
      </div>

      <div class="form-group pull-right">
        <button type="submit" class="btn btn-primary" id="btnEditlogo">แก้ไข</button>
        <button type="button" class="btn btn-default" id="btnCancellogo">ยกเลิก</button>
      </div>

    </form>
  </div>
</div>

<script type="text/javascript">

  $("#btnCancellogo").click(function(){
    setTimeout(function(){ window.location.reload(); }, 100);
  })

  $("input#logo").change(function(){
    readURL(this);
    console.log(this.files.length);
  });

  function readURL(input){
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				$('#images').attr('src', e.target.result);
			}
		}

		reader.readAsDataURL(input.files[0]);
	}

  $("#logoeditor").submit(function(event) {
    event.preventDefault();
    var data = new FormData();
		var uploader = <?=$_SESSION['emp_id']?>;
		data.append("uploader", uploader);
		data.append("file", $("input#logo").get(0).files[0]);
    $.ajax({
      url: '/employer/uploadlogo/',
		  type: 'POST',
		  cache: false,
		  contentType: false,
		  processData: false,
		  data: data,
		  dataType: "json",
		  success: function(result){
				if(result.status){
					setTimeout(function(){ window.location.reload(); }, 100);
				}
		  }
		});
  });
</script>
