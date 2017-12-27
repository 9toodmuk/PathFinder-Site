<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <div class="row">
                <div class="col col-xs-6">
                  <h3 class="panel-title"><?=$lang['Employers']?></h3>
                </div>
                <div class="col col-xs-6 text-right">
                  <form class="form-inline" role="form" action="/admin/categories/add/employer/" method="post">
                    <input type="text" name="name" class="form-control" placeholder="<?=$lang['Employers']?>" required>
                    <button class="btn btn-primary"><em class="fa fa-plus"></em> <?=$lang['NewBtn']?></button>
                  </form>
                </div>
              </div>
            </div>
            <div class="panel-body">
              <table width="100%" class="table table-hover" id="datatables">
                <thead>
                  <tr>
                    <th width="8%"><em class="fa fa-cog"></em></th>
                    <th class="hidden-xs" width="8%">ID</th>
                    <th><?=$lang['name']?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $conn = Config\Database::connection();
                    $sql = "SELECT * FROM company_categories";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()) {
                  ?>
                  <tr id="g<?php echo $row['id'] ?>">
                    <td align="center">
                      <a class="btn btn-default btn-edit" onclick="btnEditClick(<?php echo $row['id'] ?>)"><em class="fa fa-pencil"></em></a>
                      <a class="btn btn-danger" data-title="Delete" data-toggle="modal" data-target="#delete" data-book-id="<?php echo $row['id'] ?>"><em class="fa fa-trash"></em></a>
                    </td>
                    <td class="hidden-xs" id="tid<?php echo $row['id'] ?>"><?php echo $row["id"] ?></td>
                    <td id="nm<?php echo $row['id'] ?>"><?php echo $row["name"] ?></td>
                  </tr>
                  <?php
                    }
                  ?>
                </tbody>
        </table>
        </div>
        <div class="panel-footer">
          <div class="row">
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title custom_align" id="Heading">ลบหมวดหมู่นี้</h4>
      </div>
      <div class="modal-body">

        <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> แน่ใจหรือไม่ว่าต้องการลบหมวดหมู่นี้?</div>

      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> ใช่</a>
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> ไม่ใช่</button>
      </div>
    </div>
  </div>
</div>

<script>
  function btnEditClick(id){
    var id = $("#tid"+id).text();
    var name = $("#nm"+id).text();

    var tr = '<td align="center" id="c-'+id+'">' +
    '<a class="btn btn-default btn-edit" onclick="editClick('+id+')"><em class="fa fa-pencil"></em> แก้ไข</button>' +
    '</td>' +
    '<td class="hidden-xs" id="cid">'+
    '<input type="text" class="form-control" value="'+id+'" disabled>'+
    '<input type="hidden" id="id-'+id+'" name="id" value="'+id+'">'+
    '</td>' +
    '<td>'+
    '<input type="text" id="name-'+id+'" name="name" class="form-control" value="'+name+'" required>'+
    '</td>';

    $("#g"+id).html(tr);
  }

  function editClick(id){
    var id = $("input#id-"+id).val();
    var name = $("input#name-"+id).val();

    var tr = '<td align="center">' +
    '<a class="btn btn-default btn-edit" onclick="btnEditClick('+id+')"><em class="fa fa-pencil"></em></a> '+
    '<a class="btn btn-danger" data-title="Delete" data-toggle="modal" data-target="#delete" data-book-id="'+id+'"><em class="fa fa-trash"></em></a>'+
    '</td>'+
    '<td class="hidden-xs" id="cid">'+id+'</td>'+
    '<td>'+name+'</td>';

    $.ajax({
      url: '/dist/admin/categories/editemployer.php',
      type: 'POST',
      data: {id : id, name: name},
      success: function (result) {
        $("td#c-"+id).parent().html(tr);
      }
    });
  }

  $('#delete').on('show.bs.modal', function(e) {

    var id = $(e.relatedTarget).data('book-id');
    $(e.currentTarget).find('a.btn-success').attr("href","/admin/categories/employer/delete/"+id+"/");
  });
</script>
