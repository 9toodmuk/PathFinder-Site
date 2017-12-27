<div class="panel panel-default">
  <div class="post">
    <form id="post-form" method="post" role="form" style="display: block;">
      <div class="panel-heading post-editor-body"><strong><?=$lang['WritePost']?></strong></div>
      <div class="panel-body post-editor-body">
        <div class="form-group">
          <textarea class="form-control post-editor" name="message" id="message" placeholder="<?=$lang['WhatAreYouThinking']?>" rows="1"></textarea>
        </div>
        <input type="submit" name="message-post" id="message-post" tabindex="4" style="display: none;" class="btn btn-post pull-right" value="Post">
      </div>
    </form>
  </div>
</div>
<script>

$('#message').on({
  focus: function(){
    $('#message').animate({ height: "6em" }, 500);
    $('#message-post').show();
  },
  blur: function() {
    if($("#message").val() == "") {
      $('#message').animate({ height: "3em" }, 500);
      $('#message-post').hide();
    }else{
      $('#message').animate({ height: "3em" }, 500);
    }
  }
});
</script>
