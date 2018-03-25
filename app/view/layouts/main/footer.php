<footer class="footer text-white hidden-xs">
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <?=$lang['Language']?>: <a href="#" data-title="Change Language" data-toggle="modal" data-target="#changelanguage" data-book-id="en"> English</a> | <a href="#" data-title="Change Language" data-toggle="modal" data-target="#changelanguage" data-book-id="th"> ภาษาไทย</a>
      </div>
      <div class="col-sm-6 text-right">
        <?=$lang['Copyright']?>
      </div>
    </div>
  </div>
</footer>

<?php include_once 'app/view/layouts/utils/changelanguage-modal.php'; ?>
