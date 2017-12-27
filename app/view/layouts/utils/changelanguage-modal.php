<div class="modal fade" id="changelanguage" tabindex="-1" role="dialog" aria-labelledby="changelanguage" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title custom_align" id="Heading"><?=$lang['ChangeLanguageTitle']?></h4>
      </div>
      <div class="modal-body">

        <div class="alert alert-warning"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?=$lang['ChangeLanguageText']?> <kbd id="langname"></kbd> ?</div>

      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i> <?=$lang['ChangeLanguageButton']?></a>
        <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> <?=$lang['Close']?></a>
      </div>
    </div>
  </div>
</div>

<script>
  $('#changelanguage').on('show.bs.modal', function(e) {
    var lang = $(e.relatedTarget).data('book-id');

    if(lang == "th"){
      $langname = "ภาษาไทย";
    }else if(lang == "en"){
      $langname = "English";
    }

    $('#langname').html($langname);
    $(e.currentTarget).find('a.btn-success').on('click', function(){
      changelanguage(lang);
    });
  });

  function changelanguage(lang){
    $.ajax({
      url: '/home/changelanguage/',
      type: 'GET',
      data: {language: lang},
      success: function (result) {
        location.reload();
      }
    });
  }
</script>
