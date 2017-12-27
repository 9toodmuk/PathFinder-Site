<div>
<table class="table table-bordered" id="<?=$row['id']?>">
  <tr><th colspan="2" style="vertical-align: middle;"><strong><?=$row['name']?></strong>
    <span class="pull-right">
      <a onclick="editexp(this)" class="btn btn-edit"><i class="fa fa-pencil-square-o"></i> <?=$lang['EditBtn']?></a>
      <a onclick="removeexp(this)" class="btn btn-remove"><i class="fa fa-trash"></i> <?=$lang['RemoveBtn']?></a>
    </span>

  </th></tr>
  <tr><td width="20%"><strong><?=$lang['Employer']?></strong></td><td><?=$row['company']?></td></tr>
  <tr>
    <td><strong><?=$lang['Durations']?></strong></td>
    <td>
      <?php
        $startdate = date("M Y", strtotime($row['start_at']));
        echo $startdate;
        if($row['status'] == 0){
          $enddate = date("M Y", strtotime($row['end_at']));
          echo " - ".$enddate;
        }else if($row['status'] == 1){
          echo " - Now";
        }
      ?>
    </td>
  </tr>
</table>
</div>
