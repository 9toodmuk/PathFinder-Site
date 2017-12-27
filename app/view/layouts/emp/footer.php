<footer id="last-footer">
  <div class="container" id="bottom-footer">
    <div class="row">
      <div class="col-md-12 text-center">
        <p><strong><?=$lang['Language']?>: </strong><a href="#" data-title="Change Language" data-toggle="modal" data-target="#changelanguage" data-book-id="en"> English</a> | <a href="#" data-title="Change Language" data-toggle="modal" data-target="#changelanguage" data-book-id="th"> ภาษาไทย</a></p>
        <?=$lang['Copyright']?>
      </div>
    </div>
  </div>
</footer>

<?php include_once 'app/view/layouts/utils/changelanguage-modal.php'; ?>
