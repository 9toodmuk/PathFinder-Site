<div class="modal fade" id="editprofilepic" tabindex="-1" role="dialog" aria-labelledby="editprofilepic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title custom_align" id="Heading"> แก้ไขรูปโปรไฟล์</h4>
      </div>
      <div class="modal-body">

        <div class="hiddenfile">
          <input name="profilepic" type="file" id="profilepic" accept="image/*"/>
        </div>

        <div class="text-center">
          <img id="demo">
        </div>

      </div>
      <div class="modal-footer">
        <button id="btnSubmit" type="button" class="btn btn-success" onclick="upload()" data-loading-text="<?=$lang['processing']?>"><i class="fa fa-upload" aria-hidden="true"></i> Upload</button>
        <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> <?=$lang['Close']?></a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $("#editprofilepic").on('hidden.bs.modal', function(e){
    $("input#profilepic").val("");
  });
</script>
