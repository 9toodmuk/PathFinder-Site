<?php
use Controller\Admin\Postings;
?>
<div>
  <table class="table table-bordered" id="<?=$row['id']?>">
    <tr><th colspan="2"><strong><?=$row['institute_name']?></strong>
      <span class="pull-right">
        <a onclick="editedu(this)" class="btn btn-edit"><i class="fa fa-pencil-square-o"></i> <?=$lang['editlocationbtn']?></a>
        <a onclick="removeedu(this)" class="btn btn-remove"><i class="fa fa-trash"></i> <?=$lang['RemoveBtn']?></a>
      </span>
    </th></tr>
    <tr><td width="20%"><strong>Background</strong></td><td><?php Postings::eduLevel($row['background']) ?></td></tr>
    <tr><td><strong>Major</strong></td><td><?=$row['major']?></td></tr>
    <tr><td><strong>GPA</strong></td><td><?=$row['gpa']?></td></tr>
  </table>
</div>
